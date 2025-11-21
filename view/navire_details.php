<?php
// $navire peut être null (create) ou un tableau (update/view)
// $action = 'create' | 'update' | 'view'
$action = $_GET['action'] ?? 'list';
$readonly = ($action === 'view') ? 'readonly' : '';
$disabled = ($action === 'view') ? 'disabled' : '';
// valeurs par défaut
$values = [
    'nom' => $navire['nom'] ?? '',
    'autorise' => $navire['autorise'] ?? 0,
    'longueur' => $navire['longueur'] ?? '',
    'largeur' => $navire['largeur'] ?? '',
    'tirant_eau' => $navire['tirant_eau'] ?? '',
    'capacite' => $navire['capacite'] ?? '',
    'propulseur' => $navire['propulseur'] ?? 0,
    'remorqueur' => $navire['remorqueur'] ?? 0,
    'id_fret' => $navire['id_fret'] ?? '',
    'id' => $navire['id'] ?? '',
    'id_port' => $navire['id_port'] ?? '',
];
?>
<h2><?php echo ($action === 'create') ? 'Ajouter un navire' : (($action === 'view') ? 'Détails du navire' : 'Modifier le navire'); ?></h2>

<form method="post" action="navire_details.php?action=<?php echo htmlspecialchars($action) . ($navire['id_navire'] ?? (isset($_GET['id_navire']) ? '&id_navire=' . intval($_GET['id_navire']) : '')); ?>">
    <label>Nom:</label>
    <input type="text" name="nom" value="<?php echo htmlspecialchars($values['nom']); ?>" <?php echo $readonly; ?> required><br>

    <label>Autorisé:</label>
    <input type="checkbox" name="autorise" value="1" <?php echo ($values['autorise'] ? 'checked' : ''); ?> <?php echo $disabled; ?>><br>

    <label>Longueur:</label>
    <input type="number" step="0.1" name="longueur" value="<?php echo htmlspecialchars($values['longueur']); ?>" <?php echo $readonly; ?>><br>

    <label>Largeur:</label>
    <input type="number" step="0.1" name="largeur" value="<?php echo htmlspecialchars($values['largeur']); ?>" <?php echo $readonly; ?>><br>

    <label>Tirant d'eau:</label>
    <input type="number" step="0.1" name="tirant_eau" value="<?php echo htmlspecialchars($values['tirant_eau']); ?>" <?php echo $readonly; ?>><br>

    <label>Capacité:</label>
    <input type="number" step="0.1" name="capacite" value="<?php echo htmlspecialchars($values['capacite']); ?>" <?php echo $readonly; ?>><br>

    <label>Propulseur:</label>
    <input type="checkbox" name="propulseur" value="1" <?php echo ($values['propulseur'] ? 'checked' : ''); ?> <?php echo $disabled; ?>><br>

    <label>Remorqueur:</label>
    <input type="checkbox" name="remorqueur" value="1" <?php echo ($values['remorqueur'] ? 'checked' : ''); ?> <?php echo $disabled; ?>><br>

    <label>ID Fret:</label>
    <input type="number" name="id_fret" value="<?php echo htmlspecialchars($values['id_fret']); ?>" <?php echo $readonly; ?>><br>

    <label>ID Armateur (id):</label>
    <input type="number" name="id" value="<?php echo htmlspecialchars($values['id']); ?>" <?php echo $readonly; ?>><br>

    <label>ID Port:</label>
    <input type="number" name="id_port" value="<?php echo htmlspecialchars($values['id_port']); ?>" <?php echo $readonly; ?>><br>

    <?php if ($action === 'view'): ?>
        <p><a href="navires.php">Retour</a></p>
    <?php else: ?>
        <button type="submit"><?php echo ($action === 'create') ? 'Créer' : 'Enregistrer'; ?></button>
        <a href="navires.php">Annuler</a>
    <?php endif; ?>
</form>