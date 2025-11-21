<?php
require_once 'model/UserModel.php';
require_once __DIR__ . '/../model/Navire.php'; // modèle Navire (doit implémenter getAll())

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