<?php
require_once "model/NavireModel.php";

function afficherNavires() {
    $navires = getNavires();
    require "view/Navire_liste.php";
}

function creerNavire() {
    $frets = getFrets(); // créer cette fonction dans Naviremodel.php qui fait SELECT * FROM fret
    if (!empty($_POST)) {
        insertNavire(
            $_POST['nom'],
            $_POST['autorise'],
            $_POST['longueur'],
            $_POST['largeur'],
            $_POST['tirant_eau'],
            $_POST['capacite'],
            $_POST['propulseur'],
            $_POST['remorqueur'],
            $_POST['id_fret'],
            $_POST['id_port']
        );
        header("Location: index.php?page=navires");
        exit;
    }
    require "view/Navire_create.php";
}


function afficherNavire($id_navire) {
    $navire = getNavireById($id_navire);
    if (!$navire) die("Navire introuvable.");
    require "view/Navire_details.php";
}

function modifierNavire($id_navire) {
    $navire = getNavireById($id_navire);
    if (!$navire) die("Navire introuvable.");

    if (!empty($_POST)) {
        updateNavire($id_navire, $_POST['nom'], $_POST['type'], $_POST['tonnage']);
        header("Location: index.php?page=navires");
        exit;
    }
    require "view/Navire_modifier.php";
}

function supprimerNavire($id_navire) {
    deleteNavire($id_navire);
    header("Location: index.php?page=navires");
    exit;
}
?>
