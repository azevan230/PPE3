<?php
require_once 'model/UserModel.php';

class LoginController {
    // Méthode principale appelée depuis index.php
    public function handleRequest() {
        $error = '';
        $model = new UserModel(); // Instancie le modèle pour accéder à la base

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['login'])) {
                $login = $_POST['user'] ?? '';
                $mdp = $_POST['password'] ?? '';
                // Vérifie les identifiants via le modèle
                $user = $model->checkLogin($login, $mdp);
                if ($user) {
                    // Si la connexion réussit, redirige vers la page d'accueil
                    include 'model/SessionModel.php';
                    $sessionModel = new SessionModel();
                    $sessionModel->createSession($user);
                    include 'view/accueil.php';
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