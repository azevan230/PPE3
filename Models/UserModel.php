<?php
class UserModel {
    // Objet PDO pour la connexion à la base de données
    private $pdo;

    // Constructeur : initialise la connexion PDO à la base 'escale'
    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=escale', 'root', '');
    }

    // Vérifie les identifiants de connexion pour la table 'utilisateur'
    // $login : identifiant saisi
    // $mdp : mot de passe saisi
    public function checkLogin($login, $mdp) {
        // Prépare la requête pour récupérer l'utilisateur selon le login
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        // Vérifie que l'utilisateur existe et que le mot de passe SHA-256 correspond
        if ($user && hash('sha256', $mdp) === $user['mdp']) {
            return $user; // Connexion réussie
        }
        return false; // Connexion échouée
    }

    // ...existing code...
}
?>