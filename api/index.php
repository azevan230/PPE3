<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Token, Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

define('TOKEN_SECRET', 'ppe3_escale_secret_2026');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=escale;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['succes' => false, 'message' => 'Erreur base de données']);
    exit;
}

// Token stateless : base64(id_armateur:sha256(id_armateur+secret))
function genererToken(int $id_armateur): string {
    $hash = hash('sha256', $id_armateur . TOKEN_SECRET);
    return base64_encode($id_armateur . ':' . $hash);
}

function validerToken(string $token): ?int {
    $decoded = base64_decode($token, true);
    if (!$decoded || strpos($decoded, ':') === false) return null;
    [$id_armateur, $hash] = explode(':', $decoded, 2);
    if (hash('sha256', $id_armateur . TOKEN_SECRET) === $hash) {
        return (int)$id_armateur;
    }
    return null;
}

function reponseErreur(string $message, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['succes' => false, 'message' => $message]);
    exit;
}

// Routing via PATH_INFO (/api/index.php/endpoint)
$endpoint = trim($_SERVER['PATH_INFO'] ?? '', '/');

switch ($endpoint) {

    // ── CONNEXION ─────────────────────────────────────────────────────────
    case 'connecteArmateur':
        $login = trim($_GET['id']  ?? '');
        $mdp   = trim($_GET['mdp'] ?? '');

        if ($login === '' || $mdp === '') {
            reponseErreur('Identifiants manquants');
        }

        $stmt = $pdo->prepare(
            "SELECT id_utilisateur, id_armateur
             FROM utilisateur
             WHERE login = ? AND mdp = ? AND id_role = 4 AND id_armateur IS NOT NULL"
        );
        $stmt->execute([$login, hash('sha256', $mdp)]);
        $user = $stmt->fetch();

        if (!$user) {
            reponseErreur('Identifiants incorrects ou compte non armateur', 401);
        }

        echo json_encode([
            'succes' => true,
            'token'  => genererToken((int)$user['id_armateur']),
        ]);
        break;

    // ── NAVIRES DE L'ARMATEUR ─────────────────────────────────────────────
    case 'voirNaviresArmateur':
        $token = $_SERVER['HTTP_X_TOKEN'] ?? '';
        $id_armateur = validerToken($token);

        if ($id_armateur === null) {
            reponseErreur('Token invalide ou expiré', 401);
        }

        $stmt = $pdo->prepare(
            "SELECT n.id_navire, n.nom, n.autorise,
                    n.longueur, n.largeur, n.tirant_eau, n.capacite,
                    n.propulseur, n.remorqueur,
                    f.type  AS fret_type,
                    f.libelle AS fret_libelle,
                    CASE WHEN EXISTS (
                        SELECT 1 FROM escale e
                        WHERE e.id_navire = n.id_navire
                          AND e.statut IN ('en_attente', 'validee')
                    ) THEN 1 ELSE 0 END AS en_escale
             FROM navire n
             LEFT JOIN fret f ON f.id_fret = n.id_fret
             WHERE n.id = ?"
        );
        $stmt->execute([$id_armateur]);
        $navires = $stmt->fetchAll();

        // Convertir en_escale en booléen et forcer types numériques
        foreach ($navires as &$n) {
            $n['en_escale'] = (bool)$n['en_escale'];
        }
        unset($n);

        echo json_encode(['succes' => true, 'navires' => $navires]);
        break;

    // ── DEMANDE D'ESCALE ──────────────────────────────────────────────────
    case 'demandeEscale':
        $token = $_SERVER['HTTP_X_TOKEN'] ?? '';
        $id_armateur = validerToken($token);

        if ($id_armateur === null) {
            reponseErreur('Token invalide ou expiré', 401);
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $id_navire   = isset($body['id_navire'])   ? (int)$body['id_navire']   : null;
        $date_arrive = $body['date_arrive'] ?? null;
        $date_depart = $body['date_depart'] ?? null;

        if (!$id_navire || !$date_arrive || !$date_depart) {
            reponseErreur('Données manquantes (id_navire, date_arrive, date_depart requis)');
        }

        // Vérifier que le navire appartient à cet armateur
        $stmt = $pdo->prepare("SELECT id_navire, id_fret FROM navire WHERE id_navire = ? AND id = ?");
        $stmt->execute([$id_navire, $id_armateur]);
        $navire = $stmt->fetch();

        if (!$navire) {
            reponseErreur('Navire introuvable ou non autorisé', 403);
        }

        // Insérer la demande d'escale (statut en_attente par défaut)
        $stmt = $pdo->prepare(
            "INSERT INTO escale (date_arrive, date_depart, statut, id_fret, id_navire)
             VALUES (?, ?, 'en_attente', ?, ?)"
        );
        $stmt->execute([$date_arrive, $date_depart, $navire['id_fret'], $id_navire]);

        echo json_encode([
            'succes'     => true,
            'message'    => 'Demande d\'escale enregistrée',
            'id_escale'  => (int)$pdo->lastInsertId(),
        ]);
        break;

    default:
        reponseErreur('Endpoint non trouvé', 404);
}
