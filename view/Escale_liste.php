<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Escales - Port de La Rochelle</title>
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

        .header-title { display: flex; align-items: center; gap: 15px; }
        .header-icon  { font-size: 2.5em; filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3)); }

        h1 {
            color: #fff;
            font-size: 2em;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .action-buttons { display: flex; gap: 15px; flex-wrap: wrap; }

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
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(77, 208, 225, 0.6); }

        .btn-secondary {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-secondary:hover { background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.15) 100%); transform: translateY(-2px); }

        /* Filtres par statut */
        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .filter-btn {
            padding: 8px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }
        .filter-btn:hover { background: rgba(255, 255, 255, 0.2); }
        .filter-btn.active {
            background: linear-gradient(135deg, #4dd0e1 0%, #26a69a 100%);
            border-color: transparent;
            font-weight: 600;
        }
        .filter-count {
            display: inline-block;
            margin-left: 6px;
            padding: 2px 8px;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            font-size: 0.85em;
        }

        .message {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .message.success { border-left: 4px solid #2ecc71; color: #a8e6cf; }
        .message.error   { border-left: 4px solid #e74c3c; color: #ffb3ba; }

        .table-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }

        table { width: 100%; border-collapse: collapse; min-width: 1300px; }

        thead tr {
            background: linear-gradient(135deg, rgba(77, 208, 225, 0.3) 0%, rgba(38, 166, 154, 0.3) 100%);
            border-bottom: 2px solid rgba(77, 208, 225, 0.5);
        }
        th {
            padding: 15px 10px;
            text-align: left;
            color: #fff;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease; }
        tbody tr:hover { background: rgba(77, 208, 225, 0.1); }
        td { padding: 12px 10px; color: #e0e0e0; font-size: 0.85em; }
        td strong { color: #fff; }

        /* Ligne en attente : surlignage subtil orange */
        tbody tr.row-en-attente { background: rgba(243, 156, 18, 0.08); }
        tbody tr.row-en-attente:hover { background: rgba(243, 156, 18, 0.15); }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-empty { background: rgba(255, 255, 255, 0.05); color: #888; border: 1px dashed rgba(255, 255, 255, 0.15); font-style: italic; }

        /* Badges de statut */
        .badge-statut-en_attente { background: linear-gradient(135deg, rgba(243, 156, 18, 0.45), rgba(230, 126, 34, 0.45)); color: #ffe2b8; border: 1px solid rgba(243, 156, 18, 0.6); }
        .badge-statut-validee    { background: linear-gradient(135deg, rgba(46, 204, 113, 0.45),  rgba(39, 174, 96, 0.45));  color: #a8e6cf; border: 1px solid rgba(46, 204, 113, 0.6); }
        .badge-statut-refusee    { background: linear-gradient(135deg, rgba(231, 76, 60, 0.45),   rgba(192, 57, 43, 0.45));  color: #ffb3ba; border: 1px solid rgba(231, 76, 60, 0.6); }
        .badge-statut-terminee   { background: linear-gradient(135deg, rgba(149, 165, 166, 0.45), rgba(127, 140, 141, 0.45));color: #ddd;    border: 1px solid rgba(149, 165, 166, 0.6); }

        .badge-fret     { background: linear-gradient(135deg, rgba(155, 89, 182, 0.4) 0%, rgba(142, 68, 173, 0.4) 100%); color: #d7bde2; border: 1px solid rgba(155, 89, 182, 0.5); }
        .badge-employee { background: linear-gradient(135deg, rgba(52, 152, 219, 0.4) 0%, rgba(41, 128, 185, 0.4) 100%); color: #a8dadc; border: 1px solid rgba(52, 152, 219, 0.5); }
        .badge-docker   { background: linear-gradient(135deg, rgba(241, 196, 15, 0.4) 0%, rgba(243, 156, 18, 0.4) 100%); color: #f9e79f; border: 1px solid rgba(241, 196, 15, 0.5); }
        .badge-quai     { background: linear-gradient(135deg, rgba(46, 204, 113, 0.4) 0%, rgba(39, 174, 96, 0.4) 100%);  color: #a8e6cf; border: 1px solid rgba(46, 204, 113, 0.5); }
        .badge-navire   { background: linear-gradient(135deg, rgba(77, 208, 225, 0.4) 0%, rgba(38, 166, 154, 0.4) 100%); color: #a8dadc; border: 1px solid rgba(77, 208, 225, 0.5); }

        .date-cell { color: #a8dadc; font-weight: 500; }

        .action-cell { display: flex; gap: 6px; flex-wrap: wrap; }

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
        .btn-info    { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: #fff; }
        .btn-warning { background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: #fff; }
        .btn-danger  { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: #fff; }
        .btn-success { background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: #fff; }
        .btn-small:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); }

        .no-data { text-align: center; padding: 60px 20px; color: #b0bec5; }
        .no-data-icon { font-size: 4em; margin-bottom: 20px; opacity: 0.5; }
        .no-data p { font-size: 1.2em; margin-bottom: 25px; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .table-container { animation: fadeInUp 0.6s ease forwards; }

        @media (max-width: 1400px) {
            .container { padding: 30px 15px; }
            th, td { font-size: 0.75em; padding: 8px 6px; }
        }
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; }
            h1 { font-size: 1.5em; }
            .table-container { padding: 10px; }
            .action-cell { flex-direction: column; }
            .action-buttons { width: 100%; }
            .btn { width: 100%; justify-content: center; }
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
            <div class="message success">✓ <?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="message error">✗ <?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <?php
        // ─── Filtre par statut ─────────────────────────────────────────────
        $statutFiltre = $_GET['statut'] ?? 'tous';
        $statutsValides = ['tous', 'en_attente', 'validee', 'refusee', 'terminee'];
        if (!in_array($statutFiltre, $statutsValides, true)) {
            $statutFiltre = 'tous';
        }

        // Comptage par statut
        $compteurs = ['tous' => 0, 'en_attente' => 0, 'validee' => 0, 'refusee' => 0, 'terminee' => 0];
        foreach ($escales as $e) {
            $compteurs['tous']++;
            $s = $e['statut'] ?? 'validee';
            if (isset($compteurs[$s])) $compteurs[$s]++;
        }

        // Filtrage de la liste
        $escalesAffichees = $statutFiltre === 'tous'
            ? $escales
            : array_filter($escales, fn($e) => ($e['statut'] ?? 'validee') === $statutFiltre);
        ?>

        <div class="filters">
            <a href="index.php?page=escales&statut=tous" class="filter-btn <?= $statutFiltre === 'tous' ? 'active' : '' ?>">
                Toutes <span class="filter-count"><?= $compteurs['tous'] ?></span>
            </a>
            <a href="index.php?page=escales&statut=en_attente" class="filter-btn <?= $statutFiltre === 'en_attente' ? 'active' : '' ?>">
                ⏳ En attente <span class="filter-count"><?= $compteurs['en_attente'] ?></span>
            </a>
            <a href="index.php?page=escales&statut=validee" class="filter-btn <?= $statutFiltre === 'validee' ? 'active' : '' ?>">
                ✓ Validées <span class="filter-count"><?= $compteurs['validee'] ?></span>
            </a>
            <a href="index.php?page=escales&statut=terminee" class="filter-btn <?= $statutFiltre === 'terminee' ? 'active' : '' ?>">
                Terminées <span class="filter-count"><?= $compteurs['terminee'] ?></span>
            </a>
            <a href="index.php?page=escales&statut=refusee" class="filter-btn <?= $statutFiltre === 'refusee' ? 'active' : '' ?>">
                ✗ Refusées <span class="filter-count"><?= $compteurs['refusee'] ?></span>
            </a>
        </div>

        <div class="table-container">
            <?php if (empty($escalesAffichees)): ?>
                <div class="no-data">
                    <div class="no-data-icon">📋</div>
                    <p>
                        <?= $statutFiltre === 'tous'
                            ? 'Aucune escale enregistrée pour le moment'
                            : 'Aucune escale avec ce statut' ?>
                    </p>
                    <?php if ($statutFiltre === 'tous'): ?>
                        <a href="index.php?page=escale_create" class="btn btn-primary">➕ Créer la première escale</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Statut</th>
                            <th>📅 Arrivée</th>
                            <th>📅 Départ</th>
                            <th>🚢 Navire</th>
                            <th>📦 Fret</th>
                            <th>🧭 Pilote 1</th>
                            <th>🧭 Pilote 2</th>
                            <th>⚓ Docker</th>
                            <th>🗗️ Poste / Quai</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($escalesAffichees as $escale): ?>
                            <?php
                            $statut = $escale['statut'] ?? 'validee';
                            $rowClass = $statut === 'en_attente' ? 'row-en-attente' : '';

                            // Libellés humains
                            $statutLabel = [
                                'en_attente' => '⏳ En attente',
                                'validee'    => '✓ Validée',
                                'refusee'    => '✗ Refusée',
                                'terminee'   => 'Terminée',
                            ][$statut] ?? $statut;
                            ?>
                            <tr class="<?= $rowClass ?>">
                                <td><strong>#<?= htmlspecialchars($escale['id_escale']) ?></strong></td>

                                <td>
                                    <span class="badge badge-statut-<?= htmlspecialchars($statut) ?>">
                                        <?= $statutLabel ?>
                                    </span>
                                </td>

                                <td class="date-cell"><?= htmlspecialchars($escale['date_arrive'] ?? '-') ?></td>
                                <td class="date-cell"><?= htmlspecialchars($escale['date_depart'] ?? '-') ?></td>

                                <td>
                                    <span class="badge badge-navire">
                                        🚢 <?= htmlspecialchars($escale['navire_nom'] ?? '-') ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-fret" title="<?= htmlspecialchars($escale['fret_libelle'] ?? '') ?>">
                                        📦 <?= htmlspecialchars($escale['fret_type'] ?? '-') ?>
                                    </span>
                                </td>

                                <!-- Pilote 1 (peut être NULL si en_attente) -->
                                <td>
                                    <?php if (!empty($escale['pilote1_nom'])): ?>
                                        <span class="badge badge-employee">
                                            🧭 <?= htmlspecialchars($escale['pilote1_nom'] . ' ' . ($escale['pilote1_prenom'] ?? '')) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-empty">à affecter</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Pilote 2 (peut être NULL) -->
                                <td>
                                    <?php if (!empty($escale['pilote2_nom'])): ?>
                                        <span class="badge badge-employee">
                                            🧭 <?= htmlspecialchars($escale['pilote2_nom'] . ' ' . ($escale['pilote2_prenom'] ?? '')) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-empty">à affecter</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Docker (peut être NULL) -->
                                <td>
                                    <?php if (!empty($escale['docker_nom'])): ?>
                                        <span class="badge badge-docker">
                                            ⚓ <?= htmlspecialchars($escale['docker_nom'] . ' ' . ($escale['docker_prenom'] ?? '')) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-empty">à affecter</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Poste / Quai (peut être NULL) -->
                                <td>
                                    <?php if (!empty($escale['quai_nom'])): ?>
                                        <span class="badge badge-quai">
                                            🗗️ <?= htmlspecialchars($escale['quai_nom']) ?>
                                            <?php if (!empty($escale['poste_numero'])): ?>
                                                (<?= htmlspecialchars($escale['poste_numero']) ?>)
                                            <?php elseif (!empty($escale['id_poste_accostage'])): ?>
                                                (P<?= htmlspecialchars($escale['id_poste_accostage']) ?>)
                                            <?php endif; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-empty">à affecter</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="action-cell">
                                        <a href="index.php?page=escale_details&id_escale=<?= $escale['id_escale'] ?>"
                                           class="btn-small btn-info" title="Voir">👁️ Voir</a>

                                        <?php if ($statut === 'en_attente'): ?>
                                            <!-- Pour les demandes : bouton spécial "Valider" -->
                                            <a href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>"
                                               class="btn-small btn-success" title="Affecter ressources et valider">
                                                ✓ Valider
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>"
                                               class="btn-small btn-warning" title="Modifier">✏️ Modifier</a>
                                        <?php endif; ?>

                                        <a href="index.php?page=escale_supprimer&id_escale=<?= $escale['id_escale'] ?>"
                                           class="btn-small btn-danger"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette escale ?');"
                                           title="Supprimer">🗑️ Suppr.</a>
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
</html>