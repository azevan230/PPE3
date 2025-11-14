<?php
require_once 'model/UserModel.php';
require_once 'model/SessionModel.php';

class LoginController {

    // Méthode principale appelée depuis index.php
    public function handleRequest() {

        $error = '';
        $model = new UserModel(); // Accès au modèle utilisateur


        // --- Déconnexion en POST ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' 
            && isset($_POST['action']) 
            && $_POST['action'] === 'logout') {

            $sessionModel = new SessionModel();
            $sessionModel->destroySession();
            header('Location: index.php');
            exit;
        }


        // --- Connexion ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['login'])) {

                $login = $_POST['user'] ?? '';
                $mdp   = $_POST['password'] ?? '';

                // Vérifie les identifiants
                $user = $model->checkLogin($login, $mdp);

                if ($user) {
                    // Connexion OK -> création session
                    $sessionModel = new SessionModel();
                    $sessionModel->createSession($user);

                    include 'view/accueil.php';
                    exit;
                } else {
                    // Identifiants incorrects
                    $error = 'Identifiants incorrects';
                }
            }
        }

        // Affiche la page de login
        include 'view/login.php';
    }
}
?>
