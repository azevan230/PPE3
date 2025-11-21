<nav>
    <a href="index.php?page=employes">Employés</a> |
    <a href="index.php?page=escales">Escales</a> |
    <a href="index.php?page=navires">Navires</a>
</nav>

<?php
require_once "controller/EmployeController.php";
require_once "controller/EscaleController.php";
require_once "controller/NavireController.php";

$page = $_GET['page'] ?? "login";

switch ($page) {
    case "login":
        require "view/login.php";
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
