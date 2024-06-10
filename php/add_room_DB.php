<?php
include 'connect.php';
$conn= connect();

// getting data from the form
$nom = $_POST['nom'];
$type = $_POST['type'];
$capacite = $_POST['capacite'];
$id = $_POST['ID_bat'];

// preparing sql request
$sql = "INSERT INTO salle (NOM_salle, type, capacite, ID_bat) VALUES ('$nom', '$type', '$capacite', '$id')";

//check for error
if (mysqli_query($conn, $sql) === TRUE) {  
  echo "Nouvel enregistrement cree avec succes !";
} else {
    
	echo mysqli_error($conn);
}

// close the connection
mysqli_close($conn);
?>
