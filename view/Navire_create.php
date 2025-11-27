<!-- view/navire_create.php -->
<h2>Créer un nouveau navire</h2>

<?php if (!empty($error)): ?>
    <div class="error-message">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?page=navire_create">
    
    <label for="nom">Nom du navire * :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="autorise">Autorisé :</label>
    <input type="checkbox" id="autorise" name="autorise" value="1">

    <label for="longueur">Longueur (m) :</label>
    <input type="number" id="longueur" name="longueur" step="0.1" min="0">

    <label for="largeur">Largeur (m) :</label>
    <input type="number" id="largeur" name="largeur" step="0.1" min="0">

    <label for="tirant_eau">Tirant d'eau (m) :</label>
    <input type="number" id="tirant_eau" name="tirant_eau" step="0.1" min="0">

    <label for="capacite">Capacité (t) :</label>
    <input type="number" id="capacite" name="capacite" step="0.1" min="0">

    <label for="propulseur">Propulseur :</label>
    <input type="checkbox" id="propulseur" name="propulseur" value="1">

    <label for="remorqueur">Remorqueur :</label>
    <input type="checkbox" id="remorqueur" name="remorqueur" value="1">

    <label for="id_fret">Type de fret :</label>
    <select id="id_fret" name="id_fret">
        <option value="">-- Sélectionner un fret --</option>
        <?php foreach ($frets as $fret): ?>
            <option value="<?= $fret['id_fret'] ?>">
                <?= htmlspecialchars($fret['type']) ?> - <?= htmlspecialchars($fret['libelle']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_armateur">Armateur :</label>
    <select id="id_armateur" name="id_armateur">
        <option value="">-- Sélectionner un armateur --</option>
        <?php foreach ($armateurs as $armateur): ?>
            <option value="<?= $armateur['id'] ?>">
                <?= htmlspecialchars($armateur['nom']) ?> <?= htmlspecialchars($armateur['prenom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="id_port">Port d'attache :</label>
    <select id="id_port" name="id_port">
        <option value="">-- Sélectionner un port --</option>
        <?php foreach ($ports as $port): ?>
            <option value="<?= $port['id_port'] ?>">
                <?= htmlspecialchars($port['nom']) ?> - <?= htmlspecialchars($port['ville']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="form-actions">
        <button type="submit">Créer le navire</button>
        <a href="index.php?page=navires">Annuler</a>
    </div>
</form>