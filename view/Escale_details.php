<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'escale - Port de La Rochelle</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; margin:40px; }
        .container { width:540px; margin:auto; background:white; padding:30px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        h2 { text-align:center; color:#333; border-bottom:2px solid #0055a5; padding-bottom:10px; }
        ul { list-style:none; padding:0; margin:0; }
        li { padding:10px 0; border-bottom:1px solid #eee; display:flex; gap:10px; }
        li strong { min-width:180px; color:#555; }
        .actions { margin-top:20px; display:flex; gap:10px; }
        .btn { display:inline-block; padding:10px 18px; border-radius:6px; text-decoration:none; font-weight:bold; }
        .btn-blue  { background:#0055a5; color:white; }
        .btn-orange{ background:#f39c12; color:white; }
        .btn:hover { opacity:0.85; }
    </style>
</head>
<body>

<div class="container">
    <h2>Détails de l'escale #<?= $escale['id_escale'] ?></h2>

    <ul>
        <li><strong>Navire :</strong>              <?= htmlspecialchars($escale['navire_nom']) ?></li>
        <li><strong>Agent consignataire :</strong> <?= htmlspecialchars($escale['agent_nom'] ?? 'Non renseigné') ?></li>
        <li><strong>Date d'arrivée :</strong>      <?= htmlspecialchars($escale['date_arrive']) ?></li>
        <li><strong>Date de départ :</strong>      <?= htmlspecialchars($escale['date_depart']) ?></li>
        <li><strong>Destination suivante :</strong><?= htmlspecialchars($escale['destination'] ?? 'Non renseignée') ?></li>
        <li><strong>Fret :</strong>                <?= htmlspecialchars($escale['fret_type']) ?> — <?= htmlspecialchars($escale['fret_libelle']) ?></li>
        <li><strong>Docker :</strong>              <?= htmlspecialchars($escale['docker_nom'] . ' ' . $escale['docker_prenom']) ?></li>
        <li><strong>Pilote 1 (entrée) :</strong>  <?= htmlspecialchars($escale['pilote1_nom'] . ' ' . $escale['pilote1_prenom']) ?></li>
        <li><strong>Pilote 2 (sortie) :</strong>  <?= htmlspecialchars($escale['pilote2_nom'] . ' ' . $escale['pilote2_prenom']) ?></li>
        <li><strong>Quai :</strong>                <?= htmlspecialchars($escale['quai_nom']) ?></li>
        <li><strong>Poste d'accostage :</strong>  Poste <?= htmlspecialchars($escale['id_poste_accostage']) ?></li>
    </ul>

    <div class="actions">
        <a class="btn btn-blue"   href="index.php?page=escales">← Retour</a>
        <a class="btn btn-orange" href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>">✏️ Modifier</a>
    </div>
</div>

</body>
</html>