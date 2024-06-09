<?php
$file = "/home/sae23/Desktop/json.txt";

$parsed_json = json_decode($file);
$temp = $parsed_json->{'temperature'};

echo "$temp";
?>
