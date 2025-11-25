<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Armateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s;
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
            margin-right: 10px;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .btn-info {
            background: #3498db;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
        }
        .btn-info:hover {
            background: #2980b9;
        }
        .btn-warning {
            background: #f39c12;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
        }
        .btn-warning:hover {
            background: #e67e22;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            background: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <h1>Liste des Armateurs</h1>
            <div>
                <a href="index.php?page=accueil" class="btn btn-secondary">Retour à l'accueil</a>
                <a href="index.php?page=armateur_create" class="btn btn-primary">+ Ajouter un armateur</a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($armateurs)): ?>
            <div class="no-data">
                <p>Aucun armateur enregistré pour le moment.</p>
                <a href="index.php?page=armateur_create" class="btn btn-primary">Ajouter le premier armateur</a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Adresse</th>
                        <th>Navires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($armateurs as $armateur): ?>
                        <?php 
                        // Compter le nombre de navires
                        require_once __DIR__ . '/../model/ArmateurModel.php';
                        $nbNavires = countNaviresByArmateur($armateur['id']);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($armateur['id']) ?></td>
                            <td><strong><?= htmlspecialchars($armateur['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($armateur['prenom'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($armateur['adresse'] ?? '-') ?></td>
                            <td>
                                <?php if ($nbNavires > 0): ?>
                                    <span class="badge"><?= $nbNavires ?> navire<?= $nbNavires > 1 ? 's' : '' ?></span>
                                <?php else: ?>
                                    <span style="color: #999;">Aucun navire</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?page=armateur_details&id_armateur=<?= $armateur['id'] ?>" 
                                       class="btn btn-info">Voir</a>
                                    <a href="index.php?page=armateur_modifier&id_armateur=<?= $armateur['id'] ?>" 
                                       class="btn btn-warning">Modifier</a>
                                    <a href="index.php?page=armateur_supprimer&id_armateur=<?= $armateur['id'] ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer l\'armateur <?= htmlspecialchars($armateur['nom']) ?> ? \n\nAttention : Cela supprimera également tous ses navires !')">
                                       Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>