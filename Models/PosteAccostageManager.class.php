<?php

class PosteAccostageManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPostesByQuai($id_quai) {
        $postes = [];
        $query = "SELECT pa.*, q.nom as nom_quai 
                  FROM poste_accostage pa 
                  INNER JOIN quai q ON pa.id_quai = q.id_quai 
                  WHERE pa.id_quai = :id_quai 
                  ORDER BY pa.id_poste_accostage";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmt->execute();
        
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $postes[] = new PosteAccostage($data);
        }
        
        return $postes;
    }

    public function getPosteById($id_poste_accostage) {
        $query = "SELECT pa.*, q.nom as nom_quai 
                  FROM poste_accostage pa 
                  INNER JOIN quai q ON pa.id_quai = q.id_quai 
                  WHERE pa.id_poste_accostage = :id_poste_accostage";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_poste_accostage', $id_poste_accostage, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new PosteAccostage($data);
        }
        
        return null;
    }

    public function creerPoste(PosteAccostage $poste) {
        $query = "INSERT INTO poste_accostage (id_quai) VALUES (:id_quai)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $poste->getId_quai(), PDO::PARAM_INT);
        
        return $stmt->execute();
}
    public function supprimerPoste($id_poste_accostage) {
        // Vérifier s'il y a des escales associées
        $queryCheck = "SELECT COUNT(*) FROM escale WHERE id_poste_accostage = :id_poste_accostage";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindValue(':id_poste_accostage', $id_poste_accostage, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        if ($stmtCheck->fetchColumn() > 0) {
            throw new Exception("Impossible de supprimer le poste : des escales y sont associées");
        }
        
        $query = "DELETE FROM poste_accostage WHERE id_poste_accostage = :id_poste_accostage";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_poste_accostage', $id_poste_accostage, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function isPosteDisponible($id_poste_accostage) {
        $query = "SELECT COUNT(*) FROM escale 
                  WHERE id_poste_accostage = :id_poste_accostage 
                  AND date_depart IS NULL";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_poste_accostage', $id_poste_accostage, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 0;
    }
}
?>