<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");

$album =  $_POST['album'];
$listeOeuvres = chercherOeuvres($album);

foreach ($listeOeuvres as $oeuvre) {
    $id = $oeuvre->getID();
    $titre = $oeuvre->getTitre();
    echo "<option value='$id:$titre'>$titre</option>";
}
?>