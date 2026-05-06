<?php

// =============================================================================
// API mobile - Port de La Rochelle (PPE3)
// Authentification par token, dédiée aux armateurs
// =============================================================================

error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/db.php';

define('CLE_SECRETE', 'PPE3_LaRochelle_2026');

// ─── Helpers token ─────────────────────────────────────────────────────────

function genererToken($id_armateur) {
    $signature = hash('sha256', $id_armateur . CLE_SECRETE);
    return base64_encode($id_armateur . ':' . $signature);
}

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
// Authentifie via utilisateur.id_armateur (FK), retourne un token
// ═══════════════════════════════════════════════════════════════════════════
if ($method === 'GET' && $route === 'connecteArmateur') {

    $login = $_GET['id']  ?? '';
    $mdp   = $_GET['mdp'] ?? '';

    if (empty($login) || empty($mdp)) {
        repondre(['succes' => false, 'message' => 'Paramètres id et mdp requis'], 400);
    }

    try {
        $pdo = getDB();

        // On récupère l'utilisateur ET son armateur en une seule requête (jointure)
        $stmt = $pdo->prepare("
            SELECT
                u.id_utilisateur,
                u.nom         AS user_nom,
                u.prenom      AS user_prenom,
                u.login,
                u.mdp,
                u.id_armateur,
                a.nom         AS armateur_nom,
                a.adresse     AS armateur_adresse,
                a.tel         AS armateur_tel,
                a.mail        AS armateur_mail
            FROM utilisateur u
            LEFT JOIN armateur a ON a.id = u.id_armateur
            WHERE u.login = ?
        ");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if (!$user || hash('sha256', $mdp) !== $user['mdp']) {
            repondre(['succes' => false, 'message' => 'Identifiants incorrects'], 401);
        }

        if (empty($user['id_armateur'])) {
            repondre(['succes' => false, 'message' => 'Ce compte n\'est pas un compte armateur'], 403);
        }

        repondre([
            'succes'           => true,
            'message'          => 'Connexion réussie',
            'token'            => genererToken($user['id_armateur']),
            'id_armateur'      => (int) $user['id_armateur'],
            'societe'          => $user['armateur_nom'],     // raison sociale
            'contact_nom'      => $user['user_nom'],         // humain
            'contact_prenom'   => $user['user_prenom'],
            'mail'             => $user['armateur_mail'],
        ]);

    } catch (Exception $e) {
        repondre(['succes' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 2 — GET /deconnecteArmateur
// ═══════════════════════════════════════════════════════════════════════════
elseif ($method === 'GET' && $route === 'deconnecteArmateur') {
    repondre(['succes' => true, 'message' => 'Déconnexion réussie — supprimez le token côté app']);
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 3 — POST /voirNaviresArmateur
// Header : X-Token
// Pour chaque navire, retourne :
//   - statut : "En escale", "Demande en attente", "Disponible"
//   - id_escale_active : si escale en cours ou en attente, son id
//   - infos d'escale (dates, statut) si applicable
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
                n.num_lloyds,
                n.nom,
                n.type_navire,
                n.pavillon,
                n.longueur,
                n.largeur,
                n.tirant_eau,
                n.capacite,
                n.propulseur,
                n.remorqueur,
                n.autorise,
                f.type      AS fret_type,
                f.libelle   AS fret_libelle,
                p.nom       AS port_nom,
                p.ville     AS port_ville,
                -- Escale active : en cours OU en attente OU validée future
                (
                    SELECT e.id_escale FROM escale e
                    WHERE e.id_navire = n.id_navire
                      AND e.statut IN ('en_attente','validee')
                      AND e.date_depart >= CURDATE()
                    ORDER BY e.date_arrive ASC
                    LIMIT 1
                ) AS id_escale_active,
                (
                    SELECT e.statut FROM escale e
                    WHERE e.id_navire = n.id_navire
                      AND e.statut IN ('en_attente','validee')
                      AND e.date_depart >= CURDATE()
                    ORDER BY e.date_arrive ASC
                    LIMIT 1
                ) AS statut_escale,
                (
                    SELECT e.date_arrive FROM escale e
                    WHERE e.id_navire = n.id_navire
                      AND e.statut IN ('en_attente','validee')
                      AND e.date_depart >= CURDATE()
                    ORDER BY e.date_arrive ASC
                    LIMIT 1
                ) AS escale_date_arrive,
                (
                    SELECT e.date_depart FROM escale e
                    WHERE e.id_navire = n.id_navire
                      AND e.statut IN ('en_attente','validee')
                      AND e.date_depart >= CURDATE()
                    ORDER BY e.date_arrive ASC
                    LIMIT 1
                ) AS escale_date_depart
            FROM navire n
            JOIN fret f ON f.id_fret = n.id_fret
            JOIN port  p ON p.id_port = n.id_port
            WHERE n.id = ?
            ORDER BY n.nom
        ");
        $stmt->execute([$id_armateur]);
        $navires = $stmt->fetchAll();

        // Calcul du libellé d'affichage pour le mobile
        $today = date('Y-m-d');
        foreach ($navires as &$nav) {
            $nav['en_escale']    = false;
            $nav['en_attente']   = false;

            if ($nav['id_escale_active']) {
                $nav['id_escale_active'] = (int) $nav['id_escale_active'];
                if ($nav['statut_escale'] === 'en_attente') {
                    $nav['statut']      = 'Demande en attente';
                    $nav['en_attente']  = true;
                } else { // validee
                    if ($nav['escale_date_arrive'] <= $today && $nav['escale_date_depart'] >= $today) {
                        $nav['statut']    = 'En escale';
                        $nav['en_escale'] = true;
                    } else {
                        $nav['statut']    = 'Escale prévue';
                        $nav['en_escale'] = true; // pour masquer le bouton "demander"
                    }
                }
            } else {
                $nav['statut']           = 'Disponible';
                $nav['id_escale_active'] = null;
            }
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
// Header : X-Token
// Body JSON : { id_navire, date_arrive, date_depart, provenance?, destination?, tonnage? }
// Crée une escale au statut 'en_attente' (sans pilote/docker/poste — la
// capitainerie validera et affectera ces ressources via l'app web)
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
    $provenance  = $input['provenance']  ?? null;
    $destination = $input['destination'] ?? null;
    $tonnage     = $input['tonnage']     ?? null;

    if (!$id_navire || !$date_arrive || !$date_depart) {
        repondre(['succes' => false, 'message' => 'Paramètres requis : id_navire, date_arrive, date_depart'], 400);
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_arrive) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_depart)) {
        repondre(['succes' => false, 'message' => 'Format de date invalide (YYYY-MM-DD)'], 400);
    }

    if ($date_arrive >= $date_depart) {
        repondre(['succes' => false, 'message' => 'La date de départ doit être après l\'arrivée'], 400);
    }

    if ($date_arrive < date('Y-m-d')) {
        repondre(['succes' => false, 'message' => 'La date d\'arrivée doit être dans le futur'], 400);
    }

    try {
        $pdo = getDB();

        // Vérifie que le navire appartient à cet armateur
        $stmt = $pdo->prepare("SELECT id_navire, nom, id_fret, autorise FROM navire WHERE id_navire = ? AND id = ?");
        $stmt->execute([$id_navire, $id_armateur]);
        $navire = $stmt->fetch();

        if (!$navire) {
            repondre(['succes' => false, 'message' => 'Navire introuvable ou non autorisé'], 403);
        }

        if (!$navire['autorise']) {
            repondre(['succes' => false, 'message' => 'Ce navire est interdit d\'accostage'], 403);
        }

        // Pas de chevauchement avec une escale existante (en_attente ou validee)
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM escale
            WHERE id_navire = ?
              AND statut IN ('en_attente','validee')
              AND date_arrive < ?
              AND date_depart > ?
        ");
        $stmt->execute([$id_navire, $date_depart, $date_arrive]);
        if ($stmt->fetchColumn() > 0) {
            repondre(['succes' => false, 'message' => 'Ce navire a déjà une escale prévue sur cette période'], 409);
        }

        // INSERT en 'en_attente' — pas de pilote/docker/poste, la capitainerie validera
        $stmt = $pdo->prepare("
            INSERT INTO escale
                (date_arrive, date_depart, provenance, destination, tonnage,
                 statut, id_fret, id_navire)
            VALUES (?, ?, ?, ?, ?, 'en_attente', ?, ?)
        ");
        $stmt->execute([
            $date_arrive,
            $date_depart,
            $provenance,
            $destination,
            $tonnage,
            $navire['id_fret'],
            $id_navire,
        ]);

        repondre([
            'succes'      => true,
            'message'     => 'Demande d\'escale enregistrée — en attente de validation par la Capitainerie',
            'id_escale'   => (int) $pdo->lastInsertId(),
            'navire'      => $navire['nom'],
            'date_arrive' => $date_arrive,
            'date_depart' => $date_depart,
            'statut'      => 'en_attente',
        ]);

    } catch (Exception $e) {
        repondre(['succes' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}

// ═══════════════════════════════════════════════════════════════════════════
// ROUTE 5 — POST /annulerDemandeEscale
// Header : X-Token
// Body JSON : { id_escale }
// Permet à l'armateur d'annuler sa propre demande tant qu'elle est en_attente
// ═══════════════════════════════════════════════════════════════════════════
elseif ($method === 'POST' && $route === 'annulerDemandeEscale') {

    $id_armateur = verifierToken();
    if (!$id_armateur) {
        repondre(['succes' => false, 'message' => 'Token invalide ou manquant'], 401);
    }

    $input     = json_decode(file_get_contents('php://input'), true);
    $id_escale = $input['id_escale'] ?? null;

    if (!$id_escale) {
        repondre(['succes' => false, 'message' => 'Paramètre requis : id_escale'], 400);
    }

    try {
        $pdo = getDB();

        // Vérifier que l'escale appartient à un navire de l'armateur ET est en_attente
        $stmt = $pdo->prepare("
            SELECT e.id_escale
            FROM escale e
            JOIN navire n ON n.id_navire = e.id_navire
            WHERE e.id_escale = ? AND n.id = ? AND e.statut = 'en_attente'
        ");
        $stmt->execute([$id_escale, $id_armateur]);
        if (!$stmt->fetch()) {
            repondre(['succes' => false, 'message' => 'Demande introuvable ou non annulable'], 403);
        }

        $stmt = $pdo->prepare("DELETE FROM escale WHERE id_escale = ?");
        $stmt->execute([$id_escale]);

        repondre(['succes' => true, 'message' => 'Demande annulée']);

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
            'POST voirNaviresArmateur     header: X-Token',
            'POST demandeEscale           header: X-Token  body: {id_navire, date_arrive, date_depart, provenance?, destination?, tonnage?}',
            'POST annulerDemandeEscale    header: X-Token  body: {id_escale}',
        ],
    ], 404);
}