<?php

class PosteAccostage {
    private $id_poste_accostage;
    private $id_quai;

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
    public function getId_poste_accostage() { 
        return $this->id_poste_accostage; 
    }
    
    public function getId_quai() { 
        return $this->id_quai; 
    }

    // Setters - CORRECTION CRITIQUE
    public function setId_poste_accostage($id_poste_accostage) { 
        // Ne définir l'ID que s'il est valide et > 0
        if ($id_poste_accostage !== null && $id_poste_accostage > 0) {
            $this->id_poste_accostage = (int) $id_poste_accostage;
        } else {
            $this->id_poste_accostage = null; // Important pour l'auto-incrément
        }
    }
    
    public function setId_quai($id_quai) { 
        $this->id_quai = (int) $id_quai; 
    }
}
?>