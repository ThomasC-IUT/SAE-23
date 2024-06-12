#!/opt/lampp/bin/php/
<?php
$id_bd = mysqli_connect("localhost", "root", "passsae", "sae23")
    or die("Echec de la connexion au serveur et/ou à la base de données");

while (true) {

	// Access to the name of each room from the database	
	$sql = "SELECT DISTINCT NOM_salle FROM capteur";
	$result = mysqli_query($id_bd, $sql);
	// transform the result of the request to an array
	$tab = mysqli_fetch_array($result);

	// for loop to insert data for each room
	for ($i = 0; $i <= count($tab); $i++) {
		// Access to the type of value for one room
		$sql_val = "SELECT type FROM capteur WHERE NOM_capteur = $tab[$i]";
		$result_val = mysqli_query($id_bd, $sql_val);

		$val = mysqli_fetch_array($result_val);
		
		// Subscribe to MQTT topic and get data
		$json = shell_exec("mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/$NOM_salle/data -C 1");
		$arr = json_decode($json, true);

		// Prepare data for insertion
		$date = date('Y-m-d');
		$heure = date("H:i:s");
		$heure = "'" . $heure . "'";
		$date = "'" . $date . "'";

		// Insert data into the database
		$requete = "INSERT INTO `mesure` (`date`, `horaire`, `valeur`, `NOM_capteur`) VALUES ($date, $heure, $value, '${devName}')";
		mysqli_query($id_bd, $requete)
		    or die("Execution de la requete impossible : $requete");

		//for loop to insert data for the type of value

		for ($j = 0; $j <= count($val); $j++) {

			$devName = $arr[1]["deviceName"];
			$devName = "$devName" . "$j[0]";

			$value = $arr[0][$j];

			echo "$j";
			echo "$devname";
			echo "$value";
			echo "${devName}";
			
			// Insert data into the database
			$requete = "INSERT INTO mesure (`date`, `horaire`, `valeur`, `NOM_capteur`) VALUES ($date, $heure, $value, '${devName}')";
			mysqli_query($id_bd, $requete)
		    		or die("Execution de la requete impossible : $requete");
			echo mysqli_error($id_bd);
			
			
		}
	}
}
mysqli_close($id_bd);
?>

