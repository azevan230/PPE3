<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des employés</title>
<style>
    body { font-family: Arial; background:#f8f9fa; margin:40px; }
    table { margin:auto; width:70%; border-collapse: collapse; background:white; }
    th, td { padding:10px; border:1px solid #ccc; text-align:center; }
    th { background:#0055a5; color:white; }
    a.btn { padding:6px 12px; background:#007bff; color:white; border-radius:4px; text-decoration:none; }
    a.sup { background:red; }
    .message { text-align:center; color:red; font-weight:bold; }
</style>
</head>
<body>

<h1 style="text-align:center;color:#003366;">Employés du port</h1>

<!-- <?php if (!empty($message)): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?> -->

<table>
<thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Téléphone</th>
        <th>Rôle</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
<?php foreach ($employes as $emp): ?>
<tr>
<td><?= htmlspecialchars($emp['id_employee']) ?></td>
<td><?= htmlspecialchars($emp['nom']) ?></td>
<td><?= htmlspecialchars($emp['prenom']) ?></td>
<td><?= htmlspecialchars($emp['num_tel']) ?></td>
<td><?= htmlspecialchars($emp['role']) ?></td>
<td>
    <a class="btn" href="index.php?page=modifierEmploye&id=<?= $emp['id_employee'] ?>">Modifier</a>
    <a class="btn sup" href="index.php?page=supprimerEmploye&id=<?= $emp['id_employee'] ?>" onclick="return confirm('Supprimer cet employé ?');">Supprimer</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div style="text-align:center; margin-top:20px;">
<a class="btn" href="index.php?page=ajouterEmploye">Ajouter un employé</a>
</div>

</body>
</html>
