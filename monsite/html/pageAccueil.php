<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/functions_inc.php");
//define('__ROOT__', dirname(__FILE__));
// var_dump($_SERVER['DOCUMENT_ROOT']);
// var_dump(__ROOT__."/includes/entete_inc.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/entete_inc.php");
?>

<!-- Binh, Michel, Dom -->
<main class="col col-sm-9 col-lg-10 pt-2 pb-4">
    <h2 class="text-center my-4">Accueil</h2>
    
    <p class="text_accueil">Magasin de musique en ligne - MML</p>
    <p class="text_accueil">Notre magasin vous offre le meilleur de la musique classique, folk, rock,
        rap, jazz, blues, country et techno. Vous pouvez achetez les oeuvres des plus grands artistes
        du moment à des prix exceptionnels. De plus, notre site est simple et rapide d'utilisation pour les amateurs
        de musique car nous savons que votre temps est précieux.</p>
    <p class="text_accueil">Visitez notre page d'albums pour un coup d'oeil rapide et repérer les albums de vos
        artistes favoris. Inscrivez-vous sur la page d'inscription et commander vos oeuvres sur la page des commandes.
        Notre site vous offrira de nouvelle options dans un futur proche et la quantité d'oeuvres disponibles ne cessera
        de s'accroître. Nous vous promettons plein d'agréables surprises!</p>
    <div class="text-center bg-danger text-warning">
        <h1>TP2 Nginx LoadBalancer</h1>
        <p>Wow! Encore une page Web fait par DL!</p>

        <h3>Je te test!</h3>
        <h4>Tentative de connexion 
            <?php
            echo getenv('MON_HOST')
            ?> 
        depuis 
        <?php
            echo getenv('MON_SERVEUR')
            ?> ...</h4>
            
        <?php  
        $host = getenv('MON_HOST'); 
        $user = 'root'; 
        $pass = 'rootpassword'; 
        $conn = new mysqli($host, $user, $pass); 
        
        if ($conn->connect_error) { 
            die("La connexion a ". getenv('MON_HOST') ." échoué: " . $conn->connect_error); 
        }  
        
        echo "Connexion réussie à ". getenv('MON_HOST'). "!"; 
        //phpinfo();
        ?>
    </div>
</main>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/includes/pied_inc.php");
?>
