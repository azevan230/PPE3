<?php

require_once __DIR__ . '/../model/EscaleModel.php';

// ─── Liste ─────────────────────────────────────────────────────────────────

function afficherEscales() {
    $escales = getEscales();
    require __DIR__ . '/../view/Escale_liste.php';
}

// ─── Détail ────────────────────────────────────────────────────────────────

function afficherEscale($id_escale) {
    $escale = getEscaleById($id_escale);
    if (!$escale) die("Escale introuvable.");
    require __DIR__ . '/../view/Escale_details.php';
}

// ─── Créer ─────────────────────────────────────────────────────────────────

function creerEscale() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        insertEscale(
            $_POST['date_arrive'],
            $_POST['date_depart'],
            $_POST['id_fret'],
            $_POST['id_docker'],
            $_POST['id_pilote1'],
            $_POST['id_pilote2'],
            $_POST['id_poste_accostage'],
            $_POST['id_navire'],
            !empty($_POST['id_agent'])    ? (int) $_POST['id_agent']       : null,
            !empty($_POST['destination']) ? trim($_POST['destination'])     : null
        );
        header("Location: index.php?page=escales");
        exit;
    }
    require __DIR__ . '/../view/Escale_create.php';
}

// ─── Modifier ──────────────────────────────────────────────────────────────

function modifierEscale($id_escale) {
    $pdo    = getConnexion();
    $escale = getEscaleById($id_escale);
    if (!$escale) die("Escale introuvable.");

    // Toutes les listes déroulantes dont la vue a besoin
    $agents  = getAllAgents();
    $frets   = $pdo->query("SELECT * FROM fret")->fetchAll(PDO::FETCH_ASSOC);
    $dockers = $pdo->query("
        SELECT e.id_employee, e.nom, e.prenom
        FROM employee e JOIN docker d ON d.id_employee = e.id_employee
    ")->fetchAll(PDO::FETCH_ASSOC);
    $pilotes = $pdo->query("
        SELECT e.id_employee, e.nom, e.prenom
        FROM employee e JOIN pilote p ON p.id_employee = e.id_employee
    ")->fetchAll(PDO::FETCH_ASSOC);
    $postes  = $pdo->query("
        SELECT pa.id_poste_accostage, q.nom AS quai_nom
        FROM poste_accostage pa JOIN quai q ON q.id_quai = pa.id_quai
    ")->fetchAll(PDO::FETCH_ASSOC);
    $navires = $pdo->query("SELECT * FROM navire")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        updateEscale(
            $id_escale,
            $_POST['date_arrive'],
            $_POST['date_depart'],
            $_POST['id_fret'],
            $_POST['id_docker'],
            $_POST['id_pilote1'],
            $_POST['id_pilote2'],
            $_POST['id_poste_accostage'],
            $_POST['id_navire'],
            !empty($_POST['id_agent'])    ? (int) $_POST['id_agent']   : null,
            !empty($_POST['destination']) ? trim($_POST['destination']) : null
        );
        header("Location: index.php?page=escales");
        exit;
    }

    require __DIR__ . '/../view/Escale_modifier.php';
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function supprimerEscale($id_escale) {
    deleteEscale($id_escale);
    header("Location: index.php?page=escales");
    exit;
}