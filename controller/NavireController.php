<?php
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
        $autorise = !empty($_POST['autorise']) ? 1 : 0;
        $longueur = $_POST['longueur'] ?? 0;
        $largeur = $_POST['largeur'] ?? 0;
        $tirant_eau = $_POST['tirant_eau'] ?? 0;
        $capacite = $_POST['capacite'] ?? 0;
        $propulseur = !empty($_POST['propulseur']) ? 1 : 0;
        $remorqueur = !empty($_POST['remorqueur']) ? 1 : 0;
        $id_fret = $_POST['id_fret'] ?? null;
        $id_port = $_POST['id_port'] ?? null;
        
        // Validation basique
        if (!empty($nom)) {
            insertNavire($nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port);
            header('Location: index.php?page=navires&success=Navire créé avec succès');
            exit;
        } else {
            $error = 'Le nom du navire est obligatoire';
        }
    }
    
    // Afficher le formulaire
    $navire = null; // Pour le formulaire vide
    $action = 'create';
    require __DIR__ . '/../view/navire_details.php';
}

// Fonction pour afficher les détails d'un navire
function afficherNavire($id_navire) {
    $navire = getNavireById($id_navire);
    
    if (!$navire) {
        header('Location: index.php?page=navires&error=Navire non trouvé');
        exit;
    }
    
    $action = 'view';
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
        $autorise = !empty($_POST['autorise']) ? 1 : 0;
        $longueur = $_POST['longueur'] ?? 0;
        $largeur = $_POST['largeur'] ?? 0;
        $tirant_eau = $_POST['tirant_eau'] ?? 0;
        $capacite = $_POST['capacite'] ?? 0;
        $propulseur = !empty($_POST['propulseur']) ? 1 : 0;
        $remorqueur = !empty($_POST['remorqueur']) ? 1 : 0;
        $id_fret = $_POST['id_fret'] ?? null;
        $id_port = $_POST['id_port'] ?? null;
        
        if (!empty($nom)) {
            updateNavire($id_navire, $nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port);
            header('Location: index.php?page=navire_details&id_navire=' . $id_navire . '&success=Navire modifié avec succès');
            exit;
        } else {
            $error = 'Le nom du navire est obligatoire';
        }
    }
    
    $action = 'update';
    require __DIR__ . '/../view/navire_details.php';
}

// Fonction pour supprimer un navire
function supprimerNavire($id_navire) {
    deleteNavire($id_navire);
    header('Location: index.php?page=navires&success=Navire supprimé avec succès');
    exit;
}
?>