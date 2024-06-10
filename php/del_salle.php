<?php



include 'connect.php';
$conn = connect();



// getting the name to delete
$id_salle = $_POST['nom_salle'];

$id_salle='"'.$id_salle.'"';

//prepare the sql request
$sql = "DELETE FROM salle WHERE NOM_salle=$id_salle";

// delete the row in the DB
mysqli_query($conn, $sql);

mysqli_close($conn);

// Redirecting
header("Location: show_salle.php");
exit();
?>

