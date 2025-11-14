<h1>Liste des navires</h1>
<a href="navire_details.php?action=create">Ajouter un navire</a>
<table border="1">
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
        <th>ID Fret</th>
        <th>ID</th>
        <th>ID Port</th>
        <th>Actions</th>
    </tr>
    <?php foreach($navires as $navire): ?>
    <tr>
        <td><?= $navire['id_navire'] ?></td>
        <td><?= htmlspecialchars($navire['nom']) ?></td>
        <td><?= $navire['autorise'] ? 'Oui' : 'Non' ?></td>
        <td><?= $navire['longueur'] ?></td>
        <td><?= $navire['largeur'] ?></td>
        <td><?= $navire['tirant_eau'] ?></td>
        <td><?= $navire['capacite'] ?></td>
        <td><?= $navire['propulseur'] ? 'Oui' : 'Non' ?></td>
        <td><?= $navire['remorqueur'] ? 'Oui' : 'Non' ?></td>
        <td><?= $navire['id_fret'] ?></td>
        <td><?= $navire['id'] ?></td>
        <td><?= $navire['id_port'] ?></td>
        <td>
            <a href="navire_details.php?action=view&id_navire=<?= $navire['id_navire'] ?>">Voir</a> |
            <a href="navire_details.php?action=update&id_navire=<?= $navire['id_navire'] ?>">Modifier</a> |
            <a href="navire_details.php?action=delete&id_navire=<?= $navire['id_navire'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>