-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 14 mai 2021 à 06:26
-- Version du serveur :  5.7.33
-- Version de PHP : 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bts-app`
--
CREATE DATABASE IF NOT EXISTS `bts-app` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bts-app`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `Id_Categorie` int(255) NOT NULL,
  `nom_categorie` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`Id_Categorie`, `nom_categorie`) VALUES
(3, 'PC'),
(4, 'Nintendo Switch'),
(5, 'PS4'),
(6, 'XBOX ONE');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style_couleur_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `email`, `roles`, `password`, `num_tel`, `pseudo`, `nom`, `prenom`, `country`, `photo_profil`, `style_couleur_profil`, `point_client`) VALUES
(29, 'figueres.adrien@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$srQSsK+IG9WR3RvZr8ZBIA$9zeEl2XpeDJdNTHbQd7KSZstZjp9DU/GQotYUvh4zls', '0626246006', 'Adriraxor', 'FIGUERES', 'Adrien', 'France', 'call-of-duty-ghosts-cover.jpg', '#ff0000', 15594),
(30, 'figueres.alain@gmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$evdVSRFd7QMkAZNIXmfThg$uYjH805tGOaydORKt6p3zsbRpIIf5uS2obSR1dJXJVI', '0626246007', 'Lezardo', 'FIGUERES', 'Alain', 'France', 'dark-souls-3-cover.jpg', '#ff7575', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_client_id` int(11) NOT NULL,
  `date_commande` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_total` double DEFAULT NULL,
  `Id_Facture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_client_id`, `date_commande`, `montant_total`, `Id_Facture`) VALUES
(163, 29, '14-05-2021 06:20', 77, 163);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `commande_dun_client`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `commande_dun_client` (
`image` varchar(255)
,`nom_produit` varchar(50)
,`qte` double
,`tarif_produit` int(11)
,`date_commande` varchar(255)
,`montant_total` double
);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire_produit`
--

CREATE TABLE `commentaire_produit` (
  `id` int(11) NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_produit` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Id_Client` int(11) DEFAULT NULL,
  `Id_Produit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire_produit`
--

INSERT INTO `commentaire_produit` (`id`, `message`, `note_produit`, `date`, `Id_Client`, `Id_Produit`) VALUES
(61, 'test', 2, '15-04-2021 12:01', 30, 24),
(62, 'te', 2, '15-04-2021 12:30', 30, 24),
(63, 'te', 1, '15-04-2021 12:30', 30, 45),
(64, 'te', 4, '15-04-2021 12:30', 30, 45),
(65, 'te', 4, '15-04-2021 12:30', 30, 31),
(66, 'te', 2, '15-04-2021 12:30', 30, 31),
(67, 'te', 5, '15-04-2021 12:30', 30, 25),
(68, 'te', 4, '15-04-2021 12:30', 30, 28),
(69, 'Super produit comme d\'hab', 5, '26-04-2021 15:44', 29, 24);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `Id_Facture` int(11) NOT NULL,
  `numero_facture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant_facture` int(11) NOT NULL,
  `facture_pdf` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`Id_Facture`, `numero_facture`, `montant_facture`, `facture_pdf`) VALUES
(163, '61a59960-7cf1-4fa4-a501-e63bbd841d73', 77, 0x3c21444f43545950452068746d6c3e0a3c68746d6c3e0a3c686561643e0a202020203c6d65746120636861727365743d225554462d38223e0a202020203c7469746c653e5261786f7253686f70202d2050616e6965723c2f7469746c653e0a2020202020202020202020202020202020202020202020203c6c696e6b2072656c3d2269636f6e2220687265663d222f6274732d6170702f7075626c69632f2e2e2f496d616765732f4469766572732f70616e6965725f66617669636f6e2e706e6722202f3e0a20202020202020203c6c696e6b2072656c3d227374796c6573686565742220687265663d2268747470733a2f2f6d617863646e2e626f6f74737472617063646e2e636f6d2f626f6f7473747261702f342e302e302f6373732f626f6f7473747261702e6d696e2e637373220a2020202020202020202020202020696e746567726974793d227368613338342d476e3533383478715131616f5758412b30353852585078506736667934495776544e683045323633586d46634a6c5341776947674641572f64416953364a586d220a202020202020202020202020202063726f73736f726967696e3d22616e6f6e796d6f7573223e0a20202020202020203c6c696e6b2072656c3d227374796c6573686565742220687265663d2268747470733a2f2f63646e2e6a7364656c6976722e6e65742f6e706d2f626f6f7473747261702d69636f6e7340312e342e302f666f6e742f626f6f7473747261702d69636f6e732e637373223e0a20202020202020203c6c696e6b2072656c3d227374796c6573686565742220687265663d2268747470733a2f2f7573652e666f6e74617765736f6d652e636f6d2f72656c65617365732f76352e31352e332f6373732f616c6c2e6373732220696e746567726974793d227368613338342d535a5878583477684a37392f67457277634f59662b7a574c654a64592f71707571433463416139724f47557374506f6d747170754e575439776450456e32666b222063726f73736f726967696e3d22616e6f6e796d6f7573223e0a0a20202020202020203c6c696e6b2072656c3d227374796c6573686565742220687265663d222f6274732d6170702f7075626c69632f6275696c642f70616e6965722e637373223e0a202020200a2020202020202020202020203c736372697074207372633d2268747470733a2f2f636f64652e6a71756572792e636f6d2f6a71756572792d332e322e312e736c696d2e6d696e2e6a73220a20202020202020202020202020202020696e746567726974793d227368613338342d4b4a336f32444b74496b7659494b3355454e7a6d4d374b436b52722f7245392f5170673661415a474a7746444d564e412f4770474646393368587047354b6b4e220a2020202020202020202020202020202063726f73736f726967696e3d22616e6f6e796d6f7573223e3c2f7363726970743e0a20202020202020203c736372697074207372633d2268747470733a2f2f63646e6a732e636c6f7564666c6172652e636f6d2f616a61782f6c6962732f706f707065722e6a732f312e31322e392f756d642f706f707065722e6d696e2e6a73220a20202020202020202020202020202020696e746567726974793d227368613338342d41704e62676839422b5931514b747633526e3757336d6750786855394b2f53635173415037685569625833396a3766616b4650736b7658757376666130623451220a2020202020202020202020202020202063726f73736f726967696e3d22616e6f6e796d6f7573223e3c2f7363726970743e0a20202020202020203c736372697074207372633d2268747470733a2f2f6d617863646e2e626f6f74737472617063646e2e636f6d2f626f6f7473747261702f342e302e302f6a732f626f6f7473747261702e6d696e2e6a73220a20202020202020202020202020202020696e746567726974793d227368613338342d4a5a52365370656a683455303264386a4f7436764c454866652f4a514769525253515178536646577069314d7175566441796a556172352b37365056436d596c220a2020202020202020202020202020202063726f73736f726967696e3d22616e6f6e796d6f7573223e3c2f7363726970743e0a20202020202020203c736372697074207372633d2268747470733a2f2f6b69742e666f6e74617765736f6d652e636f6d2f363564623537313331382e6a73222063726f73736f726967696e3d22616e6f6e796d6f7573223e3c2f7363726970743e0a0a202020203c2f686561643e0a3c626f64793e0a2020202020202020202020203c68313e566f69636920766f7472652066616374757265206ec2b02036316135393936302d376366312d346661342d613530312d653633626264383431643733203c2f68313e0a20202020202020202020202020202020202020203c64697620636c6173733d22636f6e7461696e6572223e0a202020202020202020202020202020204772616e64205468656674204175746f205620266e6273703b207c0a20202020202020202020202020202020416374696f6e2c204f70656e20576f726c642c20506f70756c6169726520266e6273703b207c0a20202020202020202020202020202020283120266e6273703b202a0a202020202020202020202020202020203339e282ac20266e6273703b29202d3e0a20202020202020202020202020202020333920e282ac0a202020202020202020202020202020203c62723e0a202020202020202020202020202020203c6872207374796c653d2273697a653a203170783b223e0a2020202020202020202020203c2f6469763e0a0a20202020202020202020202020202020202020203c64697620636c6173733d22636f6e7461696e6572223e0a2020202020202020202020202020202043616c6c206f662044757479203a20426c61636b204f707320266e6273703b207c0a202020202020202020202020202020204172636164652c20416374696f6e2c2046505320266e6273703b207c0a20202020202020202020202020202020283220266e6273703b202a0a202020202020202020202020202020203139e282ac20266e6273703b29202d3e0a20202020202020202020202020202020333820e282ac0a202020202020202020202020202020203c62723e0a202020202020202020202020202020203c6872207374796c653d2273697a653a203170783b223e0a2020202020202020202020203c2f6469763e0a0a202020202020202020202020202020203c64697620636c6173733d22696e666f2d636c69656e74223e0a2020202020202020202020203c68333e496e666f726d6174696f6e20647520636c69656e74203a3c2f68333e3c62723e0a2020202020202020202020203c703e3c623e4164726573736520656d61696c203c2f623e203a2066696775657265732e61647269656e40676d61696c2e636f6d3c2f703e0a2020202020202020202020203c703e3c623e4e6f6d203c2f623e203a204649475545524553203c2f703e0a2020202020202020202020203c703e3c623e5072c3a96e6f6d203c2f623e203a2041647269656e3c2f703e0a2020202020202020202020203c703e3c623e4e756dc3a9726f2064652074c3a96cc3a970686f6e6520203c2f623e3a20303632363234363030363c2f703e0a20202020202020203c2f6469763e0a0a20202020202020203c68313e546f74616c206465206c612066616374757265203a20373720e282ac20286c652031342d30352d323032312030363a32303c2f68313e0a202020203c2f626f64793e0a3c2f68746d6c3e0a);

-- --------------------------------------------------------

--
-- Structure de la table `inclure`
--

CREATE TABLE `inclure` (
  `id` int(11) NOT NULL,
  `idProduit` int(11) DEFAULT NULL,
  `id_panier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inclure`
--

INSERT INTO `inclure` (`id`, `idProduit`, `id_panier`) VALUES
(23, 25, 39),
(24, 30, 39);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id` int(11) NOT NULL,
  `Id_Produit` int(11) DEFAULT NULL,
  `Id_commande` int(11) DEFAULT NULL,
  `qte` double DEFAULT NULL,
  `tarif` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `Id_Produit`, `Id_commande`, `qte`, `tarif`) VALUES
(46, 25, 163, 1, 38),
(47, 30, 163, 2, 38);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `Moyenne_Jeu`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `Moyenne_Jeu` (
`Note_Jeu` decimal(12,2)
,`nom produit` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `qte` int(11) DEFAULT NULL,
  `Id_Client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `qte`, `Id_Client`) VALUES
(39, 2, 29);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `nom_produit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_produit` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `libelle` text COLLATE utf8mb4_unicode_ci,
  `date_apparition` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Id_Categorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `nom_produit`, `tarif_produit`, `stock`, `libelle`, `date_apparition`, `image`, `Id_Categorie`) VALUES
(24, 'Call of duty : Modern Warfare 3', 14, 0, 'Arcade, Action, FPS', '2021-04-12 16:43:00', '2021-04-12_3839-call-duty-modern-warfare-3.jpg', 3),
(25, 'Grand Theft Auto V', 39, 60, 'Action, Open World, Populaire', '2021-04-12 16:43:00', '2021-04-12_4211.jpg', 3),
(26, 'Asseto Corsa Competizione', 59, 95, 'Simulation, Course Automobile', '2021-04-12 16:44:00', '2021-04-12_assetto-corsa-competizione-cover.jpg', 3),
(27, 'Asseto Corsa : Ultimate Edition', 19, 99, 'Simulation, Course Automobile', '2021-04-12 16:44:00', '2021-04-12_assetto-corsa-ultimate-edition-cover.jpg', 3),
(28, 'Call of duty : World At War', 29, 99, 'Arcade, Action, FPS', '2021-04-12 16:45:00', '2021-04-12_C17x+5ruxQS._AC_.jpg', 3),
(29, 'Call of duty 4 : Modern Warfare', 9, 86, 'Arcade, Action, FPS', '2021-04-12 16:45:00', '2021-04-12_call-of-duty-4-modern-warfare-cover.jpg', 3),
(30, 'Call of Duty : Black Ops', 19, 97, 'Arcade, Action, FPS', '2021-04-12 16:46:00', '2021-04-12_call-of-duty-black-ops-cover.jpg', 3),
(31, 'Call of duty : Ghost', 9, 99, 'Arcade, Action, FPS', '2021-04-12 16:46:00', '2021-04-12_call-of-duty-ghosts-cover.jpg', 3),
(32, 'Call of duty : Modern Warfare 2', 19, 99, 'Arcade, Action, FPS', '2021-04-12 16:46:00', '2021-04-12_call-of-duty-modern-warfare-2-cover.jpg', 3),
(33, 'Call of duty : Black Ops 3', 39, 99, 'Arcade, Action, FPS', '2021-04-12 16:47:00', '2021-04-12_cc9d87a13467050cb3669b7c59c307a3_350x200_1x-0.jpg', 3),
(34, 'Dark Souls 3', 15, 99, 'Fantaisie, Hardcore, Survie', '2021-04-12 16:47:00', '2021-04-12_dark-souls-3-cover.jpg', 3),
(35, 'Dark Souls : Remastered', 29, 99, 'Fantaisie, Hardcore, Survie', '2021-04-12 16:48:00', '2021-04-12_dark-souls-remastered-cover.jpg', 3),
(36, 'Dirt Rally 2.0', 29, 99, 'Simulation, Course Automobile', '2021-04-12 16:48:00', '2021-04-12_dirt-rally-20-game-of-the-year-edition-cover.jpg', 3),
(37, 'Euro Truck Simulator 2', 5, 99, 'Simulation, Camion, Route, Gestion', '2021-04-12 16:48:00', '2021-04-12_euro-truck-simulator-2-cover.jpg', 3),
(38, 'Forza Horizon 4', 59, 99, 'Simulation, Course Automobile', '2021-04-12 16:49:00', '2021-04-12_forza-horizon-4-pc-xbox-one-cover.jpg', 6),
(39, 'Gears Of War 5', 59, 99, 'Arcade, Action, FPS', '2021-04-12 16:49:00', '2021-04-12_gears-5-pc-xbox-one-cover.jpg', 6),
(40, 'Gran Turismo Sport', 59, 99, 'Simulation, Course Automobile', '2021-04-12 16:50:00', '2021-04-12_gt-sport-jaquette.jpg', 5),
(41, 'Dark Souls 2', 19, 99, 'Fantaisie, Hardcore, Survie', '2021-04-12 16:50:00', '2021-04-12_jaquette-dark-souls-ii-pc-cover-avant-g-1368565343.jpg', 3),
(42, 'Call of Duty : Black Ops 2', 15, 99, 'Arcade, Action, FPS', '2021-04-12 16:50:00', '2021-04-12_l1tJkUk_350x200_1x-0.jpg', 3),
(43, 'Minecraft : Xbox one edition', 28, 99, 'Bac a sable, OpenWorld, Multijoueur', '2021-04-12 16:51:00', '2021-04-12_minecraft-cover.jpg', 6),
(44, 'Project Cars 2', 19, 99, 'Simulation, Course Automobile', '2021-04-12 16:51:00', '2021-04-12_project-cars-2-cover.jpg', 3),
(45, 'Project Cars 3', 29, 99, 'Simulation, Course Automobile', '2021-04-12 16:52:00', '2021-04-12_project-cars-3-cover.jpg', 3),
(46, 'Project Cars', 9, 99, 'Simulation, Course Automobile', '2021-04-12 16:52:00', '2021-04-12_project-cars-cover.jpg', 3),
(47, 'Sea of Thieves', 29, 99, 'Action, Open World, Pirate', '2021-04-12 16:53:00', '2021-04-12_sea-of-thieves-pc-xbox-one-cover.jpg', 6),
(48, 'Uncharted 1', 5, 99, 'Aventure, Action, TPS', '2021-04-12 16:53:00', '2021-04-12_Uncharted_1_capa.png', 5),
(49, 'Uncharted 2', 15, 99, 'Arcade, Action, TPS', '2021-04-12 16:54:00', '2021-04-12_Uncharted_2_Among_Thieves.jpg', 5),
(50, 'Uncharted 3', 19, 99, 'Aventure, Action, TPS', '2021-04-12 16:54:00', '2021-04-12_Uncharted_3_L\'Illusion_de_Drake.jpg', 5),
(51, 'Uncharted 4', 29, 99, 'Aventure, Action, TPS', '2021-04-12 16:54:00', '2021-04-12_Uncharted.jpg', 5),
(52, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(53, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(54, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(55, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(56, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(57, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(58, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(59, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:50:00', '2021-04-12_Uncharted_1_capa.png', 4),
(89, 'Uncharted 1', 89, 99, 'Sort prochainement', '2021-06-09 10:51:00', '2021-04-12_Uncharted_1_capa.png', 4);

-- --------------------------------------------------------

--
-- Structure de la vue `commande_dun_client`
--
DROP TABLE IF EXISTS `commande_dun_client`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `commande_dun_client`  AS SELECT `p`.`image` AS `image`, `p`.`nom_produit` AS `nom_produit`, `lc`.`qte` AS `qte`, `p`.`tarif_produit` AS `tarif_produit`, `c`.`date_commande` AS `date_commande`, `c`.`montant_total` AS `montant_total` FROM (((`ligne_commande` `lc` join `commande` `c` on((`lc`.`Id_commande` = `c`.`id`))) join `produit` `p` on((`lc`.`Id_Produit` = `p`.`idProduit`))) join `client` `cl` on((`c`.`id_client_id` = `cl`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `Moyenne_Jeu`
--
DROP TABLE IF EXISTS `Moyenne_Jeu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `Moyenne_Jeu`  AS SELECT cast(avg(`cp`.`note_produit`) as decimal(12,2)) AS `Note_Jeu`, `p`.`nom_produit` AS `nom produit` FROM (`commentaire_produit` `cp` join `produit` `p` on((`cp`.`Id_Produit` = `p`.`idProduit`))) GROUP BY `p`.`idProduit` ORDER BY `Note_Jeu` DESC ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`Id_Categorie`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C7440455E7927C74` (`email`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67D99DED506` (`id_client_id`),
  ADD KEY `IDX_6EEAA67DA0FBF72C` (`Id_Facture`);

--
-- Index pour la table `commentaire_produit`
--
ALTER TABLE `commentaire_produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A6D7E74642E362D` (`Id_Client`),
  ADD KEY `IDX_5A6D7E7477D87F1B` (`Id_Produit`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`Id_Facture`);

--
-- Index pour la table `inclure`
--
ALTER TABLE `inclure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6C35D95C391C87D5` (`idProduit`),
  ADD KEY `IDX_6C35D95C2FBB81F` (`id_panier`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3170B74BB8ADC53F` (`Id_commande`),
  ADD KEY `IDX_3170B74B77D87F1B` (`Id_Produit`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24CC0DF2642E362D` (`Id_Client`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`),
  ADD KEY `IDX_29A5EC2753883348` (`Id_Categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `Id_Categorie` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT pour la table `commentaire_produit`
--
ALTER TABLE `commentaire_produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `Id_Facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT pour la table `inclure`
--
ALTER TABLE `inclure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67D99DED506` FOREIGN KEY (`id_client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6EEAA67DA0FBF72C` FOREIGN KEY (`Id_Facture`) REFERENCES `facture` (`Id_Facture`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire_produit`
--
ALTER TABLE `commentaire_produit`
  ADD CONSTRAINT `FK_5A6D7E74642E362D` FOREIGN KEY (`Id_Client`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_5A6D7E7477D87F1B` FOREIGN KEY (`Id_Produit`) REFERENCES `produit` (`idProduit`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inclure`
--
ALTER TABLE `inclure`
  ADD CONSTRAINT `FK_6C35D95C2FBB81F` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `FK_6C35D95C391C87D5` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `FK_3170B74B77D87F1B` FOREIGN KEY (`Id_Produit`) REFERENCES `produit` (`idProduit`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3170B74BB8ADC53F` FOREIGN KEY (`Id_commande`) REFERENCES `commande` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF2642E362D` FOREIGN KEY (`Id_Client`) REFERENCES `client` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC2753883348` FOREIGN KEY (`Id_Categorie`) REFERENCES `categorie` (`Id_Categorie`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
