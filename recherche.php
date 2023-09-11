<?php
include('connexion.php') ; 

    //recuperation des entrées 
    $method = $_SERVER['REQUEST_METHOD'];  //stokage de la methode
    $date_heure_debut = $_GET['date_heure_debut']; // recuperation de la date et heure de debut
    $date_heure_fin = $_GET['date_heure_fin']; //recuperation de la date et heure de fin
    $plaque = $_GET['plaque']; //recuperation de la plaque
    $dateactuelle = date('Y-m-d H:i') ;  //date actuelle pour verifier les dates

    // Vérification de la methode
    if($method != 'GET')
    {
        http_response_code(405) ; 
        echo json_encode("erreur sur la methode") ; 
        exit;
    }

    //Verifiaction du format de la plaque 
    if (!empty($plaque) && !preg_match("/^[0-9]{4}[A-Za-z]{2}[0-9]{2}$/", $plaque)) 
    {
        http_response_code(400) ; 
        echo json_encode("Veuillez entrer une plaque valide EX :1234AB01");
        exit; 
    }

    //Verification des dates 

    $pres = "" ; 
    if((!empty($date_heure_debut) && !empty($date_heure_fin)))
    {
        $pres = "1" ;  
    }  


    ////Verifié que la date de debut soit superieur a la date de fin
    if(!empty($pres) && ($date_heure_debut > $date_heure_fin))
    {
        http_response_code(400); 
        echo json_encode("La date de debut ne doit pas etre superieur a la date de fin") ; 
        exit ; 
    }

    //Verifié que la date de fin soit superieur a la date actuelle
    if(!empty($pres) && ($date_heure_fin > $dateactuelle ))
    {
        http_response_code(400); 
        echo json_encode("La date de fin ne doit pas etre superieur a la date actuelle") ; 
        exit ; 
    }    

    //Verifié que la date de debut soit superieur a la date actuelle
    if(!empty($pres)&& ($date_heure_debut > $dateactuelle))
    {
        http_response_code(400); 
        echo json_encode("La date de debut ne doit pas etre superieur a la date actuelle") ;  
        exit ; 
    }

    //Constitution de la requete SQL 
    $sql = "SELECT * FROM parking WHERE 1   " ;       

    //Verification des dates et concatenation de la requete SQL
    if (!empty($date_heure_debut)&& (empty($date_heure_fin))) 
    {
        $sql .= " AND date >= '$date_heure_debut'";
    }
    elseif(!empty($date_heure_fin)&& (empty($date_heure_debut)))
    {
        $sql .= " AND date <= '$date_heure_fin'";
    }
    elseif(!empty($pres))
    {
        $sql .= " AND date >= '$date_heure_debut' AND date <= '$date_heure_fin'";
    }


    //Vérification de l'existance de la plaque et ensuite ajout la requete correspondante
    if (!empty($plaque)) {
        $sql .= " AND plaque = '$plaque'";
    }
        
    $sql .= " ORDER BY date"; //Ajout de l'ordonnement par ordre croissant

    //Affichage du tableau json des resultats de la requete 
    try
    {
        http_response_code(200) ;      
        $resultat = $connexion->query($sql);
        $tableauResultats = array();
        while ($ligne = $resultat->fetch_assoc()) { // stockage des ligne dans $tableauResultats[]
            $tableauResultats[] = $ligne;
        }
        echo json_encode($tableauResultats);
    }
    catch(Exception $e)
    {
        http_response_code(500) ;
        echo json_encode("erreur au niveau de la requete"); 
        echo ($sql) ; 
    }
    
?>