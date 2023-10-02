<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connexion.php');
    
// Récupérez la date et l'heure depuis l'URL
$date = $_GET['date'];
$heure = $_GET['heure'];

// Requête SQL pour obtenir la liste des véhicules pour la date et l'heure précises
$sql = "SELECT id, plaque,date, DATE_FORMAT(date, '%H:%i') AS heure FROM parking WHERE DATE_FORMAT(date, '%d-%m-%Y') = '$date' AND DATE_FORMAT(date, '%H') = '$heure'";
    
// Exécution de la requête SQL
$resultat = $connexion->query($sql);
    
if ($resultat) {
    $tableauResultats = array();
    while ($ligne = $resultat->fetch_assoc()) {
        $tableauResultats[] = $ligne;
    }
    echo json_encode($tableauResultats);
} else {
    echo "0";
}
?>
