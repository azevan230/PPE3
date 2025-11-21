<?php
// Démarre la session pour gérer l'authentification
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'controller/LoginController.php';

$controller = new LoginController();
$controller->handleRequest();
?>
