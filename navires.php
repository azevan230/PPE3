<?php
// Démarre la session si besoin (navigation protégée si nécessaire)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Appel du contrôleur Navire
require_once __DIR__ . '/controller/NavireController.php';
$controller = new NavireController();
$controller->handleRequest();
?>
