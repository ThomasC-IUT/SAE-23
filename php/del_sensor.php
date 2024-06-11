<?php



include 'connect.php';
$conn = connect();



// getting the name to delete
$NOM_capteur = $_POST['nom_capteur'];

$NOM_capteur='"'.$NOM_capteur.'"';

//prepare the sql request
$sql = "DELETE FROM capteur WHERE NOM_capteur=$NOM_capteur";

// delete the row in the DB
mysqli_query($conn, $sql);

mysqli_close($conn);

// Redirecting
header("Location: show_sensor.php");
exit();
?>

