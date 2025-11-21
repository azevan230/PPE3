<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des escales</title>
    <style>
        body { font-family: Arial; background:#f8f9fa; margin:40px; }
        table { margin:auto; width:90%; border-collapse: collapse; background:white; }
        th, td { padding:10px; border:1px solid #ccc; text-align:center; }
        th { background:#0055a5; color:white; }
        a.btn { padding:6px 12px; background:#007bff; color:white; border-radius:4px; text-decoration:none; }
        a.sup { background:red; }
    </style>
</head>
<body>

<h1 style="text-align:center;color:#003366;">Gestion des escales</h1>

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date arrivée</th>
            <th>Date départ</th>
            <th>Fret</th>
            <th>Pilote 1</th>
            <th>Pilote 2</th>
            <th>Docker</th>
            <th>Poste / Quai</th>
            <th>Navire</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($escales as $escale): ?>
            <tr>
                <td><?= $escale['id_escale'] ?></td>
                <td><?= $escale['date_arrive'] ?></td>
                <td><?= $escale['date_depart'] ?></td>

                <td><?= $escale['fret_type'] ?> (<?= $escale['fret_libelle'] ?>)</td>

                <td><?= $escale['pilote1_nom'] . " " . $escale['pilote1_prenom'] ?></td>
                <td><?= $escale['pilote2_nom'] . " " . $escale['pilote2_prenom'] ?></td>

                <td><?= $escale['docker_nom'] . " " . $escale['docker_prenom'] ?></td>

                <td><?= $escale['quai_nom'] ?> (Poste <?= $escale['id_poste_accostage'] ?>)</td>

                <td><?= $escale['navire_nom'] ?></td>

                <td>
                    <a class="btn" href="index.php?page=escale_details&id_escale=<?= $escale['id_escale'] ?>">Détails</a>
                    <a class="btn" href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>">Modifier</a>
                    <a class="btn sup" href="index.php?page=escale_supprimer&id_escale=<?= $escale['id_escale'] ?>" onclick="return confirm('Supprimer cette escale ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br><br>

<div style="text-align:center;">
    <a class="btn" href="index.php?page=escale_create">Créer une escale</a>
</div>

</body>
</html>
