<?php
require_once "model/EscaleModel.php";

function afficherEscales() {
    $escales = getEscales();
    require "view/Escale_liste.php";
}

function creerEscale() {
    if (!empty($_POST)) {

        insertEscale(
            $_POST['date_arrive'],        // date_arrive
            $_POST['date_depart'],        // date_depart
            $_POST['id_fret'],            // fret transporté
            $_POST['id_docker'],          // id_employee (docker)
            $_POST['id_pilote1'],         // id_employee_1
            $_POST['id_pilote2'],         // id_employee_2
            $_POST['id_poste_accostage'], // poste d'accostage
            $_POST['id_navire']           // navire
        );

        header("Location: index.php?page=escales");
        exit;
    }

    require "view/Escale_create.php";
}

function afficherEscale($id_escale) {
    $escale = getEscaleById($id_escale);
    if (!$escale) die("Escale introuvable.");
    require "view/Escale_details.php";
}

function modifierEscale($id_escale) {
    $pdo = getConnexion();

    // Récupération de l'escale
    $escale = getEscaleById($id_escale);
    if (!$escale) die("Escale introuvable.");

    // Récupération des données pour les listes déroulantes
    $frets = $pdo->query("SELECT * FROM fret")->fetchAll();
    $dockers = $pdo->query("
        SELECT e.id_employee, e.nom, e.prenom
        FROM employee e
        JOIN docker d ON d.id_employee = e.id_employee
    ")->fetchAll();
    $pilotes = $pdo->query("
        SELECT e.id_employee, e.nom, e.prenom
        FROM employee e
        JOIN pilote p ON p.id_employee = e.id_employee
    ")->fetchAll();
    $postes = $pdo->query("
        SELECT pa.id_poste_accostage, q.nom AS quai_nom
        FROM poste_accostage pa
        JOIN quai q ON q.id_quai = pa.id_quai
    ")->fetchAll();
    $navires = $pdo->query("SELECT * FROM navire")->fetchAll();

    // Traitement du formulaire
    if (!empty($_POST)) {
        updateEscale(
            $id_escale,
            $_POST['date_arrive'],
            $_POST['date_depart'],
            $_POST['id_fret'],
            $_POST['id_docker'],
            $_POST['id_pilote1'],
            $_POST['id_pilote2'],
            $_POST['id_poste_accostage'],
            $_POST['id_navire']
        );
        header("Location: index.php?page=escales");
        exit;
    }

    require "view/Escale_modifier.php";
}


function supprimerEscale($id_escale) {
    deleteEscale($id_escale);
    header("Location: index.php?page=escales");
    exit;
}
?>
