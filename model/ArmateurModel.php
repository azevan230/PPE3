<?php

require_once __DIR__ . '/Connexion.php'; // connexion unique via getConnexion()

// ─── Lire ──────────────────────────────────────────────────────────────────

function getArmateurs() {
    $pdo = getConnexion();
    return $pdo->query("SELECT * FROM armateur ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
}

function getArmateurById($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM armateur WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ─── Créer ─────────────────────────────────────────────────────────────────

function insertArmateur($nom, $prenom, $adresse, $tel) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO armateur (nom, adresse, tel)
        VALUES (?, ?, ?)
    ");
    return $stmt->execute([$nom, $adresse, $tel]);
}

// ─── Modifier ──────────────────────────────────────────────────────────────

function updateArmateur($id, $nom, $adresse, $tel) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        UPDATE armateur
        SET nom = ?, adresse = ?, tel = ?
        WHERE id = ?
    ");
    return $stmt->execute([$nom, $adresse, $tel, $id]);
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function deleteArmateur($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM armateur WHERE id = ?");
    return $stmt->execute([$id]);
}

// ─── Utilitaire ────────────────────────────────────────────────────────────

function countNaviresByArmateur($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM navire WHERE id = ?");
    $stmt->execute([$id]);
    return (int) $stmt->fetchColumn();
}