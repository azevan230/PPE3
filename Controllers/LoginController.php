<?php
require_once 'model/UserModel.php';

// Contrôleur pour gérer la connexion utilisateur
class LoginController {
    // Méthode principale appelée depuis index.php
    public function handleRequest() {
        $error = ''; // Message d'erreur à afficher en cas d'échec
        $model = new UserModel(); // Instancie le modèle pour accéder à la base

        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si le bouton "Se connecter" a été cliqué
            if (isset($_POST['login'])) {
                // Récupère les valeurs du formulaire
                $login = $_POST['user'] ?? '';
                $mdp = $_POST['password'] ?? '';
                // Vérifie les identifiants via le modèle
                $user = $model->checkLogin($login, $mdp);
                if ($user) {
                    // Si la connexion réussit, redirige vers la page d'accueil
                    header('Location: accueil.php');
                    exit;
                } else {
                    // Sinon, affiche un message d'erreur
                    $error = 'Identifiants incorrects';
                }
            }
        }
        // Affiche la vue du formulaire de connexion
        include 'view/login.php';
    }
}
?>