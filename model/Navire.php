<?php
class Navire {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM navire");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_navire) {
        $stmt = $this->pdo->prepare("SELECT * FROM navire WHERE id_navire = ?");
        $stmt->execute([$id_navire]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function create($data) {
    $stmt = $this->pdo->prepare("
        INSERT INTO navire
        (nom, autorise, longueur, largeur, tirant_eau, capacite, propulseur, remorqueur, id_fret, id, id_port) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([
        $data['nom'],
        $data['autorise'] ?? 0,
        $data['longueur'] ?? 0,
        $data['largeur'] ?? 0,
        $data['tirant_eau'] ?? 0,
        $data['capacite'] ?? 0,
        $data['propulseur'] ?? 0,
        $data['remorqueur'] ?? 0,
        $data['id_fret'],
        $data['id'],
        $data['id_port']
    ]);
}

public function update($id_navire, $data) {
    $stmt = $this->pdo->prepare("
        UPDATE navire SET 
        nom=?, autorise=?, longueur=?, largeur=?, tirant_eau=?, capacite=?, propulseur=?, remorqueur=?, id_fret=?, id=?, id_port=?
        WHERE id_navire=?
    ");
    return $stmt->execute([
        $data['nom'],
        $data['autorise'] ?? 0,
        $data['longueur'] ?? 0,
        $data['largeur'] ?? 0,
        $data['tirant_eau'] ?? 0,
        $data['capacite'] ?? 0,
        $data['propulseur'] ?? 0,
        $data['remorqueur'] ?? 0,
        $data['id_fret'],
        $data['id'],
        $data['id_port'],
        $id_navire
    ]);
}


    public function delete($id_navire) {
        $stmt = $this->pdo->prepare("DELETE FROM navire WHERE id_navire = ?");
        return $stmt->execute([$id_navire]);
    }
}
