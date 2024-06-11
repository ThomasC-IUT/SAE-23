<?php
include 'connect.php';
$conn= connect();

// getting data from the form
$nom = $_POST['nom'];
$type = $_POST['type'];
$unite = $_POST['unite'];
$nom_salle = $_POST['NOM_salle'];

// preparing sql request
$sql = "INSERT INTO capteur (NOM_capteur, type, unite, NOM_salle) VALUES ('$nom', '$type', '$unite', '$nom_salle')";

//check for error
if (mysqli_query($conn, $sql) === TRUE) {  
  echo "Nouvel enregistrement cree avec succes !";
} else {
    
	echo mysqli_error($conn);
}

// close the connection
mysqli_close($conn);
?>
