<?php


// Charger la configuration pour récupérer $pdo si disponible
$configPath = __DIR__ . '/../config/config.php';
if (file_exists($configPath)) {
    require_once $configPath;
}
// Charger le modèle Navire
require_once __DIR__ . '/../model/Navire.php';



class NavireController {
    private $navireModel;




    public function __construct() {
        // Si $pdo est défini et est bien un PDO, essayer de l'injecter dans le modèle
        if (isset($pdo) && $pdo instanceof PDO) {
            try {
                // Vérifie si le constructeur du modèle accepte un paramètre (injection PDO)
                $ref = new ReflectionClass('Navire');
                $ctor = $ref->getConstructor();
                if ($ctor && $ctor->getNumberOfParameters() > 0) {
                    // Passe $pdo au constructeur si attendu
                    $this->navireModel = $ref->newInstance($pdo);
                    return;
                }
            } catch (ReflectionException $e) {
                // Si réflexion échoue, on tombe en backoff sur l'instanciation sans param
            }
        }

        // Fallback : instanciation sans PDO
        $this->navireModel = new Navire();
    }



    
    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';
        $id_navire = $_GET['id_navire'] ?? null;

        switch($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->navireModel->create($_POST);
                    header('Location: navires.php');
                } else {
                    include __DIR__ . '/../view/navire_details.php';
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_navire) {
                    $this->navireModel->update($id_navire, $_POST);
                    header('Location: navires.php');
                } else {
                    $navire = $this->navireModel->getById($id_navire);
                    include __DIR__ . '/../view/navire_details.php';
                }
                break;

            case 'delete':
                if ($id_navire) {
                    $this->navireModel->delete($id_navire);
                    header('Location: navires.php');
                }
                break;

            case 'view':
                $navire = $this->navireModel->getById($id_navire);
                include __DIR__ . '/../view/navire_details.php';
                break;

            default:
                $navires = $this->navireModel->getAll();
                include __DIR__ . '/../view/navires.php';
        }
    }
}
