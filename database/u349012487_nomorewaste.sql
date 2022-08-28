-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 28 août 2022 à 19:03
-- Version du serveur : 10.5.16-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u349012487_nomorewaste`
--

-- --------------------------------------------------------

--
-- Structure de la table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siren` char(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee_creation` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_telephone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `online` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `autorisation` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mail non valide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `organization`
--

INSERT INTO `organization` (`id`, `nom`, `siren`, `annee_creation`, `mail`, `mdp`, `numero_telephone`, `adresse`, `code_postal`, `ville`, `pays`, `check_mail`, `blocked`, `online`, `autorisation`) VALUES
(1, 'Jingle Jangle', '214536215', '2011', 'tidioukane44@yahoo.fr', '$2y$10$DC7zC66FCx3xI35Pymni.OGliKLHNyb9YgxM6D6pVO.aM1bnWuS62', '0325416959', '78bis rue garden', '13006', 'Marseille', 'France', '1', '0', '1', 'autorisee'),
(2, 'Resto Du Coeur', '124578351', '1985', 'restoducoeur85@gmail.com', '$2y$10$zHuqQwRzKDy0Ootp5LzLKO4sAFhws8PVUxD..VhPBV6OQgamh3asG', '0915482619', '5 rue carnot', '27000', 'Evreux', 'France', 'ff22f21003b263a405170a53b76ddf93', '0', '0', 'mail non valide'),
(3, 'Testedit', '564785236', '2022', 'testeditp@jl.com', '$2y$10$mAxMFagQX3dYCnII1NGrxeXebmKb/PoOrGsOgt6WKU0Qqwc6rvY6m', '0856217929', '56 rue leon blum', '63450', 'Gert', 'Angola', '67100581bef8883570e64a906ba353fc', '0', '0', 'autorisee');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `panier_origine` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_consommation` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acteur` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_acteur` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_benevole` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `quantite_total` int(11) NOT NULL,
  `date_transaction` datetime NOT NULL,
  `disponible` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `panier_origine`, `nom`, `description`, `etat`, `date_consommation`, `acteur`, `id_acteur`, `id_benevole`, `quantite_total`, `date_transaction`, `disponible`) VALUES
(1, '', 'PATISSERIE', '5 croissants, 2 pains au chocolats, 9 cookies', 'collecte', '2022-09-01', 'particulier', '3', '13', 16, '2022-08-27 00:00:00', 'expedie'),
(2, '', 'BONBONS', '3 tagada, 5 crocos', 'collecte', '2022-12-30', 'particulier', '3', '0', 8, '2022-08-27 00:00:00', 'traitement'),
(3, '', 'FRUITS & LéGUMES', '9 carottes, 11 aubergines, 8 pommes, 6 oranges', 'collecte', '2022-09-12', 'Association', '1', '13', 34, '2022-08-27 00:00:00', 'arrivee'),
(4, '', 'BOISSONS', '8 cocas, 10 fantas, 12 schweppes', 'collecte', '2023-12-30', 'Commerce', '1', '13', 30, '2022-08-27 14:38:19', 'arrivee'),
(5, '', 'PLAT SUSHI', '80 sushi, 50 sashimi', 'livraison', '2023-01-23', 'admin', '1', '10', 130, '0000-00-00 00:00:00', 'traitement'),
(6, '', 'PLAT VéGéTARIENS', '30 plateaux de couscous au veau à la sauce rouge', 'livraison', '2022-09-02', 'admin', '1', '13', 30, '2022-08-27 18:27:30', 'arrivee');

-- --------------------------------------------------------

--
-- Structure de la table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siren` char(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee_immatriculation` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_telephone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `online` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `autorisation` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mail non valide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `shop`
--

INSERT INTO `shop` (`id`, `nom`, `categorie`, `siren`, `annee_immatriculation`, `mail`, `mdp`, `numero_telephone`, `adresse`, `code_postal`, `ville`, `pays`, `check_mail`, `blocked`, `online`, `autorisation`) VALUES
(1, 'LE PANETON', 'BOULANGERIE', '123456789', '2016', 'shop@gmail.com', '$2y$10$.ZuWtF/DVN6UDUXnaprhNefu/O08V4aJLPACgOYJDKbAOPfRuVdV.', '0412789536', '123 rue guepard', '75009', 'Paris', 'France', '1', '0', '1', 'validee'),
(2, 'La Pate', 'Patisserie', '987654321', '2019', 'shop01@yahoo.com', '$2y$10$olWnbPKxLkINZN1OlUgH6O1jpBv5HYs.8mqqDPMkdq5Imk7BX8xFe', '0521786419', '54 rue zola', '75016', 'Paris', 'France', '6f78e2ad4e9a5fae4536363d94352f8d', '0', '0', 'refusee'),
(3, 'La Brebis', 'Epicerie', '720154385', '2021', 'shop02@aol.com', '$2y$10$VrL7qkmuZ2DPsZtFI4b4eOC8kaOZYt7y5R7MI/VCnIBwokQw7Wg42', '0124761837', '69 avenue versailles', '75015', 'Paris', 'France', '1251ffc25c90ff8f37135195f07ece63', '0', '0', 'autorisee'),
(4, 'TOP B', 'Charcuterie', '563217893', '2001', 'shopboucherie@gmail.com', '$2y$10$Efyx2ixfWb0BeSxWy5O9YuP.X8dCJWGKRQP402wOg6U4gVUKXrznC', '0543216738', '34 rue de paris', '75011', 'Paris', 'France', 'd09c756058316b3a7d079bb3aa7b8f6e', '0', '0', 'mail non valide'),
(5, 'Croissant De Lune', 'Patisserie', '897645261', '2005', 'crdelune05@yahoo.com', '$2y$10$9zB2QIi14CST8LrSHKzfTu52mlcHwGzqpKBhOiUzCwXsXYYUnEhCS', '0245782618', '49 rue montgomery', '76300', 'Sotteville Les Rouen', 'France', '3f9498906991764f2511f5bfb11024eb', '0', '0', 'mail non valide'),
(8, 'Terrytest', 'Epicerie', '534687921', '2020', 'gffdsg@aol.com', '$2y$10$0lyV/Jk90xpqiuV3fhsX0unWdPKrJoUKT79iOAVeXU304SpCRSveC', '0854123698', '108 rue gert', '45012', 'Ker', 'Andorre', '0c67e324ae326028b995901d90f799ba', '0', '0', 'autorisee');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `numero_telephone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non',
  `online` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `status`, `nom`, `prenom`, `mail`, `mdp`, `date_naissance`, `numero_telephone`, `adresse`, `code_postal`, `ville`, `pays`, `check_mail`, `blocked`, `online`) VALUES
(1, 'admin', 'KANE', 'Cheikh', 'cheikh.kane@nomorewaste.online', '$2y$10$xAfe2Mx6YPOnsp4VXSuW8u7QoS0GSf.EZklufWXzgG.Fj5DJwXHWG', '1996-06-18', '0652949018', '107B Avenue Ile de France', '27200', 'Vernon', 'France', '1', 'non', '0'),
(2, 'particulier', 'DIALLO', 'Aminata', 'a.sow90@yahoo.fr', '$2y$10$F9c8LLEzzbtTmX09d1qGweRIfA1gsTzn41u5PcUOv0R0kkGO1Mbom', '1998-08-12', '0646852389', 'Uyggjytg', '75012', 'Paris', 'France', '1', 'non', '0'),
(3, 'particulier', 'KANE', 'Tidiou', 'tidioukane@gmail.com', '$2y$10$iHEIgGr3k/L/.m0m1G2/Juee6aJdQhNrdtXzonaQTUI.wt74v0inG', '1998-06-18', '0612784593', '29 rue du rouy', '27950', 'Saint-marcel', 'France', '1', 'non', '1'),
(4, 'particulier', 'SULLY', 'Quentin', 'sully.quentin@orange.fr', '$2y$10$8wCYZbB3Sq9UxFrXb5WhW.xa4tZuwSeL2W7wS0UPUSN1O3OWUlktW', '1994-06-16', '0615483768', '37 avenue serge', '27620', 'Gasny', 'France', 'aa7d7da57dd35a0f69163fd8e8095ed6', 'non', '0'),
(9, 'particulier', 'LEPETIT', 'Tess', 'test@aol.com', '$2y$10$w3HHBhDQIptJmBzAhT824uN2BEcrTHNS.dyP10UdEefxbXKmVef8O', '1999-08-15', '0652187963', '234 rue vernane', '63600', 'Rivelyoon', 'France', '48e7264fca71f20a6943cc98faf4191d', 'non', '0'),
(10, 'benevole', 'GASPARD', 'Ben', 'ben@aol.com', '$2y$10$AaWLQvl5ApWvEAuYZ0lLxevXmtRsVEE/naMfvkpAdpX/.0/pbqYQ2', '2001-05-18', '0715894623', '132 rue rayard', '75017', 'Berlin', 'Allemagne', '1', 'non', '1'),
(13, 'benevole', 'SOLO', 'Ben', 'ben@gmail.com', '$2y$10$mOiT4kxwlBUcnb6D2ZD9FeURzlpdXPPq.4RHV8Ff3.VPGks7DtKHK', '1970-06-15', '0615487913', '25 rue blondin', '75011', 'Paris', 'France', '1', 'non', '1');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
