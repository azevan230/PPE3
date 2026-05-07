<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($quai) && $quai->getId_quai() ? 'Modifier' : 'Créer' ?> un Quai - Port de La Rochelle</title>
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
            max-width: 800px;
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

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            color: #ffffff;
            font-size: 0.95em;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #4dd0e1;
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 0 3px rgba(77,208,225,0.2);
        }

        .fret-list {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            padding: 15px;
        }

        .fret-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 8px;
            border-left: 3px solid rgba(77,208,225,0.5);
            background: rgba(255,255,255,0.03);
            transition: background 0.2s;
        }

        .fret-item:last-child { margin-bottom: 0; }

        .fret-item.danger { border-left-color: rgba(231,76,60,0.7); }

        .fret-item:hover { background: rgba(255,255,255,0.07); }

        .fret-item input[type="checkbox"] {
            width: 17px;
            height: 17px;
            accent-color: #4dd0e1;
            cursor: pointer;
            flex-shrink: 0;
        }

        .fret-item label {
            margin: 0;
            color: #e0e0e0;
            font-size: 0.9em;
            text-transform: none;
            letter-spacing: 0;
            cursor: pointer;
        }

        .badge-danger {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(231,76,60,0.3);
            color: #ffb3ba;
            border: 1px solid rgba(231,76,60,0.5);
            border-radius: 12px;
            font-size: 0.75em;
            margin-left: 6px;
        }

        .form-hint { color: #78909c; font-size: 0.82em; margin-top: 6px; text-transform: none; letter-spacing: 0; font-weight: 400; }

        .empty-warning {
            color: #f9e79f;
            background: rgba(241,196,15,0.1);
            border: 1px solid rgba(241,196,15,0.3);
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 0.9em;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
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
                <div class="header-icon">🛳️</div>
                <h1><?= isset($quai) && $quai->getId_quai() ? 'Modifier le Quai' : 'Nouveau Quai' ?></h1>
            </div>
            <a href="index.php?page=quais" class="btn btn-secondary">← Retour</a>
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
                    <label for="nom">Nom du quai *</label>
                    <input type="text" id="nom" name="nom"
                           value="<?= isset($quai) ? htmlspecialchars($quai->getNom()) : '' ?>"
                           required maxlength="50">
                </div>

                <div class="form-group">
                    <label for="tirant_eau_max">Tirant d'eau maximum (m) *</label>
                    <input type="number" id="tirant_eau_max" name="tirant_eau_max"
                           step="0.1" min="0.1"
                           value="<?= isset($quai) ? htmlspecialchars($quai->getTirant_eau_max()) : '' ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Types de fret autorisés *</label>
                    <?php if (empty($typesFret)): ?>
                        <div class="empty-warning">⚠ Aucun type de fret disponible</div>
                    <?php else: ?>
                        <?php
                        $typesFretQuaiIds = [];
                        if (isset($typesFretQuai) && is_array($typesFretQuai)) {
                            foreach ($typesFretQuai as $fretQuai) {
                                $typesFretQuaiIds[] = $fretQuai['id_fret'];
                            }
                        }
                        ?>
                        <div class="fret-list">
                            <?php foreach ($typesFret as $fret): ?>
                                <div class="fret-item <?= $fret['danger'] ? 'danger' : '' ?>">
                                    <input type="checkbox"
                                           name="types_fret[]"
                                           value="<?= $fret['id_fret'] ?>"
                                           id="fret_<?= $fret['id_fret'] ?>"
                                           <?= in_array($fret['id_fret'], $typesFretQuaiIds) ? 'checked' : '' ?>>
                                    <label for="fret_<?= $fret['id_fret'] ?>">
                                        <strong><?= htmlspecialchars($fret['type']) ?></strong>
                                        — <?= htmlspecialchars($fret['libelle']) ?>
                                        <?php if ($fret['danger']): ?>
                                            <span class="badge-danger">Dangereux</span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <p class="form-hint">Sélectionnez les types de fret que ce quai peut accueillir</p>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        ✔ <?= isset($quai) && $quai->getId_quai() ? 'Modifier' : 'Créer' ?> le Quai
                    </button>
                    <a href="index.php?page=quais" class="btn btn-secondary">✕ Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
