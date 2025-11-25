<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier une escale</title>
<style>
body { font-family: Arial; background:#f4f4f4; margin:40px; }
form { width:400px; margin:auto; background:white; padding:20px; border-radius:8px; }
input, select { width:100%; padding:8px; margin-top:6px; }
button { padding:10px 15px; margin-top:15px; background:#0055a5; color:white; border:none; border-radius:6px; cursor:pointer; }
</style>
</head>
<body>

<h2 style="text-align:center;">Modifier l'escale #<?= $escale['id_escale'] ?></h2>

<form method="POST">

    <label>Date arrivée :</label>
    <input type="date" name="date_arrive" value="<?= $escale['date_arrive'] ?>" required>

    <label>Date départ :</label>
    <input type="date" name="date_depart" value="<?= $escale['date_depart'] ?>" required>

    <label>Fret :</label>
    <select name="id_fret" required>
        <?php foreach ($frets as $f): ?>
            <option value="<?= $f['id_fret'] ?>" 
                <?= $f['id_fret'] == $escale['id_fret'] ? 'selected' : '' ?>>
                <?= $f['type'] ?> - <?= $f['libelle'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Docker :</label>
    <select name="id_docker" required>
        <?php foreach ($dockers as $d): ?>
            <option value="<?= $d['id_employee'] ?>" 
                <?= $d['id_employee'] == $escale['id_employee'] ? 'selected' : '' ?>>
                <?= $d['nom'] ?> <?= $d['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Pilote 1 :</label>
    <select name="id_pilote1" required>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" 
                <?= $p['id_employee'] == $escale['id_employee_1'] ? 'selected' : '' ?>>
                <?= $p['nom'] ?> <?= $p['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Pilote 2 :</label>
    <select name="id_pilote2" required>
        <?php foreach ($pilotes as $p): ?>
            <option value="<?= $p['id_employee'] ?>" 
                <?= $p['id_employee'] == $escale['id_employee_2'] ? 'selected' : '' ?>>
                <?= $p['nom'] ?> <?= $p['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Poste d'accostage :</label>
    <select name="id_poste_accostage" required>
        <?php foreach ($postes as $po): ?>
            <option value="<?= $po['id_poste_accostage'] ?>" 
                <?= $po['id_poste_accostage'] == $escale['id_poste_accostage'] ? 'selected' : '' ?>>
                Poste <?= $po['id_poste_accostage'] ?> - <?= $po['quai_nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Navire :</label>
    <select name="id_navire" required>
        <?php foreach ($navires as $n): ?>
            <option value="<?= $n['id_navire'] ?>" 
                <?= $n['id_navire'] == $escale['id_navire'] ? 'selected' : '' ?>>
                <?= $n['nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Enregistrer</button>
</form>

<br>
<div style="text-align:center;">
    <a href="index.php?page=escales">Retour</a>
</div>

</body>
</html>
