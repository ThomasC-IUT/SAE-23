<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "passsae";
$dbname = "sae23";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user = $_POST['username'];
$pass = md5($_POST['password']);

// Préparer et exécuter la requête SQL
$sql = "SELECT * FROM Administration WHERE login='$user'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
   
    // Vérifier le mot de passe
    if ($pass == $row['motdepasse']) {
        // Mot de passe correct, créer une session
        echo "$row[motdepasse]";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        header("Location: ../html/admin.html");
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Nom d'utilisateur incorrect.";
}

$conn->close();
?>
