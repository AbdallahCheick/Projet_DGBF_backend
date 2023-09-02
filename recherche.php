<?php
    include('connexion.php');
    if (isset($_POST['rechercher'])) {
        $date_heure_debut = $_POST["date_heure_debut"];
        $date_heure_fin = $_POST["date_heure_fin"];
        $plaque = $_POST["plaque"];
        
        // Conversion des datetime-local en variables distinctes
        $date_debut = substr($date_heure_debut, 0, 10);
        $heure_debut = (int)substr($date_heure_debut, 11, 5);
        
        $date_fin = substr($date_heure_fin, 0, 10);
        $heure_fin =(int)substr($date_heure_fin, 11, 5);

        
        if (!empty($plaque) && !preg_match("/^[0-9]{4}[A-Za-z]{2}[0-9]{2}$/", $plaque)) {
            echo '<script>alert("La plaque d\'immatriculation ne respecte pas le format attendu (1234AB12).");</script>';
            echo "<p></p>";
            exit; 
        }

        //Requete SQL de la gloire
        $sql = "SELECT * FROM parking WHERE 1   " ; 
        //SELECT * FROM `parking` WHERE DATE_FORMAT(date, '%Y-%m-%d %H:%i' )>='2023-08-28 08:35'
      
        if (!empty($date_debut) && !empty($date_fin)) {
                $sql .= " AND DATE_FORMAT(date, '%Y-%m-%dT%H:%i' ) >= '$date_heure_debut' AND DATE_FORMAT(date, '%Y-%m-%dT%H:%i' ) <= '$date_heure_fin'";
        }

        if (!empty($plaque)) {
            $sql .= " AND plaque = '$plaque'";
        }
        
        $sql .= " ORDER BY date";
        $resultat = $connexion->query($sql);

        if ($resultat) {
            $tableauResultats = array();
            while ($ligne = $resultat->fetch_assoc()) {
                $tableauResultats[] = $ligne;
            }
            echo json_encode($tableauResultats);
        }
        else
        {
            echo "0" ; 
        }
    }
    
?>