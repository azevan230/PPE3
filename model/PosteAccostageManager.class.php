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
    try {
        // Récupérer le prochain ID manuellement
        $queryMaxId = "SELECT COALESCE(MAX(id_poste_accostage), 0) + 1 as next_id FROM poste_accostage";
        $stmtMaxId = $this->db->prepare($queryMaxId);
        $stmtMaxId->execute();
        $nextId = $stmtMaxId->fetch(PDO::FETCH_ASSOC)['next_id'];
        
        error_log("Prochain ID manuel pour poste: " . $nextId);
        
        $query = "INSERT INTO poste_accostage (id_poste_accostage, id_quai) VALUES (:id_poste_accostage, :id_quai)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_poste_accostage', $nextId, PDO::PARAM_INT);
        $stmt->bindValue(':id_quai', $poste->getId_quai(), PDO::PARAM_INT);
        
        $result = $stmt->execute();
        
        if ($result) {
            error_log("Poste créé avec ID manuel: " . $nextId);
            return $nextId;
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("Exception dans creerPoste: " . $e->getMessage());
        throw $e;
    }
}

    public function supprimerPoste($id_poste_accostage) {
    try {
        $this->db->beginTransaction();
        
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
        $result = $stmt->execute();
        
        $this->db->commit();
        return $result;
        
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
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
    public function creerPosteEtRetournerId($data) {
    try {
        // 1. Trouver le prochain ID disponible
        $queryMaxId = "SELECT MAX(id_poste_accostage) as max_id FROM poste_accostage";
        $stmtMaxId = $this->db->prepare($queryMaxId);
        $stmtMaxId->execute();
        $maxId = $stmtMaxId->fetch(PDO::FETCH_ASSOC)['max_id'];
        $nextId = ($maxId ? $maxId : 0) + 1;

        // 2. Insérer avec l'ID manuel
        $query = "INSERT INTO poste_accostage (id_poste_accostage, id_quai) VALUES (:id_poste_accostage, :id_quai)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_poste_accostage', $nextId, PDO::PARAM_INT);
        $stmt->bindValue(':id_quai', $data['id_quai'], PDO::PARAM_INT);
        
        $result = $stmt->execute();
        
        if ($result) {
            return $nextId;
        }
        
        return 0;
        
    } catch (Exception $e) {
        error_log("Exception dans creerPosteEtRetournerId: " . $e->getMessage());
        throw $e;
    }
}
}
?>