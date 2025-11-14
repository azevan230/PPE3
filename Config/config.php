<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=escale', 'root', '');
} catch (\PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}