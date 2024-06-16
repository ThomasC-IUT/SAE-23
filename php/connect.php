<?php
function connect()
{$servername = "localhost";
$username = "lampp";
$password = "passsae";
$dbname = "sae23";


$conn = new mysqli($servername, $username, $password, $dbname);
return $conn;
}
?>
