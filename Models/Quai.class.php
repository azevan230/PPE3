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
    public function getId_quai() { return $this->id_quai; }
    public function getNom() { return $this->nom; }
    public function getTirant_eau_max() { return $this->tirant_eau_max; }

    // Setters
    public function setId_quai($id_quai) { 
        $this->id_quai = (int) $id_quai; 
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