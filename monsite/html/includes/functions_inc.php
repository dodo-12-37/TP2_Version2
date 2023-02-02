<?php
if (session_id() == "") {
    session_start();
}
//Ajout classes 
//var_dump($_SERVER['DOCUMENT_ROOT']);
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/utilisateur.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/album.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/artiste.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/oeuvre.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/pays.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/ville.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/produit.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/panier.class.php');


$pathinfo = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
$jsFilename = str_replace('php', 'js', $pathinfo);

$titleName = str_replace('.js', '', $jsFilename);
$titleName = str_replace('page', '', $titleName);
// echo "$pathinfo<br>";
// echo "$jsFilename<br>";
// echo "$titleName<br>";


// function seConnecterMySQLi()
// {
//     try {
//         //echo "<h1>Bases de données MySQL (PDO)</h1>";
//         $servername = getenv('MON_HOST');
//         $username = 'root';
//         $password = 'rootpassword';
//         $bd = 'tp2_media_web';
//         $conn = new mysqli($servername, $username, $password, $bd); 
//         //$conn = new PDO("mysql:host=$servername; dbname=$bd; charset=utf8", $username, $password);
//         //echo "Sa fonctionne !!!";
//     } catch (Exception $e) {
//         die('Erreur lors de la connexion à la BD : ' . $e->getMessage());
//     }

//     return $conn;
// }

function seConnecterPDO()
{
    try {
        //echo "<h1>Bases de données MySQL (PDO)</h1>";
        $servername = getenv('MON_HOST');
        $username = 'root';
        $password = 'rootpassword';
        $bd = 'tp2_media_web';
        
        $conn = new PDO("mysql:host=$servername; dbname=$bd; charset=utf8", $username, $password);
        //echo "Sa fonctionne !!!";
    } catch (Exception $e) {
        die('Erreur lors de la connexion à la BD : ' . $e->getMessage());
    }

    return $conn;
}


//Page Menu
function estPageActive_Nav($NomPage)
{
    if (strpos($_SERVER['PHP_SELF'], $NomPage) !== false) {
        return "active";
    }
}

function validerEntree($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Page Connexion
function chercherUser($p_courriel, $p_password)
{
    try {
        //https://bcrypt.online/    pour créer des HASH bcrypt
        $reqsql = "SELECT u.id_utilisateur, u.nom, u.courriel, u.mot_passe, u.age, u.id_ville, v.nom_ville , p.id_pays, p.nom_pays, p.code_monnaie, p.taux, c.nom_continent
                FROM utilisateur AS u
                INNER JOIN ville AS v ON u.id_ville = v.id_ville
                INNER JOIN pays AS p ON v.id_pays = p.id_pays
                INNER JOIN continent AS c ON p.id_continent = c.id_continent
                WHERE u.courriel=?";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_courriel));

        while ($donnees = $reponse->fetch()) {
            // $donnees = $reponse->fetch(PDO::FETCH_ASSOC);
            $password = $donnees['mot_passe'];
            if (password_verify($p_password, $password)) {
                $idUser = $donnees['id_utilisateur'];
                $nom = $donnees['nom'];
                $courriel = $donnees['courriel'];
                $age = $donnees['nom'];
                $idVille = $donnees['id_ville'];
                $nomVille = $donnees['nom_ville'];
                $idPays = $donnees['id_pays'];
                $nomPays = $donnees['nom_pays'];
                $codeMonnaie = $donnees['code_monnaie'];
                $taux = $donnees['taux'];
                $nomContinent = $donnees['nom_continent'];

                $newPays = new Pays($idPays, $nomPays, $codeMonnaie, $taux, $nomContinent);
                $newVille = new Ville($idVille, $nomVille, $newPays);
                $newUtilisateur = new Utilisateur($idUser, $nom, $courriel, $password, $newVille, $age);
                //À supprimer
                //var_dump($donnees);
                //var_dump($newUtilisateur);
                //$reponse->close();
                //$reponse->mysqli_close($conn);
                $reponse->closeCursor();
                $conn = null;
                return $newUtilisateur;
            } else {
                echo "ERREUR DE REQUÊTE !!!";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

//Page AfficherAlbums
function chercherAlbums()
{
    try {

        //https://bcrypt.online/    pour créer des HASH bcrypt
        $reqsql = "SELECT a.id_album, a.titre, a.code_album, a.date_album, g.description, a.pht_couvt
                FROM album AS a
                INNER JOIN genre AS g ON a.id_genre = g.id_genre";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();

        $listeAlbums = [];

        while ($donnees = $reponse->fetch()) {
            $idAlbum = $donnees['id_album'];
            $titre = $donnees['titre'];
            $codeAlbum = $donnees['code_album'];
            $dateAlbum = $donnees['date_album'];
            $descriptionGenre = $donnees['description'];
            $imageName = $donnees['pht_couvt'];

            $newAlbum = new Album($idAlbum, $titre, $codeAlbum, $dateAlbum, $descriptionGenre, $imageName, chercherOeuvres($idAlbum));
            array_push($listeAlbums, $newAlbum);
            //À supprimer
            //var_dump($donnees);
            //var_dump($newUtilisateur);
        }

        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $listeAlbums;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

//Page AfficherAlbums
function chercherOeuvres($p_idAlbum)
{
    try {
        //https://bcrypt.online/    pour créer des HASH bcrypt
        $reqsql = "SELECT o.id_oeuvre, o.titre_oeuvre, o.id_artiste, a.nom_artiste, o.id_role, r.description
                        , o.dureesec, o.taillemb, o.date_ajout, o.id_album, alb.titre, o.prix
                    FROM oeuvre AS o
                        INNER JOIN artiste AS a ON o.id_artiste = a.id_artiste
                        INNER JOIN roles AS r ON o.id_role = r.id_role
                        INNER JOIN album AS alb ON o.id_album = alb.id_album
                    WHERE o.id_album = ?";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idAlbum));

        $listeOeuvres = [];

        while ($donnees = $reponse->fetch()) {
            $idOeuvre = $donnees['id_oeuvre'];
            $titreOeuvre = $donnees['titre_oeuvre'];
            $nomArtiste = $donnees['nom_artiste'];
            $descriptionRole = $donnees['description'];
            $dureesec = $donnees['dureesec'];
            $idRole = $donnees['id_role'];
            $idAlbum = $donnees['id_album'];
            $idArtiste = $donnees['id_artiste'];
            $tailleMb = $donnees['taillemb'];
            $dateAjout = $donnees['date_ajout'];
            $titreAlbum = $donnees['titre'];
            $prix = $donnees['prix'];

            $newOeuvre = new Oeuvre($idOeuvre, $titreOeuvre, $idArtiste, $dureesec, $tailleMb, null, $dateAjout, $idAlbum, $prix, $idRole);
            array_push($listeOeuvres, $newOeuvre);
            //À supprimer
            //var_dump($donnees);
            //var_dump($newUtilisateur);
        }

        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $listeOeuvres;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


// Fonctions de page Artiste -Binh
function ajouterArtiste()
{
    // get infos d'artiste
    $idVille_nomVille = ValiderEntree($_POST['nomVilleSelect']);
    $array = explode(':', $idVille_nomVille);
    $idVille = $array[0];
    $nomVille = $array[1];
    $nomArtiste = ValiderEntree($_POST['nom']);
    $fotoArtiste = str_replace(" ", "_", $nomArtiste) . ".jpg";



    try {
        $estExsist =  ArtistExist($nomArtiste, $idVille);
        if ($estExsist) {
            throw new RuntimeException();
        }
    } catch (RuntimeException $e) {
        echo "L'artiste existe déjà dans la base de données <br>"  . $e->getMessage();
        return false;
    }


    $artiste = new Artiste(null, $nomArtiste, $fotoArtiste, $idVille);
    try {
        // var_dump($p_Artiste);

        $reqsql = "INSERT INTO artiste (id_artiste, nom_artiste, pht_artiste, id_ville) " .
            " values (?,?,?,?);";
        $conn = seConnecterPDO();
        $rq = $conn->prepare($reqsql);
        $rq->execute(array(
            $artiste->getID(), $artiste->GetNom(),
            $artiste->getImageName(), $artiste->getIdVille()
        ));

        $rq->closeCursor();
        // $rq->close();
        $conn = null;
        return true;
    } catch (PDOException $e) {
        throw new InvalidArgumentException("L'ajout l'artiste dans la BD n'a pas fonctionné! <br> " . $e->getMessage());
        return false;
    }
}


function getListeVilles()
{
    try {
        $reqsql = "select * from ville";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();
        $villes = array();
        while ($valeur = $reponse->fetch()) {
            $idVille = $valeur['id_ville'];
            $nomVille = $valeur['nom_ville'];
            $villes[$idVille] =  $nomVille;
        }
        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $villes;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function getListeArtistes()
{
    try {
        $reqsql = "select * from artiste";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();
        $listeArtistes = array();
        while ($valeur = $reponse->fetch()) {
            $id = $valeur['id_artiste'];
            $nom = $valeur['nom_artiste'];
            $pht_artiste = $valeur['pht_artiste'];
            $id_ville = $valeur['id_ville'];
            $artiste = new Artiste($id, $nom, $pht_artiste, $id_ville);
            array_push($listeArtistes, $artiste);
        }
        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $listeArtistes;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function artistExist($p_nom, $p_Idville)
{

    $listeArtistes = GetListeArtistes();
    foreach ($listeArtistes as $artiste) {
        if (strtolower($artiste->getNom()) == strtolower($p_nom)  && $artiste->getIdVille() == $p_Idville) {
            return true;
        }
    }
    return false;
}



// ---------------------------------------------------------------------------------------------------------------------
// Fonctions de page Ajouter Album
function albumExiste($p_albumTitre)
{

    $listeAlbums = chercherAlbums();
    foreach ($listeAlbums as $album) {
        if (strtolower($album->getTitre()) == strtolower($p_albumTitre)) {
            return true;
        }
    }
    return false;
}

function codeAlbumExiste($p_albumCode)
{

    $listeAlbums = chercherAlbums();
    foreach ($listeAlbums as $album) {
        if (strtolower($album->getCodeAlbum()) == strtolower($p_albumCode)) {
            return true;
        }
    }
    return false;
}

function ajouterAlbum($p_album)
{
    try {
        // var_dump($p_album);

        $reqsql = "INSERT INTO album (id_album, titre, code_album, date_album, id_genre, pht_couvt) values (?,?,?,?,?,?);";
        $conn = seConnecterPDO();
        $rq = $conn->prepare($reqsql);
        $rq->execute(array(
            $p_album->getID(), $p_album->getTitre(), $p_album->getCodeAlbum(), $p_album->getDateAlbum(),
            $p_album->getGenre(), $p_album->getImageName()
        ));

        $rq->closeCursor();
        // $rq->close();
        $conn = null;
        return true;
    } catch (PDOException $e) {
        throw new InvalidArgumentException("L'ajout de l'album dans la BD n'a pas fonctionné! <br> " . $e->getMessage());
        return false;
    }
}
// ----------------------------------------------------------------------------------------------------------------------
// Fonction de page Ajouter Oeuvre
function getListeRole()
{
    try {
        $reqsql = "select * from roles";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();
        $roles = array();
        while ($valeur = $reponse->fetch()) {
            $idRole = $valeur['id_role'];
            $roleDes = $valeur['description'];
            $roles[$idRole] = $roleDes;
        }
        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $roles;
    } catch (PDOException $e) {
        throw new InvalidArgumentException("La récupération des roles dans la BD n'a pas fonctionné! <br> " . $e->getMessage());
    }
}

function ajouterOeuvre()
{
    // get infos d'oeuvre
    $arr_idArtiste = explode(':', $_POST['nomArtiste']);
    $arr_idRole = explode(':', $_POST['art_role']);
    $arr_idAlbum = explode(':', $_POST['art_code']);
    $id = null;
    $titre = validerEntree($_POST['nom_oeuvre']);
    $idArtiste = (int) $arr_idArtiste[0];
    $idRole = (int) $arr_idRole[0];
    $tailleMb = (float) validerEntree($_POST['art_taille']);
    $dureeSec = (int) validerEntree($_POST['art_duration']);
    $dateAjout = validerEntree($_POST['art_date_maj']);
    $idAlbum =  (int) $arr_idAlbum[0];
    $prix = (int) validerEntree($_POST['art_prix']);
    $lyric = "" ? null : validerEntree($_POST['art_lyrics']);


    $oeuvre = new Oeuvre($id, $titre, $idArtiste, $dureeSec, $tailleMb, null, $dateAjout, $idAlbum, $prix, $idRole);


    try {
        // INSERT INTO oeuvre (id_oeuvre, titre_oeuvre, id_artiste, dureesec, taillemb, lyrics, date_ajout, id_album, prix,id_role)
        $reqsql = "INSERT INTO oeuvre (id_oeuvre, titre_oeuvre, id_artiste, dureesec, taillemb, lyrics, date_ajout, id_album, prix,id_role)" .
            " values (?,?,?,?,?,?,?,?,?,?)";
        $conn = seConnecterPDO();

        $rq = $conn->prepare($reqsql);
        $rq->execute(array(
            $oeuvre->getID(),
            $oeuvre->getTitre(),
            $oeuvre->getIdArtiste(),
            $oeuvre->getDureeSec(),
            $oeuvre->getTailleMb(),
            $oeuvre->getLyric(),
            $oeuvre->getDateAjout(),
            $oeuvre->getIdAlbum(),
            $oeuvre->getPrix(),
            $oeuvre->getIdRole()
        ));
        $rq->closeCursor();
        // $rq->close();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        throw new InvalidArgumentException("L'ajout de l'oeuvre dans la BD n'a pas fonctionné! <br> " . $e->getMessage());
        return false;
    }
}


// ------------------------------------------------------------------------------------------------------
// Fonctions de page Inscription

function UtilisateurExiste($pCourriel)
{
    try {
        $reqsql = "SELECT * FROM utilisateur WHERE LOWER(courriel) = LOWER(?)";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        // $reponse->bindValue(':courr', strtoupper($pCourriel));
        $reponse->execute(array($pCourriel));
        $count = $reponse->rowCount();
        // $count = $reponse->num_rows();

        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        throw new InvalidArgumentException("L'utilisateur n'existe pas dans la BD! <br> " . $e->getMessage());
        return false;
    }
}

function AjouterUtilisateur()
{
    // get infos utilisateur
    $nom = ValiderEntree($_POST['nom_utilisateur']);
    $idVille = (int) (ValiderEntree(explode(':', $_POST['nomVilleSelect'])[0]));
    $age = (int) ValiderEntree($_POST['age_utilisateur']);
    $courriel = filter_var($_POST['courriel'], FILTER_SANITIZE_EMAIL);
    $motPasse = $_POST['mot_de_passe'];
    // $confirmer_mdp = ValiderEntree($_POST['confirmer_mdp']);
    //$nom = ValiderEntree($_POST['nom_utilisateur']);

    try {

        $reqsql = "INSERT INTO utilisateur (id_utilisateur, nom, courriel, mot_passe, id_ville, age) VALUES (?,?,?,?,?,?)";
        $conn = seConnecterPDO();
        $rq = $conn->prepare($reqsql);
        $pmPasse = password_hash($motPasse,  PASSWORD_BCRYPT);
        $rq->execute(array(null, $nom, $courriel, $pmPasse, $idVille, $age));

        $rq->closeCursor();
        // $rq->close();
        $conn = null;
        //return true;

    } catch (PDOException $e) {
        throw new InvalidArgumentException("L'ajout de l'utilisateur dans la BD n'a pas fonctionné! <br> " . $e->getMessage());
        //return false;
    }
}


// -----------------------------------------------------------------------------
// Fonctions de pageCommander

function getListeAlbums()
{
    try {
        $reqsql = "SELECT * FROM album";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();
        $listeAlbums = array();

        while ($valeur = $reponse->fetch()) {
            $id = $valeur['id_album'];
            $titre = $valeur['titre'];
            $code_album = $valeur['code_album'];
            $date_album = $valeur['date_album'];
            $id_genre = $valeur['id_genre'];
            $pht_couv = $valeur['pht_couv'];
            $listeOeuvres = null;

            $album = new Album($id, $titre, $code_album, $date_album, $id_genre, $pht_couv, $listeOeuvres);
            array_push($listeAlbums, $album);
        }

        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $listeAlbums;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function getListeOeuvres()
{
    try {
        // $reqsql = "SELECT * FROM oeuvre";
        $reqsql = "SELECT id_oeuvre, titre_oeuvre, id_artiste, id_role, dureesec, taillemb, lyrics, date_ajout, id_album, prix FROM oeuvre;";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute();
        $listeOeuvres = array();

        while ($valeur = $reponse->fetch()) {
            $id = $valeur['id_oeuvre'];
            $titre_oeuvre = $valeur['titre_oeuvre'];
            $id_artiste = $valeur['id_artiste'];
            $id_role = $valeur['id_role'];
            $dureesec = $valeur['dureesec'];
            $taillemb = $valeur['taillemb'];
            $lyrics = $valeur['lyrics'];
            $date_ajout = $valeur['date_ajout'];
            $id_album = $valeur['id_album'];
            $prix = $valeur['prix'];

            $oeuvre = new Oeuvre($id, $titre_oeuvre, $id_artiste, $dureesec, $taillemb, $lyrics, $date_ajout, $id_album, $prix, $id_role);
            array_push($listeOeuvres, $oeuvre);
        }

        $reponse->closeCursor();
        // $reponse->close();
        $conn = null;
        return $listeOeuvres;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}


function chercherOeuvre($p_idOeuvre)
{
    try {
        $reqsql = "SELECT o.id_oeuvre, o.titre_oeuvre, o.id_artiste, a.nom_artiste, o.id_role, r.description
                        , o.dureesec, o.taillemb, o.date_ajout, o.id_album, alb.titre, o.prix, a.pht_artiste
                    FROM oeuvre AS o
                        INNER JOIN artiste AS a ON o.id_artiste = a.id_artiste
                        INNER JOIN roles AS r ON o.id_role = r.id_role
                        INNER JOIN album AS alb ON o.id_album = alb.id_album
                    WHERE o.id_oeuvre = ?";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idOeuvre));

        while ($donnees = $reponse->fetch()) {
            $idOeuvre = $donnees['id_oeuvre'];
            $titreOeuvre = $donnees['titre_oeuvre'];
            $nomArtiste = $donnees['nom_artiste'];
            $descriptionRole = $donnees['description'];
            $dureesec = $donnees['dureesec'];
            $idRole = $donnees['id_role'];
            $idAlbum = $donnees['id_album'];
            $idArtiste = $donnees['id_artiste'];
            $tailleMb = $donnees['taillemb'];
            $dateAjout = $donnees['date_ajout'];
            $titreAlbum = $donnees['titre'];
            $prix = $donnees['prix'];

            $newOeuvre = new Oeuvre($idOeuvre, $titreOeuvre, $idArtiste, $dureesec, $tailleMb, null, $dateAjout, $idAlbum, $prix, $idRole);
            //array_push($listeOeuvres, $newOeuvre);

            $reponse->closeCursor();
            // $reponse->close();
            $conn = null;
            return $newOeuvre;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function chercherAlbum($p_idAlbum)
{
    try {
        $reqsql = "SELECT a.id_album, a.titre, a.code_album, a.date_album, g.description, a.pht_couvt
                    FROM album AS a
                    INNER JOIN genre AS g ON a.id_genre = g.id_genre
                    WHERE a.id_album = ?";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idAlbum));

        while ($donnees = $reponse->fetch()) {
            $idAlbum = $donnees['id_album'];
            $titre = $donnees['titre'];
            $codeAlbum = $donnees['code_album'];
            $dateAlbum = $donnees['date_album'];
            $descriptionGenre = $donnees['description'];
            $imageName = $donnees['pht_couvt'];
            $newAlbum = new Album($idAlbum, $titre, $codeAlbum, $dateAlbum, $descriptionGenre, $imageName, null);
            //array_push($listeAlbums, $newAlbum);

            $reponse->closeCursor();
            // $reponse->close();
            $conn = null;
            return $newAlbum;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function afficherProduits()
{

    if (isset($_SESSION['cart'])) {
        $panier = unserialize($_SESSION['cart']);

        foreach ($panier->getItems() as $key => $produitPanier) {
            $produit = $produitPanier['item'];
            $quantiteProduit = $produitPanier['qty'];
?>
            <div class="col-12 col-lg-6 mb-2 p-2 border" id="commande<?= $key + 1 ?>">
                <img src="img/<?= $produit->getImage() ?>" alt="Image de l'album" class="float-right img-thumbnail mb-2" width="75" height="75">
                <h4><?= $produit->getAlbumTitre() ?></h4>
                <p><?= $produit->getOeuvreTitre() ?></p>
                <input type="number" class="form-control mb-3 " name="nbOeuvre<?= $key + 1 ?>" id="nbOeuvre<?= $key + 1 ?>" min="0" max="10" value="<?= $quantiteProduit ?>">
                <div>
                    Prix unitaire:
                    <span id="prixUnitaire<?= $key + 1 ?>"><?= $produit->getPrixUnitaire() ?></span> $
                </div>
                <div class="font-weight-bold font-italic">
                    Prix:
                    <span id="prix<?= $key + 1 ?>"><?= $produit->getPrixProduitTotal($quantiteProduit) ?></span> $
                </div>
            </div>
<?php
        }
    }
}


function passerCommande(int $p_idUtilisateur, DateTime $p_dateCommande, Panier $p_panier)
{
    try {
        $reqsql = "INSERT INTO commande (id_commande, id_utilisateur, date_commande) 
                    VALUES (null, ?, ?)";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idUtilisateur, $p_dateCommande->format('Y-m-d H:i:s')));

        $idCommande = trouverIdCommande($p_idUtilisateur, $p_dateCommande);

        foreach ($p_panier->getItems() as $key => $item) {
            $produit = $item['item'];
            $nbProduit = $item['qty'];
            $idOeuvre = $produit->getOeuvre()->getID();

            passerLigneCommande($idCommande, $idOeuvre, $nbProduit);
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function passerLigneCommande(int $p_idCommande, int $p_idOeuvre, int $p_quantite)
{
    try {
        $reqsql = "INSERT INTO ligne_commande (id_commande, id_oeuvre, quantite) 
                    VALUES (?, ?, ?)";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idCommande, $p_idOeuvre, $p_quantite));

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function trouverIdCommande(int $p_idUtilisateur, Datetime $p_dateCommande)
{

    try {
        $reqsql = "SELECT c.id_commande
                    FROM commande AS c
                    WHERE c.id_utilisateur = ? AND c.date_commande = ?";
        $conn = seConnecterPDO();
        $reponse = $conn->prepare($reqsql);
        $reponse->execute(array($p_idUtilisateur, $p_dateCommande->format('Y-m-d H:i:s')));

        while ($donnees = $reponse->fetch()) {
            $idCommande = $donnees['id_commande'];

            $reponse->closeCursor();
            // $reponse->close();
            $conn = null;
            return $idCommande;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}



?>
