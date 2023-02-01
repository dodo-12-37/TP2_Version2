<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");

if (!isset($_SESSION['type'])) {
    header("Location: pageConnexion.php");
    exit();
} else {
    if ($_SESSION['type'] != 'gerant') {
        header("Location: pageAccueil.php");
        exit();
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['submit'] == 'Soumettre') {
                //$_SESSION['postdata'] = $_POST;
                
                AjouterOeuvre();
                
                //unset($_POST);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
}
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $_SESSION['postdata'] = $_POST;

//     AjouterOeuvre();

//     unset($_POST);
//     header("Location: " . $_SERVER['PHP_SELF']);
//     exit();
// }

?>

<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Ajouter une oeuvre</h2>

    <form id="art_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="mx-auto container" novalidate method="POST">
        <div class="row">
            <div id="err_nom_oeuvre" class="col-6 text-danger err_texts"></div>
            <div id="err_art_code" class="col-3 text-danger err_texts"></div>
            <div id="err_art_prix" class="col-3 text-danger err_texts"></div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Titre</span>
                    </div>
                    <input type="text" class="form-control" name="nom_oeuvre" id="nom_oeuvre" required>
                </div>
            </div>

            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Code d'album</span>
                    </div>
                    <select name="art_code" id="art_code" class="form-control">
                        <?php
                        $listAlbums = chercherAlbums();
                        foreach ($listAlbums as $album) {
                            $idAlbum = $album->getID();
                            $codeAlbum = $album->getCodeAlbum();
                            echo "<option value='$idAlbum:$codeAlbum'>$codeAlbum</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Prix</span>
                    </div>
                    <input type="number" min="0" name="art_prix" id="art_prix" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text">$</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="err_art_principal" class="text-danger err_texts"></div>
        <div class="form-row">
            <div class="form-group col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Artiste principale</span>
                    </div>
                    <select name="nomArtiste" id="nomArtiste" class="form-control" size="1">
                        <!-- inserer liste déroulante -->
                        <?php
                        $listArtistes = GetListeArtistes();
                        foreach ($listArtistes as $artiste) {
                            $id = $artiste->getID();
                            $nom = $artiste->getNom();
                            echo "<option value='$id:$nom'>$nom</option>";
                        }
                        ?>
                    </select>
                    <!-- <input type="text" name="art_principal" id="art_principal" class="form-control"> -->
                </div>
            </div>
            <div class="form-group col-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rôle de l’artiste</span>
                    </div>

                    <select name="art_role" id="art_role" size="1" class="form-control">
                        <!-- inserer liste dèroulante -->
                        <?php
                        $listeRoles = GetListeRole();
                        foreach ($listeRoles as $idRole => $roleDes) {
                            echo "<option value='$idRole:$roleDes'>$roleDes</option>";
                        }
                        ?>

                    </select>

                </div>

            </div>
        </div>
        <div class="form-row">
            <div id="err_art_date_maj" class="col-4 text-danger err_texts"></div>
            <div id="err_art_duration" class="col-4 text-danger err_texts"></div>
            <div id="err_art_taille" class="col-4 text-danger err_texts"></div>
        </div>
        <div class="form-row">
            <div class="form-group col-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            Date d'ajout
                        </span>
                    </div>
                    <input type="date" readonly name="art_date_maj" id="art_date_maj" class="form-control">

                </div>

            </div>
            <div class="form-group col-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Durée</span>
                    </div>
                    <input type="number" min="0" name="art_duration" id="art_duration" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">sec</span>
                    </div>
                </div>

            </div>
            <div class="form-group col-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Taille</span>
                    </div>
                    <input type="number" min="0" name="art_taille" id="art_taille" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">Mb</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group form-control-plaintext">
            <textarea placeholder="Lyrics" class="form-control" name=" art_lyrics" id="" rows="3"></textarea>
        </div>

        <div class="form-row">
            <div class="col-6 col-md-9">
                <button id="oeuvre_submit" class="btn btn-success btn-block" type="submit" name="submit" value="Soumettre">Envoyer</button>
            </div>
            <div class="col-6 col-md-3">
                <button id="oeuvre_reset" class="btn btn-outline-danger btn-block" type="reset">Réinitialiser</button>
            </div>
        </div>
    </form>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>