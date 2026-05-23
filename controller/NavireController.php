<?php
// controller/NavireController.php
require_once __DIR__ . '/../model/NavireModel.php';

// Fonction pour afficher la liste des navires
function afficherNavires() {
    $navires = getNavires();
    require __DIR__ . '/../view/navires.php';
}

// Fonction pour créer un navire
function creerNavire() {
    $error = '';
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération et nettoyage des données
        $nom = trim($_POST['nom'] ?? '');
        $num_lloyds       = !empty($_POST['num_lloyds'])       ? trim($_POST['num_lloyds'])       : null;
        $type_navire      = !empty($_POST['type_navire'])      ? trim($_POST['type_navire'])      : null;
        $pavillon         = !empty($_POST['pavillon'])         ? trim($_POST['pavillon'])         : null;
        $port_attache_nom = !empty($_POST['port_attache_nom']) ? trim($_POST['port_attache_nom']) : null;
        $autorise = !empty($_POST['autorise']) ? 1 : 0;
        $longueur = floatval($_POST['longueur'] ?? 0);
        $largeur = floatval($_POST['largeur'] ?? 0);
        $tirant_eau = floatval($_POST['tirant_eau'] ?? 0);
        $capacite = floatval($_POST['capacite'] ?? 0);
        $propulseur = !empty($_POST['propulseur']) ? 1 : 0;
        $remorqueur = !empty($_POST['remorqueur']) ? 1 : 0;
        $id_fret = !empty($_POST['id_fret']) ? intval($_POST['id_fret']) : null;
        $id_armateur = !empty($_POST['id_armateur']) ? intval($_POST['id_armateur']) : null;
        $id_port = !empty($_POST['id_port']) ? intval($_POST['id_port']) : null;
        
        // Validation basique
        if (empty($nom)) {
            $error = 'Le nom du navire est obligatoire';
        } else {
            try {
                insertNavire($nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port, $num_lloyds, $type_navire, $pavillon, $port_attache_nom);
                header('Location: index.php?page=navires&success=Navire créé avec succès');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de la création : ' . $e->getMessage();
            }
        }
    }
    
    // Récupérer les données pour les listes déroulantes
    $frets = getAllFrets();
    $armateurs = getAllArmateurs();
    $ports = getAllPorts();
    
    // Afficher le formulaire
    require __DIR__ . '/../view/navire_create.php';
}

// Fonction pour afficher les détails d'un navire
function afficherNavire($id_navire) {
    $navire = getNavireById($id_navire);
    
    if (!$navire) {
        header('Location: index.php?page=navires&error=Navire non trouvé');
        exit;
    }
    
    // Récupérer les infos supplémentaires pour l'affichage
    $frets = getAllFrets();
    $armateurs = getAllArmateurs();
    $ports = getAllPorts();
    
    require __DIR__ . '/../view/navire_details.php';
}

// Fonction pour modifier un navire
function modifierNavire($id_navire) {
    $navire = getNavireById($id_navire);
    $error = '';
    $success = '';
    
    if (!$navire) {
        header('Location: index.php?page=navires&error=Navire non trouvé');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = trim($_POST['nom'] ?? '');
        $num_lloyds       = !empty($_POST['num_lloyds'])       ? trim($_POST['num_lloyds'])       : null;
        $type_navire      = !empty($_POST['type_navire'])      ? trim($_POST['type_navire'])      : null;
        $pavillon         = !empty($_POST['pavillon'])         ? trim($_POST['pavillon'])         : null;
        $port_attache_nom = !empty($_POST['port_attache_nom']) ? trim($_POST['port_attache_nom']) : null;
        $autorise = !empty($_POST['autorise']) ? 1 : 0;
        $longueur = floatval($_POST['longueur'] ?? 0);
        $largeur = floatval($_POST['largeur'] ?? 0);
        $tirant_eau = floatval($_POST['tirant_eau'] ?? 0);
        $capacite = floatval($_POST['capacite'] ?? 0);
        $propulseur = !empty($_POST['propulseur']) ? 1 : 0;
        $remorqueur = !empty($_POST['remorqueur']) ? 1 : 0;
        $id_fret = !empty($_POST['id_fret']) ? intval($_POST['id_fret']) : null;
        $id_armateur = !empty($_POST['id_armateur']) ? intval($_POST['id_armateur']) : null;
        $id_port = !empty($_POST['id_port']) ? intval($_POST['id_port']) : null;
        
        if (empty($nom)) {
            $error = 'Le nom du navire est obligatoire';
        } else {
            try {
                updateNavire($id_navire, $nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port, $num_lloyds, $type_navire, $pavillon, $port_attache_nom);
                header('Location: index.php?page=navires&success=Navire modifié avec succès');
                exit;
            } catch (Exception $e) {
                $error = 'Erreur lors de la modification : ' . $e->getMessage();
            }
        }
    }
    
    // Récupérer les données pour les listes déroulantes
    $frets = getAllFrets();
    $armateurs = getAllArmateurs();
    $ports = getAllPorts();
    
    require __DIR__ . '/../view/navire_modifier.php';
}

// Fonction pour supprimer un navire
function supprimerNavire($id_navire) {
    try {
        deleteNavire($id_navire);
        header('Location: index.php?page=navires&success=Navire supprimé avec succès');
    } catch (Exception $e) {
        header('Location: index.php?page=navires&error=Erreur lors de la suppression : ' . $e->getMessage());
    }
    exit;
}
?>