<?php
    require_once 'config/config.php';
    include 'controller/NavireController.php';
    $controller = new NavireController();
    $controller->handleRequest();
?>