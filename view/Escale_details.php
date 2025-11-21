<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détails de l'escale</title>

<style>
body { font-family: Arial; background:#f4f4f4; margin:40px; }
.container { width:500px; margin:auto; background:white; padding:20px; border-radius:8px; }
h2 { text-align:center; }
ul { list-style:none; padding:0; }
li { padding:8px 0; border-bottom:1px solid #ddd; }
a.btn { display:inline-block; padding:8px 12px; background:#0055a5; color:white; margin-right:8px; border-radius:6px; text-decoration:none; }
</style>

</head>
<body>

<div class="container">

<h2>Détails de l'escale #<?= $escale['id_escale'] ?></h2>

<ul>
    <li><strong>Date arrivée :</strong> <?= $escale['date_arrive'] ?></li>
    <li><strong>Date départ :</strong> <?= $escale['date_depart'] ?></li>

    <li><strong>Fret :</strong> <?= $escale['fret_type'] ?> (<?= $escale['fret_libelle'] ?>)</li>

    <li><strong>Docker :</strong> <?= $escale['docker_nom'] ?> <?= $escale['docker_prenom'] ?></li>

    <li><strong>Pilote 1 :</strong> <?= $escale['pilote1_nom'] ?> <?= $escale['pilote1_prenom'] ?></li>

    <li><strong>Pilote 2 :</strong> <?= $escale['pilote2_nom'] ?> <?= $escale['pilote2_prenom'] ?></li>

    <li><strong>Poste d'accostage :</strong> Poste <?= $escale['id_poste_accostage'] ?> (Quai <?= $escale['quai_nom'] ?>)</li>

    <li><strong>Navire :</strong> <?= $escale['navire_nom'] ?></li>
</ul>

<br>

<a class="btn" href="index.php?page=escales">Retour</a>
<a class="btn" href="index.php?page=escale_modifier&id_escale=<?= $escale['id_escale'] ?>">Modifier</a>

</div>

</body>
</html>
