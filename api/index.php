<?php

// ─── Init ──────────────────────────────────────────────────────────────────
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';

// Clé secrète pour signer les tokens — change-la, ne la partage jamais
define('CLE_SECRETE', 'PPE3_LaRochelle_2026');

// ─── Helpers token ─────────────────────────────────────────────────────────

/**
 * Génère un token à partir de l'id armateur.
 * Format : base64( id_armateur:signature )
 * La signature est un hash de l'id + la clé secrète.
 */
function genererToken($id_armateur) {
    $signature = hash('sha256', $id_armateur . CLE_SECRETE);
    return base64_encode($id_armateur . ':' . $signature);
}

/**
 * Vérifie le token passé dans le header X-Token.
 * Retourne l'id_armateur si valide, null sinon.
 */
function verifierToken() {
    $token = $_SERVER['HTTP_X_TOKEN'] ?? '';
    if (empty($token)) return null;

    $decoded = base64_decode($token, true);
    if ($decoded === false) return null;

    $parts = explode(':', $decoded, 2);
    if (count($parts) !== 2) return null;

    [$id_armateur, $signature] = $parts;

    $signatureAttendue = hash('sha256', $id_armateur . CLE_SECRETE);
    if (!hash_equals($signatureAttendue, $signature)) return null;

    return (int) $id_armateur;
}

// ─── Helpers réponse ───────────────────────────────────────────────────────

function repondre($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ─── Routage ───────────────────────────────────────────────────────────────

$method = $_SERVER['REQUEST_METHOD'];
$route  = basename(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 1 — GET /connecteArmateur?id=LOGIN&mdp=MDP
// Authentifie via la table utilisateur, récupère l'armateur lié par le nom,
// retourne un token à stocker côté Android.
// ═══════════════════════════════════════════════════════════════════════════
if ($method === 'GET' && $route === 'connecteArmateur') {

    $login = $_GET['id']  ?? '';
    $mdp   = $_GET['mdp'] ?? '';

    if (empty($login) || empty($mdp)) {
        repondre(['succes' => false, 'message' => 'Paramètres id et mdp requis'], 400);
    }

    try {
        $pdo = getDB();

        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if (!$user || hash('sha256', $mdp) !== $user['mdp']) {
            repondre(['succes' => false, 'message' => 'Identifiants incorrects'], 401);
        }

        // Récupère l'armateur lié par le nom
        $stmt = $pdo->prepare("SELECT * FROM armateur WHERE nom = ?");
        $stmt->execute([$user['nom']]);
        $armateur = $stmt->fetch();

        if (!$armateur) {
            repondre(['succes' => false, 'message' => 'Aucun armateur lié à ce compte'], 403);
        }

        repondre([
            'succes'      => true,
            'message'     => 'Connexion réussie',
            'token'       => genererToken($armateur['id']),  // ← à stocker sur Android
            'id_armateur' => $armateur['id'],
            'nom'         => $armateur['nom'],
            'prenom'      => $armateur['prenom'],
        ]);

    } catch (Exception $e) {
        repondre(['succes' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 2 — GET /deconnecteArmateur
// Côté serveur il n'y a rien à détruire (pas de session).
// Android doit juste supprimer le token de ses SharedPreferences.
// ═══════════════════════════════════════════════════════════════════════════
elseif ($method === 'GET' && $route === 'deconnecteArmateur') {

    repondre(['succes' => true, 'message' => 'Déconnexion réussie — supprimez le token côté app']);
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 3 — POST /voirNaviresArmateur
// Header requis : X-Token: <token reçu à la connexion>
// Retourne les navires de l'armateur avec leur statut (En escale / Disponible)
// ═══════════════════════════════════════════════════════════════════════════
elseif ($method === 'POST' && $route === 'voirNaviresArmateur') {

    $id_armateur = verifierToken();
    if (!$id_armateur) {
        repondre(['succes' => false, 'message' => 'Token invalide ou manquant'], 401);
    }

    try {
        $pdo = getDB();

        $stmt = $pdo->prepare("
            SELECT
                n.id_navire,
                n.nom,
                n.longueur,
                n.largeur,
                n.tirant_eau,
                n.capacite,
                n.propulseur,
                n.remorqueur,
                n.autorise,
                f.type    AS fret_type,
                f.libelle AS fret_libelle,
                p.nom     AS port_nom,
                p.ville   AS port_ville,
                EXISTS (
                    SELECT 1 FROM escale e
                    WHERE e.id_navire = n.id_navire
                      AND e.date_arrive <= CURDATE()
                      AND e.date_depart >= CURDATE()
                ) AS en_escale
            FROM navire n
            JOIN fret f ON f.id_fret = n.id_fret
            JOIN port  p ON p.id_port = n.id_port
            WHERE n.id = ?
            ORDER BY n.nom
        ");
        $stmt->execute([$id_armateur]);
        $navires = $stmt->fetchAll();

        foreach ($navires as &$nav) {
            $nav['statut']    = $nav['en_escale'] ? 'En escale' : 'Disponible';
            $nav['en_escale'] = (bool) $nav['en_escale'];
        }
        unset($nav);

        repondre([
            'succes'  => true,
            'navires' => $navires,
            'total'   => count($navires),
        ]);

    } catch (Exception $e) {
        repondre(['succes' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 4 — POST /demandeEscale
// Header requis : X-Token: <token>
// Corps JSON    : { "id_navire": 1, "date_arrive": "2026-06-01", "date_depart": "2026-06-05" }
// ═══════════════════════════════════════════════════════════════════════════
elseif ($method === 'POST' && $route === 'demandeEscale') {

    $id_armateur = verifierToken();
    if (!$id_armateur) {
        repondre(['succes' => false, 'message' => 'Token invalide ou manquant'], 401);
    }

    $input       = json_decode(file_get_contents('php://input'), true);
    $id_navire   = $input['id_navire']   ?? null;
    $date_arrive = $input['date_arrive'] ?? null;
    $date_depart = $input['date_depart'] ?? null;

    if (!$id_navire || !$date_arrive || !$date_depart) {
        repondre(['succes' => false, 'message' => 'Paramètres requis : id_navire, date_arrive, date_depart'], 400);
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_arrive) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_depart)) {
        repondre(['succes' => false, 'message' => 'Format de date invalide (YYYY-MM-DD)'], 400);
    }

    if ($date_arrive >= $date_depart) {
        repondre(['succes' => false, 'message' => 'date_depart doit être après date_arrive'], 400);
    }

    try {
        $pdo = getDB();

        // Vérifie que le navire appartient à cet armateur
        $stmt = $pdo->prepare("SELECT id_navire, nom, id_fret FROM navire WHERE id_navire = ? AND id = ?");
        $stmt->execute([$id_navire, $id_armateur]);
        $navire = $stmt->fetch();

        if (!$navire) {
            repondre(['succes' => false, 'message' => 'Navire introuvable ou non autorisé'], 403);
        }

        // Vérifie qu'il n'y a pas de chevauchement d'escale
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM escale
            WHERE id_navire = ? AND date_arrive < ? AND date_depart > ?
        ");
        $stmt->execute([$id_navire, $date_depart, $date_arrive]);
        if ($stmt->fetchColumn() > 0) {
            repondre(['succes' => false, 'message' => 'Ce navire est déjà en escale sur cette période'], 409);
        }

        // Récupère un docker, deux pilotes, un poste d'accostage
        $docker  = $pdo->query("SELECT id_employee FROM docker LIMIT 1")->fetch();
        $pilotes = $pdo->query("SELECT id_employee FROM pilote LIMIT 2")->fetchAll();
        $poste   = $pdo->query("SELECT id_poste_accostage FROM poste_accostage LIMIT 1")->fetch();

        if (!$docker || count($pilotes) < 2 || !$poste) {
            repondre(['succes' => false, 'message' => 'Ressources insuffisantes en BDD (docker/pilotes/poste)'], 500);
        }

        $stmt = $pdo->prepare("
            INSERT INTO escale
                (date_arrive, date_depart, id_fret, id_employee, id_employee_1, id_employee_2, id_poste_accostage, id_navire)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $date_arrive,
            $date_depart,
            $navire['id_fret'],
            $docker['id_employee'],
            $pilotes[0]['id_employee'],
            $pilotes[1]['id_employee'],
            $poste['id_poste_accostage'],
            $id_navire,
        ]);

        repondre([
            'succes'      => true,
            'message'     => 'Demande d\'escale enregistrée, en attente de validation',
            'id_escale'   => (int) $pdo->lastInsertId(),
            'navire'      => $navire['nom'],
            'date_arrive' => $date_arrive,
            'date_depart' => $date_depart,
        ]);

    } catch (Exception $e) {
        repondre(['succes' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

// ─── Route inconnue ────────────────────────────────────────────────────────
else {
    repondre([
        'succes'  => false,
        'message' => 'Route inconnue',
        'routes'  => [
            'GET  connecteArmateur?id=LOGIN&mdp=MDP',
            'GET  deconnecteArmateur',
            'POST voirNaviresArmateur          header: X-Token',
            'POST demandeEscale                header: X-Token  body: {id_navire, date_arrive, date_depart}',
        ],
    ], 404);
}