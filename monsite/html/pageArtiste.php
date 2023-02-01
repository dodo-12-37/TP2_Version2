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

        $valide = true;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //$_SESSION['postdata'] = $_POST;
            AjouterArtiste();
            unset($_POST);
            // header("Location: " . $_SERVER['PHP_SELF']);
            // exit;
        }
    }
}

?>

<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Ajouter un artiste</h2>

    <div class="mx-auto text-info w-75">
        <Form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <!-- <h2 class="text-white text-center col-9">Ajouter un artiste</h2> -->
            <div class="form-row">
                <div class="col-9">
                    <div class="input-group my-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nom</span>
                        </div>
                        <input class="form-control" type="text" name="nom" id="nom">
                        <span id="err_nom" class="text-danger"></span>

                    </div>
                    <div class="input-group my-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Ville</span>
                        </div>
                        <select class="form-control" name="nomVilleSelect" id="villeGroupSelect" size="1">
                            <!-- inserer liste dèroulante -->
                            <?php
                            $villes = getListeVilles();
                            foreach ($villes as $idVille => $nomVille) {
                                echo "<option value='$idVille:$nomVille'>$nomVille</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="input-group my-4">
                        <div class="input-group-append">
                            <span class="input-group-text">Télécharger</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="filePhoto" name="filePhoto" aria-describedby="inputGroupFileAddon01">
                            <label id="custom-file-label" class="custom-file-label" for="filePhoto">Télécharger Votre photo</label>
                        </div>
                        <span class="text-danger" id="err_artiste_photo"></span>
                    </div>
                </div>
                <div class="col-md-3 my-4 text-center">
                    <figure class="figure ">
                        <img class="rounded img-fluid" id="artiste_photo" src="img/artiste_photo.png" alt="artiste_foto" width="100px" height="120px">
                        <figcaption class="figure-caption" id="artiste_figcap">Exemple de photo.
                        </figcaption>
                    </figure>
                </div>

            </div>
            <div class="form-row">
                <div class="col-9">
                    <button type="submit" value="Soumettre Artite" name="envoyer" class="btn btn-block btn-success my-2" id="btn_submit">Envoyer</button>
                </div>
                <div class="col-3">
                    <button type="reset" class="btn btn-block btn-outline-danger  my-2" id="btn_reset">Réinitialiser</button>
                </div>
            </div>
        </Form>



    </div>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");

?>