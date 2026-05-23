<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un navire</title>
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
        .btn-info {
            background: #3498db;
            color: white;
        }
        .btn-info:hover {
            background: #2980b9;
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
        <h2>Modifier le navire : <?= htmlspecialchars($navire['nom']) ?></h2>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=navire_modifier&id_navire=<?= $navire['id_navire'] ?>">
            

            <div class="form-group">
                <label for="num_lloyds">N° Lloyds</label>
                <input type="text" id="num_lloyds" name="num_lloyds" maxlength="15" value="<?= htmlspecialchars($navire['num_lloyds'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="nom">Nom du navire *</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($navire['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="type_navire">Type de navire</label>
                <input type="text" id="type_navire" name="type_navire" value="<?= htmlspecialchars($navire['type_navire'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="pavillon">Pavillon</label>
                <input type="text" id="pavillon" name="pavillon" value="<?= htmlspecialchars($navire['pavillon'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="port_attache_nom">Port d'attache</label>
                <input type="text" id="port_attache_nom" name="port_attache_nom" value="<?= htmlspecialchars($navire['port_attache_nom'] ?? '') ?>">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="autorise" name="autorise" value="1" <?= $navire['autorise'] ? 'checked' : '' ?>>
                <label for="autorise">Autorisé</label>
            </div>

            <div class="form-group">
                <label for="longueur">Longueur (m)</label>
                <input type="number" id="longueur" name="longueur" step="0.1" min="0" value="<?= htmlspecialchars($navire['longueur']) ?>">
            </div>

            <div class="form-group">
                <label for="largeur">Largeur (m)</label>
                <input type="number" id="largeur" name="largeur" step="0.1" min="0" value="<?= htmlspecialchars($navire['largeur']) ?>">
            </div>

            <div class="form-group">
                <label for="tirant_eau">Tirant d'eau (m)</label>
                <input type="number" id="tirant_eau" name="tirant_eau" step="0.1" min="0" value="<?= htmlspecialchars($navire['tirant_eau']) ?>">
            </div>

            <div class="form-group">
                <label for="capacite">Capacité (t)</label>
                <input type="number" id="capacite" name="capacite" step="0.1" min="0" value="<?= htmlspecialchars($navire['capacite']) ?>">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="propulseur" name="propulseur" value="1" <?= $navire['propulseur'] ? 'checked' : '' ?>>
                <label for="propulseur">Propulseur</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remorqueur" name="remorqueur" value="1" <?= $navire['remorqueur'] ? 'checked' : '' ?>>
                <label for="remorqueur">Remorqueur</label>
            </div>

            <div class="form-group">
                <label for="id_fret">Type de fret</label>
                <select id="id_fret" name="id_fret">
                    <option value="">-- Sélectionner un fret --</option>
                    <?php foreach ($frets as $fret): ?>
                        <option value="<?= $fret['id_fret'] ?>" <?= $navire['id_fret'] == $fret['id_fret'] ? 'selected' : '' ?>>
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
                        <option value="<?= $armateur['id'] ?>" <?= $navire['id'] == $armateur['id'] ? 'selected' : '' ?>>
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
                        <option value="<?= $port['id_port'] ?>" <?= $navire['id_port'] == $port['id_port'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($port['nom']) ?> - <?= htmlspecialchars($port['ville']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="index.php?page=navire_details&id_navire=<?= $navire['id_navire'] ?>" class="btn btn-info">Annuler</a>
                <a href="index.php?page=navires" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
</body>
</html>