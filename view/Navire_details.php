<?php
// Définition des variables depuis les paramètres GET/POST
$action = $_GET['action'] ?? 'create';
$id_navire = intval($_GET['id_navire'] ?? ($_POST['id_navire'] ?? 0));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
        echo ($action === 'create') ? 'Ajouter un navire' : 
             (($action === 'view') ? 'Détails du navire' : 'Modifier le navire');
    ?></title>
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
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
        }
        input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="checkbox"][disabled] {
            cursor: not-allowed;
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
        .btn-group {
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
        .info-group {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 16px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Déterminer les valeurs pour préremplir le formulaire
        $values = [
            'nom' => $navire['nom'] ?? '',
            'autorise' => $navire['autorise'] ?? 0,
            'longueur' => $navire['longueur'] ?? '',
            'largeur' => $navire['largeur'] ?? '',
            'tirant_eau' => $navire['tirant_eau'] ?? '',
            'capacite' => $navire['capacite'] ?? '',
            'propulseur' => $navire['propulseur'] ?? 0,
            'remorqueur' => $navire['remorqueur'] ?? 0,
            'id_fret' => $navire['id_fret'] ?? '',
            'id' => $navire['id'] ?? '',
            'id_port' => $navire['id_port'] ?? '',
        ];
        $readonly = ($action === 'view') ? 'readonly' : '';
        $disabled = ($action === 'view') ? 'disabled' : '';
        ?>

        <?php if ($action === 'view'): ?>
            <!-- MODE AFFICHAGE -->
            <h2>Détails du navire</h2>

            <div class="info-group">
                <div class="info-label">Nom</div>
                <div class="info-value"><?= htmlspecialchars($values['nom']) ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    <?php if ($values['autorise']): ?>
                        <span class="badge badge-success">✓ Autorisé</span>
                    <?php else: ?>
                        <span class="badge badge-danger">✗ Non autorisé</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Dimensions</div>
                <div class="info-value">
                    Longueur: <?= htmlspecialchars($values['longueur']) ?> m | 
                    Largeur: <?= htmlspecialchars($values['largeur']) ?> m | 
                    Tirant d'eau: <?= htmlspecialchars($values['tirant_eau']) ?> m
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">Capacité</div>
                <div class="info-value"><?= htmlspecialchars($values['capacite']) ?> tonnes</div>
            </div>

            <div class="info-group">
                <div class="info-label">Équipements</div>
                <div class="info-value">
                    <?php if ($values['propulseur']): ?>
                        <span class="badge badge-success">Propulseur</span>
                    <?php endif; ?>
                    <?php if ($values['remorqueur']): ?>
                        <span class="badge badge-success">Remorqueur</span>
                    <?php endif; ?>
                    <?php if (!$values['propulseur'] && !$values['remorqueur']): ?>
                        <span style="color: #999;">Aucun équipement spécial</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-group">
                <div class="info-label">ID Fret</div>
                <div class="info-value"><?= htmlspecialchars($values['id_fret']) ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">ID Armateur</div>
                <div class="info-value"><?= htmlspecialchars($values['id']) ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">ID Port</div>
                <div class="info-value"><?= htmlspecialchars($values['id_port']) ?></div>
            </div>

            <div class="btn-group">
                <a href="index.php?page=navires" class="btn btn-secondary">Retour à la liste</a>
            </div>

        <?php else: ?>
            <!-- MODE FORMULAIRE (CREATE ou UPDATE) -->
            <h2><?php echo ($action === 'create') ? 'Ajouter un navire' : 'Modifier le navire'; ?></h2>

            <form method="post" action="navire_details.php?action=<?php echo htmlspecialchars($action); ?><?php if ($id_navire) echo '&id_navire=' . $id_navire; ?>">
                <?php if ($action !== 'create'): ?>
                    <input type="hidden" name="id_navire" value="<?php echo $id_navire; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($values['nom']); ?>" <?php echo $readonly; ?> required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="autorise" id="autorise" value="1" <?php echo ($values['autorise'] ? 'checked' : ''); ?> <?php echo $disabled; ?>>
                    <label for="autorise">Autorisé</label>
                </div>

                <div class="form-group">
                    <label for="longueur">Longueur (m)</label>
                    <input type="number" step="0.1" name="longueur" id="longueur" value="<?php echo htmlspecialchars($values['longueur']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="form-group">
                    <label for="largeur">Largeur (m)</label>
                    <input type="number" step="0.1" name="largeur" id="largeur" value="<?php echo htmlspecialchars($values['largeur']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="form-group">
                    <label for="tirant_eau">Tirant d'eau (m)</label>
                    <input type="number" step="0.1" name="tirant_eau" id="tirant_eau" value="<?php echo htmlspecialchars($values['tirant_eau']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="form-group">
                    <label for="capacite">Capacité (t)</label>
                    <input type="number" step="0.1" name="capacite" id="capacite" value="<?php echo htmlspecialchars($values['capacite']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="propulseur" id="propulseur" value="1" <?php echo ($values['propulseur'] ? 'checked' : ''); ?> <?php echo $disabled; ?>>
                    <label for="propulseur">Propulseur</label>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="remorqueur" id="remorqueur" value="1" <?php echo ($values['remorqueur'] ? 'checked' : ''); ?> <?php echo $disabled; ?>>
                    <label for="remorqueur">Remorqueur</label>
                </div>

                <div class="form-group">
                    <label for="id_fret">ID Fret</label>
                    <input type="number" name="id_fret" id="id_fret" value="<?php echo htmlspecialchars($values['id_fret']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="form-group">
                    <label for="id">ID Armateur</label>
                    <input type="number" name="id" id="id" value="<?php echo htmlspecialchars($values['id']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="form-group">
                    <label for="id_port">ID Port</label>
                    <input type="number" name="id_port" id="id_port" value="<?php echo htmlspecialchars($values['id_port']); ?>" <?php echo $readonly; ?>>
                </div>

                <div class="btn-group">
                    <a href="index.php?page=navires" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary"><?php echo ($action === 'create') ? 'Créer' : 'Enregistrer'; ?></button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>