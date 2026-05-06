<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une escale - Port de La Rochelle</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; margin:40px; }
        form, .actions-extra { width:560px; margin:auto; background:white; padding:30px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        .actions-extra { margin-top: 14px; padding: 18px 30px; }
        h2 { text-align:center; color:#333; }
        label { display:block; margin-top:14px; font-weight:bold; color:#555; }
        input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; }
        button { width:100%; padding:12px; margin-top:20px; color:white; border:none; border-radius:6px; cursor:pointer; font-size:15px; font-weight: bold; }
        .btn-primary { background:#0055a5; }
        .btn-primary:hover { background:#003d7a; }
        .btn-success { background:#27ae60; }
        .btn-success:hover { background:#1e8449; }
        .btn-danger  { background:#c0392b; }
        .btn-danger:hover { background:#922b21; }
        .btn-secondary { background:#7f8c8d; }
        .btn-retour { display:block; text-align:center; margin-top:12px; color:#0055a5; }

        .banner {
            margin: -10px 0 20px;
            padding: 14px 18px;
            border-radius: 6px;
            font-size: 0.95em;
        }
        .banner-pending { background: #fff3cd; border-left: 4px solid #f39c12; color: #7a5b00; }
        .banner-error   { background: #f8d7da; border-left: 4px solid #e74c3c; color: #721c24; }

        .help { color: #888; font-size: 0.85em; margin-top: 4px; }

        .actions-extra h3 { margin-bottom: 10px; color: #555; font-size: 1.05em; }
        .actions-extra .row { display: flex; gap: 10px; }
        .actions-extra button { margin-top: 0; flex: 1; padding: 10px; }

        /* Champ requis visuellement */
        .required-when-validating::after { content: " *"; color: #e74c3c; }
    </style>
</head>
<body>

<?php
$statut = $escale['statut'] ?? 'validee';
$enAttente = $statut === 'en_attente';
?>

<form method="POST" id="formEscale">
    <h2>
        <?= $enAttente ? "Valider la demande #" : "Modifier l'escale #" ?><?= $escale['id_escale'] ?>
    </h2>

    <?php if ($enAttente): ?>
        <div class="banner banner-pending">
            ⏳ <strong>Demande envoyée par l'armateur via l'app mobile.</strong><br>
            Pour valider, affectez un docker, un pilote d'entrée et un poste d'accostage,
            puis cliquez « Valider et affecter ». Vous pouvez aussi refuser la demande ci-dessous.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="banner banner-error">✗ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <!-- Statut courant (caché, modifié par le bouton de soumission) -->
    <input type="hidden" name="statut" id="champStatut" value="<?= htmlspecialchars($statut) ?>">

    <label>Navire :</label>
    <select name="id_navire" required>
        <?php foreach ($navires as $n): ?>
            <option value="<?= $n['id_navire'] ?>" <?= $n['id_navire'] == $escale['id_navire'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($n['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Agent consignataire :</label>
    <select name="id_agent">
        <option value="">-- Aucun --</option>
        <?php foreach ($agents as $ag): ?>
            <option value="<?= $ag['id_agent'] ?>" <?= $ag['id_agent'] == $escale['id_agent'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($ag['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Date d'arrivée :</label>
    <input type="date" name="date_arrive" value="<?= htmlspecialchars($escale['date_arrive']) ?>" required>

    <label>Date de départ :</label>
    <input type="date" name="date_depart" value="<?= htmlspecialchars($escale['date_depart']) ?>" required>

    <label>Provenance :</label>
    <input type="text" name="provenance" value="<?= htmlspecialchars($escale['provenance'] ?? '') ?>" placeholder="ex : ROTTERDAM">

    <label>Destination suivante :</label>
    <input type="text" name="destination" value="<?= htmlspecialchars($escale['destination'] ?? '') ?>" placeholder="ex : TUNIS">

    <label>Fret :</label>
    <select name="id_fret" required>
        <?php foreach ($frets as $f): ?>
            <option value="<?= $f['id_fret'] ?>" <?= $f['id_fret'] == $escale['id_fret'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($f['type']) ?> - <?= htmlspecialchars($f['libelle']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="required-when-validating">Docker :</label>
    <select name="id_docker">
        <option value="">-- À affecter --</option>
        <?php foreach ($dockers as $d): ?>
            <option value="<?= $d['id_employee'] ?>" <?= $d['id_employee'] == ($escale['id_employee'] ?? 0) ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['nom'] . ' ' . $d['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="required-when-validating">Pilote 1 (entrée) :</label>
    <select name="id_pilote1">
        <option value="">-- À affecter --</option>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" <?= $p['id_employee'] == ($escale['id_employee_1'] ?? 0) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Pilote 2 (sortie) :</label>
    <select name="id_pilote2">
        <option value="">-- Optionnel --</option>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" <?= $p['id_employee'] == ($escale['id_employee_2'] ?? 0) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="help">Pilote de sortie : peut être affecté plus tard et être différent du pilote d'entrée.</div>

    <label class="required-when-validating">Poste d'accostage :</label>
    <select name="id_poste_accostage">
        <option value="">-- À affecter --</option>
        <?php foreach ($postes as $po): ?>
            <option value="<?= $po['id_poste_accostage'] ?>" <?= $po['id_poste_accostage'] == ($escale['id_poste_accostage'] ?? 0) ? 'selected' : '' ?>>
                <?= htmlspecialchars($po['quai_nom']) ?>
                <?php if (!empty($po['poste_numero'])): ?>
                    — Poste <?= htmlspecialchars($po['poste_numero']) ?>
                <?php else: ?>
                    — Poste #<?= $po['id_poste_accostage'] ?>
                <?php endif; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ($enAttente): ?>
        <button type="submit" class="btn-success" onclick="document.getElementById('champStatut').value='validee'">
            ✓ Valider et affecter
        </button>
    <?php else: ?>
        <button type="submit" class="btn-primary">Enregistrer les modifications</button>
    <?php endif; ?>
</form>

<?php if ($statut === 'en_attente' || $statut === 'validee'): ?>
    <!-- ── Actions secondaires : refuser / terminer ──────────────────────── -->
    <div class="actions-extra">
        <h3>Autres actions</h3>
        <div class="row">
            <?php if ($statut === 'en_attente'): ?>
                <form method="POST" style="margin:0; padding:0; box-shadow:none; flex:1;">
                    <input type="hidden" name="action" value="refuser">
                    <button type="submit" class="btn-danger"
                            onclick="return confirm('Refuser cette demande d\'escale ?')">
                        ✗ Refuser la demande
                    </button>
                </form>
            <?php endif; ?>

            <?php if ($statut === 'validee'): ?>
                <form method="POST" style="margin:0; padding:0; box-shadow:none; flex:1;">
                    <input type="hidden" name="action" value="terminer">
                    <button type="submit" class="btn-secondary"
                            onclick="return confirm('Marquer cette escale comme terminée ?')">
                        Marquer terminée
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<a class="btn-retour" href="index.php?page=escales">← Retour à la liste</a>

</body>
</html>