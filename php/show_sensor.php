<?php



include 'connect.php';

$conn = connect();

//preparing and executing sql request
$sql = "SELECT NOM_capteur, type, unite, NOM_salle FROM capteur";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/style_del.css">
    <title>Supprimer un capteur</title>
</head>
<body>
    <h2>Supprimer un capteur</h2>

    <?php

	if(mysqli_num_rows($result) > 0) {

  	//display the name of each column
        echo "<table border='1'>";
        echo "<tr><th>NOM_capteur</th><th>type</th><th>unite</th><th>NOM_salle</th><th>Action</th></tr>";
        
     // put each line in an associative table
		while($row = mysqli_fetch_assoc($result)) {
			//display each building in a table in html           
			echo "<tr>";
            echo "<td>" . $row["NOM_capteur"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["unite"] . "</td>";
			echo "<td>" . $row["NOM_salle"] . "</td>";
            echo "<td>";
            echo "<form action='del_sensor.php' method='post' style='display:inline;'>";
            echo "<input type='hidden' name='nom_capteur' value='" . $row["NOM_capteur"] . "'>";
            echo "<button type='submit'>Supprimer</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
	
        }
        echo "</table>";
		
    } else {
        echo "Aucune entrée trouvée.";
    }

    // close connection
    mysqli_close($conn);
    ?>
</body>
</html>

