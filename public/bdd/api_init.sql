-- Initialisation des données pour l'API Armateurs
-- Utilisateurs de test pour les armateurs

-- Mots de passe de test avec hashes SHA-256:
-- dubois1 / demo123
-- martin2 / 12345
-- bernard3 / password

INSERT IGNORE INTO utilisateur (id_utilisateur, nom, prenom, login, mdp, date_creation, id_role) VALUES
(1, 'Dubois', 'Pierre', 'dubois1', '3c59dc048e8850243be8079a5c74d079ca78ef701a521b08093c0725abccd5c1', CURDATE(), 1),
(2, 'Martin', 'Sophie', 'martin2', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacb11', CURDATE(), 1),
(3, 'Bernard', 'Jean', 'bernard3', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', CURDATE(), 1);

-- Ajouter une colonne 'statut' à la table escale s'il n'existe pas
ALTER TABLE escale ADD COLUMN IF NOT EXISTS statut VARCHAR(50) DEFAULT 'validee';
