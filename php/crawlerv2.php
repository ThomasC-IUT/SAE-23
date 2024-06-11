#!/opt/lampp/bin/php/
<?php
$id_bd = mysqli_connect("localhost", "root", "passsae", "sae23")
    or die("Echec de la connexion au serveur et/ou à la base de données");

while (true) {
    $sql = "SELECT DISTINCT NOM_salle FROM capteur";
    $result = mysqli_query($id_bd, $sql);
    
    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . mysqli_error($id_bd));
    }

    // Fetch all room names
    $rooms = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row['NOM_salle'];
    }
    
    foreach ($rooms as $nom_salle) {
        // Fetch distinct sensor types for each room
        $sql_val = "SELECT type FROM capteur WHERE NOM_capteur = '$nom_salle'";
        $result_val = mysqli_query($id_bd, $sql_val);
        
        if (!$result_val) {
            die("Erreur lors de l'exécution de la requête : " . mysqli_error($id_bd));
        }

        while ($type_row = mysqli_fetch_assoc($result_val)) {
            $type = $type_row['type'];
            
            // Subscribe to MQTT topic and get data
            $json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/$nom_salle/data -C 1");
            $arr = json_decode($json, true);
            
            if ($arr) {
                // Prepare data for insertion
                $date = date('Y-m-d');
                $heure = date("H:i:s");
                
                $devName = $arr['deviceName'] . $type;
                $value = isset($arr[$type]) ? $arr[$type] : 0; // Ensure $value is set even if the key does not exist
                
                // Insert data into the database
                $requete = "INSERT INTO mesure (`date`, `horaire`, `valeur`, `NOM_capteur`) VALUES ('$date', '$heure', $value, '$devName')";
                $insert_result = mysqli_query($id_bd, $requete);
                
                if (!$insert_result) {
                    echo "Execution de la requete impossible : " . mysqli_error($id_bd);
                }
            } else {
                echo "Erreur lors de la réception des données MQTT pour $nom_salle";
            }
        }
    }
    
    // Sleep for a while to avoid overwhelming the server
    sleep(10);
}

mysqli_close($id_bd);
?>
