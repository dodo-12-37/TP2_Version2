<div class="col col-sm-3 col-lg-2 jumbotron jumbotron-fluid m-0 p-1">
    <nav class="nav bg-dark flex-column nav-pills nav-justified text-center rounded sticky-top mt-5 mb-5">
        <?php
        $loginType = '';

        if (isset($_SESSION['login'])) {
            // $loginType = unserialize($_SESSION['login'])->getType();
            $loginType = $_SESSION['type'];
            echo '<form action="pageDeconnexion.php " method="post" style="max-width: 800px;" class="mx-auto p-3 col">';
            echo '<div class="form-row">';
            echo '<div class="col mx-auto">';
            echo '<button id="deconn_submit" class="btn btn-danger btn-block nav-item" type="submit" name="deconnexion_submit" value="submit">Se déconnecter</button>';
            echo '</div></div></form>';
        } else {
            echo '<div class="col mx-auto p-3">';
            echo '<a class="btn btn-success btn-block nav-item" href="pageConnexion.php">Connexion</a></div>';
        }

        echo "<p class='nav-item bg-danger text-warning'>";
        echo getenv('MON_SERVEUR');
        echo "</p>";

        if (isset($_SESSION['login'])) {
            $nomUserConnecter = unserialize($_SESSION['login'])->getNom();
            echo "<p class='nav-item text-info'>Bonjour $nomUserConnecter !!!</p>";
        }

        ?>
        <h3 class="navbar-text text-white">MENU</h3>
        <div class="p-3">
            <?php
            // if (isset($_SESSION['type'])) {
                
            //     echo "<p class='nav-item text-info'>À Supprimer<br>Session : $loginType </p>";
            // } else {
                
            //     echo "<p class='nav-item text-info'>À Supprimer<br>Session: Visiteur</p>";
            // }

            $menu = [
                "accueil" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageAccueil.php") . '" href="pageAccueil.php">Accueil</a>',
                "connexion" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageConnexion.php") . '" href="pageConnexion.php">Connexion</a>',
                "deconnexion" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageDeconnexion.php") . '" href="pageDeconnexion.php">Deconnexion</a>',
                "inscription" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageInscription.php") . '" href="pageInscription.php">Inscription</a>',
                "listeAlbum" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageListeAlbums.php") . '" href="pageListeAlbums.php">Afficher Albums</a>',
                "commander" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageCommander.php") . '" href="pageCommander.php">Commander</a>',
                "ajouterArtiste" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageArtiste.php") . '" href="pageArtiste.php">Ajouter Artiste</a>',
                "ajouterAlbum" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageAlbum.php") . '" href="pageAlbum.php">Ajouter Album</a>',
                "ajouterOeuvre" => '<a class="nav-item nav-link ' . estPageActive_Nav("pageOeuvre.php") . '" href="pageOeuvre.php">Ajouter Oeuvre</a>'
            ];

            $listNomPage = [];

            switch ($loginType) {
                case 'gerant':
                    $listNomPage = ['ajouterArtiste', 'ajouterAlbum', 'ajouterOeuvre', 'listeAlbum', 'accueil'];
                    break;

                case 'client':
                    $listNomPage = ['commander', 'listeAlbum', 'accueil'];
                    break;

                default:
                    $listNomPage = ['listeAlbum', 'inscription', 'accueil'];
                    break;
            }

            foreach ($menu as $nomMenu => $btnMenu) {
                if (in_array($nomMenu, $listNomPage)) {
                    echo $btnMenu;
                }
            }


            ?>
        </div>
    </nav>
</div>