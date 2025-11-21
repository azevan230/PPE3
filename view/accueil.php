<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Escales - Port de La Rochelle</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('image.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
        }
        
        .container {
            position: relative;
            z-index: 2;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            margin: 0;
        }
        
        .user-info {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }
        
        .clickable-div {
            flex: 1;
            min-width: 200px;
            max-width: 300px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
            border: 2px solid #333;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        
        .clickable-div:hover {
            background-color: rgba(255, 255, 255, 1);
            transform: scale(1.05);
        }
        
        .logout-btn {
            padding: 10px 20px;
            background: #c0392b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #a02818;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>GESTION DES ESCALES - PORT DE LA ROCHELLE</h1>
        
        <div class="user-info">
            <span>Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?></strong></span>
            <form method="POST" action="index.php" style="margin: 0;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
        
        <!-- Première ligne avec 3 divs -->
        <div class="row">
            <a href="index.php?page=navires" class="clickable-div">Gestion des navires</a>
            <a href="page2.html" class="clickable-div">Gestion des armateurs</a>
            <a href="index.php?page=escales" class="clickable-div">Gestion des demandes d'escales</a>
        </div>
        
        <!-- Deuxième ligne avec 3 divs -->
        <div class="row">
            <a href="page4.html" class="clickable-div">Gestion des infrastructures</a>
            <a href="index.php?page=employes" class="clickable-div">Gestion des employés</a>
            <a href="index.php?page=escales" class="clickable-div">Gestion des escales</a>
        </div>
    </div>
</body>
</html>