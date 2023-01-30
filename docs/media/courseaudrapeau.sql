-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 12 nov. 2022 à 21:55
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
-- Base de données : `courseaudrapeau`
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
(1, 2, 'Parce que c\'est là que se trouvait le drapeau de polytechnique pendant la seconde guerre mondiale. Alors que Bordeaux était en zone occupée, trois étudiants ont franchi la ligne pour ramener le drapeau à Lyon où se situait l\'école à l\'époque.'),
(1, 3, 'Quelle distance ?'),
(1, 4, 'Il y a 860 kms de course divisés en tronçons de 11.5km. Chaque tronçon est prévu pour être couru en 1h10 soit 10km/h ou encore 6min/km pour que chaque trinôme puisse tenir le rythme. Chaque trinôme court un tronçon, se repose et recourt un tronçon dans la journée.'),
(1, 5, 'Comment me rendre au point de départ ?'),
(1, 6, 'Il y aura des groupes de 6 personnes: deux trinômes. Il faudra que dans chaque trinôme l\'un d\'entre vous accepte de conduire (en dehors de la course bien sûr). Les véhicules de plus de 6 places vous seront fournis. C\'est à vous d\'être autonome pour être au départ de chaque tronçon que vous courrez. Vous aurez bientôt la répartition des groupes et des tronçons dans votre espace personnel.'),
(1, 7, 'Quand pourrons-nous dormir ?'),
(1, 8, 'Dès que vous ne serez pas en course. A l\'hébergement, vous pourrez vous reposer et manger avant de repartir.'),
(1, 9, 'Pourquoi cette date ?'),
(1, 10, 'Nous avons cherché à faire coïncider la date d\'arrivée avec le jour de la sainte Barbe. C\'est une des saintes patronnes des militaires. Il est traditionnel à l\'X d\'organiser un cross à cette date.'),
(1, 11, 'Nous allons courrir de nuit ?'),
(1, 12, 'Oui bien sûr, le relai se fait 24h sur 24. Mais il y aura un roulement pour que les créneaux d\'un groupe ne tombent pas systématiquement la nuit. Il faut prévoir des tenues chaudes et des lampes frontales.'),
(1, 13, 'Comment je sais où je dois être et quand ?'),
(1, 14, 'Dans mon espace personnel, il est indiqué tous les tronçons que je dois courir avec les points de départ, d\'arrivée et les horaires. '),
(1, 15, 'Quel matériel emporter ?'),
(1, 16, 'Il y a une liste à cet effet dans mon espace personnel <a href=\"index.php?page=EspacePerso\">ici</a>.'),
(1, 17, 'Dois-je emporter de quoi manger ?'),
(1, 18, 'Des repas seront servis sur les hébergements presque toute la journée. Il y aura aussi des pique-nique à emporter pour ceux qui auront besoin. Vous pouvez néanmoins emmener des barres énergétiques en plus.'),
(1, 19, 'Comment puis-je suivre l\'avancement de la course ?'),
(1, 20, 'Il y a un onglet dédié à cela <a href=http://course-drapeau.binets.fr/index.php?page=Suivi>ici</a>.'),
(1, 21, 'J\'ai un problème avec mon compte'),
(1, 22, 'Contacte-nous directement <a href=http://course-drapeau.binets.fr/index.php?page=Contact>ici</a>.\n'),
(1, 23, 'C\'est quand ?'),
(1, 24, 'Le départ du premier trinôme est à 15h de Bordeaux le lundi 28 novembre. L\'arrivée est le  le vendredi 2 décembre à 10h.'),
(1, 25, 'Quelles sont les mesures de sécurité pendant la course ?'),
(1, 26, 'Le groupe de coureurs sera en permanence suivi par un ou plusieurs vélo balai. Le cycliste aura une trousse de secours SAN. Il y aura une cellule de suivi de course disponible 24h/24 pour venir vous chercher ou vous aider. Vous serez munis de balises GPS qui permettront de voir votre avancement et vérifier que l\'itinéraire est bien suivi. La course de nuit se fera obligatoirement avec une lampe frontale.'),
(2, 1, '3 jours de course'),
(2, 2, 'Plus de 800 km\n'),
(2, 3, 'Une organisation de folie'),
(4, 1, '1669644000'),
(4, 2, '1669971600'),
(14, 1, 'La course coûte 50€, vous pouvez régler '),
(14, 2, 'https://collecte.io/course-au-drapeau-bordeaux-x-2056401/fr'),
(14, 3, 'ici');

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
('Accueil', 1, 'Slogans présents sur la page d\'accueil du site', 2),
('Troncons', 1, 'date et heure de début et de fin de course', 4),
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
  `trinome_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `tracesgpx`
--

INSERT INTO `tracesgpx` (`id`, `heure_dep`, `heure_arr`, `gps_dep`, `gps_arr`, `trinome_id`) VALUES
(1, '2022-11-28 14:00:00', '2022-11-28 15:10:00', '44.83743 -0.57733', '44.88159 -0.52586', 1),
(2, '2022-11-28 15:10:00', '2022-11-28 16:20:00', '44.88160 -0.52574', '44.93676 -0.49351', 2),
(3, '2022-11-28 16:20:00', '2022-11-28 17:30:00', '44.93673 -0.49352', '44.99252 -0.44834', 1),
(4, '2022-11-28 17:30:00', '2022-11-28 18:40:00', '44.99244 -0.44791', '45.03728 -0.50765', 2),
(5, '2022-11-28 18:40:00', '2022-11-28 19:50:00', '45.03717 -0.50771', '45.05606 -0.60613', 3),
(6, '2022-11-28 19:50:00', '2022-11-28 21:00:00', '45.05605 -0.60610', '45.10914 -0.64419', 4),
(7, '2022-11-28 21:00:00', '2022-11-28 22:10:00', '45.10915 -0.64419', '45.16195 -0.61557', 3),
(8, '2022-11-28 22:10:00', '2022-11-28 23:20:00', '45.16190 -0.61561', '45.21976 -0.57965', 4),
(9, '2022-11-28 23:20:00', '2022-11-29 00:30:00', '45.21985 -0.57964', '45.28954 -0.56189', 5),
(10, '2022-11-29 00:30:00', '2022-11-29 01:40:00', '45.28967 -0.56183', '45.34346 -0.56304', 6),
(11, '2022-11-29 01:40:00', '2022-11-29 02:50:00', '45.34340 -0.56304', '45.41725 -0.55627', 5),
(12, '2022-11-29 02:50:00', '2022-11-29 04:00:00', '45.41722 -0.55624', '45.47849 -0.57300', 6),
(13, '2022-11-29 04:00:00', '2022-11-29 05:10:00', '45.47826 -0.57301', '45.53844 -0.57397', 7),
(14, '2022-11-29 05:10:00', '2022-11-29 06:20:00', '45.53844 -0.57373', '45.60824 -0.56705', 8),
(15, '2022-11-29 06:20:00', '2022-11-29 07:30:00', '45.60350 -0.56188', '45.67492 -0.61777', 7),
(16, '2022-11-29 07:30:00', '2022-11-29 08:40:00', '45.67491 -0.61774', '45.74480 -0.62885', 8),
(17, '2022-11-29 08:40:00', '2022-11-29 09:50:00', '45.74497 -0.62927', '45.80510 -0.58003', 9),
(18, '2022-11-29 09:50:00', '2022-11-29 11:00:00', '45.80528 -0.58013', '45.87410 -0.58788', 10),
(19, '2022-11-29 11:00:00', '2022-11-29 12:10:00', '45.87414 -0.58796', '45.93465 -0.53029', 9),
(20, '2022-11-29 12:10:00', '2022-11-29 13:20:00', '45.93460 -0.53035', '45.97523 -0.45401', 10),
(21, '2022-11-29 13:20:00', '2022-11-29 14:30:00', '45.97514 -0.45407', '46.01195 -0.35313', 11),
(22, '2022-11-29 14:30:00', '2022-11-29 15:40:00', '46.01195 -0.35313', '46.08380 -0.28390', 12),
(23, '2022-11-29 15:40:00', '2022-11-29 16:50:00', '46.08383 -0.28387', '46.14370 -0.21835', 11),
(24, '2022-11-29 16:50:00', '2022-11-29 18:00:00', '46.14371 -0.21834', '46.21084 -0.18274', 12),
(25, '2022-11-29 18:00:00', '2022-11-29 19:10:00', '46.21093 -0.18277', '46.24527 -0.10782', 5),
(26, '2022-11-29 19:10:00', '2022-11-29 20:20:00', '46.24523 -0.10785', '46.32117 -0.08426', 6),
(27, '2022-11-29 20:20:00', '2022-11-29 21:30:00', '46.32118 -0.08449', '46.35804 0.03253', 5),
(28, '2022-11-29 21:30:00', '2022-11-29 22:40:00', '46.35803 0.03237', '46.43064 0.11699', 6),
(29, '2022-11-29 22:40:00', '2022-11-29 23:50:00', '46.43055 0.11691', '46.48699 0.19071', 7),
(30, '2022-11-29 23:50:00', '2022-11-30 01:00:00', '46.48700 0.19066', '46.53684 0.28790', 8),
(31, '2022-11-30 01:00:00', '2022-11-30 02:10:00', '46.53675 0.28793', '46.54293 0.32729', 7),
(32, '2022-11-30 02:10:00', '2022-11-30 03:20:00', '46.54284 0.32731', '46.58725 0.35815', 8),
(33, '2022-11-30 03:20:00', '2022-11-30 04:30:00', '46.58767 0.35850', '46.67150 0.41637', 9),
(34, '2022-11-30 04:30:00', '2022-11-30 05:40:00', '46.67135 0.41622', '46.73187 0.49948', 10),
(35, '2022-11-30 05:40:00', '2022-11-30 06:50:00', '46.73174 0.49933', '46.79816 0.54311', 9),
(36, '2022-11-30 06:50:00', '2022-11-30 08:00:00', '46.79817 0.54307', '46.87419 0.57500', 10),
(37, '2022-11-30 08:00:00', '2022-11-30 09:10:00', '46.87296 0.57383', '46.93393 0.62911', 11),
(38, '2022-11-30 09:10:00', '2022-11-30 10:20:00', '46.93386 0.62919', '47.00641 0.60038', 12),
(39, '2022-11-30 10:20:00', '2022-11-30 11:30:00', '47.00640 0.60037', '47.07443 0.60751', 11),
(40, '2022-11-30 11:30:00', '2022-11-30 12:40:00', '47.07441 0.60750', '47.14950 0.63781', 12),
(41, '2022-11-30 12:40:00', '2022-11-30 13:50:00', '47.14950 0.63781', '47.21020 0.70359', 1),
(42, '2022-11-30 13:50:00', '2022-11-30 15:00:00', '47.21025 0.70364', '47.28282 0.73240', 2),
(43, '2022-11-30 15:00:00', '2022-11-30 16:10:00', '47.28292 0.73251', '47.36433 0.74949', 1),
(44, '2022-11-30 16:10:00', '2022-11-30 17:20:00', '47.36434 0.74949', '47.40150 0.71527', 2),
(45, '2022-11-30 17:20:00', '2022-11-30 18:30:00', '47.40147 0.71501', '47.41148 0.83598', 3),
(46, '2022-11-30 18:30:00', '2022-11-30 19:40:00', '47.41168 0.83609', '47.43806 0.87432', 4),
(47, '2022-11-30 19:40:00', '2022-11-30 20:50:00', '47.43809 0.87420', '47.49814 0.89003', 3),
(48, '2022-11-30 20:50:00', '2022-11-30 22:00:00', '47.49828 0.88991', '47.56568 0.90441', 4),
(49, '2022-11-30 22:00:00', '2022-11-30 23:10:00', '47.56560 0.90436', '47.63178 0.91540', 9),
(50, '2022-11-30 23:10:00', '2022-12-01 00:20:00', '47.63170 0.91525', '47.69536 0.91557', 10),
(51, '2022-12-01 00:20:00', '2022-12-01 01:30:00', '47.69537 0.91557', '47.73995 0.91741', 9),
(52, '2022-12-01 01:30:00', '2022-12-01 02:40:00', '47.73993 0.91743', '47.76371 0.97270', 10),
(53, '2022-12-01 02:40:00', '2022-12-01 03:50:00', '47.76389 0.97270', '47.79544 1.07459', 11),
(54, '2022-12-01 03:50:00', '2022-12-01 05:00:00', '47.79546 1.07470', '47.86090 1.13534', 12),
(55, '2022-12-01 05:00:00', '2022-12-01 06:10:00', '47.86085 1.13524', '47.89590 1.22400', 11),
(56, '2022-12-01 06:10:00', '2022-12-01 07:20:00', '47.89592 1.22397', '47.95814 1.25348', 12),
(57, '2022-12-01 07:20:00', '2022-12-01 08:30:00', '47.89592 1.22397', '47.95814 1.25348', 1),
(58, '2022-12-01 08:30:00', '2022-12-01 09:40:00', '48.01664 1.24541', '48.06095 1.29689', 2),
(59, '2022-12-01 09:40:00', '2022-12-01 10:50:00', '48.06094 1.29690', '48.11182 1.31122', 1),
(60, '2022-12-01 10:50:00', '2022-12-01 12:00:00', '48.11182 1.31111', '48.14138 1.40167', 2),
(61, '2022-12-01 12:00:00', '2022-12-01 13:10:00', '48.14141 1.40171', '48.20921 1.36945', 3),
(62, '2022-12-01 13:10:00', '2022-12-01 14:20:00', '48.20916 1.36940', '48.25314 1.29493', 4),
(63, '2022-12-01 14:20:00', '2022-12-01 15:30:00', '48.25308 1.29496', '48.30071 1.24696', 3),
(64, '2022-12-01 15:30:00', '2022-12-01 16:40:00', '48.30085 1.24670', '48.33456 1.30236', 4),
(65, '2022-12-01 16:40:00', '2022-12-01 17:50:00', '48.33510 1.30369', '48.39604 1.38649', 5),
(66, '2022-12-01 17:50:00', '2022-12-01 19:00:00', '48.39624 1.38660', '48.40119 1.48515', 6),
(67, '2022-12-01 19:00:00', '2022-12-01 20:10:00', '48.40128 1.48503', '48.47043 1.48649', 5),
(68, '2022-12-01 20:10:00', '2022-12-01 21:20:00', '48.47046 1.48671', '48.51570 1.56375', 6),
(69, '2022-12-01 21:20:00', '2022-12-01 22:30:00', '48.51578 1.56353', '48.56979 1.59020', 7),
(70, '2022-12-01 22:30:00', '2022-12-01 23:40:00', '48.56981 1.59016', '48.61537 1.61111', 8),
(71, '2022-12-01 23:40:00', '2022-12-02 00:50:00', '48.61545 1.61110', '48.60036 1.70234', 7),
(72, '2022-12-02 00:50:00', '2022-12-02 02:00:00', '48.60028 1.70212', '48.63369 1.77144', 8),
(73, '2022-12-02 02:00:00', '2022-12-02 03:10:00', '48.63377 1.77124', '48.61926 1.86142', NULL),
(74, '2022-12-02 03:10:00', '2022-12-02 04:20:00', '48.61906 1.86147', '48.57548 1.96611', NULL),
(75, '2022-12-02 04:20:00', '2022-12-02 05:30:00', '48.57549 1.96611', '48.63251 2.03662', NULL),
(76, '2022-12-02 05:30:00', '2022-12-02 06:40:00', '48.63252 2.03670', '48.70192 2.07433', NULL),
(77, '2022-12-02 06:40:00', '2022-12-02 07:50:00', '48.70199 2.07451', '48.70593 2.17980', NULL),
(78, '2022-12-02 07:50:00', '2022-12-02 09:00:00', '48.70594 2.17984', '48.71406 2.21080', NULL);

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
  `vegetarian` tinyint(1) DEFAULT NULL,
  `prepa_repas` tinyint(1) DEFAULT NULL,
  `allergie` text COLLATE utf8_general_mysql500_ci,
  `permis` tinyint(1) DEFAULT NULL,
  `jeune_conducteur` tinyint(1) DEFAULT NULL,
  `boite_manuelle` tinyint(1) DEFAULT NULL,
  `trinome_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;


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
