
<?php
session_start();


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$_SESSION = array();

	session_destroy();
	header("Location: ../index.html"); // Redirige vers la page de connexion ou une autre page de votre choix
exit();
}

else { header("Location: ../login.html");
exit();
}


?>
