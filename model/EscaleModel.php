<?php

require_once __DIR__ . '/Connexion.php';

// =============================================================================
// MODÈLE ESCALE — V2
// Gestion du statut (en_attente / validee / refusee / terminee) et des
// affectations (pilote/docker/poste) qui peuvent être NULL en attente
// =============================================================================

// ─── Lire toutes les escales ───────────────────────────────────────────────
// LEFT JOIN partout sur les ressources qui peuvent être NULL en statut en_attente

function getEscales() {
    $pdo = getConnexion();
    return $pdo->query("
        SELECT
            e.id_escale,
            e.date_arrive,
            e.date_depart,
            e.destination,
            e.provenance,
            e.tonnage,
            e.import_export,
            e.matieres_dangereuses,
            e.statut,

            f.type      AS fret_type,
            f.libelle   AS fret_libelle,

            ag.nom      AS agent_nom,

            d.nom       AS docker_nom,
            d.prenom    AS docker_prenom,

            p1.nom      AS pilote1_nom,
            p1.prenom   AS pilote1_prenom,

            p2.nom      AS pilote2_nom,
            p2.prenom   AS pilote2_prenom,

            e.id_poste_accostage,
            pa.numero   AS poste_numero,
            q.nom       AS quai_nom,

            n.nom       AS navire_nom,
            n.id        AS id_armateur,
            arm.nom     AS armateur_nom

        FROM escale e
        JOIN fret              f   ON f.id_fret             = e.id_fret
        LEFT JOIN agent        ag  ON ag.id_agent           = e.id_agent
        LEFT JOIN employee     d   ON d.id_employee         = e.id_employee
        LEFT JOIN employee     p1  ON p1.id_employee        = e.id_employee_1
        LEFT JOIN employee     p2  ON p2.id_employee        = e.id_employee_2
        LEFT JOIN poste_accostage pa ON pa.id_poste_accostage = e.id_poste_accostage
        LEFT JOIN quai         q   ON q.id_quai             = pa.id_quai
        JOIN navire            n   ON n.id_navire           = e.id_navire
        LEFT JOIN armateur     arm ON arm.id                = n.id
        ORDER BY
            FIELD(e.statut, 'en_attente', 'validee', 'terminee', 'refusee'),
            e.date_arrive DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
}

// ─── Lire une escale ───────────────────────────────────────────────────────

function getEscaleById($id_escale) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        SELECT
            e.*,

            f.type      AS fret_type,
            f.libelle   AS fret_libelle,

            ag.nom      AS agent_nom,

            d.nom       AS docker_nom,
            d.prenom    AS docker_prenom,

            p1.nom      AS pilote1_nom,
            p1.prenom   AS pilote1_prenom,

            p2.nom      AS pilote2_nom,
            p2.prenom   AS pilote2_prenom,

            n.nom       AS navire_nom,
            n.id        AS id_armateur,
            arm.nom     AS armateur_nom,

            pa.numero   AS poste_numero,
            q.nom       AS quai_nom

        FROM escale e
        JOIN fret              f   ON f.id_fret             = e.id_fret
        LEFT JOIN agent        ag  ON ag.id_agent           = e.id_agent
        LEFT JOIN employee     d   ON d.id_employee         = e.id_employee
        LEFT JOIN employee     p1  ON p1.id_employee        = e.id_employee_1
        LEFT JOIN employee     p2  ON p2.id_employee        = e.id_employee_2
        JOIN navire            n   ON n.id_navire           = e.id_navire
        LEFT JOIN armateur     arm ON arm.id                = n.id
        LEFT JOIN poste_accostage pa ON pa.id_poste_accostage = e.id_poste_accostage
        LEFT JOIN quai         q   ON q.id_quai             = pa.id_quai
        WHERE e.id_escale = ?
    ");
    $stmt->execute([$id_escale]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ─── Créer (par la capitainerie depuis le web) ─────────────────────────────

function insertEscale($date_arrive, $date_depart, $id_fret, $id_docker, $id_pilote1, $id_pilote2, $id_poste_accostage, $id_navire, $id_agent = null, $destination = null, $statut = 'validee') {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO escale
            (date_arrive, date_depart, id_fret, id_employee, id_employee_1, id_employee_2,
             id_poste_accostage, id_navire, id_agent, destination, statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
        $date_arrive, $date_depart, $id_fret,
        $id_docker, $id_pilote1, $id_pilote2,
        $id_poste_accostage, $id_navire, $id_agent, $destination, $statut
    ]);
}

// ─── Modifier ──────────────────────────────────────────────────────────────
// IMPORTANT : id_docker, id_pilote1, id_pilote2, id_poste_accostage peuvent
// être NULL si l'escale est encore en_attente.

function updateEscale($id_escale, $date_arrive, $date_depart, $id_fret, $id_docker, $id_pilote1, $id_pilote2, $id_poste_accostage, $id_navire, $id_agent = null, $destination = null, $statut = null) {
    $pdo  = getConnexion();

    // Si statut fourni, on l'inclut dans l'update
    if ($statut !== null) {
        $stmt = $pdo->prepare("
            UPDATE escale SET
                date_arrive        = ?,
                date_depart        = ?,
                id_fret            = ?,
                id_employee        = ?,
                id_employee_1      = ?,
                id_employee_2      = ?,
                id_poste_accostage = ?,
                id_navire          = ?,
                id_agent           = ?,
                destination        = ?,
                statut             = ?
            WHERE id_escale = ?
        ");
        return $stmt->execute([
            $date_arrive, $date_depart, $id_fret,
            $id_docker, $id_pilote1, $id_pilote2,
            $id_poste_accostage, $id_navire,
            $id_agent, $destination, $statut, $id_escale
        ]);
    }

    $stmt = $pdo->prepare("
        UPDATE escale SET
            date_arrive        = ?,
            date_depart        = ?,
            id_fret            = ?,
            id_employee        = ?,
            id_employee_1      = ?,
            id_employee_2      = ?,
            id_poste_accostage = ?,
            id_navire          = ?,
            id_agent           = ?,
            destination        = ?
        WHERE id_escale = ?
    ");
    return $stmt->execute([
        $date_arrive, $date_depart, $id_fret,
        $id_docker, $id_pilote1, $id_pilote2,
        $id_poste_accostage, $id_navire,
        $id_agent, $destination, $id_escale
    ]);
}

// ─── Changer juste le statut (refuser, terminer) ───────────────────────────

function updateEscaleStatut($id_escale, $statut) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("UPDATE escale SET statut = ? WHERE id_escale = ?");
    return $stmt->execute([$statut, $id_escale]);
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function deleteEscale($id_escale) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM escale WHERE id_escale = ?");
    return $stmt->execute([$id_escale]);
}

// ─── Utilitaires ───────────────────────────────────────────────────────────

function getAllAgents() {
    $pdo = getConnexion();
    return $pdo->query("SELECT id_agent, nom FROM agent ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
}