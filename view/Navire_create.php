<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un navire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
        }
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-right: 10px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        button.btn {
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-error,
        .error-message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success,
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Créer un nouveau navire</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=navire_create">
            
            <div class="form-group">
                <label for="nom">Nom du navire *</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="autorise" name="autorise" value="1">
                <label for="autorise">Autorisé</label>
            </div>

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

            <div class="checkbox-group">
                <input type="checkbox" id="propulseur" name="propulseur" value="1">
                <label for="propulseur">Propulseur</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remorqueur" name="remorqueur" value="1">
                <label for="remorqueur">Remorqueur</label>
            </div>

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
                            <?= htmlspecialchars($armateur['nom']) ?> <?= htmlspecialchars($armateur['prenom']) ?>
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
                <button type="submit" class="btn btn-primary">Créer le navire</button>
                <a href="index.php?page=navires" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>