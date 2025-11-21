<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détails du navire</title>
</head>
<body>

<h2>Détails du navire #<?= $navire['id_navire'] ?></h2>

<ul>
    <li>Nom : <?= htmlspecialchars($navire['nom']) ?></li>
    <li>Type : <?= htmlspecialchars($navire['type']) ?></li>
    <li>Tonnage : <?= htmlspecialchars($navire['tonnage']) ?></li>
</ul>

<a href="index.php?page=navires">Retour à la liste</a>
<a href="index.php?page=navire_modifier&id_navire=<?= $navire['id_navire'] ?>">Modifier</a>

</body>
</html>
