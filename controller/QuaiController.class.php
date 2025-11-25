<?php

require_once 'model/Quai.class.php';
require_once 'model/QuaiManager.class.php';
require_once 'model/PosteAccostage.class.php';
require_once 'model/PosteAccostageManager.class.php';
require_once 'model/FretManager.class.php';

class QuaiController {
    private $quaiManager;
    private $posteAccostageManager;
    private $fretManager;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->quaiManager = new QuaiManager($db);
        $this->posteAccostageManager = new PosteAccostageManager($db);
        $this->fretManager = new FretManager($db);
    }

    public function listeQuais() {
        try {
            $quais = $this->quaiManager->getAllQuais();
            
            require 'view/quais.php';
            
        } catch (Exception $e) {
            error_log("Erreur dans listeQuais: " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors du chargement des quais: " . $e->getMessage();
            require 'view/quais.php';
        }
    }

    public function listePostes() {
        $id_quai = isset($_GET['id_quai']) ? (int)$_GET['id_quai'] : 0;
        
        if ($id_quai <= 0) {
            $_SESSION['erreur'] = "Quai non spécifié";
            header('Location: index.php?page=quais');
            exit();
        }

        try {
            $quai = $this->quaiManager->getQuaiById($id_quai);
            if (!$quai) {
                $_SESSION['erreur'] = "Quai non trouvé";
                header('Location: index.php?page=quais');
                exit();
            }

            $postes = $this->posteAccostageManager->getPostesByQuai($id_quai);
            $typesFret = $this->quaiManager->getTypesFretByQuai($id_quai);
            
            $postesAvecDisponibilite = [];
            foreach ($postes as $poste) {
                $disponible = $this->posteAccostageManager->isPosteDisponible($poste->getId_poste_accostage());
                $postesAvecDisponibilite[] = [
                    'poste' => $poste,
                    'disponible' => $disponible
                ];
            }
            
            require 'view/postes.php';
            
        } catch (Exception $e) {
            error_log("Erreur dans listePostes: " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors du chargement des postes: " . $e->getMessage();
            header('Location: index.php?page=quais');
            exit();
        }
    }

    public function creerQuai() {
        $typesFret = $this->fretManager->getAllFret();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => trim($_POST['nom']),
                'tirant_eau_max' => (float)$_POST['tirant_eau_max']
            ];

            if ($this->validerDonneesQuai($data)) {
                try {
                    $this->db->beginTransaction();
                    
                    // CRÉATION AVEC ID MANUEL
                    $id_quai = $this->quaiManager->creerQuaiEtRetournerId($data);
                    
                    if ($id_quai > 0) {
                        // Gérer les types de fret
                        if (isset($_POST['types_fret']) && is_array($_POST['types_fret'])) {
                            foreach ($_POST['types_fret'] as $id_fret) {
                                $this->fretManager->associerFretQuai($id_fret, $id_quai);
                            }
                        }
                        
                        $this->db->commit();
                        $_SESSION['success'] = "Quai créé avec succès (ID: $id_quai)";
                        header('Location: index.php?page=quais');
                        exit();
                    } else {
                        $this->db->rollBack();
                        $_SESSION['erreur'] = "Erreur lors de la création du quai";
                    }
                } catch (Exception $e) {
                    $this->db->rollBack();
                    $_SESSION['erreur'] = "Erreur lors de la création du quai: " . $e->getMessage();
                }
            }
        }
        
        $quai = null;
        $typesFretQuai = [];
        require 'view/form_quai.php';
    }

    public function modifierQuai() {
        $id_quai = isset($_GET['id_quai']) ? (int)$_GET['id_quai'] : 0;
        
        try {
            $quai = $this->quaiManager->getQuaiById($id_quai);
            $typesFret = $this->fretManager->getAllFret();
            $typesFretQuai = $this->quaiManager->getTypesFretByQuai($id_quai);

            if (!$quai) {
                $_SESSION['erreur'] = "Quai non trouvé";
                header('Location: index.php?page=quais');
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'id_quai' => $id_quai,
                    'nom' => trim($_POST['nom']),
                    'tirant_eau_max' => (float)$_POST['tirant_eau_max']
                ];

                if ($this->validerDonneesQuai($data)) {
                    try {
                        $this->db->beginTransaction();
                        
                        $quai = new Quai($data);
                        if ($this->quaiManager->modifierQuai($quai)) {
                            
                            $this->fretManager->supprimerAssociationsFretQuai($id_quai);
                            
                            if (isset($_POST['types_fret']) && is_array($_POST['types_fret'])) {
                                foreach ($_POST['types_fret'] as $id_fret) {
                                    $this->fretManager->associerFretQuai($id_fret, $id_quai);
                                }
                            }
                            
                            $this->db->commit();
                            $_SESSION['success'] = "Quai modifié avec succès";
                            header('Location: index.php?page=quais');
                            exit();
                        } else {
                            $this->db->rollBack();
                            $_SESSION['erreur'] = "Erreur lors de la modification du quai";
                        }
                    } catch (Exception $e) {
                        $this->db->rollBack();
                        $_SESSION['erreur'] = "Erreur lors de la modification: " . $e->getMessage();
                    }
                }
            }

            require 'view/form_quai.php';
            
        } catch (Exception $e) {
            error_log("Erreur dans modifierQuai: " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors de la modification: " . $e->getMessage();
            header('Location: index.php?page=quais');
            exit();
        }
    }

    public function supprimerQuai() {
        $id_quai = isset($_GET['id_quai']) ? (int)$_GET['id_quai'] : 0;
        
        try {
            if ($this->quaiManager->supprimerQuai($id_quai)) {
                $_SESSION['success'] = "Quai supprimé avec succès";
            } else {
                $_SESSION['erreur'] = "Erreur lors de la suppression du quai";
            }
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
        
        header('Location: index.php?page=quais');
        exit();
    }

    public function creerPoste() {
        $id_quai = isset($_GET['id_quai']) ? (int)$_GET['id_quai'] : 0;
        
        try {
            $quai = $this->quaiManager->getQuaiById($id_quai);

            if (!$quai) {
                $_SESSION['erreur'] = "Quai non trouvé";
                header('Location: index.php?page=quais');
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'id_quai' => $id_quai
                ];

                if ($this->validerDonneesPoste($data)) {
                    // CRÉATION AVEC ID MANUEL
                    $id_poste = $this->posteAccostageManager->creerPosteEtRetournerId($data);
                    
                    if ($id_poste > 0) {
                        $_SESSION['success'] = "Poste créé avec succès (ID: $id_poste)";
                        header("Location: index.php?page=postes&id_quai=$id_quai");
                        exit();
                    } else {
                        $_SESSION['erreur'] = "Erreur lors de la création du poste";
                    }
                }
            }

            require 'view/form_poste.php';
            
        } catch (Exception $e) {
            error_log("Erreur dans creerPoste: " . $e->getMessage());
            $_SESSION['erreur'] = "Erreur lors de la création: " . $e->getMessage();
            header("Location: index.php?page=postes&id_quai=$id_quai");
            exit();
        }
    }

    public function supprimerPoste() {
        $id_poste_accostage = isset($_GET['id_poste_accostage']) ? (int)$_GET['id_poste_accostage'] : 0;
        
        try {
            $poste = $this->posteAccostageManager->getPosteById($id_poste_accostage);
            
            if ($poste && $this->posteAccostageManager->supprimerPoste($id_poste_accostage)) {
                $_SESSION['success'] = "Poste supprimé avec succès";
            } else {
                $_SESSION['erreur'] = "Erreur lors de la suppression du poste";
            }
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }

        if (isset($poste)) {
            header("Location: index.php?page=postes&id_quai=" . $poste->getId_quai());
        } else {
            header('Location: index.php?page=quais');
        }
        exit();
    }

    private function validerDonneesQuai($data) {
        if (empty($data['nom'])) {
            $_SESSION['erreur'] = "Le nom du quai est obligatoire";
            return false;
        }

        if ($data['tirant_eau_max'] <= 0) {
            $_SESSION['erreur'] = "Le tirant d'eau maximum doit être positif";
            return false;
        }

        return true;
    }

    private function validerDonneesPoste($data) {
        if ($data['id_quai'] <= 0) {
            $_SESSION['erreur'] = "L'identifiant du quai est invalide";
            return false;
        }

        return true;
    }
}
?>