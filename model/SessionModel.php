<?php
class SessionModel {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function createSession($user) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['username'] = $user['login'];
    }

    public function destroySession() {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}