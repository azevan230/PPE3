<?php

require_once __DIR__ . '/Connexion.php';

// =============================================================================
// MODÈLE ARMATEUR — V2
// L'armateur est une SOCIÉTÉ : plus de prenom, ajout de mail
// =============================================================================

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

function insertArmateur($nom, $adresse, $tel, $mail = null) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO armateur (nom, adresse, tel, mail)
        VALUES (?, ?, ?, ?)
    ");
    return $stmt->execute([$nom, $adresse, $tel, $mail]);
}

// ─── Modifier ──────────────────────────────────────────────────────────────

function updateArmateur($id, $nom, $adresse, $tel, $mail = null) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("
        UPDATE armateur
        SET nom = ?, adresse = ?, tel = ?, mail = ?
        WHERE id = ?
    ");
    return $stmt->execute([$nom, $adresse, $tel, $mail, $id]);
}

// ─── Supprimer ─────────────────────────────────────────────────────────────

function deleteArmateur($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM armateur WHERE id = ?");
    return $stmt->execute([$id]);
}

// ─── Utilitaires ───────────────────────────────────────────────────────────

function countNaviresByArmateur($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM navire WHERE id = ?");
    $stmt->execute([$id]);
    return (int) $stmt->fetchColumn();
}

/**
 * Compte le nombre d'utilisateurs (comptes mobiles) liés à un armateur
 * Utile dans la vue détails pour afficher s'il y a un contact actif.
 */
function countUtilisateursByArmateur($id) {
    $pdo  = getConnexion();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE id_armateur = ?");
    $stmt->execute([$id]);
    return (int) $stmt->fetchColumn();
}