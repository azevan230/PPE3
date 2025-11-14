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
    </style>

</head>
<body>
    <div class="container">
        <h1>GESTION DES ESCALES - PORT DE LA ROCHELLE</h1>
        <form method="POST" action="index.php" style="position:absolute; top:20px; right:20px;">
            <input type="hidden" name="action" value="logout">
            <button type="submit" 
                    style="padding:10px 20px; background:#c0392b; color:white; border:none; border-radius:5px; cursor:pointer;">
                Déconnexion
            </button>
        </form>
        
        <!-- Première ligne avec 3 divs -->
        <div class="row">
            <a href="page1.html" class="clickable-div">Gestion des navires</a>
            <a href="page2.html" class="clickable-div">Gestion des armateurs</a>
            <a href="page3.html" class="clickable-div">Gestion des demandes d'escales</a>
        </div>
        
        <!-- Deuxième ligne avec 3 divs -->
        <div class="row">
            <a href="page4.html" class="clickable-div">Gestion des infrastructures</a>
            <a href="page5.html" class="clickable-div">Gestion des employés</a>
            <a href="page6.html" class="clickable-div">Gestion des escales</a>
        </div>
    </div>
</body>
</html>