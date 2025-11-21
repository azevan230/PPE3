<?php
// Chargement de la config PDO si disponible
$configPath = __DIR__ . '/../config/config.php';
if (file_exists($configPath)) {
    require_once $configPath; // doit définir $pdo
}
// Charger le modèle Navire
require_once __DIR__ . '/../model/Navire.php';

class NavireController {
    private $navireModel;

    // Constructeur : injecte $pdo si disponible
    public function __construct() {
        if (isset($pdo) && $pdo instanceof PDO) {
            $this->navireModel = new Navire($pdo);
        } else {
            // fallback : le modèle gère la création PDO s'il n'en reçoit pas
            $this->navireModel = new Navire();
        }
    }

    // Gère les actions CRUD (list, create, update, delete, view)
    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';
        $id_navire = $_GET['id_navire'] ?? null;

        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Valider / nettoyer minimalement les données avant insertion
                    $data = $this->sanitizeNavireData($_POST);
                    $this->navireModel->create($data);
                    header('Location: navires.php');
                    exit;
                } else {
                    $navire = null;
                    include __DIR__ . '/../view/navire_details.php';
                }
                break;

            case 'update':
                if (!$id_navire) { header('Location: navires.php'); exit; }
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $data = $this->sanitizeNavireData($_POST);
                    $this->navireModel->update($id_navire, $data);
                    header('Location: navires.php');
                    exit;
                } else {
                    $navire = $this->navireModel->getById($id_navire);
                    include __DIR__ . '/../view/navire_details.php';
                }
                break;

            case 'delete':
                if ($id_navire) {
                    $this->navireModel->delete($id_navire);
                }
                header('Location: navires.php');
                break;

            case 'view':
                if (!$id_navire) { header('Location: navires.php'); exit; }
                $navire = $this->navireModel->getById($id_navire);
                include __DIR__ . '/../view/navire_details.php';
                break;

            default:
                $navires = $this->navireModel->getAll();
                include __DIR__ . '/../view/navires.php';
        }
    }

    // Nettoie et prépare les données issues du formulaire
    private function sanitizeNavireData(array $input): array {
        return [
            'nom' => trim($input['nom'] ?? ''),
            'autorise' => !empty($input['autorise']) ? 1 : 0,
            'longueur' => $input['longueur'] ?? 0,
            'largeur' => $input['largeur'] ?? 0,
            'tirant_eau' => $input['tirant_eau'] ?? 0,
            'capacite' => $input['capacite'] ?? 0,
            'propulseur' => !empty($input['propulseur']) ? 1 : 0,
            'remorqueur' => !empty($input['remorqueur']) ? 1 : 0,
            'id_fret' => $input['id_fret'] ?? null,  //Jeux de test (clés étrangères)
            'id' => $input['id'] ?? null,
            'id_port' => $input['id_port'] ?? null,
        ];
    }
}
