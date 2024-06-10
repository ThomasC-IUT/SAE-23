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
	<link rel="stylesheet" type="text/css" href="../styles/style_admin.css">
    <title>Ajouter une salle</title>
</head>
<body>
    <h2>Ajouter une salle dans la base de données</h2>
    <form action='add_room_DB.php' method='post'>

<?php
	if(mysqli_num_rows($result) > 0) {

		
		echo  "<label for='ID_bat'>Id_bat </label>";
		echo  "<select id='ID_bat' name='ID_bat' required>";

			while($row = mysqli_fetch_assoc($result)) {
			
			echo "<option value=".$row["ID_bat"].">".$row["ID_bat"]."<option>";

			}
    		echo"</select>";
	} 
	
	else {
		echo "aucun batiment dans la base";
	}

mysqli_close($conn);
?>

		<label for="nom">Nom salle </label>
        <input type="text" id="nom" name="nom" required><br><br>


        <label for="capacite">Capacite </label>
        <input type="number" id="capacite" name="capacite" required><br><br>
		
		<label for="type">Type </label>
        <select id="type" name="type" required>
            <option value="TP">TP</option>
            <option value="TD">TD</option>
            <option value="AMP">Amphi</option>
        </select><br><br>
        

		<input class="in" type="submit" value="Ajouter">
		
		
		<a href="../accueil_admin.html">Retour</a>
		
		
    </form>
	
</body>
</html>














