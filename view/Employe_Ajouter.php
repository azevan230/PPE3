<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter un employé</title>
</head>
<body>

<h2>Ajouter un employé</h2>

<form method="POST">
    Nom : <input type="text" name="nom" required><br><br>
    Prénom : <input type="text" name="prenom" required><br><br>
    Téléphone : <input type="text" name="telephone" required><br><br>
    Rôle :
    <select name="role" required>
        <option value="pilote">Pilote</option>
        <option value="docker">Docker</option>
    </select><br><br>

    <button type="submit">Enregistrer</button>
</form>

<a href="index.php?page=employes">Retour</a>

</body>
</html>
