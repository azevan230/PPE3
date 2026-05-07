-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 mai 2026 à 10:47
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `escale`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `id_agent` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`id_agent`, `nom`, `adresse`, `tel`, `mail`) VALUES
(1, 'SOGENA', '12 Rue du Commerce, La Rochelle', '0546123456', 'contact@sogena.fr'),
(2, 'AgriMer', '5 Boulevard Maritime, Rochefort', '0546234567', 'contact@agrimer.fr'),
(3, 'TransOcean', '8 Avenue du Port, La Rochelle', '0546345678', 'contact@transocean.fr'),
(4, 'Atlantic Shipping', '24 Quai Valin, La Rochelle', '0546456789', 'contact@atlantic-shipping.fr'),
(5, 'Maritima Conseil', '17 Rue de l\'Escale, La Pallice', '0546567890', 'contact@maritima.fr');

-- --------------------------------------------------------

--
-- Structure de la table `armateur`
--

CREATE TABLE `armateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(150) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `mail` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `armateur`
--

INSERT INTO `armateur` (`id`, `nom`, `adresse`, `tel`, `mail`) VALUES
(1, 'FluideNavy', '15 Quai des Tankers, Le Havre', '0235112233', 'contact@fluidenavy.fr'),
(2, 'White Sea & Onega Shipping', '12 Lenina St, Saint-Pétersbourg', '+78124567890', 'contact@wsos.ru'),
(3, 'Winne & Barends B.V.', 'Havenstraat 8, Delfzijl', '+31596123456', 'info@winne-barends.nl'),
(4, 'Briese Schiffahrts GmbH & Co. KG', 'Hafenweg 22, Leer', '+49491987654', 'kontakt@briese.de'),
(5, 'Western Shipping CO', '4 Lloyd\'s Avenue, Londres', '+442074561234', 'ops@western-shipping.uk'),
(6, 'Ukrrichflot', '8 Naberezhnaya, Kiev', '+380442345678', 'info@ukrrichflot.ua'),
(7, 'Polito Shipping Co Ltd', 'Nicosia Tower, Limassol', '+35725123456', 'contact@polito.cy'),
(8, 'Alina Shipping Co. Ltd.', '11 Marine Drive, Pirée', '+302104567890', 'info@alina.gr'),
(9, 'Poseidon Chartering B.V.', 'Scheepswerf 5, Rotterdam', '+31102345678', 'charter@poseidon.nl'),
(10, 'V.o.F. F.a. Aldebaran', 'Kade 17, Groningue', '+31503456789', 'info@aldebaran-vof.nl'),
(11, 'St Thomas Shipping', 'Harbour Road, Saint-Pierre', '+18095551234', 'info@stthomas-ship.com'),
(12, 'Klaus Braack GmbH et Cie', 'Reederstrasse 9, Hambourg', '+4940998877', 'kontakt@braack.de');

-- --------------------------------------------------------

--
-- Structure de la table `docker`
--

CREATE TABLE `docker` (
  `id_employee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `docker`
--

INSERT INTO `docker` (`id_employee`) VALUES
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13);

-- --------------------------------------------------------

--
-- Structure de la table `employee`
--

CREATE TABLE `employee` (
  `id_employee` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employee`
--

INSERT INTO `employee` (`id_employee`, `nom`, `prenom`, `num_tel`, `role`) VALUES
(1, 'Roquerel', 'Marc', '0612000001', 'pilote'),
(2, 'Lefèvre', 'Antoine', '0612000002', 'pilote'),
(3, 'Dupuis', 'Sébastien', '0612000003', 'pilote'),
(4, 'Marchand', 'Hugo', '0612000004', 'pilote'),
(5, 'Caron', 'Julien', '0612000005', 'pilote'),
(6, 'Moreau', 'Thomas', '0612000006', 'docker'),
(7, 'Petit', 'Marie', '0612000007', 'docker'),
(8, 'Durand', 'Luc', '0612000008', 'docker'),
(9, 'Leroy', 'Paul', '0612000009', 'docker'),
(10, 'Garnier', 'Sophie', '0612000010', 'docker'),
(11, 'Robert', 'Emma', '0612000011', 'docker'),
(12, 'Renaud', 'Mathieu', '0612000012', 'docker'),
(13, 'Vincent', 'Claire', '0612000013', 'docker');

-- --------------------------------------------------------

--
-- Structure de la table `escale`
--

CREATE TABLE `escale` (
  `id_escale` int(11) NOT NULL,
  `date_arrive` date DEFAULT NULL,
  `date_depart` date DEFAULT NULL,
  `provenance` varchar(50) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `tonnage` decimal(15,2) DEFAULT NULL,
  `import_export` enum('import','export') DEFAULT NULL,
  `matieres_dangereuses` tinyint(1) DEFAULT 0,
  `statut` enum('en_attente','validee','refusee','terminee') DEFAULT 'en_attente',
  `id_fret` int(11) NOT NULL,
  `id_employee` int(11) DEFAULT NULL COMMENT 'docker (NULL si en_attente)',
  `id_employee_1` int(11) DEFAULT NULL COMMENT 'pilote entrée (NULL si en_attente)',
  `id_employee_2` int(11) DEFAULT NULL COMMENT 'pilote sortie',
  `id_poste_accostage` int(11) DEFAULT NULL COMMENT 'NULL si en_attente',
  `id_navire` int(11) NOT NULL,
  `id_agent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `escale`
--

INSERT INTO `escale` (`id_escale`, `date_arrive`, `date_depart`, `provenance`, `destination`, `tonnage`, `import_export`, `matieres_dangereuses`, `statut`, `id_fret`, `id_employee`, `id_employee_1`, `id_employee_2`, `id_poste_accostage`, `id_navire`, `id_agent`) VALUES
(1, '2026-04-12', '2026-04-16', 'AMSTERDAM', 'TUNIS', 3200.00, 'export', 0, 'terminee', 7, 6, 1, 2, 13, 12, 1),
(2, '2026-04-15', '2026-04-22', 'ROTTERDAM', 'BARCELONE', 5800.00, 'import', 0, 'terminee', 8, 7, 2, 3, 14, 1, 2),
(3, '2026-04-18', '2026-04-21', 'GDANSK', 'HAMBOURG', 1850.00, 'import', 0, 'terminee', 4, 8, 3, 1, 8, 2, 3),
(4, '2026-04-20', '2026-04-23', 'ANVERS', 'LISBONNE', 2700.00, 'export', 0, 'terminee', 8, 9, 4, 5, 12, 3, 4),
(5, '2026-04-22', '2026-04-25', 'BREMERHAVEN', 'VALENCE', 2900.00, 'import', 0, 'terminee', 8, 10, 5, 1, 13, 4, 5),
(6, '2026-04-25', '2026-04-29', 'LIVERPOOL', 'GENES', 3100.00, 'export', 0, 'terminee', 9, 11, 1, 2, 14, 5, 1),
(7, '2026-05-02', '2026-05-08', 'STAVANGER', 'CASABLANCA', 2200.00, 'export', 0, 'validee', 6, 12, 2, 3, 11, 6, 2),
(8, '2026-05-04', '2026-05-09', 'ODESSA', 'ALGER', 2800.00, 'import', 0, 'validee', 7, 13, 3, 4, 12, 7, 3),
(9, '2026-05-03', '2026-05-07', 'BILBAO', 'ROUEN', 3300.00, 'import', 0, 'validee', 4, 6, 4, 5, 8, 8, 4),
(10, '2026-05-15', '2026-05-20', 'TANGER', 'MARSEILLE', 5200.00, 'import', 0, 'validee', 8, 7, 5, 1, 14, 9, 5),
(11, '2026-05-18', '2026-05-21', 'ROTTERDAM', 'CASABLANCA', 2400.00, 'import', 0, 'validee', 2, 8, 1, 2, 4, 10, 1),
(12, '2026-05-22', '2026-05-25', 'BREME', 'DUBLIN', 1900.00, 'export', 0, 'en_attente', 3, NULL, NULL, NULL, NULL, 11, NULL),
(13, '2026-05-25', '2026-05-29', 'STAVANGER', 'TUNIS', 4100.00, 'export', 0, 'en_attente', 7, NULL, NULL, NULL, NULL, 12, NULL),
(14, '2026-06-01', '2026-06-05', 'HAMBOURG', 'LISBONNE', 3500.00, 'export', 0, 'en_attente', 5, NULL, NULL, NULL, NULL, 13, NULL),
(15, '2026-11-30', '2027-10-31', NULL, NULL, NULL, NULL, 0, 'en_attente', 12, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fret`
--

CREATE TABLE `fret` (
  `id_fret` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `danger` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fret`
--

INSERT INTO `fret` (`id_fret`, `type`, `libelle`, `danger`) VALUES
(1, 'Houille', 'Charbon en vrac', 0),
(2, 'Agro-alimentaire', 'Produits agro-alimentaires', 0),
(3, 'Engrais', 'Engrais agricoles', 0),
(4, 'Vrac', 'Vrac sec', 0),
(5, 'Bois', 'Grumes et planches', 0),
(6, 'Colis lourds', 'Pièces industrielles', 0),
(7, 'Céréales', 'Blé, maïs, orge', 0),
(8, 'Conteneurs', 'Marchandises diverses', 0),
(9, 'Ferraille', 'Métaux à recycler', 0),
(10, 'Big Bags', 'Sacs industriels', 0),
(11, 'Carburant', 'Hydrocarbures raffinés', 1),
(12, 'Pétrole brut', 'Hydrocarbures bruts', 1),
(13, 'Produits chimiques', 'Substances dangereuses', 1);

-- --------------------------------------------------------

--
-- Structure de la table `fret_quai`
--

CREATE TABLE `fret_quai` (
  `id_fret` int(11) NOT NULL,
  `id_quai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fret_quai`
--

INSERT INTO `fret_quai` (`id_fret`, `id_quai`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 3),
(4, 6),
(5, 4),
(6, 4),
(7, 5),
(8, 5),
(9, 5),
(10, 6),
(11, 7),
(12, 7),
(13, 7);

-- --------------------------------------------------------

--
-- Structure de la table `navire`
--

CREATE TABLE `navire` (
  `id_navire` int(11) NOT NULL,
  `num_lloyds` varchar(15) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `type_navire` varchar(50) DEFAULT NULL,
  `pavillon` varchar(50) DEFAULT NULL,
  `port_attache_nom` varchar(50) DEFAULT NULL,
  `autorise` tinyint(1) DEFAULT 1,
  `longueur` decimal(15,2) DEFAULT NULL,
  `largeur` decimal(15,2) DEFAULT NULL,
  `tirant_eau` decimal(15,2) DEFAULT NULL,
  `capacite` decimal(15,2) DEFAULT NULL,
  `propulseur` tinyint(1) DEFAULT NULL,
  `remorqueur` tinyint(1) DEFAULT NULL,
  `id_fret` int(11) NOT NULL,
  `id` int(11) NOT NULL COMMENT 'FK vers armateur.id',
  `id_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `navire`
--

INSERT INTO `navire` (`id_navire`, `num_lloyds`, `nom`, `type_navire`, `pavillon`, `port_attache_nom`, `autorise`, `longueur`, `largeur`, `tirant_eau`, `capacite`, `propulseur`, `remorqueur`, `id_fret`, `id`, `id_port`) VALUES
(1, '7088624', 'ALBATROS', 'Pétrolier', 'France', 'Le Havre', 1, 114.18, 18.10, 6.10, 6210.00, 1, 0, 12, 1, 1),
(2, '9113599', 'TULOS', 'Vraquier', 'Russie', 'Saint-Pétersbourg', 1, 81.44, 11.46, 4.22, 2300.00, 1, 0, 4, 2, 2),
(3, '9115975', 'MATHILDE', 'Cargo polyvalent', 'Pays-Bas', 'Delfzijl', 1, 88.00, 12.58, 5.31, 3332.00, 1, 0, 8, 3, 3),
(4, '9116785', 'DOLLART', 'Cargo polyvalent', 'Allemagne', 'Leer', 1, 88.00, 12.80, 5.52, 3500.00, 1, 0, 8, 4, 4),
(5, '9133367', 'NEMAN', 'Cargo polyvalent', 'Royaume-Uni', 'Londres', 1, 96.30, 13.60, 5.16, 3837.00, 1, 0, 9, 5, 5),
(6, '9136125', 'SWALLOW', 'Cargo polyvalent', 'Pays-Bas', 'Delfzijl', 1, 90.46, 13.20, 5.75, 4251.00, 1, 0, 6, 3, 3),
(7, '9137234', 'KAPITAN SHYRIAGIN', 'Vraquier', 'Ukraine', 'Kiev', 1, 98.00, 16.00, 4.00, 3580.00, 1, 0, 7, 6, 6),
(8, '9139323', 'ADDI L', 'Vraquier', 'Chypre', 'Limassol', 1, 88.20, 13.60, 6.11, 4557.00, 0, 1, 4, 7, 7),
(9, '9147875', 'ALINA', 'Pétrolier', 'Grèce', 'Pirée', 1, 107.57, 18.20, 6.15, 6790.00, 1, 0, 11, 8, 8),
(10, '9148104', 'DANIEL', 'Cargo polyvalent', 'Pays-Bas', 'Rotterdam', 1, 91.15, 11.90, 5.14, 3420.00, 1, 0, 2, 9, 9),
(11, '9155688', 'ALDEBARAN', 'Cargo polyvalent', 'Pays-Bas', 'Groningue', 1, 82.45, 11.40, 4.01, 2270.00, 1, 0, 3, 10, 10),
(12, '7024421', 'NORSTONE', 'Pétrolier', 'France', 'Saint-Pierre', 1, 88.20, 13.66, 6.12, 5735.00, 0, 1, 7, 11, 12),
(13, '9169732', 'CLAUDIA ISABELL', 'Cargo polyvalent', 'Allemagne', 'Hambourg', 1, 108.95, 15.85, 6.85, 4490.00, 1, 0, 5, 12, 11);

-- --------------------------------------------------------

--
-- Structure de la table `pilote`
--

CREATE TABLE `pilote` (
  `id_employee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pilote`
--

INSERT INTO `pilote` (`id_employee`) VALUES
(1),
(2),
(3),
(4),
(5);

-- --------------------------------------------------------

--
-- Structure de la table `port`
--

CREATE TABLE `port` (
  `id_port` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `port`
--

INSERT INTO `port` (`id_port`, `nom`, `ville`, `pays`) VALUES
(1, 'Port du Havre', 'Le Havre', 'France'),
(2, 'Port de Saint-Pétersbourg', 'Saint-Pétersbourg', 'Russie'),
(3, 'Port de Delfzijl', 'Delfzijl', 'Pays-Bas'),
(4, 'Port de Leer', 'Leer', 'Allemagne'),
(5, 'Port de Londres', 'Londres', 'Royaume-Uni'),
(6, 'Port de Kiev', 'Kiev', 'Ukraine'),
(7, 'Port de Limassol', 'Limassol', 'Chypre'),
(8, 'Port du Pirée', 'Pirée', 'Grèce'),
(9, 'Port de Rotterdam', 'Rotterdam', 'Pays-Bas'),
(10, 'Port de Groningue', 'Groningue', 'Pays-Bas'),
(11, 'Port de Hambourg', 'Hambourg', 'Allemagne'),
(12, 'Port de Saint-Pierre', 'Saint-Pierre', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `poste_accostage`
--

CREATE TABLE `poste_accostage` (
  `id_poste_accostage` int(11) NOT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `longueur` decimal(15,1) DEFAULT NULL,
  `id_quai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `poste_accostage`
--

INSERT INTO `poste_accostage` (`id_poste_accostage`, `numero`, `longueur`, `id_quai`) VALUES
(1, 'B1', 175.0, 1),
(2, 'B2', 200.0, 1),
(3, 'D1', 140.0, 2),
(4, 'D2', 180.0, 2),
(5, 'D3', 210.0, 2),
(6, 'E1', 104.0, 3),
(7, 'E2', 90.0, 3),
(8, 'E4', 180.0, 3),
(9, 'F1', 170.0, 4),
(10, 'F2', 120.0, 4),
(11, 'F3', 190.0, 4),
(12, 'G1', 205.0, 5),
(13, 'G2', 190.0, 5),
(14, 'G3', 260.0, 5),
(15, 'K1', 125.0, 6),
(16, 'K2', 205.0, 6),
(17, 'S1', 120.0, 7);

-- --------------------------------------------------------

--
-- Structure de la table `quai`
--

CREATE TABLE `quai` (
  `id_quai` int(11) NOT NULL,
  `reference` varchar(5) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `tirant_eau_max` decimal(15,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quai`
--

INSERT INTO `quai` (`id_quai`, `reference`, `nom`, `tirant_eau_max`) VALUES
(1, 'B', 'Quai de Normandie', 6.0),
(2, 'D', 'Bassin de Calix', 8.6),
(3, 'E', 'Bassin Hérouville', 9.0),
(4, 'F', 'Quai Pt Delaunay', 9.0),
(5, 'G', 'Quai de Blainville', 9.0),
(6, 'K', 'Quai de Ranville', 6.3),
(7, 'S', 'Sonnec', 6.0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom_role`) VALUES
(1, 'admin'),
(2, 'commandant'),
(3, 'capitainerie'),
(4, 'armateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mail` varchar(80) DEFAULT NULL,
  `date_creation` timestamp DEFAULT current_timestamp,
  `id_role` int(11) NOT NULL,
  `id_armateur` int(11) DEFAULT NULL COMMENT 'NULL pour personnel capitainerie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `login`, `mdp`, `mail`, `date_creation`, `id_role`, `id_armateur`) VALUES
(1, 'Admin', 'Admin', 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'admin@portlarochelle.fr', '2026-04-01', 1, NULL),
(2, 'Roussel', 'François', 'froussel', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'f.roussel@portlarochelle.fr', '2026-04-05', 2, NULL),
(3, 'Lambert', 'Catherine', 'clambert', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'c.lambert@portlarochelle.fr', '2026-04-05', 3, NULL),
(4, 'Mercier', 'Pierre', 'pmercier', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'p.mercier@portlarochelle.fr', '2026-04-08', 3, NULL),
(10, 'Lefebvre', 'Jean', 'fluidenavy', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'j.lefebvre@fluidenavy.fr', '2026-04-10', 4, 1),
(11, 'Volkov', 'Dmitri', 'wsos', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'd.volkov@wsos.ru', '2026-04-10', 4, 2),
(12, 'De Vries', 'Hans', 'winne', '8c6976e5b5410415bde908bd4dee15dfb16a9c2418da12baee79dfc7b7c8b37e', 'h.devries@winne-barends.nl', '2026-04-10', 4, 3),
(13, 'Werner', 'Klaus', 'briese', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'k.werner@briese.de', '2026-04-10', 4, 4),
(14, 'Smith', 'John', 'western', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'j.smith@western-shipping.uk', '2026-04-10', 4, 5),
(15, 'Kovalenko', 'Andriy', 'ukrrichflot', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'a.kovalenko@ukrrichflot.ua', '2026-04-10', 4, 6),
(16, 'Christou', 'Nikos', 'polito', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'n.christou@polito.cy', '2026-04-10', 4, 7),
(17, 'Papadakis', 'Georgios', 'alina', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'g.papadakis@alina.gr', '2026-04-10', 4, 8),
(18, 'Van Berg', 'Pieter', 'poseidon', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'p.vanberg@poseidon.nl', '2026-04-10', 4, 9),
(19, 'Jansen', 'Marieke', 'aldebaran', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'm.jansen@aldebaran-vof.nl', '2026-04-10', 4, 10),
(20, 'Williams', 'David', 'stthomas', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'd.williams@stthomas-ship.com', '2026-04-10', 4, 11),
(21, 'Braack', 'Klaus', 'braack', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'k.braack@braack.de', '2026-04-10', 4, 12);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id_agent`);

--
-- Index pour la table `armateur`
--
ALTER TABLE `armateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `docker`
--
ALTER TABLE `docker`
  ADD PRIMARY KEY (`id_employee`);

--
-- Index pour la table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id_employee`);

--
-- Index pour la table `escale`
--
ALTER TABLE `escale`
  ADD PRIMARY KEY (`id_escale`),
  ADD KEY `id_fret` (`id_fret`),
  ADD KEY `id_employee` (`id_employee`),
  ADD KEY `id_employee_1` (`id_employee_1`),
  ADD KEY `id_employee_2` (`id_employee_2`),
  ADD KEY `id_poste_accostage` (`id_poste_accostage`),
  ADD KEY `id_navire` (`id_navire`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Index pour la table `fret`
--
ALTER TABLE `fret`
  ADD PRIMARY KEY (`id_fret`);

--
-- Index pour la table `fret_quai`
--
ALTER TABLE `fret_quai`
  ADD PRIMARY KEY (`id_fret`,`id_quai`),
  ADD KEY `id_quai` (`id_quai`);

--
-- Index pour la table `navire`
--
ALTER TABLE `navire`
  ADD PRIMARY KEY (`id_navire`),
  ADD KEY `id_fret` (`id_fret`),
  ADD KEY `id` (`id`),
  ADD KEY `id_port` (`id_port`);

--
-- Index pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD PRIMARY KEY (`id_employee`);

--
-- Index pour la table `port`
--
ALTER TABLE `port`
  ADD PRIMARY KEY (`id_port`);

--
-- Index pour la table `poste_accostage`
--
ALTER TABLE `poste_accostage`
  ADD PRIMARY KEY (`id_poste_accostage`),
  ADD KEY `id_quai` (`id_quai`);

--
-- Index pour la table `quai`
--
ALTER TABLE `quai`
  ADD PRIMARY KEY (`id_quai`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_armateur` (`id_armateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `id_agent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `armateur`
--
ALTER TABLE `armateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `escale`
--
ALTER TABLE `escale`
  MODIFY `id_escale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `fret`
--
ALTER TABLE `fret`
  MODIFY `id_fret` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `navire`
--
ALTER TABLE `navire`
  MODIFY `id_navire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `port`
--
ALTER TABLE `port`
  MODIFY `id_port` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `poste_accostage`
--
ALTER TABLE `poste_accostage`
  MODIFY `id_poste_accostage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `quai`
--
ALTER TABLE `quai`
  MODIFY `id_quai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `docker`
--
ALTER TABLE `docker`
  ADD CONSTRAINT `docker_ibfk_1` FOREIGN KEY (`id_employee`) REFERENCES `employee` (`id_employee`);

--
-- Contraintes pour la table `escale`
--
ALTER TABLE `escale`
  ADD CONSTRAINT `escale_ibfk_1` FOREIGN KEY (`id_fret`) REFERENCES `fret` (`id_fret`),
  ADD CONSTRAINT `escale_ibfk_2` FOREIGN KEY (`id_employee`) REFERENCES `docker` (`id_employee`),
  ADD CONSTRAINT `escale_ibfk_3` FOREIGN KEY (`id_employee_1`) REFERENCES `pilote` (`id_employee`),
  ADD CONSTRAINT `escale_ibfk_4` FOREIGN KEY (`id_employee_2`) REFERENCES `pilote` (`id_employee`),
  ADD CONSTRAINT `escale_ibfk_5` FOREIGN KEY (`id_poste_accostage`) REFERENCES `poste_accostage` (`id_poste_accostage`),
  ADD CONSTRAINT `escale_ibfk_6` FOREIGN KEY (`id_navire`) REFERENCES `navire` (`id_navire`),
  ADD CONSTRAINT `escale_ibfk_7` FOREIGN KEY (`id_agent`) REFERENCES `agent` (`id_agent`);

--
-- Contraintes pour la table `fret_quai`
--
ALTER TABLE `fret_quai`
  ADD CONSTRAINT `fret_quai_ibfk_1` FOREIGN KEY (`id_fret`) REFERENCES `fret` (`id_fret`),
  ADD CONSTRAINT `fret_quai_ibfk_2` FOREIGN KEY (`id_quai`) REFERENCES `quai` (`id_quai`);

--
-- Contraintes pour la table `navire`
--
ALTER TABLE `navire`
  ADD CONSTRAINT `navire_ibfk_1` FOREIGN KEY (`id_fret`) REFERENCES `fret` (`id_fret`),
  ADD CONSTRAINT `navire_ibfk_2` FOREIGN KEY (`id`) REFERENCES `armateur` (`id`),
  ADD CONSTRAINT `navire_ibfk_3` FOREIGN KEY (`id_port`) REFERENCES `port` (`id_port`);

--
-- Contraintes pour la table `pilote`
--
ALTER TABLE `pilote`
  ADD CONSTRAINT `pilote_ibfk_1` FOREIGN KEY (`id_employee`) REFERENCES `employee` (`id_employee`);

--
-- Contraintes pour la table `poste_accostage`
--
ALTER TABLE `poste_accostage`
  ADD CONSTRAINT `poste_accostage_ibfk_1` FOREIGN KEY (`id_quai`) REFERENCES `quai` (`id_quai`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_armateur`) REFERENCES `armateur` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;