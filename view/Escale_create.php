<h2>Créer une escale</h2>

<form method="POST">

    <label>Date d'arrivée :</label>
    <input type="date" name="date_arrive" required><br><br>

    <label>Date de départ :</label>
    <input type="date" name="date_depart" required><br><br>

    <label>Fret :</label>
    <select name="id_fret" required>
        <option value="">-- Sélectionner --</option>
        <?php
        $pdo = getConnexion();
        $frets = $pdo->query("SELECT * FROM fret")->fetchAll();
        foreach ($frets as $f) {
            echo "<option value='{$f['id_fret']}'>{$f['type']} - {$f['libelle']}</option>";
        }
        ?>
    </select><br><br>

    <label>Docker :</label>
    <select name="id_docker" required>
        <option value="">-- Sélectionner --</option>
        <?php
        $dockers = $pdo->query("
            SELECT employee.id_employee, nom, prenom
            FROM employee 
            JOIN docker ON docker.id_employee = employee.id_employee
        ")->fetchAll();

        foreach ($dockers as $d) {
            echo "<option value='{$d['id_employee']}'>{$d['nom']} {$d['prenom']}</option>";
        }
        ?>
    </select><br><br>

    <label>Pilote 1 :</label>
    <select name="id_pilote1" required>
        <option value="">-- Sélectionner --</option>
        <?php
        $pilotes = $pdo->query("
            SELECT employee.id_employee, nom, prenom
            FROM employee 
            JOIN pilote ON pilote.id_employee = employee.id_employee
        ")->fetchAll();

        foreach ($pilotes as $p) {
            echo "<option value='{$p['id_employee']}'>{$p['nom']} {$p['prenom']}</option>";
        }
        ?>
    </select><br><br>

    <label>Pilote 2 :</label>
    <select name="id_pilote2" required>
        <option value="">-- Sélectionner --</option>
        <?php
        foreach ($pilotes as $p) {
            echo "<option value='{$p['id_employee']}'>{$p['nom']} {$p['prenom']}</option>";
        }
        ?>
    </select><br><br>

    <label>Poste d'accostage :</label>
    <select name="id_poste_accostage" required>
        <option value="">-- Sélectionner --</option>
        <?php
        $postes = $pdo->query("
            SELECT pa.id_poste_accostage, q.nom as quai
            FROM poste_accostage pa
            JOIN quai q ON q.id_quai = pa.id_quai
        ")->fetchAll();

        foreach ($postes as $po) {
            echo "<option value='{$po['id_poste_accostage']}'>Poste {$po['id_poste_accostage']} - {$po['quai']}</option>";
        }
        ?>
    </select><br><br>

    <label>Navire :</label>
    <select name="id_navire" required>
        <option value="">-- Sélectionner --</option>
        <?php
        $navires = $pdo->query("SELECT * FROM navire")->fetchAll();
        foreach ($navires as $n) {
            echo "<option value='{$n['id_navire']}'>{$n['nom']}</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Créer</button>

</form>
