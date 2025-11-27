<!-- view/navire_modifier.php -->
<h2>Modifier le navire : <?= htmlspecialchars($navire['nom']) ?></h2>

<?php if (!empty($error)): ?>
    <div class="error-message">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success-message">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?page=navire_modifier&id_navire=<?= $navire['id_navire'] ?>">
    
    <label for="nom">Nom du navire * :</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($navire['nom']) ?>" required>

    <label for="autorise">Autorisé :</label>
    <input type="checkbox" id="autorise" name="autorise" value="1" <?= $navire['autorise'] ? 'checked' : '' ?>>

    <label for="longueur">Longueur (m) :</label>
    <input type="number" id="longueur" name="longueur" step="0.1" min="0" value="<?= htmlspecialchars($navire['longueur']) ?>">

    <label for="largeur">Largeur (m) :</label>
    <input type="number" id="largeur" name="largeur" step="0.1" min="0" value="<?= htmlspecialchars($navire['largeur']) ?>">

    <label for="tirant_eau">Tirant d'eau (m) :</label>
    <input type="number" id="tirant_eau" name="tirant_eau" step="0.1" min="0" value="<?= htmlspecialchars($navire['tirant_eau']) ?>">

    <label for="capacite">Capacité (t) :</label>
    <input type="number" id="capacite" name="capacite" step="0.1" min="0" value="<?= htmlspecialchars($navire['capacite']) ?>">

    <label for="propulseur">Propulseur :</label>
    <input type="checkbox" id="propulseur" name="propulseur" value="1" <?= $navire['propulseur'] ? 'checked' : '' ?>>

    <label for="remorqueur">Remorqueur :</label>
    <input type="checkbox" id="remorqueur" name="remorqueur" value="1" <?= $navire['remorqueur'] ? 'checked' : '' ?>>

    <label for="id_fret">Type de fret :</label>
    <select id="id_fret" name="id_fret">
        <option value="">-- Sélectionner un fret --</option>
        <?php foreach ($frets as $fret): ?>
            <option value="<?= $fret['id_fret'] ?>" <?= $navire['id_fret'] == $fret['id_fret'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($fret['type']) ?> - <?= htmlspecialchars($fret['libelle']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_armateur">Armateur :</label>
    <select id="id_armateur" name="id_armateur">
        <option value="">-- Sélectionner un armateur --</option>
        <?php foreach ($armateurs as $armateur): ?>
            <option value="<?= $armateur['id'] ?>" <?= $navire['id'] == $armateur['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($armateur['nom']) ?> <?= htmlspecialchars($armateur['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_port">Port d'attache :</label>
    <select id="id_port" name="id_port">
        <option value="">-- Sélectionner un port --</option>
        <?php foreach ($ports as $port): ?>
            <option value="<?= $port['id_port'] ?>" <?= $navire['id_port'] == $port['id_port'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($port['nom']) ?> - <?= htmlspecialchars($port['ville']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="form-actions">
        <button type="submit">Enregistrer les modifications</button>
        <a href="index.php?page=navire_details&id_navire=<?= $navire['id_navire'] ?>">Annuler</a>
        <a href="index.php?page=navires">Retour à la liste</a>
    </div>
</form>