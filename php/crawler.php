<?php
// La commande Bash que vous voulez exécuter
$commande = "mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1 | jq '.[0].illumination'";

// Exécuter la commande et récupérer le résultat
$resultat = shell_exec($commande);

// Afficher le résultat
echo "<pre>$resultat</pre>";


// je pense que probleme car doit attendre 10min pour recuperer chaque valeur
//    peut etre recuperer pour tous et prendre que ce qui est utile

// mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1 | jq '.[0].illumination'
// mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/E104/data -C 1 | jq '.[0].co2'

?>