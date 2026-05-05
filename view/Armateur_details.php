<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        echo $action === 'create' ? 'Ajouter un armateur' :
             ($action === 'update' ? 'Modifier un armateur' : 'Détails de l\'armateur');
    ?> - Port de La Rochelle</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="tel"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        input:focus { outline: none; border-color: #667eea; }
        .btn-group { display: flex; gap: 10px; margin-top: 30px; }
        .btn { padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-secondary { background: #95a5a6; color: white; }
        .btn-secondary:hover { background: #7f8c8d; }
        .btn-warning { background: #f39c12; color: white; }
        .btn-warning:hover { background: #e67e22; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .info-group { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px; }
        .info-label { font-weight: bold; color: #555; margin-bottom: 5px; }
        .info-value { color: #333; font-size: 16px; }
    </style>
</head>
<body>
<div class="container">

    <?php if ($action === 'view'): ?>

        <!-- ── MODE AFFICHAGE ─────────────────────────────────────────── -->
        <h1>Détails de l'armateur</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <div class="info-group">
            <div class="info-label">ID</div>
            <div class="info-value"><?= htmlspecialchars($armateur['id']) ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Nom</div>
            <div class="info-value"><?= htmlspecialchars($armateur['nom']) ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Prénom</div>
            <div class="info-value"><?= htmlspecialchars($armateur['prenom'] ?? '-') ?></div>
        </div>
        <div class="info-group">
            <div class="info-label">Adresse</div>
            <div class="info-value"><?= htmlspecialchars($armateur['adresse'] ?? '-') ?></div>
        </div>

        <!-- ── CHAMP TEL ajouté (exigé par le CDC) ───────────────────── -->
        <div class="info-group">
            <div class="info-label">Téléphone</div>
            <div class="info-value"><?= htmlspecialchars($armateur['tel'] ?? '-') ?></div>
        </div>

        <?php $nbNavires = countNaviresByArmateur($armateur['id']); ?>
        <div class="info-group">
            <div class="info-label">Navires</div>
            <div class="info-value">
                <?= $nbNavires > 0 ? $nbNavires . ' navire' . ($nbNavires > 1 ? 's' : '') : 'Aucun navire' ?>
            </div>
        </div>

        <div class="btn-group">
            <a href="index.php?page=armateurs" class="btn btn-secondary">Retour à la liste</a>
            <a href="index.php?page=armateur_modifier&id_armateur=<?= $armateur['id'] ?>" class="btn btn-warning">Modifier</a>
        </div>

    <?php else: ?>

        <!-- ── MODE FORMULAIRE (create ou update) ────────────────────── -->
        <h1><?= $action === 'create' ? 'Ajouter un armateur' : 'Modifier l\'armateur' ?></h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom"
                       value="<?= htmlspecialchars($armateur['nom'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                       value="<?= htmlspecialchars($armateur['prenom'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse"
                       value="<?= htmlspecialchars($armateur['adresse'] ?? '') ?>">
            </div>

            <!-- ── CHAMP TEL ajouté (exigé par le CDC) ─────────────── -->
            <div class="form-group">
                <label for="tel">Téléphone</label>
                <input type="tel" id="tel" name="tel"
                       value="<?= htmlspecialchars($armateur['tel'] ?? '') ?>"
                       placeholder="ex : 0546123456">
            </div>

            <div class="btn-group">
                <a href="index.php?page=armateurs" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <?= $action === 'create' ? 'Créer' : 'Enregistrer' ?>
                </button>
            </div>

        </form>

    <?php endif; ?>

</div>
</body>
</html>