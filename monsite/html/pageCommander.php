<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");

if (!isset($_SESSION['type'])) {
    header("Location: pageConnexion.php");
    exit();
}

if (isset($_SESSION)) {
    if (isset($_POST['action'])) {
        
        switch ($_POST['action']) {
            case 'addCommande':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $estValide = true;
                    
                    if (!isset($_POST["sltAlbums"])) {
                        $erreurAlbum = "L'album est requis.";
                    } else {
                        $connAlbum = ValiderEntree($_POST["sltAlbums"]);
                    }
                    
                    if (!isset($_POST["sltOeuvres"])) {
                        $erreurOeuvre = "L'oeuvre est requis.";
                    } else {
                        $connOeuvre = ValiderEntree($_POST["sltOeuvres"]);
                    }
                    
                    if (!isset($_POST["nbOeuvre"])) {
                        $erreurNbOeuvre = "L'album est requis.";
                    } else {
                        $connNbOeuvre = ValiderEntree($_POST["nbOeuvre"]);
                        
                        if (!filter_var($connNbOeuvre, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 10]])) {
                            $erreurNbOeuvre = "Le nombre d'oeuvres n'est pas entre 1 et 10 inclus. Recommencer.";
                            $estValide = false;
                        }
                    }
                    
                    if ($estValide) {
                        if (isset($_SESSION['cart'])) {
                            $panier = unserialize($_SESSION['cart']);
                        } else {
                            $panier = new Panier();
                            $panier->setEtat('En cours');
                        }
                        
                        $newOeuvre = chercherOeuvre(explode(":", $connOeuvre)[0]);
                        $newAlbum = chercherAlbum(explode(":", $connAlbum)[0]);
                        $newProduit = new Produit($panier->getCountItems(), $newAlbum, $newOeuvre, $newOeuvre->getPrix(), $newAlbum->getImageName());
                        
                        $panier->addItem($newProduit, $connNbOeuvre);
                        
                        $_SESSION['cart'] = serialize($panier);
                        unset($_POST);
                        header("Location: pageCommander.php");
                        exit();
                        break;
                    }
                }
                
                case 'resetCommande':
                    if (isset($_SESSION['cart'])) {
                        unset($_SESSION['cart']);
                        unset($_POST);
                        header("Location: pageCommander.php");
                        exit();
                    }
                    break;
                    
                    case 'submitCommande':
                        if (isset($_SESSION['cart']) && isset($_SESSION['login'])) {
                            $panier = unserialize($_SESSION['cart']);
                            $idUtilisateur = unserialize($_SESSION['login'])->getID();
                            
                            $datetime = new DateTime();
                            $timezone = new DateTimeZone('America/Toronto');
                            $datetime->setTimezone($timezone);
                            
                            passerCommande($idUtilisateur, $datetime, $panier);
                            
                            if (isset($_SESSION['cart'])) {
                                unset($_SESSION['cart']);
                                unset($_POST);
                                header("Location: pageCommander.php");
                                exit();
                            }
                            
                        } else {
                            //Rien a acheter
                            
                        }
                        break;
                        
                        default:
                        # code...
                        break;
                    }
    }
}

require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");
?>

<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Commander</h2>
    <!-- <?= $_POST["SHIT"] ?> -->
    <div class="form-row justify-content-center">
        <!-- 1er form -->
        <form id="formAjouterCommande" class="form  justify-content-center was-validated col-12 col-md-4" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <fieldset class=" form-group border p-3 mb-3">
                <legend class="w-auto px-2">Choix des oeuvres :</legend>
                <div class="sticky-top pt-3">
                    <div class="form-group col">
                        <label class="" for="sltAlbums">Albums : </label>
                        <select class="form-control" name="sltAlbums" id="sltAlbums" required value="sltAlbums">

                            <option value="null" disabled selected></option>
                            <?php
                            $listeAlbums = GetListeAlbums();

                            foreach ($listeAlbums as $album) {
                                $id = $album->getID();
                                $titre = $album->getTitre();
                                echo "<option value='$id:$titre'>$titre</option>";
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group col">
                        <label class="form-check-label" for="sltOeuvres">Oeuvres : </label>
                        <select class="form-control" name="sltOeuvres" id="sltOeuvres" required>

                            <option value="null" disabled selected></option>

                        </select>
                        <p id="err_sltOeuvres" class="err_texts text-danger"></p>
                    </div>

                    <div class="form-group col">
                        <label for="nbOeuvre">Nombre : </label>
                        <input class="form-control " type="number" name="nbOeuvre" id="nbOeuvre" min=1 max=10 value=1 required>
                    </div>

                    <button type="submit" class="btn btn-block btn-info my-2" id="btn_addCommande" name="action" value="addCommande">Ajouter
                        à la commande</button>
                </div>
            </fieldset>
        </form>



        <!-- 2eme form -->
        <form id="formCommander" class="form  justify-content-center was-validated col-12 col-md-8" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <fieldset class=" form-group border p-3 mb-3 vertical-scrollable">
                <legend class="w-auto px-2">Commande :</legend>
                <div class="form-group col">
                    <div id="listCommande" class="row">
                        <!-- Commentaire ci-bas pour tests  -->
                        <!-- <div id="commande1" class="col-12 col-lg-6 mb-2 p-2 border">
                        <img id="" src="img/album1.jpeg" alt="qwerty" class="float-right img-thumbnail mb-2" width="75" height="75">
                        <h4>Oeuvre12</h4>
                        <p>Album7</p>
                        <input class="form-control mb-3" type="number" name="nbOeuvre1"
                            id="nbOeuvre1" value=1>
                        <div>
                            Prix unitaire:
                            <span id="prixUnitaire1">13,00</span>
                            $
                        </div>

                        <div class="font-weight-bold font-italic">
                            Prix:
                            <span id="prix1">13,00</span>
                            $
                        </div>
                        </div> -->
                        <?php
                        if (isset($_SESSION['cart'])) {
                            $panier = unserialize($_SESSION['cart']);
                            afficherProduits();
                        }
                        ?>
                    </div>
                </div>
            </fieldset>

            <div class="form-row col-12">
                <div class="col col-sm-8">
                    <button type="submit" class="btn btn-block btn-success my-2" id="btn_submitCommande" name="action" value="submitCommande">
                        Passer la commande
                    </button>
                </div>
                <div class="col col-sm-4">
                    <button type="submit" class="btn btn-block btn-outline-danger my-2" id="btn_resetCommande" name="action" value="resetCommande">
                        Réinitialiser
                    </button>
                </div>
            </div>
        </form>

        <div class="row col-12 bg-secondary p-2 my-2 justify-content-center">
            <div class="row col-12 col-md-6">
                <span class="font-weight-bolder  col-12 row">
                    <span class="col-6">
                        Prix total:
                    </span>
                    <span class="col-6">
                        =
                        <span id="prixTotalCommande"><?php if (isset($panier)) {
                                                            echo number_format($panier->getPrixTotal(), 2);
                                                        } else {
                                                            echo "0,00";
                                                        } ?></span>
                        $
                    </span>
                </span>

                <span class="font-weight-bolder  col-12 row">
                    <span id="rabaisTitre" class="col-6">
                        Rabais:
                    </span>
                    <span class="col-6">
                        −
                        <span id="prixRabaisCommande"><?php if (isset($panier)) {
                                                            echo number_format($panier->getRabais(), 2);
                                                        } else {
                                                            echo "0,00";
                                                        } ?></span>
                        $
                    </span>
                </span>

                <span class="font-weight-bolder  col-12 row">
                    <span class="col-6">
                        Prix total avant taxes:
                    </span>
                    <span class="col-6">
                        =
                        <span id="prixTotalAvantTaxesCommande"><?php if (isset($panier)) {
                                                                    echo number_format($panier->getPrixTotalAvantTaxes(), 2);
                                                                } else {
                                                                    echo "0,00";
                                                                } ?></span>
                        $
                    </span>
                </span>

                <span class="font-weight-bolder  col-12 row">
                    <span class="col-6">
                        Taxes (TPS & TVQ):
                    </span>
                    <span class="col-6">
                        +
                        <span id="taxesCommande"><?php if (isset($panier)) {
                                                        echo number_format($panier->getTaxes(), 2);
                                                    } else {
                                                        echo "0,00";
                                                    } ?></span>
                        $
                    </span>
                </span>
            </div>
            <div class="row col-12 col-md-6">
                <span class="font-weight-bolder lead col-12 col-md align-self-center">
                    Prix total avec taxes: =
                    <span id="prixTotalTaxesCommande"><?php if (isset($panier)) {
                                                            echo number_format($panier->getPrixTotalAvecTaxes(), 2);
                                                        } else {
                                                            echo "0,00";
                                                        } ?></span>
                    $
                </span>
            </div>
        </div>
    </div>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>