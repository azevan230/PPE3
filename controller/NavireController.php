<?php
<<<<<<< HEAD
require_once "model/NavireModel.php";

function afficherNavires() {
    $navires = getNavires();
    require "view/Navire_liste.php";
}

function creerNavire() {
    $frets = getFrets(); // créer cette fonction dans Naviremodel.php qui fait SELECT * FROM fret
    if (!empty($_POST)) {
        insertNavire(
            $_POST['nom'],
            $_POST['autorise'],
            $_POST['longueur'],
            $_POST['largeur'],
            $_POST['tirant_eau'],
            $_POST['capacite'],
            $_POST['propulseur'],
            $_POST['remorqueur'],
            $_POST['id_fret'],
            $_POST['id_port']
        );
        header("Location: index.php?page=navires");
        exit;
    }
    require "view/Navire_create.php";
}


function afficherNavire($id_navire) {
    $navire = getNavireById($id_navire);
    if (!$navire) die("Navire introuvable.");
    require "view/Navire_details.php";
}

function modifierNavire($id_navire) {
    $navire = getNavireById($id_navire);
    if (!$navire) die("Navire introuvable.");

    if (!empty($_POST)) {
        updateNavire($id_navire, $_POST['nom'], $_POST['type'], $_POST['tonnage']);
        header("Location: index.php?page=navires");
        exit;
    }
    require "view/Navire_modifier.php";
}

function supprimerNavire($id_navire) {
    deleteNavire($id_navire);
    header("Location: index.php?page=navires");
    exit;
}
?>
=======
// Charger la config PDO si disponible
$configPath = __DIR__ . '/../config/config.php';
if (file_exists($configPath)) {
    require_once $configPath; // doit définir $pdo
}
// Charger le modèle Navire
require_once __DIR__ . '/../model/Navire.php';

class NavireController {
    private $navireModel;

    // Injecte $pdo si disponible, sinon le modèle gère sa propre connexion
    public function __construct() {
        if (isset($pdo) && $pdo instanceof PDO) {
            $this->navireModel = new Navire($pdo);
        } else {
            $this->navireModel = new Navire();
        }
    }

    // Gère les actions CRUD
    public function handleRequest() {
        // Récupère l'action (list/create/update/delete/view)
        $action = $_REQUEST['action'] ?? 'list';
        // Récupère l'id depuis GET ou POST (permet au formulaire POST d'envoyer l'id)
        $id_navire = $_REQUEST['id_navire'] ?? $_REQUEST['id'] ?? null;

        switch ($action) {
            case 'create':
                // GET => affiche le formulaire, POST => crée l'enregistrement
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                // Update : peut provenir d'un POST (formulaire) ou GET pour afficher le formulaire
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // id peut être envoyé en POST (hidden field) ou via query string
                    $id_navire = $_POST['id_navire'] ?? $id_navire;
                    if (!$id_navire) { header('Location: navires.php'); exit; }
                    $data = $this->sanitizeNavireData($_POST);
                    $this->navireModel->update($id_navire, $data);
                    header('Location: navires.php');
                    exit;
                } else {
                    if (!$id_navire) { header('Location: navires.php'); exit; }
                    $navire = $this->navireModel->getById($id_navire);
                    include __DIR__ . '/../view/navire_details.php';
                }
                break;

            case 'delete':
                // Delete : action via GET (confirm côté client). Toujours valider côté serveur.
                if ($id_navire) {
                    $this->navireModel->delete($id_navire);
                }
                header('Location: navires.php');
                exit;
                break;

            case 'view':
                if (!$id_navire) { header('Location: navires.php'); exit; }
                $navire = $this->navireModel->getById($id_navire);
                include __DIR__ . '/../view/navire_details.php';
                break;

            default: // list
                $navires = $this->navireModel->getAll();
                include __DIR__ . '/../view/navires.php';
        }
    }

    // Nettoie et prépare les données issues du formulaire avant insertion / update
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
            'id_fret' => $input['id_fret'] ?? null,
            // la colonne en base s'appelle 'id' (armateur) : garder 'id' cohérent avec le modèle
            'id' => $input['id'] ?? null,
            'id_port' => $input['id_port'] ?? null,
        ];
    }
}
>>>>>>> jonathan
