<?php

function getConnexion() {
    $pdo = new PDO("mysql:host=localhost;dbname=escale;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function getEmployes() {
    $pdo = getConnexion();
    return $pdo->query("SELECT * FROM employee ORDER BY id_employee")->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeById($id) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM employee WHERE id_employee = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertEmploye($nom, $prenom, $telephone, $role) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("INSERT INTO employee (nom, prenom, num_tel, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $telephone, $role]);
}

function updateEmploye($id, $nom, $prenom, $telephone, $role) {
    $pdo = getConnexion();
    $stmt = $pdo->prepare("UPDATE employee SET nom=?, prenom=?, num_tel=?, role=? WHERE id_employee=?");
    $stmt->execute([$nom, $prenom, $telephone, $role, $id]);
}

function deleteEmploye($id) {
    $pdo = getConnexion();

    // Vérifier si employé est utilisé dans pilote
    $stmt = $pdo->prepare("SELECT * FROM pilote WHERE id_employee = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) return false;

    // Vérifier si employé est utilisé dans docker
    $stmt = $pdo->prepare("SELECT * FROM docker WHERE id_employee = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) return false;

    // Supprimer l'employé
    $stmt = $pdo->prepare("DELETE FROM employee WHERE id_employee = ?");
    $stmt->execute([$id]);

    return true;
}

?>
