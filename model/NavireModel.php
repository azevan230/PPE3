<?php
require_once "connexion.php"; // ton fichier de connexion

function getNavires() {
    $pdo = getConnexion(); // récupérer la connexion
    $stmt = $pdo->query("SELECT * FROM navire");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getNavireById($id_navire) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM navire WHERE id_navire = ?");
    $stmt->execute([$id_navire]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertNavire($nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("
        INSERT INTO navire 
        (nom, autorise, longueur, largeur, tirant_eau, capacite, propulseur, remorqueur, id_fret, id_port) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port]);
}

function updateNavire($id_navire, $nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("
        UPDATE navire SET 
        nom=?, autorise=?, longueur=?, largeur=?, tirant_eau=?, capacite=?, propulseur=?, remorqueur=?, id_fret=?, id_port=? 
        WHERE id_navire=?
    ");
    $stmt->execute([$nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_port, $id_navire]);
}

function deleteNavire($id_navire) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("DELETE FROM navire WHERE id_navire = ?");
    $stmt->execute([$id_navire]);
}
