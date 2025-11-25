<?php
session_start();

// Inclure la configuration de la base de données
require_once 'config/config.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Gestion des routes
$page = isset($_GET['page']) ? $_GET['page'] : 'quais';

try {
    switch($page) {
        case 'quais':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listeQuais();
            break;
            
        case 'postes':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listePostes();
            break;
            
        case 'creer_quai':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->creerQuai();
            break;
            
        case 'modifier_quai':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->modifierQuai();
            break;
            
        case 'supprimer_quai':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->supprimerQuai();
            break;
            
        case 'creer_poste':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->creerPoste();
            break;
            
        case 'supprimer_poste':
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->supprimerPoste();
            break;
            
        default:
            require_once 'controller/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listeQuais();
            break;
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// ARRÊTER l'exécution ici pour éviter que le HTML s'affiche directement
exit();
?>