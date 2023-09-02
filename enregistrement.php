<?php
include('connexion.php');
$date = date('Y-m-d H:i:s');
if (isset($_POST['enregistrer'])) { 
    $plaque = $_POST['plaque'];
    if (!empty($plaque)) {
        $requete = "INSERT INTO parking(plaque, date) VALUES ('" . $plaque . "','" . $date . "')";
        $requete = mysqli_query($connexion, $requete);
        if ($requete) {
            echo json_encode("Véhicule enregistré");
        } else {
            echo json_encode("Erreur lors de l'enregistrement");
        }
    }
}
?>
