-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 08 Juin 2017 à 10:33
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `testw2l`
--

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'create'),
(2, 'edit'),
(3, 'delete'),
(4, 'show');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`, `user_id`, `post_id`) VALUES
(1, 'mon premier post', 'Contenu de mon premier post', '2017-06-08 11:50:25', 1, NULL),
(2, NULL, 'Je viens de répondre à ton premier post', '2017-06-08 11:50:25', 2, 1),
(3, 'Mon second post', 'Voici le contenu de mon second post', '2017-06-08 12:05:37', 4, NULL),
(4, 'Mon troisième post', 'Le contenu de mon troisième post', '2017-06-08 11:50:25', 4, NULL),
(5, NULL, 'Une réponse à mon troisième post', '2017-06-08 11:50:25', 5, 4),
(6, NULL, 'Une nouvelle réponse à mon troisième post', '2017-06-08 13:50:25', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `firstname`, `lastname`, `created_at`) VALUES
(1, 'toto', 'a3dcc01c895cb55e54bd7a19f7f0e82518673211', 'toto', 'toto', '2017-06-08 11:40:34'),
(2, 'tata', 'ddb061563c638c8cbe7a736163ac600ae0607b90', 'tata', 'tata', '2017-06-08 11:43:09'),
(3, 'titi', 'fcf27745ce4abf0ed110a7597b2e25f712d9667e', 'titi', 'titi', '2017-06-08 11:43:09'),
(4, 'tutu', '7b082d749020ec780a63f4a9509aea459b52b95f', 'tutu', 'tutu', '2017-06-08 11:43:09'),
(5, 'tete', '00e784225814e1e11b98f5872bc9796eae12424d', 'tete', 'tete', '2017-06-08 11:43:09');

-- --------------------------------------------------------

--
-- Structure de la table `users_has_permissions`
--

CREATE TABLE `users_has_permissions` (
  `users_id` int(11) NOT NULL,
  `permissions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users_has_permissions`
--

INSERT INTO `users_has_permissions` (`users_id`, `permissions_id`) VALUES
(1, 1),
(2, 1),
(5, 1),
(1, 2),
(3, 2),
(4, 2),
(5, 2),
(1, 3),
(4, 3),
(5, 3),
(1, 4),
(3, 4),
(5, 4);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_posts_users_idx` (`user_id`),
  ADD KEY `fk_posts_posts1_idx` (`post_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo_UNIQUE` (`pseudo`);

--
-- Index pour la table `users_has_permissions`
--
ALTER TABLE `users_has_permissions`
  ADD PRIMARY KEY (`users_id`,`permissions_id`),
  ADD KEY `fk_users_has_permissions_permissions1_idx` (`permissions_id`),
  ADD KEY `fk_users_has_permissions_users1_idx` (`users_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `users_has_permissions`
--
ALTER TABLE `users_has_permissions`
  ADD CONSTRAINT `fk_users_has_permissions_permissions1` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_permissions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
