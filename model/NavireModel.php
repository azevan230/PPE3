<?php

require_once __DIR__ . '/Connexion.php'; // connexion unique

// ─── Lire ──────────────────────────────────────────────────────────────────

function getNavires() {
    $pdo = getConnexion();
    return $pdo->query("SELECT * FROM navire")->fetchAll(PDO::FETCH_ASSOC);
}

function getNavireById($id_navire) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM navire WHERE id_navire = ?");
    $stmt->execute([$id_navire]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ─── Créer ─────────────────────────────────────────────────────────────────

function insertNavire($nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port,
                     $num_lloyds = null, $type_navire = null, $pavillon = null, $port_attache_nom = null) {
    if (empty($id_fret) || empty($id_armateur) || empty($id_port)) {
        throw new Exception("Le type de fret, l'armateur et le port sont obligatoires");
    }
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO navire (num_lloyds, nom, type_navire, pavillon, port_attache_nom, autorise, longueur, largeur, tirant_eau, capacite, propulseur, remorqueur, id_fret, id, id_port)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([$num_lloyds, $nom, $type_navire, $pavillon, $port_attache_nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port]);
}

// ─── Modifier ──────────────────────────────────────────────────────────────
// CORRECTION : id_armateur (colonne "id") est maintenant inclus dans l'UPDATE

function updateNavire($id_navire, $nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port,
                     $num_lloyds = null, $type_navire = null, $pavillon = null, $port_attache_nom = null) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        UPDATE navire SET
            num_lloyds       = ?,
            nom              = ?,
            type_navire      = ?,
            pavillon         = ?,
            port_attache_nom = ?,
            autorise         = ?,
            longueur         = ?,
            largeur          = ?,
            tirant_eau       = ?,
            capacite         = ?,
            propulseur       = ?,
            remorqueur       = ?,
            id_fret          = ?,
            id               = ?,
            id_port          = ?
        WHERE id_navire = ?
    ");
    return $stmt->execute([$num_lloyds, $nom, $type_navire, $pavillon, $port_attache_nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port, $id_navire]);
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function deleteNavire($id_navire) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM navire WHERE id_navire = ?");
    return $stmt->execute([$id_navire]);
}

// ─── Utilitaires pour les listes déroulantes ───────────────────────────────

function getAllFrets() {
    $pdo = getConnexion();
    return $pdo->query("SELECT id_fret, type, libelle FROM fret ORDER BY type")->fetchAll(PDO::FETCH_ASSOC);
}

function getAllArmateurs() {
    $pdo = getConnexion();
    return $pdo->query("SELECT id, nom FROM armateur ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPorts() {
    $pdo = getConnexion();
    return $pdo->query("SELECT id_port, nom, ville FROM port ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
}