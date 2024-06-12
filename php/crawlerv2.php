#!/opt/lampp/bin/php/
<?php
$id_bd = mysqli_connect("localhost", "root", "passsae", "sae23")
    or die("Echec de la connexion au serveur et/ou à la base de données");

while (true) {
    $sql = "SELECT DISTINCT NOM_salle FROM capteur";
    $result = mysqli_query($id_bd, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $NOM_salle = $row['NOM_salle'];
        $sql_val = "SELECT type, NOM_capteur FROM capteur WHERE NOM_salle = '$NOM_salle'";
        $result_val = mysqli_query($id_bd, $sql_val);

        while ($val = mysqli_fetch_assoc($result_val)) {
            $type = $val['type'];
            $NOM_capteur = $val['NOM_capteur'];
            
            // Subscribe to MQTT topic and get data
            $json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/$NOM_salle/data -C 1");
            $arr = json_decode($json, true);
            
            if (is_array($arr) && isset($arr[1]["deviceName"], $arr[0][$type])) {
                // Prepare data for insertion
                $date = date('Y-m-d');
                $heure = date("H:i:s");
                $devName = $arr[1]["deviceName"] . $type;
                $value = $arr[0][$type];

                // Insert data into the database
                $requete = "INSERT INTO mesure (`date`, `horaire`, `valeur`, `NOM_capteur`) 
                            VALUES ('$date', '$heure', '$value', '$devName')";
                mysqli_query($id_bd, $requete) or die("Execution de la requete impossible : $requete");
            } else {
                // Handle error or log if the expected data structure is not found
                echo "Erreur: données MQTT inattendues pour $NOM_salle";
            }
        }
    }

    // Sleep for a while to prevent continuous execution
    sleep(60); // Sleep for 60 seconds before next iteration
}

mysqli_close($id_bd);
?>
