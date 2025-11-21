<nav>
    <a href="index.php?page=employes">Employés</a> |
    <a href="index.php?page=escales">Escales</a>
</nav>

<?php
require_once "controleur/EmployeControleur.php";
require_once "controleur/EscaleControleur.php";

$page = $_GET['page'] ?? "employes";

switch ($page) {
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

    default:
        echo "Page non trouvée.";
}
?>
