<?php 
    $connexion = mysqli_connect("localhost", "root", "", "part1") ; 
    if(!$connexion){
        die("impossible de faire la connexion". mysqli_connect_error()) ; 
    }
?>