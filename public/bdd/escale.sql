-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 07 avr. 2026 à 12:52
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
-- Structure de la table `armateur`
--

CREATE TABLE `armateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `armateur`
--

INSERT INTO `armateur` (`id`, `nom`, `prenom`, `adresse`) VALUES
(1, 'Dubois', 'Pierre', '12 Rue du Port, Marseille'),
(2, 'Martin', 'Sophie', '45 Avenue Maritime, Le Havre'),
(3, 'Bernard', 'Jean', '8 Quai des Armateurs, Dunkerque');

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
(1),
(2),
(3);

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
(1, 'Moreau', 'Thomas', '0612345678', 'docker'),
(2, 'Petit', 'Marie', '0623456789', 'pilote'),
(3, 'Durand', 'Luc', '0634567890', 'docker'),
(4, 'Leroy', 'Paul', '064567890', 'docker'),
(5, 'Simoa', 'Juli', '000000000', 'docker');

-- --------------------------------------------------------

--
-- Structure de la table `escale`
--

CREATE TABLE `escale` (
  `id_escale` int(11) NOT NULL,
  `date_arrive` date DEFAULT NULL,
  `date_depart` date DEFAULT NULL,
  `id_fret` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_employee_1` int(11) NOT NULL,
  `id_employee_2` int(11) NOT NULL,
  `id_poste_accostage` int(11) NOT NULL,
  `id_navire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `escale`
--

INSERT INTO `escale` (`id_escale`, `date_arrive`, `date_depart`, `id_fret`, `id_employee`, `id_employee_1`, `id_employee_2`, `id_poste_accostage`, `id_navire`) VALUES
(1, '2025-10-01', '2025-10-03', 1, 1, 4, 5, 1, 1),
(2, '2025-10-02', '2025-10-04', 2, 2, 4, 4, 3, 2),
(3, '2025-11-05', '2025-11-06', 2, 2, 4, 5, 2, 3),
(4, '2025-10-30', '2025-10-31', 3, 2, 4, 4, 2, 2),
(6, '2025-10-29', '2025-11-15', 4, 2, 5, 5, 2, 4),
(7, '2025-11-13', '2025-11-16', 2, 3, 4, 4, 1, 2),
(8, '2025-10-31', '2025-10-31', 2, 2, 4, 5, 1, 4);

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
(1, 'Conteneurs', 'Marchandises diverses', 0),
(2, 'Liquide', 'Pétrole brut', 1),
(3, 'Vrac', 'Céréales', 0),
(4, 'Dangereux', 'Produits chimiques', 1);

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
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 2),
(3, 4),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `navire`
--

CREATE TABLE `navire` (
  `id_navire` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `autorise` tinyint(1) DEFAULT NULL,
  `longueur` decimal(15,1) DEFAULT NULL,
  `largeur` decimal(15,1) DEFAULT NULL,
  `tirant_eau` decimal(15,1) DEFAULT NULL,
  `capacite` decimal(15,1) DEFAULT NULL,
  `propulseur` tinyint(1) DEFAULT NULL,
  `remorqueur` tinyint(1) DEFAULT NULL,
  `id_fret` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `id_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `navire`
--

INSERT INTO `navire` (`id_navire`, `nom`, `autorise`, `longueur`, `largeur`, `tirant_eau`, `capacite`, `propulseur`, `remorqueur`, `id_fret`, `id`, `id_port`) VALUES
(1, 'Sea Explorer', 1, 250.0, 32.0, 12.5, 50000.0, 1, 0, 1, 1, 1),
(2, 'Oil Tanker One', 1, 300.0, 50.0, 15.0, 150000.0, 1, 1, 2, 2, 2),
(3, 'Grain Carrier', 1, 200.0, 30.0, 10.0, 35000.0, 1, 0, 3, 3, 3),
(4, 'Chemical Express', 1, 180.0, 28.0, 9.5, 25000.0, 1, 1, 4, 1, 1);

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
(1, 'Port de Marseille', 'Marseille', 'France'),
(2, 'Port du Havre', 'Le Havre', 'France'),
(3, 'Port de Dunkerque', 'Dunkerque', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `poste_accostage`
--

CREATE TABLE `poste_accostage` (
  `id_poste_accostage` int(11) NOT NULL,
  `id_quai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `poste_accostage`
--

INSERT INTO `poste_accostage` (`id_poste_accostage`, `id_quai`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `quai`
--

CREATE TABLE `quai` (
  `id_quai` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `tirant_eau_max` decimal(15,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quai`
--

INSERT INTO `quai` (`id_quai`, `nom`, `tirant_eau_max`) VALUES
(1, 'Quai Nord', 15.5),
(2, 'Quai Sud', 12.0),
(3, 'Quai Ouest', 18.0),
(4, 'Quai Est', 10.5);

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
(1, 'admin');

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
  `date_creation` date DEFAULT curdate(),
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

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
  ADD KEY `id_navire` (`id_navire`);

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
  ADD UNIQUE KEY `email` (`login`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `employee`
--
ALTER TABLE `employee`
  MODIFY `id_employee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `escale`
--
ALTER TABLE `escale`
  MODIFY `id_escale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `escale_ibfk_6` FOREIGN KEY (`id_navire`) REFERENCES `navire` (`id_navire`);

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
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
