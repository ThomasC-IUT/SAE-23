#!/opt/lampp/bin/php/
<?php
$id_bd = mysqli_connect("localhost", "root", "passsae", "sae23")
    or die("Echec de la connexion au serveur et/ou à la base de données");

$sql = "SELECT NOM_salle, type FROM capteur";
$result = mysqli_query($id_bd, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $NOM_salle = $row['NOM_salle'];
    $type = $row['type'];

    // Subscribe to MQTT topic and get data
    $json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/$NOM_salle/data -C 1");
    $arr = json_decode($json, true);

    // Prepare data for insertion
    $date = date('Y-m-d');
    $heure = date("H:i:s");
    $heure = "'" . $heure . "'";
    $date = "'" . $date . "'";

    $devName = $arr[1]["deviceName"];
    $devName = "$devName" . "$type[0]";

    $value = $arr[0][$type];

    // Insert data into the database
    $requete = "INSERT INTO `mesure` (`date`, `horaire`, `valeur`, `NOM_capteur`) VALUES ($date, $heure, $value, '${devName}')";
    mysqli_query($id_bd, $requete)
        or die("Execution de la requete impossible : $requete");
}

mysqli_close($id_bd);
?>

