<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");
?>

<main class="col col-sm-9 col-lg-10 pt-2 pb-4 text-center">
    <h2 class="my-4">Liste des albums disponible</h2>

    <div id="listeAlbums" class="row p-0">
        <!-- <div id="album1" class="col-12 col-sm-6 col-md-4 col-lg-3 pt-4 pb-4">
            <h4 class="">Album 1</h4>
            <a class="collapsed" data-toggle="collapse" href="#image1" role="button"
                aria-expanded="false" aria-controls="image1">
                <img class="img-thumbnail" src="img/artiste_photo.png" alt="Album 1"
                    data-toggle="tooltip" data-placement="top"
                    title="Cliquer pour voir les oeuvres associées">
            </a>
            <div class="collapse multi-collapse" id="image1">
                <ul class="list-group">
                    <li class="list-group-item">Oeuvre 1</li>
                    <li class="list-group-item">Oeuvre 2</li>
                    <li class="list-group-item">Oeuvre 3</li>
                    <li class="list-group-item">Oeuvre 4</li>
                </ul>
            </div>
        </div> -->
        <!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3 container pt-4 pb-4" id="album1">
            <h4>Album 1</h4><a data-toggle="collapse" href="#image1" role="button" data-ariaexpanded="false" data-ariacontrols="image1" class="" aria-expanded="true"><img class="img-thumbnail" src="img/album1.jpeg" alt="Album 1" data-toggle="tooltip" data-placement="top" title="Cliquer pour voir les oeuvres associées"></a>
            <div class="multi-collapse collapse show" id="image1">
                <ul class="list-group">
                    <li class="list-group-item">Oeuvre 1</li>
                    <li class="list-group-item">Oeuvre 2</li>
                    <li class="list-group-item">Oeuvre 3</li>
                    <li class="list-group-item">Oeuvre 4</li>
                    <li class="list-group-item">Oeuvre 5</li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 container pt-4 pb-4" id="album1">
            <h4>Album 1</h4><a data-toggle="collapse" href="#image1" role="button" data-ariaexpanded="false" data-ariacontrols="image1" class="collapsed" aria-expanded="false"><img class="img-thumbnail" src="img/album1.jpeg" alt="Album 1" data-toggle="tooltip" data-placement="top" title="Cliquer pour voir les oeuvres associées"></a>
            <div class="multi-collapse collapse" id="image1">
                <ul class="list-group">
                    <li class="list-group-item">Oeuvre 1</li>
                    <li class="list-group-item">Oeuvre 2</li>
                    <li class="list-group-item">Oeuvre 3</li>
                    <li class="list-group-item">Oeuvre 4</li>
                    <li class="list-group-item">Oeuvre 5</li>
                </ul>
            </div>
        </div> -->
        <?php
        $listeAlbums = chercherAlbums();
        foreach ($listeAlbums as $indiceAlbum => $album) {
            //var_dump($album);
            $nomImage = $album->getImageName();
        ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 container pt-4 pb-4" id="album1">
                <h4><?= $album->getTitre() ?></h4>
                <a data-toggle="collapse" href="#image<?= $indiceAlbum +1?>" role="button" data-ariaexpanded="false" 
                    data-ariacontrols="image<?= $indiceAlbum +1?>" class="collapsed" aria-expanded="false">
                    <img class="img-thumbnail" src="img/<?= $nomImage ?>" alt="Album <?= $indiceAlbum +1?>" data-toggle="tooltip" 
                        data-placement="top" title="Cliquer pour voir les oeuvres associées">
                </a>
                <div class="multi-collapse collapse" id="image<?= $indiceAlbum +1?>">
                    <ul class="list-group">
                        <?php
                        //var_dump($album->getListeOeuvres());
                        //if (count($album->getListeOeuvres()) == 0 ) {
                            foreach ($album->getListeOeuvres() as $indiceOeuvre => $oeuvre) {
                                echo "<li class='list-group-item'>" . $oeuvre->getTitre() ."</li>";
                            }
                        //}
                        ?>
                    </ul>
                </div>
            </div>
        <?php

        }
        ?>


    </div>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>