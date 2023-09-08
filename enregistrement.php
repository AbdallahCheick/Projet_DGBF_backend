<?php
include('connexion.php');
$method = $_SERVER['REQUEST_METHOD'];
$date = date('Y-m-d H:i:s');

if ($method == 'POST') { //verifiaction de la requete 
    $data = file_get_contents('php://input'); // Récupère le contenu du corps de la requête
$parsedData = json_decode($data, true);
$plaque = $parsedData['plaque'];
    if(preg_match('/^\d{4}[A-Za-z]{2}\d{2}$/', $plaque)) //verification de la plaque 
    { 
        
        try
        {
            $requete = "INSERT INTO parking(plaque, date) VALUES ('" . $plaque . "','" . $date . "')";
            $requete = mysqli_query($connexion, $requete);
            http_response_code(200) ; 
            echo ("Véhicule enregistré");
        } catch(Exception $e) {
            
            http_response_code(500) ; 
            echo ("Erreur lors de l'enregistrement");
        }
    }else
    {
        http_response_code(400) ; 
        echo ("Plaque invalide".$plaque);
    }
}else
{
    http_response_code(405) ; 
    echo ("Erreur sur la requete") ; 
}


?>
