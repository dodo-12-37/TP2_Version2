<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP2 Nginx LoadBalancer Site 01</title>
</head>
<body>

    <h1>TP2 Nginx LoadBalancer</h1>
    <p>Wow! Encore une page Web fait par DL!</p>
    <?php
        //<!-- Ajout cours ISS -->
        // echo "<p class='bg-danger text-warning'>";
        // echo getenv('MON_SERVEUR');
        // echo "</p>";
    ?>
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
</body>
</html>
