<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une escale - Port de La Rochelle</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; margin:40px; }
        form { width:500px; margin:auto; background:white; padding:30px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        h2 { text-align:center; color:#333; }
        label { display:block; margin-top:14px; font-weight:bold; color:#555; }
        input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; }
        button { width:100%; padding:12px; margin-top:20px; background:#0055a5; color:white; border:none; border-radius:6px; cursor:pointer; font-size:15px; }
        button:hover { background:#003d7a; }
        .btn-retour { display:block; text-align:center; margin-top:12px; color:#0055a5; }
    </style>
</head>
<body>

<form method="POST">
    <h2>Modifier l'escale #<?= $escale['id_escale'] ?></h2>

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

    <label>Docker :</label>
    <select name="id_docker" required>
        <?php foreach ($dockers as $d): ?>
            <option value="<?= $d['id_employee'] ?>" <?= $d['id_employee'] == $escale['id_employee'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($d['nom'] . ' ' . $d['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Pilote 1 (entrée) :</label>
    <select name="id_pilote1" required>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" <?= $p['id_employee'] == $escale['id_employee_1'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Pilote 2 (sortie) :</label>
    <select name="id_pilote2" required>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" <?= $p['id_employee'] == $escale['id_employee_2'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Poste d'accostage :</label>
    <select name="id_poste_accostage" required>
        <?php foreach ($postes as $po): ?>
            <option value="<?= $po['id_poste_accostage'] ?>" <?= $po['id_poste_accostage'] == $escale['id_poste_accostage'] ? 'selected' : '' ?>>
                Poste <?= $po['id_poste_accostage'] ?> - <?= htmlspecialchars($po['quai_nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Enregistrer</button>
</form>

<a class="btn-retour" href="index.php?page=escales">← Retour à la liste</a>

</body>
</html>