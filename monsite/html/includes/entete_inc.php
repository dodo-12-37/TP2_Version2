<?php
//https://stackoverflow.com/questions/20308478/where-exactly-do-i-put-a-session-start
// define('__ROOT__', dirname(__FILE__));
// require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS Homemade -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- CSS Bootstrap 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <?php

    if ($titleName != "Accueil" && $titleName != "ListeAlbums") {
        //<!-- Main JS -->
        echo "<script defer src='js/$jsFilename'></script>";
    }
    
    echo "<title>$titleName</title>";
    ?>

    <script defer src="js/nav.js"></script>
    
    <!-- <script>
        var DOCUMENT_ROOT = "<?= $_SERVER['DOCUMENT_ROOT'] ?>";
    </script> -->
</head>

<body>
    <div id="page" class="bg-white" style="min-width: 150px;">
        <header class="jumbotron text-center jumbotron-fluid mb-0 pt-4 pb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid col col-sm-3 align-self-center">
                        <img id="logo" class="img-fluid img-thumbnail rounded-pill" src="img/MML_crop300px.gif" alt="Logo MML">
                    </div>
                    <div class="container-fluid col col-sm-9 align-self-center">
                        <h1 class="p-1">Magasin de Musique en Ligne</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                <?php
                include_once($_SERVER['DOCUMENT_ROOT']."/includes/navigateur_inc.php");
                ?>