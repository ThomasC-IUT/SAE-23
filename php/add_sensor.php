<?php



include 'connect.php';

$conn = connect();

//preparing and executing sql request
$sql = "SELECT NOM_salle FROM salle";
$result = mysqli_query($conn, $sql);

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
    <title>Ajouter un capteur</title>
</head>
<body>
    <h2>Ajouter un capteur dans la base de données</h2>
    <form action='add_sensor_DB.php' method='post'>

<?php
	if(mysqli_num_rows($result) > 0) {

		
		echo  "<label for='NOM_salle'>NOM_salle</label>";
		echo  "<select id='NOM_salle' name='NOM_salle' required>";

			while($row = mysqli_fetch_assoc($result)) {
			
			echo "<option value=".$row["NOM_salle"].">".$row["NOM_salle"]."<option>";

			}
    		echo"</select>";
	} 
	
	else {
		echo "aucun batiment dans la base";
	}

mysqli_close($conn);
?>

		<label for="nom">Nom capteur </label>
        <input type="text" id="nom" name="nom" required><br><br>


        <label for="unite">unite </label>
        <input type="text" id="unite" name="unite" required><br><br>
		
		<label for="type">Type </label>
        <select id="type" name="type" required>
            <option value="temperature">Temperature</option>
            <option value="co2">co2</option>
            
        </select><br><br>
        

		<input class="in" type="submit" value="Ajouter">
		
		
		<a href="../accueil_admin.html">Retour</a>
		
		
    </form>
	
</body>
</html>














