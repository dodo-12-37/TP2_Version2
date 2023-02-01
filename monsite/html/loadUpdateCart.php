<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");

if (isset($_SESSION['cart'])) {

    $panier = unserialize($_SESSION['cart']);

    if (isset($_POST['Quantite']) && isset($_POST['Index'])) {
        $quantite =  $_POST['Quantite'];
        $index =  $_POST['Index'];
        $listeItems = $panier->getItems();

        // if ($quantite > 0) {
            $panier->addItem($listeItems[$index]['item'], $quantite);
        // }else {
        //     $panier->deleteItem($listeItems[$index]['item']);
        // }

        $_SESSION['cart'] = serialize($panier);
        afficherProduits();
        //var_dump($panier);
    }
}
?>
