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
    try {
        // Récupérer le prochain ID manuellement
        $queryMaxId = "SELECT COALESCE(MAX(id_quai), 0) + 1 as next_id FROM quai";
        $stmtMaxId = $this->db->prepare($queryMaxId);
        $stmtMaxId->execute();
        $nextId = $stmtMaxId->fetch(PDO::FETCH_ASSOC)['next_id'];
        
        error_log("Prochain ID manuel pour quai: " . $nextId);
        
        // Insérer avec l'ID manuel
        $query = "INSERT INTO quai (id_quai, nom, tirant_eau_max) VALUES (:id_quai, :nom, :tirant_eau_max)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $nextId, PDO::PARAM_INT);
        $stmt->bindValue(':nom', $quai->getNom());
        $stmt->bindValue(':tirant_eau_max', $quai->getTirant_eau_max());
        
        $result = $stmt->execute();
        
        if ($result) {
            error_log("Quai créé avec ID manuel: " . $nextId);
            return $nextId; // Retourner l'ID au lieu de true
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("Exception dans creerQuai: " . $e->getMessage());
        throw $e;
    }
}

    public function modifierQuai(Quai $quai) {
        $query = "UPDATE quai SET nom = :nom, tirant_eau_max = :tirant_eau_max WHERE id_quai = :id_quai";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $quai->getNom());
        $stmt->bindValue(':tirant_eau_max', $quai->getTirant_eau_max());
        $stmt->bindValue(':id_quai', $quai->getId_quai(), PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function supprimerQuai($id_quai) {
    try {
        $this->db->beginTransaction();
        
        // 1. Vérifier s'il y a des postes d'accostage associés
        $queryCheckPostes = "SELECT COUNT(*) FROM poste_accostage WHERE id_quai = :id_quai";
        $stmtCheckPostes = $this->db->prepare($queryCheckPostes);
        $stmtCheckPostes->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmtCheckPostes->execute();
        
        if ($stmtCheckPostes->fetchColumn() > 0) {
            throw new Exception("Impossible de supprimer le quai : des postes d'accostage y sont associés");
        }
        
        // 2. CORRECTION : Supprimer d'abord les associations dans fret_quai
        $queryDeleteFret = "DELETE FROM fret_quai WHERE id_quai = :id_quai";
        $stmtDeleteFret = $this->db->prepare($queryDeleteFret);
        $stmtDeleteFret->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $stmtDeleteFret->execute();
        
        // 3. Maintenant supprimer le quai
        $query = "DELETE FROM quai WHERE id_quai = :id_quai";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $id_quai, PDO::PARAM_INT);
        $result = $stmt->execute();
        
        $this->db->commit();
        return $result;
        
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
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
public function creerQuaiEtRetournerId($data) {
    try {
        // 1. Trouver le prochain ID disponible
        $queryMaxId = "SELECT MAX(id_quai) as max_id FROM quai";
        $stmtMaxId = $this->db->prepare($queryMaxId);
        $stmtMaxId->execute();
        $maxId = $stmtMaxId->fetch(PDO::FETCH_ASSOC)['max_id'];
        $nextId = ($maxId ? $maxId : 0) + 1;

        // 2. Insérer avec l'ID manuel
        $query = "INSERT INTO quai (id_quai, nom, tirant_eau_max) VALUES (:id_quai, :nom, :tirant_eau_max)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_quai', $nextId, PDO::PARAM_INT);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':tirant_eau_max', $data['tirant_eau_max']);
        
        $result = $stmt->execute();
        
        if ($result) {
            return $nextId;
        }
        
        return 0;
        
    } catch (Exception $e) {
        error_log("Exception dans creerQuaiEtRetournerId: " . $e->getMessage());
        throw $e;
    }
}
    
}
?>