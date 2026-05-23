<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Escales - Port de La Rochelle</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('./public/img/fondRochelle.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
        }
        
        /* Overlay sombre pour améliorer la lisibilité */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 32, 39, 0.3) 0%, rgba(32, 58, 67, 0.7) 50%, rgba(44, 83, 100, 0.85) 100%);
            z-index: 1;
        }
        
        .container {
            position: relative;
            z-index: 2;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 100px; /* Espace pour le bouton de déconnexion */
        }
        
        /* Header avec logo et titre */
        .header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        h1 {
            text-align: center;
            color: #ffffff;
            font-size: 2.5em;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .subtitle {
            text-align: center;
            color: #a8dadc;
            font-size: 1.1em;
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        /* Info utilisateur */
        .user-info {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.1) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 25px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .user-info span {
            color: #ffffff;
            font-size: 0.95em;
        }
        
        .user-info strong {
            color: #4dd0e1;
            font-weight: 600;
        }
        
        .logout-btn {
            padding: 10px 25px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.6);
        }
        
        /* Grille des modules */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 40px;
            padding: 0 20px;
        }
        
        .module-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 35px 25px;
            text-decoration: none;
            color: #ffffff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .module-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(77, 208, 225, 0.1) 0%, rgba(38, 166, 154, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            border-color: rgba(77, 208, 225, 0.6);
        }
        
        .module-card:hover::before {
            opacity: 1;
        }
        
        .module-icon {
            font-size: 3em;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        .module-title {
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }
        
        .module-description {
            font-size: 0.9em;
            color: #b0bec5;
            position: relative;
            z-index: 1;
            line-height: 1.5;
        }
        
        /* Couleurs spécifiques par module */
        .module-card:nth-child(1) { border-left: 4px solid #3498db; }
        .module-card:nth-child(2) { border-left: 4px solid #9b59b6; }
        .module-card:nth-child(3) { border-left: 4px solid #e74c3c; }
        .module-card:nth-child(4) { border-left: 4px solid #1abc9c; }
        .module-card:nth-child(5) { border-left: 4px solid #f39c12; }
        .module-card:nth-child(6) { border-left: 4px solid #2ecc71; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-top: 140px; /* Plus d'espace sur mobile */
            }
            
            h1 {
                font-size: 1.8em;
            }
            
            .user-info {
                position: fixed;
                top: 10px;
                left: 10px;
                right: 10px;
                width: calc(100% - 20px);
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px 15px;
            }
            
            .user-info span {
                font-size: 0.85em;
            }
            
            .modules-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                padding: 20px;
            }
        }
        
        /* Animation d'entrée */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .module-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .module-card:nth-child(1) { animation-delay: 0.1s; }
        .module-card:nth-child(2) { animation-delay: 0.2s; }
        .module-card:nth-child(3) { animation-delay: 0.3s; }
        .module-card:nth-child(4) { animation-delay: 0.4s; }
        .module-card:nth-child(5) { animation-delay: 0.5s; }
        .module-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <span>Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?></strong></span>
            <form method="POST" action="index.php" style="margin: 0;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
        
        <div class="header">
            <h1>⚓ Gestion des Escales</h1>
            <p class="subtitle">Port de La Rochelle - Système de gestion portuaire</p>
        </div>
        
        <div class="modules-grid">
            <a href="index.php?page=navires" class="module-card">
                <div class="module-icon">🚢</div>
                <div class="module-title">Gestion des Navires</div>
                <div class="module-description">Enregistrer et gérer les informations des navires</div>
            </a>
            
            <a href="index.php?page=armateurs" class="module-card">
                <div class="module-icon">👔</div>
                <div class="module-title">Gestion des Armateurs</div>
                <div class="module-description">Gérer les propriétaires de navires</div>
            </a>
            
            <a href="index.php?page=escales&statut=tous" class="module-card">
                <div class="module-icon">📋</div>
                <div class="module-title">Toutes les Escales</div>
                <div class="module-description">Liste complète et suivi des escales</div>
            </a>
            
            <a href="index.php?page=quais" class="module-card">
                <div class="module-icon">🏗️</div>
                <div class="module-title">Infrastructures</div>
                <div class="module-description">Gérer les quais et postes d'accostage</div>
            </a>
            
            <a href="index.php?page=employes" class="module-card">
                <div class="module-icon">👥</div>
                <div class="module-title">Gestion des Employés</div>
                <div class="module-description">Pilotes, dockers et personnel portuaire</div>
            </a>
            
            <a href="index.php?page=escales&statut=en_attente" class="module-card">
                <div class="module-icon">📊</div>
                <div class="module-title">Demandes en attente</div>
                <div class="module-description">Demandes envoyées par les armateurs à valider</div>
            </a>
        </div>
    </div>
</body>
</html>