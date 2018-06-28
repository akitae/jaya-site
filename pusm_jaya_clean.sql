-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  h2mysql27
-- Généré le :  Mer 23 Mai 2018 à 14:52
-- Version du serveur :  5.7.20-log
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pusm_jaya`
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

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

CREATE TABLE `groupe_utilisateur` (
  `groupe_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id` int(11) NOT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place` int(11) NOT NULL,
  `pole_de_competence_id` int(11) DEFAULT NULL,
  `place_stagiare` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_optionelle`
--

CREATE TABLE `matiere_optionelle` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `matiere_id` int(11) DEFAULT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matiere_parcours`
--

CREATE TABLE `matiere_parcours` (
  `id` int(11) NOT NULL,
  `matieres_id` int(11) DEFAULT NULL,
  `parcours_id` int(11) DEFAULT NULL,
  `optionnel` tinyint(1) NOT NULL
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
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180412170701'),
('20180412174652'),
('20180417172336'),
('20180504141853'),
('20180506213530'),
('20180506214234'),
('20180508203022'),
('20180509071006'),
('20180509135456'),
('20180509152657'),
('20180511110057'),
('20180511184020'),
('20180512002715');

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `annee` int(11) NOT NULL,
  `stagiare` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Structure de la table `pole_de_competence_parcours`
--

CREATE TABLE `pole_de_competence_parcours` (
  `id` int(11) NOT NULL,
  `parcours_id` int(11) DEFAULT NULL,
  `matiere_id` int(11) DEFAULT NULL,
  `nbrMatiereOptionnelle` int(11) NOT NULL,
  `pole_de_competence_id` int(11) DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Structure de la table `semestre_parcours`
--

CREATE TABLE `semestre_parcours` (
  `parcours_id` int(11) NOT NULL,
  `semestre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numeroEtudiant` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `parcours_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `salt`, `numeroEtudiant`, `enabled`, `username`, `username_canonical`, `email_canonical`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `parcours_id`) VALUES
(16, 'ADMIN', 'admin', 'admin@admin.com', 'BEJ0vfQJV1FhCuFoQC0JFcU9OP9J2Q5w4F25wQ1Ldeo', 0, 1, 'admin', 'admin', 'admin@admin.com', 'GiJthM5FyXjtdPI9TxVpRkWM9/3scjn7yFMbmK1y+3oIHMihgzJx5x5XH0RrxZ1i3xvNHIcAHtFnS6SHaCvVXw==', '2018-05-23 14:35:38', 'abNEgIyzWxqZbGx3Y7h2rEgt28hAbJo2fnBeFIyMJwE', NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_matiere`
--

CREATE TABLE `utilisateur_matiere` (
  `utilisateur_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
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
  ADD KEY `IDX_9014574A5577AFDB` (`semestre_id`),
  ADD KEY `IDX_9014574AC9E7CDE8` (`pole_de_competence_id`);

--
-- Index pour la table `matiere_optionelle`
--
ALTER TABLE `matiere_optionelle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B13C1906A76ED395` (`user_id`),
  ADD KEY `IDX_B13C1906F46CD258` (`matiere_id`);

--
-- Index pour la table `matiere_parcours`
--
ALTER TABLE `matiere_parcours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2DD9465B82350831` (`matieres_id`);

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
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pole_de_competence`
--
ALTER TABLE `pole_de_competence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pole_de_competence_parcours`
--
ALTER TABLE `pole_de_competence_parcours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C34812846E38C0DB` (`parcours_id`),
  ADD KEY `IDX_C3481284F46CD258` (`matiere_id`),
  ADD KEY `IDX_C3481284C9E7CDE8` (`pole_de_competence_id`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `semestre_parcours`
--
ALTER TABLE `semestre_parcours`
  ADD PRIMARY KEY (`parcours_id`,`semestre_id`),
  ADD KEY `IDX_EB1DE39A6E38C0DB` (`parcours_id`),
  ADD KEY `IDX_EB1DE39A5577AFDB` (`semestre_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B33A14BF69` (`numeroEtudiant`),
  ADD KEY `FK_1D1C63B36E38C0DB` (`parcours_id`);

--
-- Index pour la table `utilisateur_matiere`
--
ALTER TABLE `utilisateur_matiere`
  ADD PRIMARY KEY (`utilisateur_id`,`matiere_id`),
  ADD KEY `IDX_EA1FA0D8FB88E14F` (`utilisateur_id`),
  ADD KEY `IDX_EA1FA0D8F46CD258` (`matiere_id`);

--
-- AUTO_INCREMENT pour les tables exportées
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `matiere_optionelle`
--
ALTER TABLE `matiere_optionelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;
--
-- AUTO_INCREMENT pour la table `matiere_parcours`
--
ALTER TABLE `matiere_parcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;
--
-- AUTO_INCREMENT pour la table `matiere_professeur`
--
ALTER TABLE `matiere_professeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `pole_de_competence`
--
ALTER TABLE `pole_de_competence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `pole_de_competence_parcours`
--
ALTER TABLE `pole_de_competence_parcours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Contraintes pour les tables exportées
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
  ADD CONSTRAINT `FK_9014574A5577AFDB` FOREIGN KEY (`semestre_id`) REFERENCES `semestre` (`id`),
  ADD CONSTRAINT `FK_9014574AC9E7CDE8` FOREIGN KEY (`pole_de_competence_id`) REFERENCES `pole_de_competence` (`id`);

--
-- Contraintes pour la table `matiere_optionelle`
--
ALTER TABLE `matiere_optionelle`
  ADD CONSTRAINT `FK_B13C1906A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_B13C1906F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`);

--
-- Contraintes pour la table `matiere_parcours`
--
ALTER TABLE `matiere_parcours`
  ADD CONSTRAINT `FK_2DD9465B82350831` FOREIGN KEY (`matieres_id`) REFERENCES `matiere` (`id`);

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
-- Contraintes pour la table `pole_de_competence_parcours`
--
ALTER TABLE `pole_de_competence_parcours`
  ADD CONSTRAINT `FK_C34812846E38C0DB` FOREIGN KEY (`parcours_id`) REFERENCES `parcours` (`id`),
  ADD CONSTRAINT `FK_C3481284C9E7CDE8` FOREIGN KEY (`pole_de_competence_id`) REFERENCES `pole_de_competence` (`id`),
  ADD CONSTRAINT `FK_C3481284F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`);

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
-- Contraintes pour la table `utilisateur_matiere`
--
ALTER TABLE `utilisateur_matiere`
  ADD CONSTRAINT `FK_EA1FA0D8F46CD258` FOREIGN KEY (`matiere_id`) REFERENCES `matiere` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EA1FA0D8FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
