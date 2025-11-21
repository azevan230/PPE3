<?php
<<<<<<< HEAD
class Database {
    private static $instance = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PDO(
                'mysql:host=localhost;dbname=escale;charset=utf8mb4',
                'root',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$instance;
    }
=======
try {
    $pdo = new PDO('mysql:host=localhost;dbname=escale', 'root', '');
} catch (\PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
>>>>>>> jonathan
}