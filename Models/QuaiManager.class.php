<?php

class QuaiManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllQuais() {
        $quais = [];
        $query = "SELECT * FROM quai ORDER BY nom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $quais[] = new Quai($data);
        }
        
        return $quais;
    }

    public function getQuaiById($id_quai) {
        $query = "SELECT * FROM quai WHERE id_quai = :id_quai";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Quai($data);
        }
        
        return null;
    }

    public function creerQuai(Quai $quai) {
        $query = "INSERT INTO quai (nom, tirant_eau_max) 
                  VALUES (:nom, :tirant_eau_max)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $quai->getNom());
        $stmt->bindValue(':tirant_eau_max', $quai->getTirant_eau_max());
        
        return $stmt->execute();
    }

    public function modifierQuai(Quai $quai) {
        $query = "UPDATE quai SET nom = :nom, tirant_eau_max = :tirant_eau_max 
                  WHERE id_quai = :id_quai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $quai->getNom());
        $stmt->bindValue(':tirant_eau_max', $quai->getTirant_eau_max());
        $stmt->bindValue(':id_quai', $quai->getId_quai(), PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function supprimerQuai($id_quai) {
        // Vérifier s'il y a des postes d'accostage associés
        $queryCheck = "SELECT COUNT(*) FROM poste_accostage WHERE id_quai = :id_quai";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        if ($stmtCheck->fetchColumn() > 0) {
            throw new Exception("Impossible de supprimer le quai : des postes d'accostage y sont associés");
        }
        
        $query = "DELETE FROM quai WHERE id_quai = :id_quai";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getTypesFretByQuai($id_quai) {
        $typesFret = [];
        $query = "SELECT f.* FROM fret f 
                  INNER JOIN fret_quai fq ON f.id_fret = fq.id_fret 
                  WHERE fq.id_quai = :id_quai 
                  ORDER BY f.type";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTypesFretIdsByQuai($id_quai) {
    $ids = [];
    $query = "SELECT id_fret FROM fret_quai WHERE id_quai = :id_quai";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ids[] = $row['id_fret'];
    }
    
    return $ids;
}
}
?>