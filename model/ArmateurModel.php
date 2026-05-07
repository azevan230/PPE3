<?php
// Fonction pour obtenir la connexion PDO
function getConnexionArmateur() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=localhost;dbname=escale;charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    
    return $pdo;
}

// Récupérer tous les armateurs
function getArmateurs() {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->query("SELECT * FROM armateur ORDER BY id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer un armateur par son ID
function getArmateurById($id_armateur) {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->prepare("SELECT * FROM armateur WHERE id = ?");
    $stmt->execute([$id_armateur]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Insérer un nouvel armateur
function insertArmateur($nom, $adresse) {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->prepare("INSERT INTO armateur (nom, adresse) VALUES (?, ?)");
    return $stmt->execute([$nom, $adresse]);
}

// Mettre à jour un armateur
function updateArmateur($id_armateur, $nom, $adresse) {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->prepare("UPDATE armateur SET nom = ?, adresse = ? WHERE id = ?");
    return $stmt->execute([$nom, $adresse, $id_armateur]);
}

// Supprimer un armateur
function deleteArmateur($id_armateur) {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->prepare("DELETE FROM armateur WHERE id = ?");
    return $stmt->execute([$id_armateur]);
}

// Compter le nombre de navires d'un armateur
function countNaviresByArmateur($id_armateur) {
    $pdo = getConnexionArmateur();
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM navire WHERE id = ?");
    $stmt->execute([$id_armateur]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}
?>