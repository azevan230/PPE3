<?php
// Vue : Liste des navires
// Explication générale (CRUD) :
// - Read (liste) : le contrôleur NavireController appelle Navire::getAll() et fournit $navires à cette vue.
//   Le front-controller est navires.php qui inclut controller/NavireController.php.
// - Create : le lien "Ajouter un navire" dirige vers navire_details.php?action=create.
//   Le contrôleur affiche le formulaire (GET) puis crée l'enregistrement via Navire::create() si POST.
// - View : le lien "Voir" dirige vers navire_details.php?action=view&id_navire=... ; le contrôleur récupère l'élément via Navire::getById().
// - Update : le lien "Modifier" dirige vers navire_details.php?action=update&id_navire=... ; le contrôleur affiche le formulaire prérempli (GET)
//   puis met à jour via Navire::update($id, $data) si POST.
// - Delete : le lien "Supprimer" appelle navire_details.php?action=delete&id_navire=... ; le contrôleur supprime via Navire::delete($id) et redirige.
// Remarque sécurité : le contrôleur doit valider les entrées et protéger ces actions (vérifier session / droits).
?>
<h1>Liste des navires</h1>

<!-- Lien de création : ouvre le formulaire (action=create) -->
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
        <th>ID Armateur</th>
        <th>ID Port</th>
        <th>Actions</th>
    </tr>
    <?php
    // $navires est fourni par le contrôleur (NavireController->handleRequest)
    // Chaque élément $navire est un tableau associatif provenant de la base (Navire::getAll()).
    foreach($navires as $navire): ?>
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
        <td><?= $navire['id_armateur'] ?></td>
        <td><?= $navire['id_port'] ?></td>
        <td>
            <!-- Voir : affiche les détails (contrôleur -> Navire::getById) -->
            <a href="navire_details.php?action=view&id_navire=<?= $navire['id_navire'] ?>">Voir</a> |
            <!-- Modifier : affiche le formulaire prérempli et met à jour en POST (contrôleur -> Navire::update) -->
            <a href="navire_details.php?action=update&id_navire=<?= $navire['id_navire'] ?>">Modifier</a> |
            <!-- Supprimer : action delete ; le contrôleur supprimera via Navire::delete puis redirigera.
                 Le onclick confirme côté client. Toujours valider côté serveur avant suppression. -->
            <a href="navire_details.php?action=delete&id_navire=<?= $navire['id_navire'] ?>" onclick="return confirm('Supprimer ?');">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>