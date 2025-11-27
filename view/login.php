<?php
// Ce fichier affiche le formulaire de connexion et les messages éventuels
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Port de La Rochelle</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
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
        
        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .login-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 50px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-icon {
            font-size: 4em;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        h2 {
            color: #ffffff;
            font-size: 2em;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .subtitle {
            color: #a8dadc;
            font-size: 0.95em;
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        label {
            color: #ffffff;
            font-size: 0.95em;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        input[type="text"],
        input[type="password"] {
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #ffffff;
            font-size: 1em;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: #4dd0e1;
            box-shadow: 0 0 15px rgba(77, 208, 225, 0.3);
        }
        
        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        button[type="submit"] {
            padding: 15px 30px;
            background: linear-gradient(135deg, #4dd0e1 0%, #26a69a 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(77, 208, 225, 0.4);
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(77, 208, 225, 0.6);
        }
        
        button[type="submit"]:active {
            transform: translateY(0);
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                padding: 40px 30px;
            }
            
            h2 {
                font-size: 1.6em;
            }
            
            .login-icon {
                font-size: 3em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">⚓</div>
                <h2>Connexion</h2>
                <p class="subtitle">Port de La Rochelle</p>
            </div>
            
            <!-- Formulaire de connexion -->
            <form method="post">
                <div class="form-group">
                    <label for="user">Login :</label>
                    <input type="text" name="user" id="user" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" id="password" required>
                </div>
                
                <button type="submit" name="login" id="login-btn">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>