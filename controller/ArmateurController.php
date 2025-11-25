<?php
require_once __DIR__ . '/../model/ArmateurModel.php';

// Fonction pour afficher la liste des armateurs
function afficherArmateurs() {
    $armateurs = getArmateurs();
    require __DIR__ . '/../view/Armateur_liste.php';
}

// Fonction pour créer un armateur
function creerArmateur() {
    $error = '';
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération et nettoyage des données
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        
        // Validation basique
        if (!empty($nom)) {
            if (insertArmateur($nom, $prenom, $adresse)) {
                header('Location: index.php?page=armateurs&success=' . urlencode('Armateur créé avec succès'));
                exit;
            } else {
                $error = 'Erreur lors de la création de l\'armateur';
            }
        } else {
            $error = 'Le nom de l\'armateur est obligatoire';
        }
    }
    
    // Afficher le formulaire
    $armateur = null; // Pour le formulaire vide
    $action = 'create';
    require __DIR__ . '/../view/Armateur_details.php';
}

// Fonction pour afficher les détails d'un armateur
function afficherArmateur($id_armateur) {
    $armateur = getArmateurById($id_armateur);
    
    if (!$armateur) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }
    
    $action = 'view';
    require __DIR__ . '/../view/Armateur_details.php';
}

// Fonction pour modifier un armateur
function modifierArmateur($id_armateur) {
    $armateur = getArmateurById($id_armateur);
    $error = '';
    $success = '';
    
    if (!$armateur) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        
        if (!empty($nom)) {
            if (updateArmateur($id_armateur, $nom, $prenom, $adresse)) {
                header('Location: index.php?page=armateur_details&id_armateur=' . $id_armateur . '&success=' . urlencode('Armateur modifié avec succès'));
                exit;
            } else {
                $error = 'Erreur lors de la modification de l\'armateur';
            }
        } else {
            $error = 'Le nom de l\'armateur est obligatoire';
        }
    }
    
    $action = 'update';
    require __DIR__ . '/../view/Armateur_details.php';
}

// Fonction pour supprimer un armateur
function supprimerArmateur($id_armateur) {
    // Vérifier si l'armateur existe
    $armateur = getArmateurById($id_armateur);
    
    if (!$armateur) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }
    
    // Supprimer l'armateur
    if (deleteArmateur($id_armateur)) {
        header('Location: index.php?page=armateurs&success=' . urlencode('Armateur supprimé avec succès'));
    } else {
        header('Location: index.php?page=armateurs&error=' . urlencode('Erreur lors de la suppression'));
    }
    exit;
}
?>