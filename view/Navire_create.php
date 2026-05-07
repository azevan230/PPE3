<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un navire - Port de La Rochelle</title>
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
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
            color: #ffb3ba;
        }

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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

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
        input[type="number"],
        select {
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
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #4dd0e1;
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 0 3px rgba(77,208,225,0.2);
        }

        select option { background: #1a3a4a; color: #ffffff; }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4dd0e1;
            cursor: pointer;
        }

        .checkbox-group label {
            margin: 0;
            color: #e0e0e0;
            font-size: 0.95em;
            text-transform: none;
            letter-spacing: 0;
            cursor: pointer;
        }

        .section-title {
            color: #4dd0e1;
            font-size: 0.85em;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(77,208,225,0.3);
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
            .form-row { grid-template-columns: 1fr; }
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
                <h1>Nouveau navire</h1>
            </div>
            <a href="index.php?page=navires" class="btn btn-secondary">← Retour</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="message">✗ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="index.php?page=navire_create">

                <div class="form-group">
                    <label for="nom">Nom du navire *</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <p class="section-title">Caractéristiques</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="longueur">Longueur (m)</label>
                        <input type="number" id="longueur" name="longueur" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="largeur">Largeur (m)</label>
                        <input type="number" id="largeur" name="largeur" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="tirant_eau">Tirant d'eau (m)</label>
                        <input type="number" id="tirant_eau" name="tirant_eau" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="capacite">Capacité (t)</label>
                        <input type="number" id="capacite" name="capacite" step="0.1" min="0">
                    </div>
                </div>

                <p class="section-title">Options</p>
                <div class="checkbox-group">
                    <input type="checkbox" id="autorise" name="autorise" value="1">
                    <label for="autorise">Autorisé</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="propulseur" name="propulseur" value="1">
                    <label for="propulseur">Propulseur</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="remorqueur" name="remorqueur" value="1">
                    <label for="remorqueur">Remorqueur</label>
                </div>

                <p class="section-title" style="margin-top:25px;">Associations</p>
                <div class="form-group">
                    <label for="id_fret">Type de fret</label>
                    <select id="id_fret" name="id_fret">
                        <option value="">-- Sélectionner un fret --</option>
                        <?php foreach ($frets as $fret): ?>
                            <option value="<?= $fret['id_fret'] ?>">
                                <?= htmlspecialchars($fret['type']) ?> - <?= htmlspecialchars($fret['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_armateur">Armateur</label>
                    <select id="id_armateur" name="id_armateur">
                        <option value="">-- Sélectionner un armateur --</option>
                        <?php foreach ($armateurs as $armateur): ?>
                            <option value="<?= $armateur['id'] ?>">
                                <?= htmlspecialchars($armateur['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_port">Port d'attache</label>
                    <select id="id_port" name="id_port">
                        <option value="">-- Sélectionner un port --</option>
                        <?php foreach ($ports as $port): ?>
                            <option value="<?= $port['id_port'] ?>">
                                <?= htmlspecialchars($port['nom']) ?> - <?= htmlspecialchars($port['ville']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✔ Créer le navire</button>
                    <a href="index.php?page=navires" class="btn btn-secondary">✕ Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
