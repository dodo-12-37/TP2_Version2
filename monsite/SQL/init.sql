-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

--
-- Base de données : tp2_media_web
--
-- DROP DATABASE IF EXISTS tp2_media_web;
CREATE DATABASE if not exists tp2_media_web;
USE tp2_media_web;
-- --------------------------------------------------------


--
-- Structure de la table genre                           OK
--

--DROP TABLE IF EXISTS genre;
CREATE TABLE IF NOT EXISTS genre (
  id_genre int NOT NULL AUTO_INCREMENT,
  description varchar(45) NOT NULL,
  PRIMARY KEY (id_genre)
) ENGINE=InnoDB;


--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id_genre`, `description`) VALUES
(1, 'POP'),
(2, 'Country'),
(3, 'Flamenco'),
(4, 'Hard rock'),
(5, 'Disco'),
(6, 'Rock'),
(7, 'Métal'),
(8, 'Jazz'),
(9, 'Classique'),
(10, 'Rap'),
(11, 'Oriental'),
(12, 'Chanson française'),
(13, 'Rai'),
(14, 'Traditionnel'),
(15, 'Autre');
-- SELECT * FROM GENRE;


--
-- Structure de la table roles                           OK
--

--DROP TABLE IF EXISTS roles;
CREATE TABLE IF NOT EXISTS roles (
  id_role tinyint UNSIGNED NOT NULL AUTO_INCREMENT,
  description varchar(30) NOT NULL,
  PRIMARY KEY (id_role)
) ENGINE=InnoDB;

--
-- Déchargement des données de la table roles
--

INSERT INTO roles (id_role, description) VALUES
(1, 'Chanteur'),
(2, 'Compositeur'),
(3, 'Interprète'),
(4, 'Auteur'),
(10, 'Autre');




--
-- Structure de la table continent                           OK
--

--DROP TABLE IF EXISTS continent;
CREATE TABLE IF NOT EXISTS continent (
  id_continent tinyint UNSIGNED NOT NULL,
  nom_continent varchar(45) NOT NULL,
  PRIMARY KEY (id_continent)
) ENGINE=InnoDB;

--
-- Déchargement des données de la table continent
--

INSERT INTO continent (id_continent, nom_continent) VALUES
(1, 'Europe'),
(2, 'Amérique du Nord'),
(3, 'Asie'),
(4, 'Amérique du Sud'),
(5, 'Afrique'),
(6, 'Océanie');

-- --------------------------------------------------------

--
-- Structure de la table pays                           OK
--

--DROP TABLE IF EXISTS pays;
CREATE TABLE IF NOT EXISTS pays (
  id_pays int NOT NULL AUTO_INCREMENT,
  nom_pays varchar(30) NOT NULL,
  code_monnaie varchar(3) NOT NULL,
  taux decimal(9,2) NOT NULL DEFAULT '1.00',
  id_continent tinyint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (id_pays),
  UNIQUE KEY nom_pays (nom_pays),
  KEY fk_pays_continent (id_continent),
  CONSTRAINT fk_pays_continent FOREIGN KEY (id_continent) REFERENCES continent (id_continent) 
) ENGINE=InnoDB;

--
-- Déchargement des données de la table pays
--

INSERT INTO pays (id_pays, nom_pays, code_monnaie, taux, id_continent) VALUES
(1, 'Canada', 'CAD', '1.00', 2),
(2, 'Etats-Unis', 'USD', '0.78', 2),
(3, 'France', 'EUR', '0.69', 1),
(4, 'Suisse', 'CHF', '0.72', 1),
(7, 'Italie', 'EUR', '0.69', 1),
(12, 'Turquie', 'TRY', '10.80', 3),
(13, 'Liban', 'LBP', '15000.00', 3),
(14, 'Algerie', 'DZD', '11035.00', 5),
(15, 'Espagne', 'EUR', '0.69', 1),
(21, 'Maroc', 'MAD', '739.02', 5),
(23, 'Russie', 'RUB', '6173.00', 1),
(24, 'Chine', 'CNY', '495.60', 3);

-- SELECT * FROM pays;
-- --------------------------------------------------------
--
-- Table structure for table `ville`                           OK
--
--DROP TABLE IF Exists ville;
CREATE TABLE IF NOT EXISTS `ville` (
  `id_ville` int NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(30) NOT NULL UNIQUE,
  id_pays int NOT NULL, 
  PRIMARY KEY (`id_ville`),
  KEY fk_ville_pays (id_pays),
  CONSTRAINT fk_ville_pays FOREIGN KEY (id_pays) REFERENCES pays (id_pays) 
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

INSERT INTO `ville` VALUES
(1,  'Montréal',1),
(2,  'Trois-Rivière',1),
(3,  'Québec',1),
(4,  'Toronto',1),
(5,  'Varennes',1),
(8,  'Laval',1),
(12, 'Lévis',1),
(13, 'Winnipeg',1),
(14, 'Victoria',1),
(15, 'Windsor',1),
(16, 'Kingston',1),
(17, 'Ottawa',1),
(18, 'London',1),
(20, 'Vancouver',1),
(21, 'Paris',3),
(22, 'Nice',3),
(23, 'Agen',3),
(24, 'Lille',3),
(26, 'Grenoble',3),
(32, 'New york',2),
(33, 'Washington',2),
(34, 'Los Angeles',2),
(35, 'Dallas',2),
(36, 'Davie',2),
(37, 'Miami',2),
(38, 'Springville',2),
(40, 'Boston',2),
(41, 'Fribourg',4),
(42, 'Lausanne',4),
(43, 'Zurich',4),
(44, 'Genève',4),
(48, 'Izmir',12),
(52, 'Istanbul',12),
(53, 'Bursa',12),
(54, 'Ankara',12),
(55, 'Rome',7),
(57, 'Milan',7),
(60, 'Venise',7),
(61, 'Beyrouth',13),
(62, 'Tripoli',13),
(63, 'Alger',14),
(64, 'Tlemcen',14),
(65, 'Madrid',15),
(66, 'Rabat',21),
(67, 'Oran',14),
(72, 'Marrakech',21),
(73, 'Casablanca',21),
(74, 'Moscou',23),
(75, 'Pékin',24),
(77, 'Shanghai',24),
(79, 'Saint-Pétersbourg',23);
-- SELECT * FROM ville;

--
-- Table structure for table `album` ------                           OK
--
--DROP TABLE IF EXISTS album;
CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `code_album` char(7) NOT NULL unique,
  `date_album` date DEFAULT NULL,
  `id_genre` int(11) NOT NULL,
  `pht_couvt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_album`),
  constraint chk_code_album check(code_album regexp '^[A-Z]{3}[0-9]{4}$'),
  KEY fk_genre_alb (id_genre),
  CONSTRAINT fk_genre_alb FOREIGN KEY (id_genre) REFERENCES genre (id_genre)  
) ENGINE=InnoDB;
  -- constraint chk_code_album check(regexp_like(code_album, '^[A-Z]{3}[0-9]{4}$')),

--
-- Déchargement des données de la table album
--

INSERT INTO album (id_album, titre, code_album, date_album, id_genre, pht_couvt) VALUES
(1, 'Design Your Universe', 'DYU1245', '2009-10-09', 7, 'album1.jpeg'),
(2, 'Taylor Swift', 'TSW0011', '2006-10-24', 1, 'album2.jpeg'),
(3, 'Entre Deux Rêves', 'EDR2100', '1967-11-14', 12, 'album3.jpg'),
(4, 'Legend', 'LGD0010', '1984-05-08', 15, 'album4.jpeg'),
(5, 'UltraViolence', 'UAV0147', '2014-06-13', 6, 'album5.jpeg'),
(6, 'Speak Now', 'SNW1111', '2010-10-25', 1, 'album6.jpeg'),
(7, 'Be the Cowboy', 'BEC1258', '2018-08-17', 6, 'album7.jpeg'),
(8, 'Thriller', 'TER1456', '1982-11-30', 1, 'album8.jpeg'),
(9, 'Reckless', 'RKS1260', '1984-11-05', 6, 'album9.jpg'),
(10, 'Norman Fucking Rockwell!', 'NFR1466', '2019-08-30', 1, 'album10.jpeg'),
(11, 'Born To Die', 'BTD2012', '2012-01-27', 1, 'album11.jpeg'),
(12, 'Kind of Blue', 'KOB1959', '1959-08-17', 15, 'album12.jpg'),
(13, 'Against the Wind', 'ATW1980', '1980-02-25', 6, 'album13.jpeg'),
(14, 'A Star Is Born (Soundtrack)', 'SIB2018', '2018-10-05', 15, 'album14.jpeg'),
(15, 'My Everything', 'MEG2014', '2014-08-25', 1, 'album15.jpeg'),
(16, 'Sahra', 'SAH1996', '1996-11-08', 13, 'album16.jpg');

-- select * from album;
-- --------------------------------------------------------

--
-- Structure de la table artiste                           OK
--

--DROP TABLE IF EXISTS artiste;
CREATE TABLE IF NOT EXISTS `artiste` (
  `id_artiste` int unsigned NOT NULL AUTO_INCREMENT,
  `nom_artiste` varchar(45) NOT NULL unique,
  `pht_artiste` VARCHAR(100) NULL DEFAULT NULL,
  `id_ville` int not NULL,
  PRIMARY KEY (`id_artiste`),  
  CONSTRAINT fk_artiste_ville FOREIGN KEY (id_ville) REFERENCES ville(id_ville)
  
) ENGINE=InnoDB;

--
-- Déchargement des données de la table artiste
--

INSERT INTO artiste (id_artiste, nom_artiste, pht_artiste, id_ville) VALUES
(1, 'Epica', 'Epica.png', 65),
(2, 'Taylor Swift', 'Taylor.jpg', 21),
(3, 'Charles Aznavour', 'charles.jpg', 21),
(4, 'Bob Marley', NULL, 18),
(5, 'Lana Del Rey', NULL, 36),
(6, 'Mitski', NULL, 35),
(7, 'Michael Jackson', NULL, 38),
(8, 'Bryan Adams', NULL, 16),
(9, 'Miles Davis', NULL, 32),
(10, 'Bob Seger', NULL, 43),
(11, 'Lady Gaga', NULL, 32),
(12, 'Ariana Grande', NULL, 34),
(13, 'Khaled', NULL, 21);

-- select * from artiste;
-- --------------------------------------------------------

--
-- Structure de la table oeuvre
--

--DROP TABLE IF EXISTS oeuvre;
CREATE TABLE IF NOT EXISTS oeuvre (
  id_oeuvre int NOT NULL AUTO_INCREMENT,
  titre_oeuvre varchar(100) NOT NULL,
  id_artiste int UNSIGNED NOT NULL,
  id_role tinyint unsigned NOT NULL,
  dureesec int DEFAULT NULL,
  taillemb float DEFAULT NULL,
  lyrics longtext,
  date_ajout datetime DEFAULT CURRENT_TIMESTAMP,
  id_album int NOT NULL,
  prix int DEFAULT '1',
  PRIMARY KEY (`id_oeuvre`),
  CONSTRAINT fk_oeuvre_alb FOREIGN KEY (id_album) REFERENCES album (id_album),
  CONSTRAINT fk_oeuvre_art FOREIGN KEY (id_artiste) REFERENCES artiste (id_artiste),
  CONSTRAINT fk_oeuvre_role FOREIGN KEY (id_role) REFERENCES roles (id_role)  
) ENGINE=InnoDB;


  --UNIQUE KEY `id_oeuvre` (`id_oeuvre`),
  --KEY fk_oeuvre_alb (id_album),
  --KEY fk_oeuvre_art (id_artiste),
  --KEY fk_oeuvre_role (id_role),
--
-- Déchargement des données de la table oeuvre
--

INSERT INTO oeuvre (id_oeuvre, titre_oeuvre, id_artiste, dureesec, taillemb, lyrics, date_ajout, id_album, prix, id_role) VALUES
(1, 'Samadhi (Prelude)', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(2, 'Resign to Surrender', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(3, 'Unleashed', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(4, 'Martyr of the Free Word', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(5, 'Our Destiny', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(6, 'Kingdom of Heaven', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(7, 'The Price of Freedom', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(8, 'Burn to a Cinder', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(9, 'Tides of Time', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(10, 'Deconstruct', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(11, 'Semblance of Liberty', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(12, 'White Waters', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(13, 'Design Your Universe', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(14, 'Incentive', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(15, 'Unleashed 2', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),
(16, 'Nothing''s Wrong', 1, 153, 1.6, NULL, '2015-04-02 00:00:00', 1, 2, 1),

(17, 'Tim McGraw', 2, 273, 2.48, NULL, '2010-05-17 00:00:00', 2, 3,1),
(18, 'Picture to Burn', 2, 258, 2.35, NULL, '2010-05-14 00:00:00', 2, 5,1),
(19, 'Teardrops on My Guitar', 2, 271, 2.46, NULL, '2010-05-31 00:00:00', 2, 3,1),
(20, 'A Place in This World', 2, 226, 2.05, NULL, '2010-06-06 00:00:00', 2, 5,1),
(21, 'Cold as You', 2, 312, 2.84, NULL, '2010-05-19 00:00:00', 2, 2,1),
(22, 'The Outside', 2, 260, 2.36, NULL, '2010-06-07 00:00:00', 2, 2,2),
(23, 'Tied Together with a Smile', 2, 307, 2.79, NULL, '2010-05-27 00:00:00', 2, 4,2),
(24, 'Stay Beautiful', 2, 330, 3.1, NULL, '2010-06-07 00:00:00', 2, 5,1),
(25, 'Should''ve Said No', 2, 252, 2.29, NULL, '2010-05-22 00:00:00', 2, 6,2),
(26, 'Mary''s Song (Oh My My My)', 2, 278, 2.53, NULL, '2010-05-27 00:00:00', 2, 1,3),
(27, 'Our Song', 2, 250, 2.27, NULL, '2010-05-21 00:00:00', 2, 2,3),

(28, 'Emmenez-moi', 3, 368, 3.35, NULL, '2010-06-07 00:00:00', 3, 1,1),
(29, 'Éteins la lumière', 3, 178, 1.62, NULL, '2010-05-25 00:00:00', 3, 4,2),
(30, 'Adieu', 3, 148, 1.2, NULL, '2017-03-04 00:00:00', 3, 3,2),
(31, 'Un jour', 3, 244, 2.22, NULL, '2014-06-06 00:00:00', 3, 6,1),
(32, 'Les vertes années', 3, 171, 1.55, NULL, '2014-06-13 00:00:00', 3, 4,1),
(33, 'Je reviens Fanny', 3, 229, 2.08, NULL, '2014-06-21 00:00:00', 3, 5,1),
(34, 'Yerushalaim', 3, 234, 2.13, NULL, '2014-06-20 00:00:00', 3, 5,2),
(35, 'Entre nous', 3, 220, 2, NULL, '2014-06-07 00:00:00', 3, 5,2),
(36, 'J''aimerais', 3, 204, 1.85, NULL, '2014-06-16 00:00:00', 3, 5,1),
(37, 'Il te faudra bien revenir', 3, 248, 2.25, NULL, '2014-06-14 00:00:00', 3, 6,1),
(38, 'Au voleur', 3, 237, 2.15, NULL, '2014-06-28 00:00:00', 3, 5,1),
(39, 'Tout s''en va', 3, 230, 2.09, NULL, '2014-06-27 00:00:00', 3, 5,1),

(40, 'Is This Love', 4, 228, 2.07, NULL, '2014-06-22 00:00:00', 4, 5,1),
(41, 'No Woman, No Cry', 4, 234, 2.13, NULL, '2014-07-04 00:00:00', 4, 5,1),
(42, 'Could You Be Loved', 4, 189, 1.72, NULL, '2014-06-14 00:00:00', 4, 4,1),
(43, 'Three Little Birds', 4, 222, 2.02, NULL, '2014-06-09 00:00:00', 4, 5,1),
(44, 'Buffalo Soldier', 4, 279, 2.54, NULL, '2014-06-18 00:00:00', 4, 6,1),
(45, 'Get Up, Stand Up', 4, 212, 1.93, NULL, '2014-07-02 00:00:00', 4, 5,1),
(46, 'Stir It Up', 4, 213, 1.94, NULL, '2014-07-04 00:00:00', 4, 5,1),
(47, 'One Love/People Get Ready', 4, 239, 2.17, NULL, '2014-07-05 00:00:00', 4, 5,1),
(48, 'I Shot the Sheriff', 4, 248, 2.25, NULL, '2014-06-26 00:00:00', 4, 6,1),
(49, 'Waiting in Vain', 4, 172, 1.56, NULL, '2014-07-04 00:00:00', 4, 4,1),
(50, 'Redemption Song', 4, 262, 2.38, NULL, '2013-07-09 00:00:00', 4, 6,1),
(51, 'Satisfy My Soul', 4, 209, 1.9, NULL, '2013-07-05 00:00:00', 4, 5,1),
(52, 'Exodus', 4, 220, 2, NULL, '2013-07-17 00:00:00', 4, 5,1),
(53, 'Jamming', 4, 264, 2.4, NULL, '2013-08-04 00:00:00', 4, 6,1),

(54, 'Cruel World', 5, 248, 2.25, NULL, '2013-08-04 00:00:00', 5, 6,1),
(55, 'Ultraviolence', 5, 283, 2.57, NULL, '2013-07-11 00:00:00', 5, 7,1),
(56, 'Shades of Cool', 5, 262, 2.38, NULL, '2013-07-09 00:00:00', 5, 6,1),
(57, 'Brooklyn Baby', 5, 261, 2.37, NULL, '2013-08-04 00:00:00', 5, 6,1),
(58, 'West Coast', 5, 269, 2.45, NULL, '2013-07-22 00:00:00', 5, 6,1),
(59, 'Sad Girl', 5, 240, 2.18, NULL, '2013-07-14 00:00:00', 5, 6,1),
(60, 'Pretty When You Cry', 5, 214, 1.95, NULL, '2013-07-15 00:00:00', 5, 5,1),
(61, 'Money Power Glory', 5, 209, 1.9, NULL, '2013-07-31 00:00:00', 5, 5,1),
(62, 'Fucked My Way Up to the Top', 5, 254, 2.31, NULL, '2013-07-26 00:00:00', 5, 6,1),
(63, 'Old Money', 5, 288, 2.62, NULL, '2013-07-16 00:00:00', 5, 7,1),
(64, 'The Other Woman', 5, 260, 4.2, NULL, '2018-07-15 00:00:00', 5, 6,1),

(65, 'Mine', 2, 300, 5.4, NULL, '2018-07-16 00:00:00', 6, 7,1),
(66, 'Sparks Fly', 2, 247, 4.02, NULL, '2018-09-15 00:00:00', 6, 6,1),
(67, 'Back to December', 2, 204, 3.4, NULL, '2018-09-16 00:00:00', 6, 5,1),
(68, 'Speak Now', 2, 290, 4.7, NULL, '2018-07-15 00:00:00', 6, 7,1),
(69, 'Dear John', 2, 295, 5.4, NULL, '2018-07-16 00:00:00', 6, 7,1),
(70, 'Mean', 2, 220, 3.12, NULL, '2018-09-15 00:00:00', 6, 5,1),
(71, 'The Story of Us', 2, 190, 3.4, NULL, '2018-09-16 00:00:00', 6, 4,1),
(72, 'Never Grow Up', 2, 175, 2.12, NULL, '2018-09-15 00:00:00', 6, 4,1),

(73, 'Geyser', 6, 193, 3.1, NULL, '2018-09-16 00:00:00', 7, 4,1),
(74, 'Why Didn''t You Stop Me?', 6, 193, 3.1, NULL, '2022-04-08 10:10:29', 7, 4,1),
(75, 'Old Friend', 6, 221, 3.5, NULL, '2022-04-08 10:10:29', 7, 5,1),
(76, 'A Pearl', 6, 234, 3.9, NULL, '2022-04-08 10:10:29', 7, 5,1),
(77, 'Lonesome Love', 6, 235, 3.91, NULL, '2022-04-08 10:10:29', 7, 5,1),
(78, 'Remember My Name', 6, 181, 3.01, NULL, '2022-04-08 10:10:29', 7, 4,1),
(79, 'Me and My Husband', 6, 291, 4.11, NULL, '2022-04-08 10:10:29', 7, 7,1),
(80, 'Come into the Water', 6, 211, 3.21, NULL, '2022-04-08 10:10:29', 7, 5,1),

(81, 'Wanna Be Startin'' Somethin''', 7, 210, 3.17, NULL, '2022-04-08 10:10:29', 8, 5,1),
(82, 'Baby Be Mine', 7, 202, 3.04, NULL, '2022-04-08 10:10:29', 8, 5,1),
(83, 'The Girl Is Mine', 7, 274, 3.45, NULL, '2022-04-08 10:10:29', 8, 6,1),
(100, 'Thriller', 7, 243, 3.25, NULL, '2022-04-08 10:10:29', 8, 6,1),
(101, 'Beat It', 7, 243, 3.25, NULL, '2022-04-08 10:10:29', 8, 6,1),
(102, 'Billie Jean', 7, 269, 3.35, NULL, '2022-04-08 10:10:29', 8, 6,1),
(103, 'Human Nature', 7, 342, 4.45, NULL, '2022-04-08 10:10:29', 8, 8,1),
(104, 'The Lady in My Life', 7, 304, 4.25, NULL, '2022-04-08 10:10:29', 8, 7,1),

(105, 'One Night Love Affair', 8, 210, 3.17, NULL, '2022-04-08 10:10:29', 9, 5,1),
(106, 'She''s Only Happy When She''s Dancin''', 8, 202, 3.04, NULL, '2022-04-08 10:10:29', 8, 5,1),
(107, 'Run to You', 8, 274, 3.45, NULL, '2022-04-08 10:10:29', 9, 6,1),
(108, 'Heaven', 8, 243, 3.25, NULL, '2022-04-08 10:10:29', 9, 6,1),
(109, 'Somebody', 8, 243, 3.25, NULL, '2022-04-08 10:10:29', 9, 6,1),
(110, 'Summer of ''69', 8, 269, 3.35, NULL, '2022-04-08 10:10:29', 9, 6,1),
(111, 'Kids Wanna Rock', 8, 342, 4.45, NULL, '2022-04-08 10:10:29', 9, 8,1),
(112, 'It''s Only Love', 8, 304, 4.25, NULL, '2022-04-08 10:10:29', 9, 7,1),

(113, 'Norman Fucking Rockwell', 5, 173, 2.25, NULL, '2022-04-08 10:10:29', 10, 4,1),
(114, 'Mariners Apartment Complex', 5, 280, 3.35, NULL, '2022-04-08 10:10:29', 10, 7,2),
(115, 'Venice Bitch', 5, 202, 3.04, NULL, '2022-04-08 10:10:29', 10, 5,1),
(116, 'Fuck It I Love You', 5, 274, 3.45, NULL, '2022-04-08 10:10:29', 10, 6,1),
(117, 'Doin'' Time', 5, 243, 3.25, NULL, '2022-04-08 10:10:29', 10, 6,1),
(118, 'Love Song', 5, 243, 3.25, NULL, '2022-04-08 10:10:29', 10, 6,1),
(119, 'Cinnamon Girl', 5, 269, 3.35, NULL, '2022-04-08 10:10:29', 10, 6,1),
(120, 'How to Disappear', 5, 342, 4.45, NULL, '2022-04-08 10:10:29', 10, 8,1),
(121, 'California', 5, 304, 4.25, NULL, '2022-04-08 10:10:29', 10, 7,1),

(122, 'Born to Die', 5, 210, 3.17, NULL, '2022-04-08 10:10:29', 11, 5,1),
(123, 'Off to the Races', 5, 202, 3.04, NULL, '2022-04-08 10:10:29', 11, 5,1),
(124, 'Blue Jeans', 5, 274, 3.45, NULL, '2022-04-08 10:10:29', 11, 6,1),
(125, 'Video Games', 5, 243, 3.25, NULL, '2022-04-08 10:10:29', 11, 6,1),
(126, 'Diet Mountain Dew', 5, 243, 3.25, NULL, '2022-04-08 10:10:29', 11, 6,1),
(127, 'National Anthem', 5, 269, 3.35, NULL, '2022-04-08 10:10:29', 11, 6,1),
(128, 'Dark Paradise', 5, 342, 4.45, NULL, '2022-04-08 10:10:29', 11, 8,1),
(129, 'Radio', 5, 304, 4.25, NULL, '2022-04-08 10:10:29', 11, 7,1),

(130, 'So What', 9, 210, 3.17, NULL, '2022-04-08 10:10:29', 12, 5,1),
(131, 'Freddie Freeloader', 9, 202, 3.04, NULL, '2022-04-08 10:10:29', 12, 5,1),
(132, 'Blue in Green', 9, 274, 3.45, NULL, '2022-04-08 10:10:29', 12, 6,1),
(133, 'All Blues', 9, 243, 3.25, NULL, '2022-04-08 10:10:29', 12, 6,1),
(134, 'Flamenco Sketches', 9, 243, 3.25, NULL, '2022-04-08 10:10:29', 12, 6,1),

(138, 'The Horizontal Bop', 10, 210, 3.17, NULL, '2022-04-08 10:10:29', 13, 5,1),
(139, 'You''ll Accomp''ny Me', 10, 202, 3.04, NULL, '2022-04-08 10:10:29', 13, 5,1),
(140, 'Her Strut', 10, 274, 3.45, NULL, '2022-04-08 10:10:29', 13, 6,1),
(141, 'No Man''s Land', 10, 243, 3.25, NULL, '2022-04-08 10:10:29', 13, 6,1),
(142, 'Long Twin Silver Line', 10, 243, 3.25, NULL, '2022-04-08 10:10:29', 13, 6,1),
(143, 'Against the Wind', 10, 269, 3.35, NULL, '2022-04-08 10:10:29', 13, 6,1),
(144, 'Good for Me', 10, 342, 4.45, NULL, '2022-04-08 10:10:29', 13, 8,1),
(145, 'Fire Lake', 10, 304, 4.25, NULL, '2022-04-08 10:10:29', 13, 7,1),

(146, 'Black Eyes', 11, 210, 3.17, NULL, '2022-04-08 10:10:29', 14, 5,1),
(147, 'La Vie en rose', 11, 202, 3.04, NULL, '2022-04-08 10:10:29', 14, 5,1),
(148, 'Maybe It''s Time', 11, 274, 3.45, NULL, '2022-04-08 10:10:29', 14, 6,1),
(149, 'Out of Time', 11, 243, 3.25, NULL, '2022-04-08 10:10:29', 14, 6,1),
(150, 'Alibi', 11, 243, 3.25, NULL, '2022-04-08 10:10:29', 14, 6,1),
(151, 'Shallow', 11, 269, 3.35, NULL, '2022-04-08 10:10:29', 14, 6,1),
(152, 'Music to My Eyes', 11, 342, 4.45, NULL, '2022-04-08 10:10:29', 14, 8,1),
(153, 'Always Remember Us This Way', 11, 304, 4.25, NULL, '2022-04-08 10:10:29', 14, 7,1),

(154, 'Problem', 12, 210, 3.17, NULL, '2022-04-08 10:10:29', 15, 5,1),
(155, 'One Last Time', 12, 202, 3.04, NULL, '2022-04-08 10:10:29', 15, 5,1),
(156, 'Why Try', 12, 274, 3.45, NULL, '2022-04-08 10:10:29', 15, 6,1),
(157, 'Break Free', 12, 243, 3.25, NULL, '2022-04-08 10:10:29', 15, 6,1),
(158, 'Best Mistake', 12, 243, 3.25, NULL, '2022-04-08 10:10:29', 15, 6,1),
(160, 'Be My Baby', 12, 269, 3.35, NULL, '2022-04-08 10:10:29', 15, 6,1),
(161, 'Love Me Harder', 12, 342, 4.45, NULL, '2022-04-08 10:10:29', 15, 8,1),
(162, 'My Everything', 12, 304, 4.25, NULL, '2022-04-08 10:10:29', 15, 7,1),

(163, 'Sahra', 13, 210, 3.17, NULL, '2022-04-08 10:10:29', 16, 5,1),
(164, 'Oran Marseille', 13, 202, 3.04, NULL, '2022-04-08 10:10:29', 16, 5,1),
(165, 'Aïcha', 13, 274, 3.45, NULL, '2022-04-08 10:10:29', 16, 6,1),
(166, 'Lillah', 13, 243, 3.25, NULL, '2022-04-08 10:10:29', 16, 6,1),
(167, 'Ouelli El Darek', 13, 243, 3.25, NULL, '2022-04-08 10:10:29', 16, 6,1),
(168, 'Detni Essekra', 13, 269, 3.35, NULL, '2022-04-08 10:10:29', 16, 6,1),
(169, 'Walou Walou', 13, 342, 4.45, NULL, '2022-04-08 10:10:29', 16, 8,1),
(170, 'Ki Kounti', 13, 304, 4.25, NULL, '2022-04-08 10:10:29', 16, 7,1);
-- select * from oeuvre;
-- --------------------------------------------------------

--
-- Structure de la table utilisateur
--

--DROP TABLE IF EXISTS utilisateur;
CREATE TABLE utilisateur (
  id_utilisateur int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom varchar(45) NOT NULL,
  courriel varchar(100) NOT NULL UNIQUE,
  mot_passe varchar(75) NOT NULL,
  id_ville int NOT NULL,
  age int NULL,  
  constraint chk_courriel check(courriel regexp '^[[:alnum:]\\._]+@[[:alnum:]]+(\\.[[:alnum:]]{2}){0,1}\.[a-z]{2,3}$'),
  CONSTRAINT fk_utilisateur_ville FOREIGN KEY (id_ville) REFERENCES ville(id_ville)
) ENGINE=InnoDB;
-- CHECK (courriel REGEXP "^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$"),
  --constraint chk_courriel check(regexp_like(courriel, '^[[:alnum:]\\._]+@[[:alnum:]]+(\\.[[:alnum:]]{2}){0,1}\.[a-z]{2,3}$','i')),

/* Ceci est pour vous montrer les mots de passe avant le hashage.
INSERT INTO utilisateur (id_utilisateur, nom, mot_passe, courriel, age) VALUES
(1, 'ali', '123456', 'awdeali@gmail.com',44),
(2, 'jacob', 'asdfgh', 'jacob@gmail.com',30),
(3, 'mathieu', 'qwerty','math@hotmail.com',24),
(4, 'france', 'azerty','france@gmail.com',41),
(5, 'admin', 'admin1','admin@yahoo.ca',27);*/

--
-- Déchargement des données de la table utilisateur
--

INSERT INTO utilisateur (id_utilisateur, nom, courriel, mot_passe, id_ville, age) VALUES
(1, 'ali', 'awdeali@gmail.com', '$2y$10$XLzosaxUSVnBcBlWxmLdJuu8pFuL3VzQGkRFVWXXlJrJdmaMgBie6', 3, 44),
(2, 'jacob', 'jacob@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 1, 30),
(3, 'mathieu', 'math@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 32, 24),
(4, 'france', 'france@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 14, 41),
(5, 'admin', 'admin@yahoo.ca', '$2y$10$35vgM52yIeHBTkJefCXTSeF/.D.pwspopyx9YtI3hJI/MHv9iYgJ6', 3, 27),
(6, 'Pierre', 'pierre@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 13, 44),
(22, 'Gabriel', 'gab@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 1, 30),
(23, 'Francine', 'francine@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 21, 24),
(24, 'Samuelle', 'Sam1@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 65, 41),
(31, 'Alain', 'alain@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 3, 44),
(32, 'Alice', 'alice@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 44, 30),
(33, 'Mart', 'mart@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 54, 24),
(34, 'Jacques', 'jacq@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 43, 41),
(41, 'Pierre Francois', 'pief@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 13, 44),
(42, 'Marie', 'marie4@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 1, 30),
(43, 'Julie', 'julie@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 60, 24),
(44, 'James', 'james@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 75, 41),
(45, 'Alain', 'alainb@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 79, 44),
(46, 'Ela', 'ela2@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 55, 30),
(47, 'Martine', 'martine6@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 74, 24),
(48, 'Jacqueline', 'jacq985@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 75, 41),
(51, 'Pier', 'pier89@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 63, 44),
(52, 'Gabrielle', 'gab54@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 1, 30),
(53, 'Francine', 'francine87@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 21, 24),
(54, 'Samu', 'Sam169@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 60, 41),
(55, 'Ada', 'ada1234@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 61, 44),
(56, 'Aline', 'aline58@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 4, 30),
(57, 'Martine', 'mart258@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 12, 24),
(58, 'Jean', 'jean45@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 13, 41),
(59, 'Jean Francois', 'francois1@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 13, 44),
(60, 'Marie-Ann', 'ann23@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 33, 30),
(73, 'Joseane', 'jose56@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 35, 24),
(74, 'Jackie', 'jacki3@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 38, 41),
(75, 'Harry', 'harry3@gmail.com', '$2y$10$r/UN9n5f68nHEj.cmrKYZedVkkVwb.bPqglxbeUp3QWYegOqgd72q', 44, 44),
(76, 'Lea', 'lea1@gmail.com', '$2y$10$LTxTJNoE2rZ8FLsxN1q56Op0iT4WSyYWfKB0dVk7xeprAdPZIduP.', 21, 30),
(77, 'Bob', 'bob@hotmail.com', '$2y$10$3TnfMB4qvXQiSafeCSzakeNfbhqu3mff8y1WHbUw17FgAYvEuI1WS', 3, 24),
(78, 'Bily', 'bily@gmail.com', '$2y$10$5Y/OCXWajOXCIkj7WDgy7u4Fznu3BqaL4BlWn4FZzBiR1AEIVSFba', 32, 41),
(79, 'Qwerty', 'qwerty@hotmail.com', '$2y$10$XLzosaxUSVnBcBlWxmLdJuu8pFuL3VzQGkRFVWXXlJrJdmaMgBie6', 1, 37);

-- SELECT * FROM utilisateur;

--
-- Structure de la table commande
--

--DROP TABLE IF EXISTS commande;
CREATE TABLE IF NOT EXISTS commande (
	id_commande int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	id_utilisateur int NOT NULL , 
	date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
	etat_commande ENUM('En cours', 'Acceptée', 'Annulée', 'En livraison', 'Livrée') DEFAULT 'En cours',
	CONSTRAINT fk_tbl_cmd_tbl_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB ;

--
-- Déchargement des données de la table commande
--

INSERT INTO commande (id_commande, id_utilisateur, date_commande, etat_commande) VALUES
(1, 1, '2020-04-01 00:00:00', 'Acceptée'),
(2, 2, '2020-04-15 00:00:00', 'Livrée'),
(3, 1, '2020-07-24 00:00:00', 'Livrée'),
(4, 5, '2020-05-12 00:00:00', 'Livrée'),
(5, 2, '2020-08-10 00:00:00', 'Livrée'),
(6, 4, '2021-01-07 00:00:00', 'Annulée'),
(7, 1, '2020-11-21 00:00:00', 'Livrée'),
(8, 2, '2020-04-03 00:00:00', 'Livrée'),
(9, 1, '2020-09-18 00:00:00', 'Livrée'),
(10, 5, '2021-01-05 00:00:00', 'Livrée'),
(11, 55, '2020-12-15 00:00:00', 'Annulée'),
(12, 54, '2020-06-23 00:00:00', 'Livrée'),
(13, 51, '2020-09-24 00:00:00', 'Livrée'),
(14, 52, '2020-08-13 00:00:00', 'Livrée'),
(15, 41, '2020-10-02 00:00:00', 'Annulée'),
(16, 45, '2020-05-07 00:00:00', 'Livrée'),
(17, 43, '2020-05-08 00:00:00', 'Livrée'),
(18, 54, '2020-11-17 00:00:00', 'Annulée'),
(19, 1, '2021-01-19 00:00:00', 'Livrée'),
(20, 52, '2020-06-07 00:00:00', 'Annulée'),
(21, 75, '2020-05-16 00:00:00', 'Livrée'),
(22, 77, '2021-01-05 00:00:00', 'Livrée'),
(23, 33, '2020-08-22 00:00:00', 'Livrée'),
(24, 34, '2020-05-11 00:00:00', 'Livrée'),
(25, 23, '2020-06-22 00:00:00', 'Livrée'),
(26, 24, '2021-12-04 00:00:00', 'En livraison'),
(27, 1, '2022-01-19 00:00:00', 'Livrée'),
(28, 51, '2022-01-28 00:00:00', 'En livraison'),
(29, 42, '2022-02-03 00:00:00', 'En livraison'),
(30, 4, '2022-02-08 00:00:00', 'En livraison'),
(31, 33, '2022-01-07 00:00:00', 'En cours'),
(32, 44, '2022-01-16 00:00:00', 'En cours'),
(33, 57, '2022-01-17 00:00:00', 'En cours'),
(34, 24, '2022-01-17 00:00:00', 'En cours'),
(35, 60, '2022-01-18 00:00:00', 'En cours'),
(36, 54, '2022-01-18 00:00:00', 'En cours'),
(37, 34, '2022-01-19 00:00:00', 'En cours'),
(38, 74, '2022-02-02 00:00:00', 'En cours'),
(39, 55, '2022-02-06 00:00:00', 'En cours'),
(40, 24, '2022-02-07 00:00:00', 'En cours'),
(41, 5, '2022-02-11 00:00:00', 'En cours'),
(42, 34, '2022-02-17 00:00:00', 'En cours'),
(43, 74, '2022-02-17 00:00:00', 'En cours'),
(44, 31, '2022-02-20 00:00:00', 'En cours'),
(45, 55, '2022-02-20 00:00:00', 'En cours');

INSERT INTO commande (`id_utilisateur`) 
VALUES ( '1'),
( '22'),
( '23'),
( '52'),
( '3'),
( '54'),
( '47'),
( '74');
-- SELECT * FROM commande ORDER BY id_utilisateur,date_commande;
-- SELECT * FROM commande ORDER BY id_commande;
-- --------------------------------------------------------

--
-- Structure de la table ligne_commande
--

--DROP TABLE IF EXISTS ligne_commande;
CREATE TABLE IF NOT EXISTS ligne_commande (
  id_commande int NOT NULL,
  id_oeuvre int NOT NULL,
  Quantite tinyint unsigned DEFAULT 1,
  PRIMARY KEY (id_commande, id_oeuvre),
  CONSTRAINT fk_tbl_lgcmd_tbl_oeuvre FOREIGN KEY (id_oeuvre) REFERENCES oeuvre (id_oeuvre) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_tbl_lgcmd_tbl_cmd FOREIGN KEY (id_commande) REFERENCES commande (id_commande) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;

--
-- Déchargement des données de la table ligne_commande
--

INSERT INTO ligne_commande (id_commande, id_oeuvre, Quantite) VALUES
(1, 12, 4),
(1, 26, 2),
(1, 52, 1),
(1, 68, 2),
(2, 13, 3),
(2, 17, 1),
(2, 43, 2),
(2, 72, 6),
(3, 60, 7),
(4, 21, 7),
(4, 54, 4),
(5, 20, 9),
(5, 54, 9),
(6, 35, 9),
(6, 47, 9),
(7, 16, 8),
(7, 45, 11),
(7, 51, 9),
(8, 38, 1),
(8, 47, 4),
(8, 72, 4),
(9, 3, 10),
(9, 36, 6),
(9, 64, 7),
(10, 20, 2),
(10, 24, 2),
(10, 33, 11),
(10, 51, 3),
(11, 43, 11),
(11, 45, 10),
(11, 52, 3),
(12, 54, 6),
(12, 71, 3),
(12, 72, 1),
(12, 82, 6),
(13, 3, 7),
(13, 43, 10),
(14, 38, 7),
(14, 41, 9),
(15, 33, 3),
(15, 40, 7),
(15, 71, 1),
(16, 3, 2),
(16, 49, 2),
(16, 70, 8),
(17, 11, 1),
(17, 19, 1),
(17, 31, 6),
(17, 83, 7),
(18, 48, 1),
(19, 28, 3),
(19, 32, 9),
(19, 47, 7),
(20, 10, 9),
(20, 31, 7),
(20, 38, 9),
(20, 59, 1),
(21, 36, 6),
(22, 2, 1),
(22, 22, 5),
(22, 72, 2),
(23, 8, 8),
(24, 20, 4),
(24, 23, 7),
(24, 25, 3),
(24, 28, 9),
(24, 44, 9),
(24, 65, 7),
(25, 8, 6),
(25, 18, 6),
(25, 31, 10),
(25, 32, 5),
(25, 53, 6),
(26, 34, 1),
(26, 58, 4),
(27, 41, 5),
(27, 44, 2),
(28, 2, 10),
(28, 6, 8),
(28, 7, 8),
(28, 22, 7),
(28, 43, 2),
(28, 64, 3),
(29, 45, 6),
(30, 16, 2),
(31, 57, 5),
(32, 5, 5),
(32, 82, 6),
(33, 13, 5),
(33, 23, 6),
(33, 30, 3),
(33, 76, 2),
(34, 65, 6),
(35, 49, 3),
(35, 67, 4),
(35, 80, 8),
(36, 22, 4),
(36, 51, 3),
(36, 62, 7),
(36, 75, 4),
(37, 19, 7),
(37, 20, 9),
(38, 78, 7),
(39, 37, 8),
(39, 45, 6),
(39, 64, 5),
(39, 75, 10),
(40, 81, 8),
(41, 9, 1),
(41, 42, 4),
(41, 49, 5),
(41, 69, 6),
(41, 103, 9),
(42, 43, 7),
(42, 51, 6),
(42, 54, 9),
(42, 73, 4),
(42, 75, 7),
(43, 27, 6),
(43, 63, 1),
(44, 72, 9),
(44, 79, 2),
(44, 83, 3),
(45, 29, 9),
(46, 49, 3),
(47, 10, 1),
(47, 24, 2),
(47, 26, 1),
(47, 40, 5),
(47, 43, 7),
(47, 71, 7),
(47, 77, 8),
(48, 28, 10),
(48, 69, 8),
(49, 68, 2),
(50, 41, 6),
(51, 62, 3),
(51, 104, 9),
(52, 10, 6),
(52, 34, 8),
(53, 6, 1);
-- select * from ligne_commande;
-- --------------------------------------------------------
-- --------------------------------------------------------

-- COMMIT;

