<?php

require_once __DIR__ . '/../model/ArmateurModel.php';

// ─── Liste ─────────────────────────────────────────────────────────────────

function afficherArmateurs() {
    $armateurs = getArmateurs();
    require __DIR__ . '/../view/Armateur_liste.php';
}

// ─── Détail ────────────────────────────────────────────────────────────────

function afficherArmateur($id_armateur) {
    $armateur = getArmateurById($id_armateur);
    if (!$armateur) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }
    $action = 'view';
    require __DIR__ . '/../view/Armateur_details.php';
}

// ─── Créer ─────────────────────────────────────────────────────────────────

function creerArmateur() {
    $error   = '';
    $armateur = null;
    $action  = 'create';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom    = trim($_POST['nom']    ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $adresse= trim($_POST['adresse']?? '');
        $tel    = trim($_POST['tel']    ?? '');

        if (empty($nom)) {
            $error = 'Le nom de l\'armateur est obligatoire';
        } else {
            if (insertArmateur($nom, $prenom, $adresse, $tel)) {
                header('Location: index.php?page=armateurs&success=' . urlencode('Armateur créé avec succès'));
                exit;
            } else {
                $error = 'Erreur lors de la création';
            }
        }
    }

    require __DIR__ . '/../view/Armateur_details.php';
}

// ─── Modifier ──────────────────────────────────────────────────────────────

function modifierArmateur($id_armateur) {
    $armateur = getArmateurById($id_armateur);
    $error    = '';
    $action   = 'update';

    if (!$armateur) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom    = trim($_POST['nom']    ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $adresse= trim($_POST['adresse']?? '');
        $tel    = trim($_POST['tel']    ?? '');

        if (empty($nom)) {
            $error = 'Le nom de l\'armateur est obligatoire';
        } else {
            if (updateArmateur($id_armateur, $nom, $prenom, $adresse, $tel)) {
                header('Location: index.php?page=armateur_details&id_armateur=' . $id_armateur . '&success=' . urlencode('Armateur modifié avec succès'));
                exit;
            } else {
                $error = 'Erreur lors de la modification';
            }
        }
    }

    require __DIR__ . '/../view/Armateur_details.php';
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function supprimerArmateur($id_armateur) {
    if (!getArmateurById($id_armateur)) {
        header('Location: index.php?page=armateurs&error=' . urlencode('Armateur non trouvé'));
        exit;
    }

    if (deleteArmateur($id_armateur)) {
        header('Location: index.php?page=armateurs&success=' . urlencode('Armateur supprimé avec succès'));
    } else {
        header('Location: index.php?page=armateurs&error=' . urlencode('Erreur lors de la suppression'));
    }
    exit;
}