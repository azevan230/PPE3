<?php

require_once "Connexion.php";

// Liste
function getEscales() {
    $pdo = getConnexion();
    $sql = "
        SELECT 
            e.id_escale,
            e.date_arrive,
            e.date_depart,

            f.type AS fret_type,
            f.libelle AS fret_libelle,

            d.nom AS docker_nom,
            d.prenom AS docker_prenom,

            p1.nom AS pilote1_nom,
            p1.prenom AS pilote1_prenom,

            p2.nom AS pilote2_nom,
            p2.prenom AS pilote2_prenom,

            pa.id_poste_accostage,
            q.nom AS quai_nom,

            n.nom AS navire_nom
        FROM escale e
        JOIN fret f ON f.id_fret = e.id_fret
        JOIN employee d ON d.id_employee = e.id_employee
        JOIN employee p1 ON p1.id_employee = e.id_employee_1
        JOIN employee p2 ON p2.id_employee = e.id_employee_2
        JOIN poste_accostage pa ON pa.id_poste_accostage = e.id_poste_accostage
        JOIN quai q ON q.id_quai = pa.id_quai
        JOIN navire n ON n.id_navire = e.id_navire
        ORDER BY e.id_escale ASC
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


// Une escale
function getEscaleById($id_escale) {
    $pdo = getConnexion();

    $stmt = $pdo->prepare("
        SELECT 
            e.*,

            -- FRET
            f.type AS fret_type,
            f.libelle AS fret_libelle,

            -- DOCKER
            d.nom AS docker_nom,
            d.prenom AS docker_prenom,

            -- PILOTE 1
            p1.nom AS pilote1_nom,
            p1.prenom AS pilote1_prenom,

            -- PILOTE 2
            p2.nom AS pilote2_nom,
            p2.prenom AS pilote2_prenom,

            -- NAVIRE
            n.nom AS navire_nom,

            -- POSTE + QUAI
            pa.id_poste_accostage,
            q.nom AS quai_nom

        FROM escale e
        
        JOIN fret f ON f.id_fret = e.id_fret
        JOIN employee d ON d.id_employee = e.id_employee
        
        JOIN employee p1 ON p1.id_employee = e.id_employee_1
        JOIN employee p2 ON p2.id_employee = e.id_employee_2
        
        JOIN navire n ON n.id_navire = e.id_navire

        JOIN poste_accostage pa ON pa.id_poste_accostage = e.id_poste_accostage
        JOIN quai q ON q.id_quai = pa.id_quai

        WHERE e.id_escale = ?
    ");

    $stmt->execute([$id_escale]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Création
function insertEscale($date_arrive, $date_depart, $id_fret, $id_docker, $id_pilote1, $id_pilote2, $id_poste_accostage, $id_navire) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO escale (date_arrive, date_depart, id_fret, id_employee, id_employee_1, id_employee_2, id_poste_accostage, id_navire)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$date_arrive, $date_depart, $id_fret, $id_docker, $id_pilote1, $id_pilote2, $id_poste_accostage, $id_navire]);
}

// Modification
function updateEscale($id_escale, $date_arrive, $date_depart, $id_fret, $id_docker, $id_pilote1, $id_pilote2, $id_poste_accostage, $id_navire) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("
        UPDATE escale SET 
            date_arrive = ?, 
            date_depart = ?, 
            id_fret = ?, 
            id_employee = ?, 
            id_employee_1 = ?, 
            id_employee_2 = ?, 
            id_poste_accostage = ?, 
            id_navire = ?
        WHERE id_escale = ?
    ");

    $stmt->execute([
        $date_arrive,
        $date_depart,
        $id_fret,
        $id_docker,
        $id_pilote1,
        $id_pilote2,
        $id_poste_accostage,
        $id_navire,
        $id_escale
    ]);
}


// Suppression
function deleteEscale($id_escale) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM escale WHERE id_escale=?");
    $stmt->execute([$id_escale]);
}
?>
