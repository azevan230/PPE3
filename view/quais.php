<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quais - Port de La Rochelle</title>
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
        
        .message.info {
            border-left: 4px solid #3498db;
            color: #a8dadc;
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
            margin-bottom: 30px;
        }
        
        .table-header {
            color: #4dd0e1;
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(77, 208, 225, 0.3);
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
        
        td strong {
            color: #ffffff;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.4) 0%, rgba(41, 128, 185, 0.4) 100%);
            color: #a8dadc;
            border: 1px solid rgba(52, 152, 219, 0.5);
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
        
        /* État vide */
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #b0bec5;
        }
        
        .no-data-icon {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .no-data p {
            font-size: 1.2em;
            margin-bottom: 25px;
        }
        
        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, rgba(77, 208, 225, 0.2) 0%, rgba(38, 166, 154, 0.2) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(77, 208, 225, 0.3);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-content h2 {
            color: #ffffff;
            font-size: 2.5em;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stat-content p {
            color: #a8dadc;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-icon {
            font-size: 3em;
            opacity: 0.7;
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
        
        .table-container, .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        
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
                <div class="header-icon">🗗️</div>
                <h1>Gestion des Quais</h1>
            </div>
            <div class="action-buttons">
                <a href="index.php?page=creer_quai" class="btn btn-primary">
                    ➕ Nouveau Quai
                </a>
                <a href="index.php?page=accueil" class="btn btn-secondary">
                    🏠 Retour à l'accueil
                </a>
            </div>
        </div>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success">
                ✓ <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="message error">
                ✗ <?= htmlspecialchars($_SESSION['erreur']) ?>
            </div>
            <?php unset($_SESSION['erreur']); ?>
        <?php endif; ?>
        
        <div class="table-container">
            <div class="table-header">📋 Liste des Quais</div>
            
            <?php if (empty($quais)): ?>
                <div class="no-data">
                    <div class="no-data-icon">🗗️</div>
                    <p>Aucun quai enregistré dans la base de données</p>
                    <a href="index.php?page=creer_quai" class="btn btn-primary">
                        ➕ Créer le premier quai
                    </a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Quai</th>
                            <th>Tirant d'eau max</th>
                            <th>Postes d'Accostage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quais as $quai): ?>
                            <tr>
                                <td><?= htmlspecialchars($quai->getId_quai()) ?></td>
                                <td><strong><?= htmlspecialchars($quai->getNom()) ?></strong></td>
                                <td>
                                    <span class="badge">
                                        📏 <?= htmlspecialchars($quai->getTirant_eau_max()) ?> m
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" 
                                       class="btn-small btn-info">
                                        👁️ Voir les postes
                                    </a>
                                </td>
                                <td>
                                    <div class="action-cell">
                                        <a href="index.php?page=modifier_quai&id_quai=<?= $quai->getId_quai() ?>" 
                                           class="btn-small btn-warning" 
                                           title="Modifier">
                                            ✏️ Modifier
                                        </a>
                                        <a href="index.php?page=supprimer_quai&id_quai=<?= $quai->getId_quai() ?>" 
                                           class="btn-small btn-danger" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer le quai <?= addslashes($quai->getNom()) ?> ?')">
                                            🗑️ Supprimer
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <h2><?= isset($quais) ? count($quais) : '0' ?></h2>
                    <p>Quais actifs</p>
                </div>
                <div class="stat-icon">🗗️</div>
            </div>
        </div>
    </div>
</body>
</html>