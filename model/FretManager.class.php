<?php

class FretManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllFret() {
        $query = "SELECT * FROM fret ORDER BY type";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function associerFretQuai($id_fret, $id_quai) {
        $query = "INSERT INTO fret_quai (id_fret, id_quai) VALUES (:id_fret, :id_quai)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_fret', $id_fret, PDO::PARAM_INT);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function supprimerAssociationsFretQuai($id_quai) {
        $query = "DELETE FROM fret_quai WHERE id_quai = :id_quai";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getFretByQuai($id_quai) {
        $query = "SELECT f.* FROM fret f 
                  INNER JOIN fret_quai fq ON f.id_fret = fq.id_fret 
                  WHERE fq.id_quai = :id_quai 
                  ORDER BY f.type";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>