<?php
<<<<<<< HEAD
session_start(); // Démarrer la session dès le début
=======
// Démarre la session pour gérer l'authentification
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'controller/LoginController.php';
>>>>>>> jonathan

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
?>