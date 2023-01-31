<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");

if (!isset($_SESSION['type'])) {
    header("Location: pageConnexion.php");
    exit();
}

if (isset($_POST['deconnexion_submit']) && $_POST['deconnexion_submit'] == 'submit') {
    if (isset($_SESSION)) {
        session_unset();
        session_destroy();
        header("Location: pageAccueil.php");
        exit();
    }
}
?>

<!-- Binh, Michel, Dom -->
<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Déconnexion</h2>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="max-width: 800px;" class="mx-auto my-4 col">
        <div class="form-row my-3">
            <div class="col mx-auto">
                <button id="deconn_submit2" class="btn btn-danger btn-block" type="submit" name='deconnexion_submit' value="submit">Se déconnecter</button>
            </div>
        </div>
    </form>

</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>