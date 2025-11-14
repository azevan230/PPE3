<?php
require_once "modele/modele.php";

function afficherEmployes() {
    $employes = getEmployes();
    $message = $_GET['deleted'] ?? '';
    require "vue/liste.php";
}

function ajouterEmploye() {
    if (!empty($_POST)) {
        insertEmploye($_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['role']);
        header("Location: index.php?page=employes");
        exit;
    }
    require "vue/ajouter.php";
}

function modifierEmploye() {
    if (!isset($_GET['id'])) {
        die("Erreur : ID manquant");
    }

    $id = intval($_GET['id']);
    $employe = getEmployeById($id);

    if (!$employe) die("Employé introuvable.");

    if (!empty($_POST)) {
        updateEmploye($id, $_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['role']);
        header("Location: index.php?page=employes");
        exit;
    }

    require "vue/modifier.php";
}

function supprimerEmploye() {
    if (!isset($_GET['id'])) {
        die("Erreur : ID manquant");
    }

    $id = intval($_GET['id']);
    $res = deleteEmploye($id);

    if (!$res) {
        $message = "Impossible : cet employé est affecté à une escale.";
        $employes = getEmployes();
        require "vue/liste.php";
        return;
    }

    header("Location: index.php?page=employes&deleted=1");
    exit;
}
?>
