<?php

use JetBrains\PhpStorm\Internal\PhpStormStubsElementAvailable;

require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");

if (!isset($_SESSION['type'])) {
    header("Location: pageConnexion.php");
    exit();
} else {
    if ($_SESSION['type'] != 'gerant') {
        header("Location: pageAccueil.php");
        exit();
    }
}

// require_once("classes/album.class.php");

$errMess = "";

if (isset($_POST["envoyer"])) {
    $titre_album = "";
    $code_album = "";
    $date_album = date("Y-m-d");
    //$genreGroupSelect = 0;
    $nomImage = "";

    $errMessAutre = "";

    if ($_POST["envoyer"] == 'Soumettre') {
        $valide = true;

        if (isset($_POST["titre_album"])) {
            $titre_album = validerEntree($_POST["titre_album"]);
            $masqueTitre = "/^([A-z]|[0-9]|\s|\.|\-|\_|[éÉùÙçÇèÈêÊîÎàÀïÏâÂ]){2,50}$/";

            if (preg_match($masqueTitre, $titre_album) == 0) {
                $valide = false;
                $errMessAutre = 'Le titre contient des caractères non valides.<br>';
            }
            if (AlbumExiste($titre_album)) {
                $valide = false;
                $errMessAutre .= "Cet album '$titre_album' existe déjà dans la BD!<br>";
            }
        }

        if (isset($_POST["code_album"])) {
            $code_album = validerEntree($_POST["code_album"]);
            $masqueCode = "/^([A-Z]{3}[0-9]{4})$/";

            if (preg_match($masqueCode, $code_album) == 0) {
                $valide = false;
                $errMessAutre .= 'Le code entré est invalide.<br>';
            }
            if (CodeAlbumExiste($code_album)) {
                $valide = false;
                $errMessAutre .= "Ce code '$code_album' existe déjà dans la BD!<br>";
                //$errMess  = '<div id="err" class="alert alert-danger">'.$errMess."</div>";  
            }
        }

        if (isset($_POST["nomImage"])) {
            $nomImage = validerEntree($_POST["nomImage"]);
            $masqueImage = "/\.(jpg|jpeg|png|webp|avif|gif|svg)$/";
            if (preg_match($masqueImage, $nomImage) == 0) {
                $valide = false;
                $errMessAutre .= 'Le type de fichier image est invalide.<br>';
            }
            $tableau = explode('\\', $nomImage);
            $nomImage = end($tableau);
        }

        if (isset($_POST["date_album"])) {
            $date_album = htmlspecialchars($_POST["date_album"]);
            $date_album = date("Y-m-d", strtotime($date_album));
            $dateToday = date('Y-m-d');
            if ($date_album > $dateToday) {
                $valide = false;
                $errMessAutre .= 'La date est invalide.<br>';
            }
        }

        if ($valide) {

            $genreGroupSelect = $_POST["genreGroupSelect"];
            try {
                $album = new Album(null, $titre_album, $code_album, $date_album, $genreGroupSelect, $nomImage, null);
                //AjouterAlbum($album);
                if (ajouterAlbum($album)) {
                    $errMess = "<div id='msg' class='alert alert-success'>L'album $titre_album" . " a été ajouté avec succès!</div>";
                    $titre_album = "";
                    $code_album = '';
                    $date_album = date("Y-m-d");
                    $genreGroupSelect = "";
                    $nomImage = "";
                    //unset($_POST); //pt à enlever...
                }
            } catch (Exception $e) {
                $errMess = '<div id="err" class="alert alert-danger">' . $errMess . $e->getMessage() . "</div>";
            }
        } else {
            $errMess = '<div id="err" class="alert alert-danger">' . $errMessAutre . "L'album n'a pas été ajouté!</div>";
        }
    }
}

?>

<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4 text-body">Ajouter un album</h2>
    <!-- MICHEL, TU AJOUTES TON CODE ICI !!! -->

    <form class="mx-auto text-info" style="max-width: 700px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-row">
            <div class="col-md-9">
                <div class="input-group my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Titre</span>
                    </div>
                    <input class="form-control" type="text" name="titre_album" id="titre_album" placeholder="titre de l'album">
                    <span id="err_titre" class="text-danger"> </span>
                </div>

                <div class="input-group my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Code</span>
                    </div>
                    <input class="form-control" type="text" name="code_album" id="code_album" placeholder="code de l'album, exemple: ABC1234">
                    <span id="err_code" class="text-danger"></span>
                </div>

                <div class="input-group date my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Date de publication</span>
                    </div>
                    <input class="form-control" type="date" name="date_album" id="date_album" min="1920-01-01" max="">

                    <span id="err_date" class="text-danger"></span>
                </div>

                <div class="input-group my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Genre</span>
                    </div>
                    <select class="form-control" name="genreGroupSelect" id="GenreGroupSelect" size="1">
                        <?php
                        $reqsql = "SELECT * FROM genre";
                        $conn = seConnecterPDO();
                        $reponse = $conn->query($reqsql);

                        while ($donnees = $reponse->fetch()) {
                            $idGenre = $donnees['id_genre'];
                            $genre = $donnees['description'];

                            echo "<option value='$idGenre'>$genre</option>";
                        }

                        $reponse->closeCursor();
                        $conn = null;
                        ?>

                    </select>
                </div>

                <div class="input-group my-4">
                    <div class="input-group-append">
                        <span class="input-group-text">Télécharger</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="nomImage" name="nomImage" aria-describedby="nomImageAria">
                        <label class="custom-file-label" id="imageAlbum" for="inputDossierImages ">Image de l'album</label>
                    </div>
                    <span class="text-danger" id="err_album_photo"></span>
                </div>

            </div>
            <div class="col-md-3 my-4 text-center">
                <figure class="figure ">
                    <img class="rounded img-fluid" id="album_photo" src="img/album_photo.webp" alt="album_photo" width="100px" height="120px">
                    <figcaption class="figure-caption" id="album_figcap">Exemple de photo.</figcaption>
                </figure>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-5">
                <button type="submit" class="btn btn-success btn-block" id="envoyer" name="envoyer" value="Soumettre">Soumettre</button>
            </div>
            <div class="col-md-4">
                <button type="reset" class="btn btn-outline-danger btn-block" id="btn_reset">Réinitialiser</button>
            </div>
            <div class="col-md-3 text-danger"><?= $errMess ?></div>
        </div>
    </Form>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>