<h1>
<?php
if ($action === 'create') echo "Ajouter un navire";
elseif ($action === 'update') echo "Modifier le navire";
else echo "Détails du navire";
?>
</h1>

<form method="post" action="">
    <label>Nom: <input type="text" name="nom" value="<?= $navire['nom'] ?? '' ?>"></label><br>

    <label>Autorisé: 
        <input type="checkbox" name="autorise" value="1" <?= !empty($navire['autorise']) ? 'checked' : '' ?>>
    </label><br>

    <label>Longueur (m): <input type="number" step="0.1" name="longueur" value="<?= $navire['longueur'] ?? '' ?>"></label><br>
    <label>Largeur (m): <input type="number" step="0.1" name="largeur" value="<?= $navire['largeur'] ?? '' ?>"></label><br>
    <label>Tirant d'eau (m): <input type="number" step="0.1" name="tirant_eau" value="<?= $navire['tirant_eau'] ?? '' ?>"></label><br>
    <label>Capacité: <input type="number" step="0.1" name="capacite" value="<?= $navire['capacite'] ?? '' ?>"></label><br>

    <label>Propulseur: 
        <input type="checkbox" name="propulseur" value="1" <?= !empty($navire['propulseur']) ? 'checked' : '' ?>>
    </label><br>

    <label>Remorqueur: 
        <input type="checkbox" name="remorqueur" value="1" <?= !empty($navire['remorqueur']) ? 'checked' : '' ?>>
    </label><br>

    <label>ID Fret: <input type="number" name="id_fret" value="<?= $navire['id_fret'] ?? '' ?>"></label><br>
    <label>ID: <input type="number" name="id" value="<?= $navire['id'] ?? '' ?>"></label><br>
    <label>ID Port: <input type="number" name="id_port" value="<?= $navire['id_port'] ?? '' ?>"></label><br>

    <button type="submit">Enregistrer</button>
</form>


<a href="navires.php">Retour à la liste</a>