<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Navires - Port de La Rochelle</title>
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
        
        /* Overlay sombre */
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
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-icon {
            font-size: 2.5em;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
        
        h1 {
            color: #ffffff;
            font-size: 2em;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        /* Boutons d'action */
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
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
            box-shadow: 0 4px 15px rgba(77, 208, 225, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(77, 208, 225, 0.6);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.15) 100%);
            transform: translateY(-2px);
        }
        
        /* Messages */
        .message {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .message.success {
            border-left: 4px solid #2ecc71;
            color: #a8e6cf;
        }
        
        .message.error {
            border-left: 4px solid #e74c3c;
            color: #ffb3ba;
        }
        
        /* Tableau */
        .table-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead tr {
            background: linear-gradient(135deg, rgba(77, 208, 225, 0.3) 0%, rgba(38, 166, 154, 0.3) 100%);
            border-bottom: 2px solid rgba(77, 208, 225, 0.5);
        }
        
        th {
            padding: 15px 10px;
            text-align: left;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background: rgba(77, 208, 225, 0.1);
        }
        
        td {
            padding: 15px 10px;
            color: #e0e0e0;
            font-size: 0.9em;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .badge-success {
            background: rgba(46, 204, 113, 0.3);
            color: #a8e6cf;
            border: 1px solid rgba(46, 204, 113, 0.5);
        }
        
        .badge-danger {
            background: rgba(231, 76, 60, 0.3);
            color: #ffb3ba;
            border: 1px solid rgba(231, 76, 60, 0.5);
        }
        
        /* Boutons d'action dans le tableau */
        .action-cell {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 0.85em;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }
        
        .btn-small:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        /* Animation */
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
        
        .table-container {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            h1 {
                font-size: 1.5em;
            }
            
            .table-container {
                padding: 10px;
            }
            
            th, td {
                padding: 10px 5px;
                font-size: 0.8em;
            }
            
            .action-cell {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <div class="header-icon">🚢</div>
                <h1>Gestion des Navires</h1>
            </div>
            <div class="action-buttons">
                <a href="index.php?page=navire_create" class="btn btn-primary">
                    ➕ Créer un navire
                </a>
                <a href="index.php?page=accueil" class="btn btn-secondary">
                    🏠 Retour à l'accueil
                </a>
            </div>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="message success">
                ✓ <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="message error">
                ✗ <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Autorisé</th>
                        <th>Longueur (m)</th>
                        <th>Largeur (m)</th>
                        <th>Tirant d'eau (m)</th>
                        <th>Capacité (t)</th>
                        <th>Propulseur</th>
                        <th>Remorqueur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($navires)): ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #b0bec5;">
                                Aucun navire enregistré pour le moment
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($navires as $navire): ?>
                            <tr>
                                <td><?= htmlspecialchars($navire['id_navire'] ?? '') ?></td>
                                <td><strong><?= htmlspecialchars($navire['nom'] ?? '') ?></strong></td>
                                <td>
                                    <?php if ($navire['autorise']): ?>
                                        <span class="badge badge-success">✓ Oui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Non</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($navire['longueur'] ?? '') ?></td>
                                <td><?= htmlspecialchars($navire['largeur'] ?? '') ?></td>
                                <td><?= htmlspecialchars($navire['tirant_eau'] ?? '') ?></td>
                                <td><?= htmlspecialchars($navire['capacite'] ?? '') ?></td>
                                <td>
                                    <?php if ($navire['propulseur']): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($navire['remorqueur']): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-cell">
                                        <a href="index.php?page=navire_details&id_navire=<?= $navire['id_navire'] ?>" class="btn-small btn-info" title="Voir les détails">
                                            👁️ Voir
                                        </a>
                                        <a href="index.php?page=navire_modifier&id_navire=<?= $navire['id_navire'] ?>" class="btn-small btn-warning" title="Modifier">
                                            ✏️ Modifier
                                        </a>
                                        <a href="index.php?page=navire_supprimer&id_navire=<?= $navire['id_navire'] ?>" class="btn-small btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce navire ?');" title="Supprimer">
                                            🗑️ Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>