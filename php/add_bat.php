<?php
include 'connect.php';
$conn= connect();

// getting data from the form
$id = $_POST['id'];
$nom = $_POST['nom'];
$login = $_POST['login'];
$mdp = $_POST['mdp'];

// preparing sql request
$sql = "INSERT INTO batiment (ID_bat, nom, login, motdepasse) VALUES ('$id', '$nom', '$login', '$mdp')";

//check for error
if (mysqli_query($conn, $sql) === TRUE) {  
  echo "Nouvel enregistrement cree avec succes !";
} else {
    echo "Erreur";
}

// close the connection
mysqli_close($conn);
?>
