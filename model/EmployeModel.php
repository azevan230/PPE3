<?php

// Inclure le fichier de connexion partagé
require_once "Connexion.php";

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
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO employee (nom, prenom, num_tel, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $telephone, $role]);
        $id = (int) $pdo->lastInsertId();

        if ($role === 'pilote') {
            $pdo->prepare("INSERT INTO pilote (id_employee) VALUES (?)")->execute([$id]);
        } elseif ($role === 'docker') {
            $pdo->prepare("INSERT INTO docker (id_employee) VALUES (?)")->execute([$id]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function updateEmploye($id, $nom, $prenom, $telephone, $role) {
    $pdo = getConnexion();
    $pdo->beginTransaction();
    try {
        // 1. Update employee
        $stmt = $pdo->prepare("UPDATE employee SET nom=?, prenom=?, num_tel=?, role=? WHERE id_employee=?");
        $stmt->execute([$nom, $prenom, $telephone, $role, $id]);

        // 2. Réaligner les tables de spécialisation
        $pdo->prepare("DELETE FROM pilote WHERE id_employee = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM docker WHERE id_employee = ?")->execute([$id]);

        if ($role === 'pilote') {
            $pdo->prepare("INSERT INTO pilote (id_employee) VALUES (?)")->execute([$id]);
        } elseif ($role === 'docker') {
            $pdo->prepare("INSERT INTO docker (id_employee) VALUES (?)")->execute([$id]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deleteEmploye($id) {
    $pdo = getConnexion();
    $pdo->beginTransaction();
    try {
        // Vérifier si employé référencé dans une escale (docker OU pilote)
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM escale
            WHERE id_employee = ? OR id_employee_1 = ? OR id_employee_2 = ?
        ");
        $stmt->execute([$id, $id, $id]);
        if ($stmt->fetchColumn() > 0) {
            $pdo->rollBack();
            return false;
        }

        // Nettoyage tables de spécialisation puis suppression
        $pdo->prepare("DELETE FROM pilote WHERE id_employee = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM docker WHERE id_employee = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM employee WHERE id_employee = ?")->execute([$id]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

?>
