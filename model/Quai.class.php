<?php

class Quai {
    private $id_quai;
    private $nom;
    private $tirant_eau_max;

    public function __construct($data = array()) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate($data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId_quai() { 
        return $this->id_quai; 
    }
    
    public function getNom() { 
        return $this->nom; 
    }
    
    public function getTirant_eau_max() { 
        return $this->tirant_eau_max; 
    }

    // Setters - CORRECTION CRITIQUE
    public function setId_quai($id_quai) { 
        // Ne définir l'ID que s'il est valide et > 0
        // Pour les nouvelles créations, l'ID doit être null
        if ($id_quai !== null && $id_quai > 0) {
            $this->id_quai = (int) $id_quai;
        } else {
            $this->id_quai = null; // Important pour l'auto-incrément
        }
    }
    
    public function setNom($nom) { 
        if (is_string($nom) && strlen($nom) <= 50) {
            $this->nom = $nom;
        }
    }
    
    public function setTirant_eau_max($tirant_eau_max) { 
        $this->tirant_eau_max = (float) $tirant_eau_max; 
    }
}
?>