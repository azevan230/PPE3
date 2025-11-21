<?php
class Navire {
    private $pdo;

    // Constructeur : accepte un PDO en paramètre (injection), sinon
    // tente de récupérer $pdo depuis config/config.php, puis fallback à une connexion locale.
    public function __construct($pdo = null) {
        // Si un PDO est passé, on l'utilise directement
        if ($pdo instanceof PDO) {
            $this->pdo = $pdo;
            return;
        }

        // Essaye de charger la configuration centrale qui définit $pdo
        $configPath = __DIR__ . '/../config/config.php';
        if (file_exists($configPath)) {
            require_once $configPath; // doit définir $pdo
            if (isset($pdo) && $pdo instanceof PDO) {
                $this->pdo = $pdo;
                return;
            }
            // si le require a défini $pdo (variable venant du fichier), l'utiliser
            if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
                $this->pdo = $GLOBALS['pdo'];
                return;
            }
            if (isset($pdo) && $pdo instanceof PDO) { // double-check
                $this->pdo = $pdo;
                return;
            }
        }

        // Fallback : création d'une connexion PDO locale sécurisée
        try {
            $dsn = 'mysql:host=localhost;dbname=escale;charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            throw new \RuntimeException('Erreur de connexion à la base de données (Navire) : ' . $e->getMessage());
        }
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