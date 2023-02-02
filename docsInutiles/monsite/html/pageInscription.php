<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");

if (isset($_SESSION['type'])) {
    if ($_SESSION['type'] != 'visiteur') {
        header("Location: pageDeconnexion.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$_SESSION['postdata'] = $_POST;

    if (isset($_POST['inscriptionSubmit']) && $_POST['inscriptionSubmit'] == 'submit') {
        $motPasse = ($_POST['mot_de_passe']);
        $confirmer_mdp = ($_POST['confirmer_mdp']);
        $courriel = filter_var($_POST['courriel'], FILTER_SANITIZE_EMAIL);

        if ($motPasse == $confirmer_mdp) {
            if (!UtilisateurExiste($courriel)) {
                AjouterUtilisateur();
                $ajoutReussi = "Le compte à été créé. Connectez-vous pour profiter du site web.";
            } else {
                // echo "utilisateur existe...";
                $erreur = "Le courriel est déjà utilisé. Choisissez un autre courriel.";
            }
        } else {
            $erreur = "Les mots de passe ne sont pas pareil.";
        }

        unset($_POST);
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit();
    }
}
//}


?>
<!-- Binh -->
<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Inscription</h2>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="max-width: 800px;" class="mx-auto my-4">
        <!-- novalidate -->
        <div class="form-row">
            <div class="form-group col-sm-4 ">
                <label for="nom_utilisateur">
                    Nom
                    <span id="errNom" class="text-danger err_texts"></span>
                </label>
                <input type="text" name="nom_utilisateur" id="nom_utilisateur" class="form-control" required>
                <!-- <div class="invalid-feedback">Erreur</div>
                                <div class="valid-feedback">Bon</div> -->
            </div>
            <div class="form-group col-sm-4">
                <label for="villeGroupSelect">Ville</label>
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
            <div class="form-group col-sm-4">
                <label for="age_utilisateur">
                    Âge <span id="err_age" class="text-danger err_texts"></span>
                </label>
                <input type="number" name="age_utilisateur" id="age_utilisateur" class="form-control" min="18" max="100">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="courriel">
                    Courriel
                    <span id="errCourriel" class="text-danger err_texts"></span>
                </label>
                <input type="email" class="form-control" name="courriel" id="courriel" required>
            </div>
            <div class="form-group col-sm-6 col-md-4">
                <label for="mot_de_passe">
                    Mot de passe <span id="err_MDP" class="text-danger err_texts">

                    </span>
                </label>
                <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" required>
            </div>
            <div class="form-group col-sm-6 col-md-4">
                <label for="confirmer_mdp">
                    Confirmer
                    <span id="err_cf_mdp" class="text-danger err_texts"></span>

                </label>
                <input type="password" class="form-control" name="confirmer_mdp" id="confirmer_mdp" required>
            </div>
        </div>
        <div class="form-row my-3">
            <div class="col-6  col-md-8">
                <button id="ins_submit" class="btn btn-success btn-block btn" type="submit" name='inscriptionSubmit' value="submit">S'inscrire</button>
            </div>
            <div class="col-6  col-md-4">
                <button id="ins_reset" class="btn btn-outline-danger btn-block btn" type="reset">Réinitialiser</button>
            </div>
        </div>
        <div class="form-row">
            <span class="col-12 text-danger err_texts" id="mdp_explique"><?php
                                                                        if (isset($erreur)) {
                                                                            echo $erreur;
                                                                        }
                                                                        ?></span>
            <span class="col-12 text-success err_texts"><?php
                                                        if (isset($ajoutReussi)) {
                                                            echo $ajoutReussi;
                                                        }
                                                        ?></span>
        </div>
    </form>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>