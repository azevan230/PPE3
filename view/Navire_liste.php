<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des navires</title>
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

<h1 style="text-align:center;color:#003366;">Gestion des navires</h1>

<br><br>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Autorisé</th>
            <th>Longueur</th>
            <th>Largeur</th>
            <th>Tirant d'eau</th>
            <th>Capacité</th>
            <th>Propulseur</th>
            <th>Remorqueur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($navires as $navire): ?>
            <tr>
                <td><?= htmlspecialchars($navire['id_navire'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['autorise'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['longueur'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['largeur'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['tirant_eau'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['capacite'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['propulseur'] ?? '') ?></td>
                <td><?= htmlspecialchars($navire['remorqueur'] ?? '') ?></td>
                <td>
                    <a class="btn" href="index.php?page=navire_details&id_navire=<?= $navire['id_navire'] ?>">Détails</a>
                    <a class="btn" href="index.php?page=navire_modifier&id_navire=<?= $navire['id_navire'] ?>">Modifier</a>
                    <a class="btn sup" href="index.php?page=navire_supprimer&id_navire=<?= $navire['id_navire'] ?>" onclick="return confirm('Supprimer ce navire ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br><br>
<div style="text-align:center;">
    <a class="btn" href="index.php?page=navire_create">Créer un navire</a>
</div>

</body>
</html>
