<?php
require_once 'model/UserModel.php';
<<<<<<< HEAD
=======
require_once __DIR__ . '/../model/Navire.php'; // modèle Navire (doit implémenter getAll())
>>>>>>> Main2

class LoginController {

    public function handleRequest() {
        $error = '';
        $sessionModel = new SessionModel();
        
        // Si déjà connecté, rediriger vers accueil
        if ($sessionModel->isLoggedIn()) {
            header('Location: index.php?page=accueil');
            exit;
        }

        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $login = $_POST['user'] ?? '';
            $mdp = $_POST['password'] ?? '';

            if (!empty($login) && !empty($mdp)) {
                $model = new UserModel();
                $user = $model->checkLogin($login, $mdp);

                if ($user) {
                    // Connexion réussie
                    $sessionModel->createSession($user);
                    header('Location: index.php?page=accueil');
                    exit;
                } else {
                    $error = 'Identifiants incorrects';
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        }

        // Afficher la page de login avec le message d'erreur éventuel
        include 'view/login.php';
    }
}
?>