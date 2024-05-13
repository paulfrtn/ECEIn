-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3300
-- Généré le : dim. 04 juin 2023 à 23:47
-- Version du serveur : 8.0.33
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ECEInDB`
--

-- --------------------------------------------------------

--
-- Structure de la table `aime`
--

CREATE TABLE `aime` (
  `id_post` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `aime_state` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `aime`
--

INSERT INTO `aime` (`id_post`, `id_utilisateur`, `aime_state`) VALUES
(27, 6, 1),
(29, 3, 1),
(30, 3, 1),
(30, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ami`
--

CREATE TABLE `ami` (
  `id_utilisateur` int NOT NULL,
  `id_utilisateur_ami` int NOT NULL,
  `ami_accept` int DEFAULT NULL,
  `date_accept` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ami`
--

INSERT INTO `ami` (`id_utilisateur`, `id_utilisateur_ami`, `ami_accept`, `date_accept`) VALUES
(3, 1, 1, '2023-06-04'),
(3, 6, 1, '2023-06-05'),
(6, 1, 1, '2023-06-04'),
(6, 7, 1, '2023-06-05'),
(7, 1, 1, '2023-06-04'),
(10, 1, 1, '2023-06-04'),
(10, 3, 1, '2023-06-05'),
(10, 7, 1, '2023-06-05');

-- --------------------------------------------------------

--
-- Structure de la table `candidater`
--

CREATE TABLE `candidater` (
  `offer_id` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `candidat_accept` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id_comment` int NOT NULL,
  `comment_content` longtext NOT NULL,
  `comment_date` date NOT NULL,
  `id_utilisateur` int NOT NULL,
  `id_post` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enregistrer`
--

CREATE TABLE `enregistrer` (
  `offer_id` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `save_state` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `envoyer`
--

CREATE TABLE `envoyer` (
  `messages_id` int NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `messages_id` int NOT NULL,
  `user_receptor` int DEFAULT NULL,
  `user_sender` int DEFAULT NULL,
  `message` longtext,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `link` longtext,
  `user_pseudo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`messages_id`, `user_receptor`, `user_sender`, `message`, `timestamp`, `link`, `user_pseudo`) VALUES
(24, 3, 10, 'Comment tu vas ?', '2023-06-04 23:43:44', NULL, 'Jules_pgt'),
(25, 7, 10, 'C\'était bien hier soir ?', '2023-06-04 23:43:59', NULL, 'Jules_pgt'),
(26, 10, 3, 'Ca va et toi ?', '2023-06-04 23:44:29', NULL, 'paul_frtn');

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id_notification` int NOT NULL,
  `notif_content` longtext NOT NULL,
  `notif_date` date NOT NULL,
  `id_utilisateur` int NOT NULL,
  `id_post` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offer`
--

CREATE TABLE `offer` (
  `offer_id` int NOT NULL,
  `offer_date` date NOT NULL,
  `offer_content` longtext NOT NULL,
  `offer_type` varchar(255) NOT NULL,
  `offer_location` varchar(255) NOT NULL,
  `offer_domain` varchar(255) NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `offer`
--

INSERT INTO `offer` (`offer_id`, `offer_date`, `offer_content`, `offer_type`, `offer_location`, `offer_domain`, `id_utilisateur`) VALUES
(5, '2023-06-05', 'Offre de stage dans la cyber sécurité', 'Stage', 'Paris 15e', 'Cyber Sécurité', 1);

-- --------------------------------------------------------

--
-- Structure de la table `partager`
--

CREATE TABLE `partager` (
  `id_post` int NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id_post` int NOT NULL,
  `post_image` varchar(255) DEFAULT NULL,
  `post_video` varchar(255) DEFAULT NULL,
  `post_cv` varchar(255) DEFAULT NULL,
  `post_location` varchar(255) DEFAULT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `post0_event1` int NOT NULL,
  `post_confid` int NOT NULL,
  `post_fic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id_post`, `post_image`, `post_video`, `post_cv`, `post_location`, `post_date`, `post_content`, `post0_event1`, `post_confid`, `post_fic`, `id_utilisateur`) VALUES
(23, '../../images/events/logo.png', NULL, NULL, NULL, '2023-06-06 00:00:00', 'journee', 1, 0, NULL, 1),
(27, '../../images/posts/40d41095-718d-45d0-8363-e91dd407130c.jpg', NULL, NULL, NULL, '2023-06-05 01:34:41', ' ', 0, 0, NULL, 3),
(28, '../../images/events/Capture d’écran 2023-06-02 à 16.35.41.png', NULL, NULL, NULL, '2023-06-06 00:00:00', 'Soutenance de projet ce Mardi', 1, 0, NULL, 3),
(29, '../../images/posts/image.jpg', NULL, NULL, NULL, '2023-06-05 01:43:11', ' ', 0, 0, NULL, 10),
(30, '../../images/posts/image.jpg', NULL, NULL, NULL, '2023-06-05 01:45:16', ' ', 0, 0, NULL, 6);

-- --------------------------------------------------------

--
-- Structure de la table `receptionner`
--

CREATE TABLE `receptionner` (
  `id_utilisateur` int NOT NULL,
  `messages_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL,
  `utilisateur_firstname` varchar(255) NOT NULL,
  `utilisateur_lastname` varchar(255) NOT NULL,
  `utilisateur_mail` varchar(255) NOT NULL,
  `utilisateur_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `utilisateur_pseudo` varchar(255) NOT NULL,
  `utilisateur_password` varchar(255) NOT NULL,
  `utilisateur_profile_picture` varchar(255) NOT NULL,
  `utilisateur_background_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `utilisateur_birthday` date NOT NULL,
  `utilisateur_cv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `utilisateur_xml` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `utilisateur_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `utilisateur_firstname`, `utilisateur_lastname`, `utilisateur_mail`, `utilisateur_phone`, `utilisateur_pseudo`, `utilisateur_password`, `utilisateur_profile_picture`, `utilisateur_background_img`, `utilisateur_birthday`, `utilisateur_cv`, `utilisateur_xml`, `utilisateur_role`) VALUES
(1, 'ECE', 'Paris', 'ece.paris@ece.fr', NULL, 'ECE_Paris', '$2y$10$bd3rh3L9/Qfpv0rp4ARRFO9lvncMuvwqz7i4DMlmfBKXUefVN8FGy', '../../images/profile_pic/photoProfileECE_Paris.jpg', '../../images/wpp/backgroundECE_Paris.jpg', '1990-10-17', NULL, NULL, 1),
(3, 'Paul-Alexandre', 'FORTUNA', 'paulalexandre.fortuna@edu.ece.fr', NULL, 'Paul_frtn', '$2y$10$f17YF8SF59WBF2INJsb5desUZ9Fz3NhwNh32kHK2MqT1T8VJBT7Ou', '../../images/profile_pic/photoProfilePaul_frtn.jpg', '../../images/wpp/backgroundPaul_frtn.jpg', '2002-01-08', NULL, NULL, 1),
(6, 'Jean-Nicolas', 'NEYRET', 'jeannicolas.neyret@edu.ece.fr', NULL, 'just_jn', '$2y$10$8S9SS4TF.Oz3pxj/dt7x1eYZvnxOmIC2BnoKDMpejhUe56X.Zswq6', '../../images/profile_pic/photoProfilejust_jn.jpeg', '../../images/wpp/backgroundjust_jn.jpg', '2023-06-29', NULL, NULL, 1),
(7, 'Cyprien', 'DUCEUX', 'cyprien.duceux@edu.ece.fr', NULL, 'Cyprien_dcx', '$2y$10$VQP//3W2qzXtETNOu2aghuQJFhLTLBwKmkKqbVJFq.Dvg8bsFGECm', '../../images/profile_pic/photoProfileCyprien_dcx.png', '../../images/wpp/backgroundCyprien_dcx.jpg', '2003-05-19', NULL, NULL, 1),
(10, 'Jules', 'PUGET', 'jules.puget@edu.ece.fr', NULL, 'Jules_pgt', '$2y$10$51nw4P827uUMfxkYCZ5XgueUaDU0Zebjpf0R6AxhIPXAQZWMVTYQ.', '../../images/profile_pic/photoProfileJules_pgt.jpg', '../../images/wpp/backgroundJules_pgt.jpg', '2023-06-06', NULL, NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `aime`
--
ALTER TABLE `aime`
  ADD PRIMARY KEY (`id_post`,`id_utilisateur`),
  ADD KEY `aime_utilisateur0_FK` (`id_utilisateur`);

--
-- Index pour la table `ami`
--
ALTER TABLE `ami`
  ADD PRIMARY KEY (`id_utilisateur`,`id_utilisateur_ami`),
  ADD KEY `ami_utilisateur0_FK` (`id_utilisateur_ami`);

--
-- Index pour la table `candidater`
--
ALTER TABLE `candidater`
  ADD PRIMARY KEY (`offer_id`,`id_utilisateur`),
  ADD KEY `candidater_utilisateur0_FK` (`id_utilisateur`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `comment_utilisateur_FK` (`id_utilisateur`),
  ADD KEY `comment_post0_FK` (`id_post`);

--
-- Index pour la table `enregistrer`
--
ALTER TABLE `enregistrer`
  ADD PRIMARY KEY (`offer_id`,`id_utilisateur`),
  ADD KEY `enregistrer_utilisateur0_FK` (`id_utilisateur`);

--
-- Index pour la table `envoyer`
--
ALTER TABLE `envoyer`
  ADD PRIMARY KEY (`messages_id`,`id_utilisateur`),
  ADD KEY `envoyer_utilisateur0_FK` (`id_utilisateur`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messages_id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `notification_utilisateur_FK` (`id_utilisateur`),
  ADD KEY `notification_post0_FK` (`id_post`);

--
-- Index pour la table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `offer_utilisateur_FK` (`id_utilisateur`);

--
-- Index pour la table `partager`
--
ALTER TABLE `partager`
  ADD PRIMARY KEY (`id_post`,`id_utilisateur`),
  ADD KEY `partager_utilisateur0_FK` (`id_utilisateur`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `post_utilisateur_FK` (`id_utilisateur`);

--
-- Index pour la table `receptionner`
--
ALTER TABLE `receptionner`
  ADD PRIMARY KEY (`id_utilisateur`,`messages_id`),
  ADD KEY `receptionner_messages0_FK` (`messages_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `messages_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notification` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `aime`
--
ALTER TABLE `aime`
  ADD CONSTRAINT `aime_post_FK` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  ADD CONSTRAINT `aime_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `ami`
--
ALTER TABLE `ami`
  ADD CONSTRAINT `ami_utilisateur0_FK` FOREIGN KEY (`id_utilisateur_ami`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `ami_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `candidater`
--
ALTER TABLE `candidater`
  ADD CONSTRAINT `candidater_offer_FK` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`),
  ADD CONSTRAINT `candidater_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post0_FK` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  ADD CONSTRAINT `comment_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `enregistrer`
--
ALTER TABLE `enregistrer`
  ADD CONSTRAINT `enregistrer_offer_FK` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`),
  ADD CONSTRAINT `enregistrer_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `envoyer`
--
ALTER TABLE `envoyer`
  ADD CONSTRAINT `envoyer_messages_FK` FOREIGN KEY (`messages_id`) REFERENCES `messages` (`messages_id`),
  ADD CONSTRAINT `envoyer_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_post0_FK` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  ADD CONSTRAINT `notification_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `offer_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `partager`
--
ALTER TABLE `partager`
  ADD CONSTRAINT `partager_post_FK` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`),
  ADD CONSTRAINT `partager_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `receptionner`
--
ALTER TABLE `receptionner`
  ADD CONSTRAINT `receptionner_messages0_FK` FOREIGN KEY (`messages_id`) REFERENCES `messages` (`messages_id`),
  ADD CONSTRAINT `receptionner_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
