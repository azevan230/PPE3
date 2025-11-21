<?php
require_once 'model/UserModel.php';
<<<<<<< HEAD
require_once 'model/SessionModel.php';
=======
require_once __DIR__ . '/../model/Navire.php'; // modèle Navire (doit implémenter getAll())
>>>>>>> jonathan

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
<<<<<<< HEAD
                    // Connexion réussie
                    $sessionModel->createSession($user);
                    header('Location: index.php?page=accueil');
=======
                    // Démarre la session si nécessaire et enregistre l'utilisateur
                    if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                    }
                    $_SESSION['user'] = $user;

                    // Récupère la liste des navires via le modèle Navire
                    try {
                        $navireModel = new Navire();
                        $navires = method_exists($navireModel, 'getAll') ? $navireModel->getAll() : [];
                    } catch (\Throwable $e) {
                        // En cas d'erreur avec le modèle Navire, on garde la liste vide
                        $navires = [];
                    }

                    // Inclut la vue d'accueil (doit afficher $navires)
                    include 'view/accueil.php';
>>>>>>> jonathan
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