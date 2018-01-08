-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 08. led 2018, 06:33
-- Verze serveru: 5.7.17
-- Verze PHP: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Databáze: `web`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `viteja_web_posts`
--

DROP TABLE IF EXISTS `viteja_web_posts`;
CREATE TABLE `viteja_web_posts` (
  `post` int(64) UNSIGNED NOT NULL COMMENT 'Identifikace příspěcvku',
  `author` int(64) UNSIGNED NOT NULL COMMENT 'FK: ID autora',
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Název příspěvku',
  `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Text příspěvku',
  `state` set('review','rejected','approved','deleted') COLLATE utf8mb4_czech_ci NOT NULL DEFAULT 'review' COMMENT 'Stav příspěvku',
  `published` datetime DEFAULT NULL COMMENT 'Datum a čas schválená'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `viteja_web_posts`
--

INSERT INTO `viteja_web_posts` (`post`, `author`, `title`, `text`, `state`, `published`) VALUES
(1, 1, 'První příspěvek', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ullamcorper suscipit metus in ullamcorper. Pellentesque et quam a quam lobortis auctor non aliquam augue. Aenean ac rhoncus arcu. Donec feugiat, mi vitae commodo placerat, nunc augue elementum elit, lobortis tempus dui tellus vel arcu. Nullam interdum, orci ac blandit venenatis, lorem purus consectetur massa, et scelerisque sapien lectus id nunc. Phasellus id ultricies dui, ut laoreet diam. Ut venenatis, orci non feugiat hendrerit, magna magna placerat nulla, ac suscipit nulla dui rhoncus urna. Quisque vulputate tincidunt arcu in iaculis. Mauris suscipit, ipsum sodales volutpat congue, diam nisl posuere erat, eget feugiat turpis eros porta tellus. Nulla auctor dolor in aliquet posuere. Duis eget nisi vitae tellus commodo tincidunt iaculis quis massa. Nam sollicitudin, massa eu elementum consectetur, enim augue lacinia elit, nec auctor augue quam at lectus. Maecenas velit lorem, malesuada vel ex vel, consectetur feugiat nunc. Donec eget faucibus eros. Sed sollicitudin neque ultrices tristique gravida. Aenean urna lorem, sagittis a quam at, tincidunt consequat tellus.', 'approved', '2018-01-08 06:27:32'),
(2, 5, 'Mauris', 'Mauris suscipit, ipsum sodales volutpat congue, diam nisl posuere erat, eget feugiat turpis eros porta tellus. Nulla auctor dolor in aliquet posuere. Duis eget nisi vitae tellus commodo tincidunt iaculis quis massa. Nam sollicitudin, massa eu elementum consectetur, enim augue lacinia elit, nec auctor augue quam at lectus. Maecenas velit lorem, malesuada vel ex vel, consectetur feugiat nunc. Donec eget faucibus eros. Sed sollicitudin neque ultrices tristique gravida. Aenean urna lorem, sagittis a quam at, tincidunt consequat tellus.', 'review', NULL),
(3, 5, 'Donec', 'Donec pretium tincidunt fermentum. Ut interdum a enim a efficitur. Sed id rhoncus libero, in tristique est. Proin aliquet hendrerit viverra. Fusce sed libero nec ipsum eleifend venenatis. Nunc non laoreet ipsum. Nulla mauris turpis, malesuada sed justo in, viverra hendrerit erat.', 'review', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `viteja_web_posts_files`
--

DROP TABLE IF EXISTS `viteja_web_posts_files`;
CREATE TABLE `viteja_web_posts_files` (
  `post` int(64) UNSIGNED NOT NULL,
  `filename` varchar(256) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `viteja_web_posts_files`
--

INSERT INTO `viteja_web_posts_files` (`post`, `filename`) VALUES
(1, '1-08-01-2018-06-14-26-profile-image.jpg'),
(1, '1-08-01-2018-06-14-26-text.txt'),
(2, '5-08-01-2018-06-18-51-textura-světlost-odbarvena.png');

-- --------------------------------------------------------

--
-- Struktura tabulky `viteja_web_reviews`
--

DROP TABLE IF EXISTS `viteja_web_reviews`;
CREATE TABLE `viteja_web_reviews` (
  `review` int(64) UNSIGNED NOT NULL COMMENT 'ID recenze',
  `post` int(64) UNSIGNED NOT NULL COMMENT 'ID příspěvku',
  `reviewer` int(64) UNSIGNED NOT NULL COMMENT 'ID recenzenta',
  `originality` set('1','2','3','4','5','') CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '' COMMENT 'hodnocení originality',
  `subject` set('1','2','3','4','5','') CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '' COMMENT 'hodnocení tématu',
  `technical` set('1','2','3','4','5','') CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '' COMMENT 'hodnocení technické stránky',
  `language` set('1','2','3','4','5','') CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL DEFAULT '' COMMENT 'hodnocení jazykové kvality',
  `note` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `viteja_web_reviews`
--

INSERT INTO `viteja_web_reviews` (`review`, `post`, `reviewer`, `originality`, `subject`, `technical`, `language`, `note`, `deleted`, `time`) VALUES
(1, 1, 2, '', '', '', '', '', 0, '2018-01-08 05:25:13.867947'),
(2, 1, 3, '', '', '', '', '', 0, '2018-01-08 05:25:17.972272'),
(3, 1, 4, '1', '1', '1', '4', '', 0, '2018-01-08 05:25:20.716003');

-- --------------------------------------------------------

--
-- Struktura tabulky `viteja_web_users`
--

DROP TABLE IF EXISTS `viteja_web_users`;
CREATE TABLE `viteja_web_users` (
  `user` int(64) UNSIGNED NOT NULL COMMENT 'Identifikace uživatele',
  `name` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Přihlašovací jméno uživatele',
  `password` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'Heslo uživatele',
  `email` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL COMMENT 'E-mail uživatele',
  `account` int(11) NOT NULL COMMENT 'Typ účtu (0 = Autor, 1 = Recenzent, 2= Admin)',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `viteja_web_users`
--

INSERT INTO `viteja_web_users` (`user`, `name`, `password`, `email`, `account`, `blocked`, `deleted`) VALUES
(1, 'Sognus', '$2y$12$mKCD88mxg5OPcE/cS/Ipp.2A3Echz4pQNV8AIjMjBL2GfvLi6FsVe', 'msognus@gmail.com', 2, 0, 0),
(2, 'Novak', '$2y$12$z4sX8vC0WhGNSABc.ZV.EeplarHB2OqhBRIkWrBvawYMbb.t18tXW', 'marty@server.cz', 1, 0, 0),
(3, 'Zeleny', '$2y$12$2P6PpW1lHuLTCEO.E/ilEe0p.FzveBDiEJ7lhOMblqeRN6eJ3cgH2', 'zeleny@server.cz', 1, 0, 0),
(4, 'Cervenka', '$2y$12$AwHZfRbSqBPUxzmi.9ABLeUe4iwpXqnFlLExUxToWlEFxlI8Mjjj.', 'cervenka@server.cz', 1, 0, 0),
(5, 'Taras', '$2y$12$R68PR2zjS74S7jeTPkUMvO0orvjrtuuBQB4OtmfTw1EKZIxdaz2wO', 'taras@server.cz', 0, 0, 0);

--
-- Pohled `viteja_web_users_alias`
--

CREATE VIEW `viteja_web_users_alias` AS
SELECT * FROM viteja_web_users;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `viteja_web_posts`
--
ALTER TABLE `viteja_web_posts`
  ADD PRIMARY KEY (`post`);

--
-- Klíče pro tabulku `viteja_web_posts_files`
--
ALTER TABLE `viteja_web_posts_files`
  ADD UNIQUE KEY `post` (`post`,`filename`);

--
-- Klíče pro tabulku `viteja_web_reviews`
--
ALTER TABLE `viteja_web_reviews`
  ADD PRIMARY KEY (`review`,`post`,`reviewer`) USING BTREE,
  ADD UNIQUE KEY `post` (`post`,`reviewer`,`deleted`,`time`);

--
-- Klíče pro tabulku `viteja_web_users`
--
ALTER TABLE `viteja_web_users`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `viteja_web_posts`
--
ALTER TABLE `viteja_web_posts`
  MODIFY `post` int(64) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifikace příspěcvku', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `viteja_web_reviews`
--
ALTER TABLE `viteja_web_reviews`
  MODIFY `review` int(64) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID recenze', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `viteja_web_users`
--
ALTER TABLE `viteja_web_users`
  MODIFY `user` int(64) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifikace uživatele', AUTO_INCREMENT=6;COMMIT;
