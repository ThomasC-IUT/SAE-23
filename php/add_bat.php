<?php
$servername = "localhost";
$username = "root";
$password = "passsae";
$dbname = "sae23";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$id = $_POST['id'];
$nom = $_POST['nom'];
$login = $_POST['login'];
$mdp = $_POST['mdp'];

// Préparer et exécuter la requête SQL
$sql = "INSERT INTO batiment (ID_bat, nom, login, motdepasse) VALUES ('$id', '$nom', '$login', '$mdp')";

if ($conn->query($sql) === TRUE) {
    echo "Nouvel enregistrement créé avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>