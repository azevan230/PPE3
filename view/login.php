<?php
// Ce fichier affiche le formulaire de connexion et les messages éventuels
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <script>
        // Script inutile ici, mais gardé pour compatibilité
        window.onload = function() {
            document.getElementById('login-btn').onclick = function() {
                hideRegisterFields();
            };
        };
    </script>
</head>
<body>
    <h2>Connexion</h2>
    <!-- Affiche le message d'erreur si besoin -->
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <!-- Affiche le message de succès si besoin -->
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <!-- Formulaire de connexion -->
    <form method="post">
        <label>Login :</label>
        <input type="text" name="user" required><br>
        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>
        <button type="submit" name="login" id="login-btn">Se connecter</button>
    </form>
</body>
</html>