<?php



include 'connect.php';
$conn = connect();



// getting the id to delete
$id_bat = $_POST['id_bat'];

$id_bat='"'.$id_bat.'"';

//prepare the sql request
$sql = "DELETE FROM batiment WHERE ID_bat=$id_bat";

// delete the row in the DB
mysqli_query($conn, $sql);
echo mysqli_error($conn);
mysqli_close($conn);

// Redirecting
header("Location: show_bat.php");
exit();
?>

