<?php
function connect()
{$servername = "localhost";
$username = "root";
$password = "passsae";
$dbname = "sae23";


$conn = new mysqli($servername, $username, $password, $dbname);
return $conn;
}
?>
