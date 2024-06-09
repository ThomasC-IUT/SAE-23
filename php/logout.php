<?php
session_start();
session_unset();
session_destroy();
header("Location: login.html"); // Redirige vers la page de connexion ou une autre page de votre choix
exit();
?>