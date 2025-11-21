<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Créer un nouveau navire</title>
<style>
    body { font-family: Arial; background:#f8f9fa; margin:40px; }
    form { width: 50%; margin:auto; background:white; padding:20px; border-radius:8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    label { display:block; margin-top:15px; font-weight:bold; }
    input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:4px; }
    button { margin-top:20px; padding:10px 15px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer; }
</style>
</head>
<body>

<h2 style="text-align:center;color:#003366;">Créer un nouveau navire</h2>

<form method="POST">
    <label>Nom :</label>
    <input type="text" name="nom" required>

    <label>Autorisé :</label>
    <select name="autorise" required>
        <option value="Oui">Oui</option>
        <option value="Non">Non</option>
    </select>

    <label>Longueur :</label>
    <input type="number" name="longueur" step="0.01" required>

    <label>Largeur :</label>
    <input type="number" name="largeur" step="0.01" required>

    <label>Tirant d'eau :</label>
    <input type="number" name="tirant_eau" step="0.01" required>

    <label>Capacité :</label>
    <input type="number" name="capacite" required>

    <label>Propulseur :</label>
    <input type="text" name="propulseur">

    <label>Remorqueur :</label>
    <input type="text" name="remorqueur">

    <label>ID Fret :</label>
    <input type="number" name="id_fret">

    <label>ID Port :</label>
    <input type="number" name="id_port">

    <button type="submit">Créer</button>
</form>

<div style="text-align:center;margin-top:20px;">
    <a href="index.php?page=navires" style="text-decoration:none;color:#007bff;">Retour à la liste des navires</a>
</div>

</body>
</html>
