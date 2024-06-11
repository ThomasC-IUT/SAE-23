<?php



include 'connect.php';

$conn = connect();

//preparing and executing sql request
$sql = "SELECT ID_bat, nom, login FROM batiment";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/style_del.css">
    <title>Supprimer batiment</title>
</head>
<body>
    <h2>Supprimer un batiment</h2>

    <?php

	if(mysqli_num_rows($result) > 0) {

  	//display the name of each column
        echo "<table border='1'>";
        echo "<tr><th>ID_bat</th><th>Nom</th><th>Login</th><th>Action</th></tr>";
        
     // put each line in an associative table
		while($row = mysqli_fetch_assoc($result)) {
			//display each building in a table in html           
			echo "<tr>";
            echo "<td>" . $row["ID_bat"] . "</td>";
            echo "<td>" . $row["nom"] . "</td>";
            echo "<td>" . $row["login"] . "</td>";
            echo "<td>";
            echo "<form action='del_bat.php' method='post' style='display:inline;'>";
            echo "<input type='hidden' name='id_bat' value='" . $row["ID_bat"] . "'>";
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

