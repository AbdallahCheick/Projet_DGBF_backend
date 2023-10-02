<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connexion.php');

$sql = "SELECT 
    DATE_FORMAT(date, '%d-%m-%Y') AS date_fr, 
    DATE_FORMAT(date, '%H') AS heure,
    COUNT(*) AS nombre_vehicules
FROM parking
GROUP BY 
    DATE_FORMAT(date, '%Y-%m-%d'),
    DATE_FORMAT(date, '%d-%m-%Y'), 
    DATE_FORMAT(date, '%H')
ORDER BY 
    DATE_FORMAT(date, '%Y-%m-%d'), 
    DATE_FORMAT(date, '%H');
";


$resultat = $connexion->query($sql);

if ($resultat) {
    $tabvaleur = array();
    while ($ligne = $resultat->fetch_assoc()) {
        $date = $ligne["date_fr"];
        $heure = $ligne["heure"];
        $sql_vehicules = "SELECT id, plaque FROM parking WHERE DATE_FORMAT(date, '%d-%m-%Y %H') = '$date $heure' 
            ORDER BY date";

        $resultat_vehicules = $connexion->query($sql_vehicules);

        if ($resultat_vehicules) {
            $tabvehicule = array();
            while ($row = $resultat_vehicules->fetch_assoc()) {
                $tabvehicule[] = $row;
            }

            $tabvaleur[] = array(
                'date_fr' => $date,
                'heure' => $heure,
                'nombre_vehicules' => $ligne['nombre_vehicules'], // Ajoutez le nombre de véhicules ici
                'vehicules' => $tabvehicule
            );
        }
    }

    // Renvoyez les données encodées en JSON
    echo json_encode($tabvaleur);
}
?>
