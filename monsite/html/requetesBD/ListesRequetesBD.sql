use tp2_media_web;

SELECT * FROM album;
SELECT * FROM genre;
SELECT * FROM oeuvre;
SELECT * FROM artiste;
SELECT * FROM roles;
SELECT * FROM continent;
SELECT * FROM pays;
SELECT * FROM utilisateur;
SELECT * FROM ville;
SELECT * FROM commande;
SELECT * FROM ligne_commande;



SELECT c.id_commande
FROM commande AS c
WHERE c.id_utilisateur = 1 AND c.date_commande = '2021-01-19 00:00:00';

-- function passerLigneCommande()
INSERT INTO ligne_commande (id_commande, id_oeuvre, quantite) 
VALUES (1, 12, 5);

-- function passerCommande()
INSERT INTO commande (id_commande, id_utilisateur, date_commande, etat_commande) 
VALUES (null, 1, '2022-09-26', 'En cours');

-- function getOeuvre()
SELECT o.id_oeuvre, o.titre_oeuvre, o.id_artiste, a.nom_artiste, o.id_role, r.description
	, o.dureesec, o.taillemb, o.date_ajout, o.id_album, alb.titre, o.prix, a.pht_artiste
FROM oeuvre AS o
	INNER JOIN artiste AS a ON o.id_artiste = a.id_artiste
	INNER JOIN roles AS r ON o.id_role = r.id_role
	INNER JOIN album AS alb ON o.id_album = alb.id_album
WHERE o.id_oeuvre = 1;

SELECT * FROM oeuvre
WHERE id_oeuvre = 3;

-- function getListeOeuvres()
SELECT * FROM oeuvre;
SELECT id_oeuvre, titre_oeuvre, id_artiste, id_role, dureesec, taillemb, lyrics, date_ajout, id_album, prix FROM oeuvre;

-- function getListeAlbums()
SELECT * FROM album;

-- function UtilisateurExiste()
SELECT * FROM utilisateur WHERE LOWER(courriel) = LOWER('qwerty@hotmail.com');

-- function ajouterUtilisateur()
INSERT INTO utilisateur (id_utilisateur, nom, courriel, mot_passe, id_ville, age) 
VALUES (null, 'Test', 'a@b.com', '$2y$10$XLzosaxUSVnBcBlWxmLdJuu8pFuL3VzQGkRFVWXXlJrJdmaMgBie6', 15, 18);

-- function AjouterOeuvres()
SELECT o.id_oeuvre, o.titre_oeuvre, o.id_artiste, a.nom_artiste, o.id_role, r.description
	, o.dureesec, o.taillemb, o.date_ajout, o.id_album, alb.titre, o.prix
FROM oeuvre AS o
	INNER JOIN artiste AS a ON o.id_artiste = a.id_artiste
	INNER JOIN roles AS r ON o.id_role = r.id_role
	INNER JOIN album AS alb ON o.id_album = alb.id_album
WHERE o.id_album = 4;

-- function AjouterAlbum()
INSERT INTO album (id_album, titre, code_album, date_album, id_genre, pht_couvt) 
values (null, "qaz", "ABC1234", '2022-09-24', 14, "album2.jpeg");

-- function chercherAlbums()
SELECT a.id_album, a.titre, a.code_album, a.date_album, g.description, a.pht_couvt
FROM album AS a
INNER JOIN genre AS g ON a.id_genre = g.id_genre;

-- function chercherOeuvres()
SELECT o.id_oeuvre, o.titre_oeuvre, a.nom_artiste, r.description
, o.dureesec, o.taillemb, o.date_ajout, alb.titre, o.prix
FROM oeuvre AS o
INNER JOIN artiste AS a ON o.id_artiste = a.id_artiste
INNER JOIN roles AS r ON o.id_role = r.id_role
INNER JOIN album AS alb ON o.id_album = alb.id_album
WHERE o.id_album = 4;

-- function chercherUser()
SELECT u.id_utilisateur, u.nom, u.courriel, u.mot_passe, u.age, u.id_ville, v.nom_ville , p.id_pays, p.nom_pays, p.code_monnaie, p.taux, c.nom_continent
FROM utilisateur AS u
INNER JOIN ville AS v ON u.id_ville = v.id_ville
INNER JOIN pays AS p ON v.id_pays = p.id_pays
INNER JOIN continent AS c ON p.id_continent = c.id_continent
WHERE u.courriel = 'qwerty@hotmail.com';
