<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier un employé</title>
</head>
<body>

<h2>Modifier un employé</h2>

<form method="POST">
    Nom : <input type="text" name="nom" value="<?= htmlspecialchars($employe['nom']) ?>" required><br><br>
    Prénom : <input type="text" name="prenom" value="<?= htmlspecialchars($employe['prenom']) ?>" required><br><br>
    Téléphone : <input type="text" name="telephone" value="<?= htmlspecialchars($employe['num_tel']) ?>" required><br><br>
    Rôle :
    <select name="role">
        <option value="pilote" <?= $employe['role']=='pilote'?'selected':'' ?>>Pilote</option>
        <option value="docker" <?= $employe['role']=='docker'?'selected':'' ?>>Docker</option>
    </select><br><br>

    <button type="submit">Enregistrer</button>
</form>

<a href="index.php?page=employes">Retour</a>

</body>
</html>
