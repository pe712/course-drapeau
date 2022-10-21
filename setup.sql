-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 21 oct. 2022 à 18:02
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bordeauxx`
--

-- --------------------------------------------------------

--
-- Structure de la table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `Sid` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `contenu` varchar(511) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`Sid`,`item`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `content`
--

INSERT INTO `content` (`Sid`, `item`, `contenu`) VALUES
(1, 1, 'Pourquoi partir de Bordeaux ?'),
(1, 2, 'Parce que c\'est là que se trouvait le drapeau de polytechnique pendant la seconde guerre mondiale. Alors que Bordeaux était en zone occupée, trois étudiants ont franchis la ligne pour ramener le drapeau à Lyon où se situait l\'école à l\'époque.'),
(1, 3, 'Quelle distance ?'),
(1, 4, 'Il y a 860 kms de course divisés en tronçons de 12km. Chaque tronçon est prévu pour être couru à 10km/h pour que chaque trinôme puisse tenir le rythme.\n.'),
(1, 5, 'Comment me rendre au point de départ ?'),
(1, 6, 'Des mini-bus seront chargés de vous emmener aux points de départ et de vous reprendre à chaque fin de course. Ils vous emmeneront aussi aux zones de récupération où vous pourrez dormir.'),
(1, 7, 'Quand pourrons-nous dormir ?'),
(1, 8, 'Dès que vous ne serez pas en course, un chauffeur vous emmènera vers le point d\'hébergement. Là vous pourrez vous reposer et manger avant de repartir.'),
(2, 1, '3 jours de course'),
(2, 2, 'Plus de 800 kms\n'),
(2, 3, 'Une organisation de folie'),
(4, 1, '1664625600'),
(4, 2, '1664798400');

-- --------------------------------------------------------

--
-- Structure de la table `content_section`
--

DROP TABLE IF EXISTS `content_section`;
CREATE TABLE IF NOT EXISTS `content_section` (
  `page` varchar(31) COLLATE utf8_general_mysql500_ci NOT NULL,
  `section` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page` (`page`,`section`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `content_section`
--

INSERT INTO `content_section` (`page`, `section`, `description`, `id`) VALUES
('About', 1, 'Questions (items impairs) et réponses (items pairs) de la FAQ', 1),
('Acceuil', 1, 'Slogans présents sur la page d\'accueil du site', 2),
('Troncons', 1, 'date et heure de début et de fin de course', 4),
('About', 2, 'faefafze', 11),
('About', 3, 'faefafze', 13),
('EspacePerso', 1, 'Lien vers la cagnotte Lydia', 14);

-- --------------------------------------------------------

--
-- Structure de la table `tracesgpx`
--

DROP TABLE IF EXISTS `tracesgpx`;
CREATE TABLE IF NOT EXISTS `tracesgpx` (
  `id` int(11) NOT NULL,
  `heure_dep` timestamp NULL DEFAULT NULL,
  `heure_arr` timestamp NULL DEFAULT NULL,
  `gps_dep` varchar(63) COLLATE utf8_general_mysql500_ci NOT NULL,
  `gps_arr` varchar(63) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `tracesgpx`
--

INSERT INTO `tracesgpx` (`id`, `heure_dep`, `heure_arr`, `gps_dep`, `gps_arr`) VALUES
(1, '2022-10-01 12:00:00', '2022-10-01 12:36:55', '44.83743 -0.57733', '44.88159 -0.52586'),
(2, '2022-10-01 12:36:55', '2022-10-01 13:13:51', '44.88160 -0.52574', '44.93676 -0.49351'),
(3, '2022-10-01 13:13:51', '2022-10-01 13:50:46', '44.93673 -0.49352', '44.99252 -0.44834'),
(4, '2022-10-01 13:50:46', '2022-10-01 14:27:42', '44.99244 -0.44791', '45.03728 -0.50765'),
(5, '2022-10-01 14:27:42', '2022-10-01 15:04:37', '45.03717 -0.50771', '45.05606 -0.60613'),
(6, '2022-10-01 15:04:37', '2022-10-01 15:41:32', '45.05605 -0.60610', '45.10914 -0.64419'),
(7, '2022-10-01 15:41:32', '2022-10-01 16:18:28', '45.10915 -0.64419', '45.16195 -0.61557'),
(8, '2022-10-01 16:18:28', '2022-10-01 16:55:23', '45.16190 -0.61561', '45.21976 -0.57965'),
(9, '2022-10-01 16:55:23', '2022-10-01 17:32:18', '45.21985 -0.57964', '45.28954 -0.56189'),
(10, '2022-10-01 17:32:18', '2022-10-01 18:09:14', '45.28967 -0.56183', '45.34346 -0.56304'),
(11, '2022-10-01 18:09:14', '2022-10-01 18:46:09', '45.34340 -0.56304', '45.41725 -0.55627'),
(12, '2022-10-01 18:46:09', '2022-10-01 19:23:05', '45.41722 -0.55624', '45.47849 -0.57300'),
(13, '2022-10-01 19:23:05', '2022-10-01 20:00:00', '45.47826 -0.57301', '45.53844 -0.57397'),
(14, '2022-10-01 20:00:00', '2022-10-01 20:36:55', '45.53844 -0.57373', '45.60824 -0.56705'),
(15, '2022-10-01 20:36:55', '2022-10-01 21:13:51', '45.60350 -0.56188', '45.67492 -0.61777'),
(16, '2022-10-01 21:13:51', '2022-10-01 21:50:46', '45.67491 -0.61774', '45.74480 -0.62885'),
(17, '2022-10-01 21:50:46', '2022-10-01 22:27:42', '45.74497 -0.62927', '45.80510 -0.58003'),
(18, '2022-10-01 22:27:42', '2022-10-01 23:04:37', '45.80528 -0.58013', '45.87410 -0.58788'),
(19, '2022-10-01 23:04:37', '2022-10-01 23:41:32', '45.87414 -0.58796', '45.93465 -0.53029'),
(20, '2022-10-01 23:41:32', '2022-10-02 00:18:28', '45.93460 -0.53035', '45.97523 -0.45401'),
(21, '2022-10-02 00:18:28', '2022-10-02 00:55:23', '45.97514 -0.45407', '46.01195 -0.35313'),
(22, '2022-10-02 00:55:23', '2022-10-02 01:32:18', '46.01195 -0.35313', '46.08380 -0.28390'),
(23, '2022-10-02 01:32:18', '2022-10-02 02:09:14', '46.08383 -0.28387', '46.14370 -0.21835'),
(24, '2022-10-02 02:09:14', '2022-10-02 02:46:09', '46.14371 -0.21834', '46.21084 -0.18274'),
(25, '2022-10-02 02:46:09', '2022-10-02 03:23:05', '46.21093 -0.18277', '46.24527 -0.10782'),
(26, '2022-10-02 03:23:05', '2022-10-02 04:00:00', '46.24523 -0.10785', '46.32117 -0.08426'),
(27, '2022-10-02 04:00:00', '2022-10-02 04:36:55', '46.32118 -0.08449', '46.35804 0.03253'),
(28, '2022-10-02 04:36:55', '2022-10-02 05:13:51', '46.35803 0.03237', '46.43064 0.11699'),
(29, '2022-10-02 05:13:51', '2022-10-02 05:50:46', '46.43055 0.11691', '46.48699 0.19071'),
(30, '2022-10-02 05:50:46', '2022-10-02 06:27:42', '46.48700 0.19066', '46.53684 0.28790'),
(31, '2022-10-02 06:27:42', '2022-10-02 07:04:37', '46.53675 0.28793', '46.54293 0.32729'),
(32, '2022-10-02 07:04:37', '2022-10-02 07:41:32', '46.54284 0.32731', '46.58725 0.35815'),
(33, '2022-10-02 07:41:32', '2022-10-02 08:18:28', '46.58767 0.35850', '46.67150 0.41637'),
(34, '2022-10-02 08:18:28', '2022-10-02 08:55:23', '46.67135 0.41622', '46.73187 0.49948'),
(35, '2022-10-02 08:55:23', '2022-10-02 09:32:18', '46.73174 0.49933', '46.79816 0.54311'),
(36, '2022-10-02 09:32:18', '2022-10-02 10:09:14', '46.79817 0.54307', '46.87419 0.57500'),
(37, '2022-10-02 10:09:14', '2022-10-02 10:46:09', '46.87296 0.57383', '46.93393 0.62911'),
(38, '2022-10-02 10:46:09', '2022-10-02 11:23:05', '46.93386 0.62919', '47.00641 0.60038'),
(39, '2022-10-02 11:23:05', '2022-10-02 12:00:00', '47.00640 0.60037', '47.07443 0.60751'),
(40, '2022-10-02 12:00:00', '2022-10-02 12:36:55', '47.07441 0.60750', '47.14950 0.63781'),
(41, '2022-10-02 12:36:55', '2022-10-02 13:13:51', '47.14950 0.63781', '47.21020 0.70359'),
(42, '2022-10-02 13:13:51', '2022-10-02 13:50:46', '47.21025 0.70364', '47.28282 0.73240'),
(43, '2022-10-02 13:50:46', '2022-10-02 14:27:42', '47.28292 0.73251', '47.36433 0.74949'),
(44, '2022-10-02 14:27:42', '2022-10-02 15:04:37', '47.36434 0.74949', '47.40150 0.71527'),
(45, '2022-10-02 15:04:37', '2022-10-02 15:41:32', '47.40147 0.71501', '47.41148 0.83598'),
(46, '2022-10-02 15:41:32', '2022-10-02 16:18:28', '47.41168 0.83609', '47.43806 0.87432'),
(47, '2022-10-02 16:18:28', '2022-10-02 16:55:23', '47.43809 0.87420', '47.49814 0.89003'),
(48, '2022-10-02 16:55:23', '2022-10-02 17:32:18', '47.49828 0.88991', '47.56568 0.90441'),
(49, '2022-10-02 17:32:18', '2022-10-02 18:09:14', '47.56560 0.90436', '47.63178 0.91540'),
(50, '2022-10-02 18:09:14', '2022-10-02 18:46:09', '47.63170 0.91525', '47.69536 0.91557'),
(51, '2022-10-02 18:46:09', '2022-10-02 19:23:05', '47.69537 0.91557', '47.73995 0.91741'),
(52, '2022-10-02 19:23:05', '2022-10-02 20:00:00', '47.73993 0.91743', '47.76371 0.97270'),
(53, '2022-10-02 20:00:00', '2022-10-02 20:36:55', '47.76389 0.97270', '47.79544 1.07459'),
(54, '2022-10-02 20:36:55', '2022-10-02 21:13:51', '47.79546 1.07470', '47.86090 1.13534'),
(55, '2022-10-02 21:13:51', '2022-10-02 21:50:46', '47.86085 1.13524', '47.89590 1.22400'),
(56, '2022-10-02 21:50:46', '2022-10-02 22:27:42', '47.89592 1.22397', '47.95814 1.25348'),
(57, '2022-10-02 22:27:42', '2022-10-02 23:04:37', '47.89592 1.22397', '47.95814 1.25348'),
(58, '2022-10-02 23:04:37', '2022-10-02 23:41:32', '48.01664 1.24541', '48.06095 1.29689'),
(59, '2022-10-02 23:41:32', '2022-10-03 00:18:28', '48.06094 1.29690', '48.11182 1.31122'),
(60, '2022-10-03 00:18:28', '2022-10-03 00:55:23', '48.11182 1.31111', '48.14138 1.40167'),
(61, '2022-10-03 00:55:23', '2022-10-03 01:32:18', '48.14141 1.40171', '48.20921 1.36945'),
(62, '2022-10-03 01:32:18', '2022-10-03 02:09:14', '48.20916 1.36940', '48.25314 1.29493'),
(63, '2022-10-03 02:09:14', '2022-10-03 02:46:09', '48.25308 1.29496', '48.30071 1.24696'),
(64, '2022-10-03 02:46:09', '2022-10-03 03:23:05', '48.30085 1.24670', '48.33456 1.30236'),
(65, '2022-10-03 03:23:05', '2022-10-03 04:00:00', '48.33510 1.30369', '48.39604 1.38649'),
(66, '2022-10-03 04:00:00', '2022-10-03 04:36:55', '48.39624 1.38660', '48.40119 1.48515'),
(67, '2022-10-03 04:36:55', '2022-10-03 05:13:51', '48.40128 1.48503', '48.47043 1.48649'),
(68, '2022-10-03 05:13:51', '2022-10-03 05:50:46', '48.47046 1.48671', '48.51570 1.56375'),
(69, '2022-10-03 05:50:46', '2022-10-03 06:27:42', '48.51578 1.56353', '48.56979 1.59020'),
(70, '2022-10-03 06:27:42', '2022-10-03 07:04:37', '48.56981 1.59016', '48.61537 1.61111'),
(71, '2022-10-03 07:04:37', '2022-10-03 07:41:32', '48.61545 1.61110', '48.60036 1.70234'),
(72, '2022-10-03 07:41:32', '2022-10-03 08:18:28', '48.60028 1.70212', '48.63369 1.77144'),
(73, '2022-10-03 08:18:28', '2022-10-03 08:55:23', '48.63377 1.77124', '48.61926 1.86142'),
(74, '2022-10-03 08:55:23', '2022-10-03 09:32:18', '48.61906 1.86147', '48.57548 1.96611'),
(75, '2022-10-03 09:32:18', '2022-10-03 10:09:14', '48.57549 1.96611', '48.63251 2.03662'),
(76, '2022-10-03 10:09:14', '2022-10-03 10:46:09', '48.63252 2.03670', '48.70192 2.07433'),
(77, '2022-10-03 10:46:09', '2022-10-03 11:23:05', '48.70199 2.07451', '48.70593 2.17980'),
(78, '2022-10-03 11:23:05', '2022-10-03 12:00:00', '48.70594 2.17984', '48.71406 2.21080');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `hash` varchar(60) COLLATE utf8_general_mysql500_ci NOT NULL,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `lastConn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `promotion` int(2) DEFAULT NULL,
  `chauffeur` tinyint(1) DEFAULT NULL,
  `num_places` int(2) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `certificat` tinyint(1) NOT NULL DEFAULT '0',
  `root` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `hash`, `creationTime`, `valid`, `lastConn`, `nom`, `prenom`, `promotion`, `chauffeur`, `num_places`, `paid`, `certificat`, `root`) VALUES
(4, 'pe.baviere@gmail.com', '$2y$14$Vpc3sXyA0o7Ntzur1N0CuOKa4HPTAm8mGOrO9aygICx0mfik.yuLq', '2022-09-16 09:09:49', 0, '2022-10-21 11:55:01', 'er', 'Pierre-Emmanuel', 21, 1, 7, 1, 1, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `contrainte de clé de section` FOREIGN KEY (`Sid`) REFERENCES `content_section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
