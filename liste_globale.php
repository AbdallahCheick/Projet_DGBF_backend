<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
include('connexion.php');

// Vérification de la connexion
if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Récupération des données de la table
$sql = "SELECT id, plaque, date FROM parking"; // Remplacez "nom_de_votre_table" par le nom réel de votre table
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "Aucune donnée trouvée dans la table.";
}

// Fermeture de la connexion
$connexion->close();
?>
