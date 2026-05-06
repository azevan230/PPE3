<?php

require_once __DIR__ . '/../model/EscaleModel.php';

// =============================================================================
// CONTRÔLEUR ESCALE — V2
// Gère le workflow : en_attente -> validee/refusee -> terminee
// =============================================================================

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

// ─── Créer (depuis le web : capitainerie) ──────────────────────────────────

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
            !empty($_POST['id_agent'])    ? (int) $_POST['id_agent']        : null,
            !empty($_POST['destination']) ? trim($_POST['destination'])     : null,
            'validee' // les escales créées depuis le web sont validées d'office
        );
        header("Location: index.php?page=escales&success=" . urlencode("Escale créée"));
        exit;
    }
    require __DIR__ . '/../view/Escale_create.php';
}

// ─── Modifier ──────────────────────────────────────────────────────────────
// Gère le workflow de validation des demandes :
//   - Si statut = 'en_attente' : le formulaire affiche une bannière "Demande
//     d'un armateur" et un bouton spécial "Valider et affecter"
//   - Validation = passage en 'validee' avec poste/docker/pilotes obligatoires
//   - Possibilité de "Refuser" la demande

function modifierEscale($id_escale) {
    $pdo    = getConnexion();
    $escale = getEscaleById($id_escale);
    if (!$escale) die("Escale introuvable.");

    // Listes déroulantes
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
        SELECT pa.id_poste_accostage, pa.numero AS poste_numero, q.nom AS quai_nom
        FROM poste_accostage pa JOIN quai q ON q.id_quai = pa.id_quai
        ORDER BY q.reference, pa.numero
    ")->fetchAll(PDO::FETCH_ASSOC);
    $navires = $pdo->query("SELECT * FROM navire")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // ── Action 1 : refuser la demande ────────────────────────────────
        if (isset($_POST['action']) && $_POST['action'] === 'refuser') {
            updateEscaleStatut($id_escale, 'refusee');
            header("Location: index.php?page=escales&statut=refusee&success="
                . urlencode("Demande refusée"));
            exit;
        }

        // ── Action 2 : marquer comme terminée ─────────────────────────────
        if (isset($_POST['action']) && $_POST['action'] === 'terminer') {
            updateEscaleStatut($id_escale, 'terminee');
            header("Location: index.php?page=escales&statut=terminee&success="
                . urlencode("Escale terminée"));
            exit;
        }

        // ── Action 3 : modification standard (avec ou sans validation) ────

        // Détermine le nouveau statut :
        //  - Si on était en_attente et qu'on remplit les ressources -> validee
        //  - Sinon on garde le statut actuel (sauf si choix explicite)
        $nouveauStatut = $_POST['statut'] ?? $escale['statut'];

        // Si on passe à validee, on EXIGE poste/docker/pilote1
        if ($nouveauStatut === 'validee') {
            if (empty($_POST['id_docker']) || empty($_POST['id_pilote1']) || empty($_POST['id_poste_accostage'])) {
                header("Location: index.php?page=escale_modifier&id_escale={$id_escale}&error="
                    . urlencode("Pour valider : docker, pilote d'entrée et poste d'accostage sont obligatoires"));
                exit;
            }
        }

        updateEscale(
            $id_escale,
            $_POST['date_arrive'],
            $_POST['date_depart'],
            $_POST['id_fret'],
            !empty($_POST['id_docker'])           ? (int) $_POST['id_docker']           : null,
            !empty($_POST['id_pilote1'])          ? (int) $_POST['id_pilote1']          : null,
            !empty($_POST['id_pilote2'])          ? (int) $_POST['id_pilote2']          : null,
            !empty($_POST['id_poste_accostage']) ? (int) $_POST['id_poste_accostage'] : null,
            $_POST['id_navire'],
            !empty($_POST['id_agent'])    ? (int) $_POST['id_agent']    : null,
            !empty($_POST['destination']) ? trim($_POST['destination']) : null,
            $nouveauStatut
        );

        $msg = $nouveauStatut === 'validee' && $escale['statut'] === 'en_attente'
            ? "Demande validée et affectée"
            : "Escale mise à jour";

        header("Location: index.php?page=escales&success=" . urlencode($msg));
        exit;
    }

    require __DIR__ . '/../view/Escale_modifier.php';
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function supprimerEscale($id_escale) {
    deleteEscale($id_escale);
    header("Location: index.php?page=escales&success=" . urlencode("Escale supprimée"));
    exit;
}