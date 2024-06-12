<?php


session_start();

include 'connect.php';
$conn = connect();

//verify that the session is active with a building
	if (!isset($_SESSION['ID_bat'])) {
		//if not then redirect the user to the login page
		header("Location: login_bat.php");
		exit();	
	}

//get the id of the building
	if (isset($_GET['id'])) {
		$id_bat=$_GET['id'];
	}
	else {
		echo " ID innexistant";
	exit();
}

//prepare the sql request
$sql = "SELECT * FROM `batiment` WHERE ID_bat=".'"'.$id_bat.'"';
//execute the sql request
$result = mysqli_query($conn, $sql);


//storing the information of the building
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $departement = $row['nom'];
} else {
    echo "Informations du bâtiment non trouvées.";
    exit();
}

//preparing sql request to get the room's information
$sql_salles = "SELECT NOM_salle, type, capacite FROM salle WHERE ID_bat=".'"'.$id_bat.'"';
//executing it
$result_salles= mysqli_query($conn,$sql_salles);

//create a table to store the room
$salles = [];
if (mysqli_num_rows($result_salles) > 0) {
	   
	 //loop to get the rooms informations
	while ($row_salle = mysqli_fetch_assoc($result_salles)) {
        $nom_salle = $row_salle['NOM_salle'];


		//preparing sql request to get the sensor's information
        $sql_capteurs = "SELECT NOM_capteur, type, unite FROM capteur WHERE NOM_salle = '$nom_salle'";
        $result_capteurs = mysqli_query($conn, $sql_capteurs);
      
	  //create a table to store the sensors
		$capteurs = [];

		
        if (mysqli_num_rows($result_capteurs) > 0) {
				
				//create associative table with each row            
				while ($row_capteur = mysqli_fetch_assoc($result_capteurs)) {
                 $nom_capteur = $row_capteur['NOM_capteur'];
                

				//preparing sql request to get the values of the metric for each sensor
				$sql_mesures = "
                    SELECT ID_mesure, date, valeur, 
                    (SELECT MIN(valeur) FROM mesure WHERE NOM_capteur = '$nom_capteur') AS min_valeur,
                    (SELECT MAX(valeur) FROM mesure WHERE NOM_capteur = '$nom_capteur') AS max_valeur,
                    (SELECT AVG(valeur) FROM mesure WHERE NOM_capteur = '$nom_capteur') AS moyenne_valeur
                    FROM mesure
                    WHERE NOM_capteur = '$nom_capteur'";
				//execute the sql query                
				$result_mesures = mysqli_query($conn, $sql_mesures);
				
				//create table to store the values and variable for min, max, and average                
				$mesures = [];
                $min_valeur = null;
                $max_valeur = null;
                $moyenne_valeur = null;

				

                if (mysqli_num_rows($result_mesures) > 0) {
					//create associative table with each row of the DB
                    while ($row_mesure = mysqli_fetch_assoc($result_mesures)) {
                        $mesures[] = $row_mesure;
                        //get the max, min and average
						if ($min_valeur === null) {
                            $min_valeur = $row_mesure['min_valeur'];
                            $max_valeur = $row_mesure['max_valeur'];
                            $moyenne_valeur = $row_mesure['moyenne_valeur'];
                        }
                    }
                }
                //store it 
                $row_capteur['mesures'] = $mesures;
                $row_capteur['min_valeur'] = $min_valeur;
                $row_capteur['max_valeur'] = $max_valeur;
                $row_capteur['moyenne_valeur'] = $moyenne_valeur;
                $capteurs[] = $row_capteur;
            }
        }
        $row_salle['capteurs'] = $capteurs;
        $salles[] = $row_salle;
    }
} else {
    echo "Aucune salle trouvée pour ce bâtiment.";
}





mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Gestion du Bâtiment</title>
	  <link rel="stylesheet" href="../styles/style_del.css">
</head>
<body>
    <h2>Bienvenue dans la gestion du bâtiment: <?php echo($id_bat); ?></h2>
    
    <h3>Departement: <?php echo ($departement); ?></h3>


 
    <?php if (!empty($salles)): ?>
        <?php foreach ($salles as $salle): ?>
            <h2><?php echo ($salle['NOM_salle']); ?> (Type: <?php echo ($salle['type']); ?>, Capacité: <?php echo ($salle['capacite']); ?>)</h2>
            <?php if (!empty($salle['capteurs'])): ?>
                <?php foreach ($salle['capteurs'] as $capteur): ?>
                 <h4>Capteur: <?php echo ($capteur['NOM_capteur']); ?> (Type: <?php echo ($capteur['type']); ?>, Unité: <?php echo ($capteur['unite']);?>)</h4>					

						
								<table border="1">
						    <tr>
                                <th>Valeur min</th>
                                <th>Valeur max</th>
                                <th>Valeur moyenne</th>
                            </tr>
							<tr>
                                    <td><?php echo ($capteur['min_valeur']); ?></td>
                                    <td><?php echo ($capteur['max_valeur']); ?></td>
                                    <td><?php echo ($capteur['moyenne_valeur']); ?></td>
                                </tr>

								</table>

					
                    <?php if (!empty($capteur['mesures'])): ?>
                        <table border="1">
                            <tr>
                                <th>ID Mesure</th>
                                <th>Date</th>
                                <th>Valeur</th>
                            </tr>
                            <?php foreach ($capteur['mesures'] as $mesure): ?>
                                <tr>
                                    <td><?php echo ($mesure['ID_mesure']); ?></td>
                                    <td><?php echo ($mesure['date']); ?></td>
                                    <td><?php echo ($mesure['valeur']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        
						

                    <?php else: ?>
                        <p>Aucune mesure trouvée pour ce capteur.</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun capteur trouvé pour cette salle.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune salle trouvée pour ce bâtiment.</p>
    <?php endif; ?>
</body>
</html>







