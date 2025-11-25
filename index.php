<?php
<<<<<<< HEAD
session_start(); // Démarrer la session dès le début

require_once "controller/EmployeController.php";
require_once "controller/EscaleController.php";
require_once "controller/NavireController.php";
require_once 'controller/LoginController.php';
require_once 'model/SessionModel.php';

$page = $_GET['page'] ?? "login";

// Gestion de la déconnexion
if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    $sessionModel = new SessionModel();
    $sessionModel->destroySession();
    header('Location: index.php?page=login');
    exit;
}

// Si pas connecté et pas sur la page login, rediriger vers login
$sessionModel = new SessionModel();
if (!$sessionModel->isLoggedIn() && $page !== 'login') {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {
    case "login":
        $loginController = new LoginController();
        $loginController->handleRequest();
        break;
    
    case "accueil":
        require "view/accueil.php";
        break;
        
    // ---------------- EMPLOYES ----------------
    case "employes":
        afficherEmployes();
        break;
    case "ajouterEmploye":
        ajouterEmploye();
        break;
    case "modifierEmploye":
        if (!isset($_GET['id'])) die("ID manquant");
        modifierEmploye((int)$_GET['id']);
        break;
    case "supprimerEmploye":
        if (!isset($_GET['id'])) die("ID manquant");
        supprimerEmploye((int)$_GET['id']);
        break;

    // ---------------- ESCALES ----------------
    case "escales":
        afficherEscales();
        break;
    case "escale_create":
        creerEscale();
        break;
    case "escale_details":
        if (!isset($_GET['id_escale'])) die("ID escale manquant");
        afficherEscale((int)$_GET['id_escale']);
        break;
    case "escale_modifier":
        if (!isset($_GET['id_escale'])) die("ID escale manquant");
        modifierEscale((int)$_GET['id_escale']);
        break;
    case "escale_supprimer":
        if (!isset($_GET['id_escale'])) die("ID escale manquant");
        supprimerEscale((int)$_GET['id_escale']);
        break;

    // ---------------- NAVIRES ----------------
    case "navires":
        afficherNavires();
        break;
    case "navire_create":
        creerNavire();
        break;
    case "navire_details":
        if (!isset($_GET['id_navire'])) die("ID navire manquant");
        afficherNavire((int)$_GET['id_navire']);
        break;
    case "navire_modifier":
        if (!isset($_GET['id_navire'])) die("ID navire manquant");
        modifierNavire((int)$_GET['id_navire']);
        break;
    case "navire_supprimer":
        if (!isset($_GET['id_navire'])) die("ID navire manquant");
        supprimerNavire((int)$_GET['id_navire']);
        break;

    default:
        echo "Page non trouvée.";
}
=======
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
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listeQuais();
            break;
            
        case 'postes':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listePostes();
            break;
            
        case 'creer_quai':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->creerQuai();
            break;
            
        case 'modifier_quai':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->modifierQuai();
            break;
            
        case 'supprimer_quai':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->supprimerQuai();
            break;
            
        case 'creer_poste':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->creerPoste();
            break;
            
        case 'supprimer_poste':
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->supprimerPoste();
            break;
            
        default:
            require_once 'controllers/QuaiController.class.php';
            $controller = new QuaiController($db);
            $controller->listeQuais();
            break;
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// ARRÊTER l'exécution ici pour éviter que le HTML s'affiche directement
exit();
>>>>>>> evan
?>