<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP2 Nginx LoadBalancer Site 02</title>
</head>
<body>
    <p>Wow! Encore une page Web fait par DL!</p>
    <p>TP2 Nginx LoadBalancer Site 02</p>

    <h1>Je te test!</h1>
    <h4>Tentative de connexion MariaDB depuis PHP...</h4>

    <?php  
    $host = 'mariadb2'; 
    $user = 'root'; 
    $pass = 'rootpassword'; 
    $conn = new mysqli($host, $user, $pass); 

    if ($conn->connect_error) { 
        die("La connexion a échoué: " . $conn->connect_error); 
    }  

    echo "Connexion réussie à MariaDB!"; 
    
    phpinfo();
    ?>
</body>
</html>