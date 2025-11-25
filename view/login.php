<?php
// Ce fichier affiche le formulaire de connexion et les messages éventuels
?>
<!DOCTYPE html>
<html>
<style>
    .login{
        margin-top: 5%;
        margin-left: 40%;
    }
</style>

<div class="login">
    <h2>Connexion</h2>
    
    <!-- Formulaire de connexion -->
    <form method="post">
        <label>Login :</label>
        <input type="text" name="user" required><br>
        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>
        <button type="submit" name="login" id="login-btn">Se connecter</button>
    </form>
</div>
</html>