<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier un navire</title>
</head>
<body>

<h2>Modifier le navire #<?= $navire['id_navire'] ?></h2>

<form method="POST">
    <label>Nom :</label>
    <input type="text" name="nom" value="<?= htmlspecialchars($navire['nom']) ?>" required>

    <label>Type :</label>
    <input type="text" name="type" value="<?= htmlspecialchars($navire['type']) ?>" required>

    <label>Tonnage :</label>
    <input type="number" name="tonnage" value="<?= htmlspecialchars($navire['tonnage']) ?>" required>

    <button type="submit">Enregistrer</button>
</form>

<div>
    <a href="index.php?page=navires">Retour à la liste</a>
</div>

</body>
</html>
