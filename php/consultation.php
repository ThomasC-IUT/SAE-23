<?php



include 'connect.php';

$conn = connect();

//preparing and executing sql request
$sql = "SELECT ID_mesure, date, horaire, valeur, NOM_capteur FROM mesure ORDER BY ID_mesure DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/style_del.css">
    <title>Consultation</title>
</head>
<body>
    <h2>Consultation</h2>

    <?php

	

  	//display the name of each column
        echo "<table border='1'>";
        echo "<tr><th>ID_mesure</th><th>date</th><th>horaire</th><th>valeur</th><th>NOM_capteur</th></tr>";
        if(mysqli_num_rows($result) > 0) {
     // put each line in an associative table
		$row = mysqli_fetch_assoc($result);
			//display in html           
			echo "<tr>";
            echo "<td>" . $row["ID_mesure"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["horaire"] . "</td>";
			echo "<td>" . $row["valeur"] . "</td>";
			echo "<td>" . $row["NOM_capteur"] . "</td>";
            echo "</tr>";
		echo "</table>";

	
        }
       
		
     else {
        echo "Aucune entrée trouvée.";
    }

    // close connection
    mysqli_close($conn);
    ?>
</body>
</html>

