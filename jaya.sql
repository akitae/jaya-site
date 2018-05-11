-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le :  jeu. 12 avr. 2018 à 21:19
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jaya`
--

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `matiere_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`id`, `matiere_id`, `nom`) VALUES
(1, 1, 'ANG_1'),
(2, 1, 'ANG_2'),
(3, 2, 'TO_1');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

CREATE TABLE `groupe_utilisateur` (
  `groupe_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `groupe_utilisateur`
--

INSERT INTO `groupe_utilisateur` (`groupe_id`, `utilisateur_id`) VALUES
(1, 2),
(1, 5),
(1, 6),
(2, 3),
(3, 2),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id` int(11) NOT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id`, `semestre_id`, `code`, `nom`, `place`) VALUES
(1, 1, 'ANG1', 'Anglais', 60),
(2, 1, 'TO1', 'Théories des organisations', 30),
(3, 1, 'ASI1', 'Système d\'information', 50),
(4, 2, 'ASI2', 'Système d\'information 2', 52),
(5, 2, 'PT', 'Projet Thématique', 80);

-- --------------------------------------------------------

--
-- Structure de la table `matiere_optionnelle`
--

CREATE TABLE `matiere_optionnelle` (
  `matiere_id` int(11) NOT NULL,
  `optionnelle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_pole_de_competence`
--

CREATE TABLE `matiere_pole_de_competence` (
  `matiere_id` int(11) NOT NULL,
  `pole_de_competence_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_professeur`
--

CREATE TABLE `matiere_professeur` (
  `id` int(11) NOT NULL,
  `nbHeuresTP` int(11) NOT NULL,
  `nbHeuresTD` int(11) NOT NULL,
  `nbHeureCours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_professeur_matiere`
--

CREATE TABLE `matiere_professeur_matiere` (
  `matiere_professeur_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_professeur_utilisateur`
--

CREATE TABLE `matiere_professeur_utilisateur` (
  `matiere_professeur_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180412170452'),
('20180412170701'),
('20180412174652');

-- --------------------------------------------------------

--
-- Structure de la table `optionnelle`
--

CREATE TABLE `optionnelle` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `optionnelle_matiere`
--

CREATE TABLE `optionnelle_matiere` (
  `optionnelle_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `annee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `parcours`
--

INSERT INTO `parcours` (`id`, `code`, `nom`, `annee`) VALUES
(1, '2COM_M2', '2COM', 2017),
(2, 'OSIE_M1', 'OSIE', 2017);

-- --------------------------------------------------------

--
-- Structure de la table `parcours_semestre`
--

CREATE TABLE `parcours_semestre` (
  `parcours_id` int(11) NOT NULL,
  `semestre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `parcours_semestre`
--

INSERT INTO `parcours_semestre` (`parcours_id`, `semestre_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `pole_de_competence`
--

CREATE TABLE `pole_de_competence` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pole_de_competence_matiere`
--

CREATE TABLE `pole_de_competence_matiere` (
  `pole_de_competence_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `dateDebutChoix` datetime NOT NULL,
  `dateFinChoix` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id`, `nom`, `dateDebut`, `dateFin`, `dateDebutChoix`, `dateFinChoix`) VALUES
(1, 'S1-M1', '2017-09-12 16:48:01', '2017-12-12 16:48:08', '2017-09-18 16:48:16', '2018-09-30 16:48:28'),
(2, 'S2-M1', '2017-12-12 16:48:08', '2018-06-12 16:49:03', '2017-12-13 16:48:08', '2017-12-20 16:48:08');

-- --------------------------------------------------------

--
-- Structure de la table `semestre_parcours`
--

CREATE TABLE `semestre_parcours` (
  `semestre_id` int(11) NOT NULL,
  `parcours_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `parcours_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motDePasse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroEtudiant` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valide` tinyint(1) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `parcours_id`, `nom`, `prenom`, `email`, `motDePasse`, `numeroEtudiant`, `valide`, `type`) VALUES
(1, 1, 'test@test.fr', 'test@test.fr', 'test@test.fr', 'test@test.fr', '2', 0, 0),
(2, 1, 'Das Neves', 'Clément', 'dasneves.clement@gmail.com', 'dasneves', '21300045', 1, 0),
(3, 1, 'Lephore', 'Florian', 'lephore@gmail.com', 'lephore', '21300047', 1, 0),
(4, 2, 'Zadick', 'Pierre', 'zadick.pierre@gmail.com', 'zadick', '21565557', 0, 0),
(5, 2, 'Dupont', 'Jean', 'dupont.jean@gmail.com', 'dupont', '21455545', 1, 0),
(6, NULL, 'Lapujade', 'Anne', 'lapujade@gmail.com', 'lapujade', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_groupe`
--

CREATE TABLE `utilisateur_groupe` (
  `utilisateur_id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateur_groupe`
--

INSERT INTO `utilisateur_groupe` (`utilisateur_id`, `groupe_id`) VALUES
(1, 1),
(3, 2),
(3, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B98C21F46CD258` (`matiere_id`);

--
-- Index pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  ADD PRIMARY KEY (`groupe_id`,`utilisateur_id`),
  ADD KEY `IDX_92C1107D7A45358C` (`groupe_id`),
  ADD KEY `IDX_92C1107DFB88E14F` (`utilisateur_id`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9014574A5577AFDB` (`semestre_id`);

--
-- Index pour la table `matiere_optionnelle`
--
ALTER TABLE `matiere_optionnelle`
  ADD PRIMARY KEY (`matiere_id`,`optionnelle_id`),
  ADD KEY `IDX_DD1226A4F46CD258` (`matiere_id`),
  ADD KEY `IDX_DD1226A4A37DB6D4` (`optionnelle_id`);

--
-- Index pour la table `matiere_pole_de_competence`
--
ALTER TABLE `matiere_pole_de_competence`
  ADD PRIMARY KEY (`matiere_id`,`pole_de_competence_id`),
  ADD KEY `IDX_5CAA9CFFF46CD258` (`matiere_id`),
  ADD KEY `IDX_5CAA9CFFC9E7CDE8` (`pole_de_competence_id`);

--
-- Index pour la table `matiere_professeur`
--
ALTER TABLE `matiere_professeur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matiere_professeur_matiere`
--
ALTER TABLE `matiere_professeur_matiere`
  ADD PRIMARY KEY (`matiere_professeur_id`,`matiere_id`),
  ADD KEY `IDX_C090D1EA249C5553` (`matiere_professeur_id`),
  ADD KEY `IDX_C090D1EAF46CD258` (`matiere_id`);

--
-- Index pour la table `matiere_professeur_utilisateur`
--
ALTER TABLE `matiere_professeur_utilisateur`
  ADD PRIMARY KEY (`matiere_professeur_id`,`utilisateur_id`),
  ADD KEY `IDX_814B113F249C5553` (`matiere_professeur_id`),
  ADD KEY `IDX_814B113FFB88E14F` (`utilisateur_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `optionnelle`
--
ALTER TABLE `optionnelle`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `optionnelle_matiere`
--
ALTER TABLE `optionnelle_matiere`
  ADD PRIMARY KEY (`optionnelle_id`,`matiere_id`),
  ADD KEY `IDX_DB7EE7A5A37DB6D4` (`optionnelle_id`),
  ADD KEY `IDX_DB7EE7A5F46CD258` (`matiere_id`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parcours_semestre`
--
ALTER TABLE `parcours_semestre`
  ADD PRIMARY KEY (`parcours_id`,`semestre_id`),
  ADD KEY `IDX_F3EF10436E38C0DB` (`parcours_id`),
  ADD KEY `IDX_F3EF10435577AFDB` (`semestre_id`);

--
-- Index pour la table `pole_de_competence`
--
ALTER TABLE `pole_de_competence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pole_de_competence_matiere`
--
ALTER TABLE `pole_de_competence_matiere`
  ADD PRIMARY KEY (`pole_de_competence_id`,`matiere_id`),
  ADD KEY `IDX_6C072BB4C9E7CDE8` (`pole_de_competence_id`),
  ADD KEY `IDX_6C072BB4F46CD258` (`matiere_id`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `semestre_parcours`
--
ALTER TABLE `semestre_parcours`
  ADD PRIMARY KEY (`semestre_id`,`parcours_id`),
  ADD KEY `IDX_EB1DE39A5577AFDB` (`semestre_id`),
  ADD KEY `IDX_EB1DE39A6E38C0DB` (`parcours_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B33A14BF69` (`numeroEtudiant`),
  ADD KEY `IDX_1D1C63B36E38C0DB` (`parcours_id`);

--
-- Index pour la table `utilisateur_groupe`
--
ALTER TABLE `utilisateur_groupe`
  ADD PRIMARY KEY (`utilisateur_id`,`groupe_id`),
  ADD KEY `IDX_6514B6AAFB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_6514B6AA7A45358C` (`groupe_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `matiere_professeur`
--
ALTER TABLE `matiere_professeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `optionnelle`
--
ALTER TABLE `optionnelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pole_de_competence`
--
ALTER TABLE `pole_de_competence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `FK_4B98C21F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`);

--
-- Contraintes pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  ADD CONSTRAINT `FK_92C1107D7A45358C` FOREIGN KEY (`groupe_id`) REFERENCES `groupe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_92C1107DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD CONSTRAINT `FK_9014574A5577AFDB` FOREIGN KEY (`semestre_id`) REFERENCES `semestre` (`id`);

--
-- Contraintes pour la table `matiere_optionnelle`
--
ALTER TABLE `matiere_optionnelle`
  ADD CONSTRAINT `FK_DD1226A4A37DB6D4` FOREIGN KEY (`optionnelle_id`) REFERENCES `optionnelle` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DD1226A4F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matiere_pole_de_competence`
--
ALTER TABLE `matiere_pole_de_competence`
  ADD CONSTRAINT `FK_5CAA9CFFC9E7CDE8` FOREIGN KEY (`pole_de_competence_id`) REFERENCES `pole_de_competence` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5CAA9CFFF46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matiere_professeur_matiere`
--
ALTER TABLE `matiere_professeur_matiere`
  ADD CONSTRAINT `FK_C090D1EA249C5553` FOREIGN KEY (`matiere_professeur_id`) REFERENCES `matiere_professeur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C090D1EAF46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matiere_professeur_utilisateur`
--
ALTER TABLE `matiere_professeur_utilisateur`
  ADD CONSTRAINT `FK_814B113F249C5553` FOREIGN KEY (`matiere_professeur_id`) REFERENCES `matiere_professeur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_814B113FFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `optionnelle_matiere`
--
ALTER TABLE `optionnelle_matiere`
  ADD CONSTRAINT `FK_DB7EE7A5A37DB6D4` FOREIGN KEY (`optionnelle_id`) REFERENCES `optionnelle` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DB7EE7A5F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `parcours_semestre`
--
ALTER TABLE `parcours_semestre`
  ADD CONSTRAINT `FK_F3EF10435577AFDB` FOREIGN KEY (`semestre_id`) REFERENCES `semestre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F3EF10436E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pole_de_competence_matiere`
--
ALTER TABLE `pole_de_competence_matiere`
  ADD CONSTRAINT `FK_6C072BB4C9E7CDE8` FOREIGN KEY (`pole_de_competence_id`) REFERENCES `pole_de_competence` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6C072BB4F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `semestre_parcours`
--
ALTER TABLE `semestre_parcours`
  ADD CONSTRAINT `FK_EB1DE39A5577AFDB` FOREIGN KEY (`semestre_id`) REFERENCES `semestre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EB1DE39A6E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B36E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`);

--
-- Contraintes pour la table `utilisateur_groupe`
--
ALTER TABLE `utilisateur_groupe`
  ADD CONSTRAINT `FK_6514B6AA7A45358C` FOREIGN KEY (`groupe_id`) REFERENCES `groupe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6514B6AAFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
