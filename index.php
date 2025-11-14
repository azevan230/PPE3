<?php
require_once "controleur/controleur.php";

$page = $_GET['page'] ?? "employes";

switch ($page) {
    case "employes":
        afficherEmployes();
        break;

    case "ajouterEmploye":
        ajouterEmploye();
        break;

    case "modifierEmploye":
        modifierEmploye(); // On récupère l'ID dans la fonction
        break;

    case "supprimerEmploye":
        supprimerEmploye(); // On récupère l'ID dans la fonction
        break;

    default:
        echo "Page non trouvée.";
}
?>
