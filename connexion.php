
<?php

    $dbHost = getenv('DB_HOST');
    $dbName = getenv('DB_Name');
    $dbUser = getenv('DB_User');
    $dbpassword= getenv('DB_Password');
    $connexion = mysqli_connect($dbHost, $dbUser, $dbpassword, $dbName) ;
    if(!$connexion)
    {
        die("impossible de faire la connexion". mysqli_connect_error()) ;
    }
?>
