<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Escales - Port de La Rochelle</title>
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
            max-width: 1800px;
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
            min-width: 1200px;
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
            white-space: nowrap;
        }
        
        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background: rgba(77, 208, 225, 0.1);
        }
        
        td {
            padding: 12px 10px;
            color: #e0e0e0;
            font-size: 0.85em;
        }
        
        td strong {
            color: #ffffff;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .badge-fret {
            background: linear-gradient(135deg, rgba(155, 89, 182, 0.4) 0%, rgba(142, 68, 173, 0.4) 100%);
            color: #d7bde2;
            border: 1px solid rgba(155, 89, 182, 0.5);
        }
        
        .badge-employee {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.4) 0%, rgba(41, 128, 185, 0.4) 100%);
            color: #a8dadc;
            border: 1px solid rgba(52, 152, 219, 0.5);
        }
        
        .badge-docker {
            background: linear-gradient(135deg, rgba(241, 196, 15, 0.4) 0%, rgba(243, 156, 18, 0.4) 100%);
            color: #f9e79f;
            border: 1px solid rgba(241, 196, 15, 0.5);
        }
        
        .badge-quai {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.4) 0%, rgba(39, 174, 96, 0.4) 100%);
            color: #a8e6cf;
            border: 1px solid rgba(46, 204, 113, 0.5);
        }
        
        .badge-navire {
            background: linear-gradient(135deg, rgba(77, 208, 225, 0.4) 0%, rgba(38, 166, 154, 0.4) 100%);
            color: #a8dadc;
            border: 1px solid rgba(77, 208, 225, 0.5);
        }
        
        /* Dates */
        .date-cell {
            color: #a8dadc;
            font-weight: 500;
        }
        
        /* Boutons d'action dans le tableau */
        .action-cell {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        
        .btn-small {
            padding: 5px 10px;
            font-size: 0.8em;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
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
        @media (max-width: 1400px) {
            .container {
                padding: 30px 15px;
            }
            
            th, td {
                font-size: 0.75em;
                padding: 8px 6px;
            }
        }
        
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
            
            .action-cell {
                flex-direction: column;
            }
            
            .action-buttons {
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <div class="header-icon">📋</div>
                <h1>Gestion des Escales</h1>
            </div>
            <div class="action-buttons">
                <a href="index.php?page=escale_create" class="btn btn-primary">
                    ➕ Créer une escale
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
            <?php if (empty($escales)): ?>
                <div class="no-data">
                    <div class="no-data-icon">📋</div>
                    <p>Aucune escale enregistrée pour le moment</p>
                    <a href="index.php?page=escale_create" class="btn btn-primary">
                        ➕ Créer la première escale
                    </a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>📅 Date arrivée</th>
                            <th>📅 Date départ</th>
                            <th>📦 Fret</th>
                            <th>🧭 Pilote 1</th>
                            <th>🧭 Pilote 2</th>
                            <th>⚓ Docker</th>
                            <th>🗗️ Poste / Quai</th>
                            <th>🚢 Navire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($escales as $escale): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($escale['id_escale']) ?></strong></td>
                                <td class="date-cell"><?= htmlspecialchars($escale['date_arrive']) ?></td>
                                <td class="date-cell"><?= htmlspecialchars($escale['date_depart']) ?></td>
                                <td>
                                    <span class="badge badge-fret" title="<?= htmlspecialchars($escale['fret_libelle']) ?>">
                                        📦 <?= htmlspecialchars($escale['fret_type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-employee">
                                        🧭 <?= htmlspecialchars($escale['pilote1_nom'] . " " . $escale['pilote1_prenom']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-employee">
                                        🧭 <?= htmlspecialchars($escale['pilote2_nom'] . " " . $escale['pilote2_prenom']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-docker">
                                        ⚓ <?= htmlspecialchars($escale['docker_nom'] . " " . $escale['docker_prenom']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-quai">
                                        🗗️ <?= htmlspecialchars($escale['quai_nom']) ?> (P<?= htmlspecialchars($escale['id_poste_accostage']) ?>)
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-navire">
                                        🚢 <?= htmlspecialchars($escale['navire_nom']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-cell">
                                        <a href="index.php?page=escale_details&id_escale=<?= $escale['id_escale'] ?>" 
                                           class="btn-small btn-info" 
                                           title="Voir les détails">
                                            👁️ Voir
                                        </a>
                                        <a href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>" 
                                           class="btn-small btn-warning" 
                                           title="Modifier">
                                            ✏️ Modifier
                                        </a>
                                        <a href="index.php?page=escale_supprimer&id_escale=<?= $escale['id_escale'] ?>" 
                                           class="btn-small btn-danger" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette escale ?');"
                                           title="Supprimer">
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
    </div>
</body>
</html>l