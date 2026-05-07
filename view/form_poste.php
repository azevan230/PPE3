<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Poste d'Accostage - Port de La Rochelle</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15,32,39,0.3) 0%, rgba(32,58,67,0.7) 50%, rgba(44,83,100,0.85) 100%);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title { display: flex; align-items: center; gap: 15px; }
        .header-icon { font-size: 2.5em; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); }

        h1 {
            color: #ffffff;
            font-size: 1.8em;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95em;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4dd0e1 0%, #26a69a 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(77,208,225,0.4);
        }

        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(77,208,225,0.6); }

        .btn-secondary {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.1) 100%);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-secondary:hover { background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.15) 100%); transform: translateY(-2px); }

        .message {
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .message.success { border-left: 4px solid #2ecc71; color: #a8e6cf; background: rgba(46,204,113,0.1); }
        .message.error   { border-left: 4px solid #e74c3c; color: #ffb3ba; background: rgba(231,76,60,0.1); }

        .form-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-group { margin-bottom: 25px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: #b0bec5;
            font-size: 0.9em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            color: #9e9e9e;
            font-size: 0.95em;
        }

        .info-box {
            background: rgba(77,208,225,0.08);
            border: 1px solid rgba(77,208,225,0.25);
            border-radius: 10px;
            padding: 15px 18px;
            color: #80deea;
            font-size: 0.9em;
            margin-bottom: 25px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; }
            h1 { font-size: 1.4em; }
            .form-actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <div class="header-icon">⚓</div>
                <h1>Nouveau Poste</h1>
            </div>
            <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" class="btn btn-secondary">← Retour</a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success">✓ <?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="message error">✗ <?= htmlspecialchars($_SESSION['erreur']) ?></div>
            <?php unset($_SESSION['erreur']); ?>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Quai associé</label>
                    <input type="text" value="<?= htmlspecialchars($quai->getNom()) ?> (ID: <?= $quai->getId_quai() ?>)" disabled>
                    <input type="hidden" name="id_quai" value="<?= $quai->getId_quai() ?>">
                </div>

                <div class="info-box">
                    ℹ Le poste d'accostage sera créé avec un identifiant automatique.
                    Vous pourrez le visualiser dans la liste des postes après création.
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✔ Créer le Poste</button>
                    <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" class="btn btn-secondary">✕ Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
