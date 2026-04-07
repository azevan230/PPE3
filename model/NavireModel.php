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

function insertNavire($nom, $autorise, $longueur, $largeur, $tirant_eau, $capacite, $propulseur, $remorqueur, $id_fret, $id_armateur, $id_port) {
    $pdo = getConnexion();
    
    // Validation : les clés étrangères sont obligatoires
    if (empty($id_fret) || empty($id_armateur) || empty($id_port)) {
        throw new Exception("Le type de fret, l'armateur et le port sont obligatoires");
    }
    
    $stmt = $pdo->prepare("
        INSERT INTO navire 
        (nom, autorise, longueur, largeur, tirant_eau, capacite, propulseur, remorqueur, id_fret, id, id_port) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
        $nom, 
        $autorise, 
        $longueur, 
        $largeur, 
        $tirant_eau, 
        $capacite, 
        $propulseur, 
        $remorqueur, 
        $id_fret, 
        $id_armateur, 
        $id_port
    ]);
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

// Récupérer tous les frets pour les listes déroulantes
function getAllFrets() {
    $pdo = getConnexion();
    $stmt = $pdo->query("SELECT id_fret, type, libelle FROM fret ORDER BY type");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer tous les armateurs pour les listes déroulantes
function getAllArmateurs() {
    $pdo = getConnexion();
    $stmt = $pdo->query("SELECT id, nom, prenom FROM armateur ORDER BY nom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer tous les ports pour les listes déroulantes
function getAllPorts() {
    $pdo = getConnexion();
    $stmt = $pdo->query("SELECT id_port, nom, ville FROM port ORDER BY nom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
