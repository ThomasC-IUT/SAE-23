
<?php session_start();

include 'connect.php';

$conn = connect();


//get the information of the form
$user = $_POST['username'];

//$pass = md5($_POST['password']);
$pass = ($_POST['password']);



// Prepare the sql request 
$sql = "SELECT * FROM batiment WHERE login='$user'";

//storing the result 
$result = mysqli_query($conn, $sql);


if(mysqli_num_rows($result) > 0) {  
//each line of the DB is put in an associative table
  $row = mysqli_fetch_assoc($result);
    
// Check the password
    if ($pass == $row['motdepasse']) {
        // password ok, creating a session
        echo "$row[motdepasse]";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
		$_SESSION['ID_bat'] = $row['ID_bat'];

		//redirecting the user
        header("Location: batiment.php?id=" . $row['ID_bat']);
        exit();
    } 
	else {
        echo "Mot de passe incorrect.";
    }
} 

else {
echo "Nom d'utilisateur incorrect.";
}

mysqli_close($conn);
?>
