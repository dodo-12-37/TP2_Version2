<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");

if (isset($_SESSION)) {
    //https://bcrypt.online/    pour créer des HASH bcrypt
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['connexion']) && $_POST['connexion'] == 'submit') {
            $estValide = true;
 
            if (!isset($_POST["courriel"])) {
                $erreurCourriel = "Le courriel est requis.";
            } else {
                $connCourriel = ValiderEntree($_POST["courriel"]);
                // check if e-mail address is well-formed
                if (!filter_var($connCourriel, FILTER_VALIDATE_EMAIL)) {
                    $erreurCourriel = "Le format du courriel est invalide.";
                    $estValide = false;
                }
            }

            if (!isset($_POST["mot_de_passe"])) {
                $erreurPassword = "Le mot de passe est requis";
            } else {
                $connPassword = ValiderEntree($_POST["mot_de_passe"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$#!%*?&]{8,}$/", $connPassword)) {
                    $erreurPassword = "Mot de passe doit contenir au minimum 8 caractères: au moins une lettre minuscule et une lettre majuscule, un caractère spécial et un chiffre.";
                    $estValide = false;
                }
            }

            if ($estValide) {
                $user = chercherUser($connCourriel, $connPassword);

                if (isset($user) && $user != null) {
                    $_SESSION['login'] = serialize($user);
                    $_SESSION['type'] = $user->getType();
                    header("Location: pageAccueil.php");
                    exit();
                } else {
                    $erreurConnexion = "Erreur de connexion.\nLe courriel et/ou le mot de passe fournis n'est pas bon.";
                }
            }
        }
    }
}
?>

<!-- Binh, Michel, Dom -->
<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Connexion</h2>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="max-width: 800px;" class="mx-auto my-4">
        <div class="form-row">
            <div class="form-group col-6">
                <label for="courriel">Courriel (awdeali@gmail.com ou qwerty@hotmail.com)</label>
                <input type="email" class="form-control" name="courriel" id="courriel" required>
                <span id="errCourriel" class="text-danger err_texts">
                    <?php if (isset($erreurCourriel)) {
                        $erreurCourriel;
                    } ?>
                </span>
                <!-- required -->
            </div>
            <div class="form-group col-6">
                <label for="mot_de_passe">Mot de passe (!Qwerty123)</label>
                <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" required>
                <span id="err_MDP" class="text-danger err_texts">
                    <?php if (isset($erreurPassword)) {
                        echo $erreurPassword;
                    } ?>
                </span>
                <!-- required -->
            </div>
            <p class="bg-danger text-warning">À cause du changement de serveur à chaque request, il n'est pas très agréable de se connecter sur le site... Il faudrait synchroniser les 2 serveurs php ???</p>
            <div class="form-row my-3">
                <div class="col-6  col-md-8">
                    <button id="conn_submit" class="btn btn-success btn-block btn" type="submit" name='connexion' value="submit">Se connecter</button>
                </div>
                <div class="col-6  col-md-4">
                    <button id="conn_reset" class="btn btn-outline-danger btn-block btn" type="reset" name='connexion' value="reset">Réinitialiser</button>
                </div>
                <div class="col  col-md">
                    <p class="text-danger err_texts">
                        <?php
                        if (isset($erreurConnexion)) {
                            echo $erreurConnexion;
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </form>

</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>