<?php

session_start();

include 'connect.php';
$conn = connect();


	if (!isset($_SESSION['ID_bat'])) {
		header("Location: login_bat.php");
		exit();	
	}


	if (isset($_GET['id'])) {
		$id_bat=$_GET['id'];
	}
	else {
		echo " ID innexistant";
	exit();
}

//$id_bat='"'.$id_bat.'"';


$sql = "SELECT * FROM `batiment` WHERE ID_bat=".'"'.$id_bat.'"';
$result = mysqli_query($conn, $sql);



if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $departement = $row['nom'];
} else {
    echo "Informations du bâtiment non trouvées.";
    exit();
}

$sql_salles = "SELECT NOM_salle, type, capacite FROM salle WHERE ID_bat=".'"'.$id_bat.'"';

$result_salles= mysqli_query($conn,$sql_salles);

$salles = [];
if (mysqli_num_rows($result_salles) > 0) {
    while ($row_salle = mysqli_fetch_assoc($result_salles)) {
        $nom_salle = $row_salle['NOM_salle'];
        $sql_capteurs = "SELECT NOM_capteur, type, unite FROM capteur WHERE NOM_salle = '$nom_salle'";
        $result_capteurs = mysqli_query($conn, $sql_capteurs);
        $capteurs = [];
        if (mysqli_num_rows($result_capteurs) > 0) {
            while ($row_capteur = mysqli_fetch_assoc($result_capteurs)) {
                $capteurs[] = $row_capteur;
            }
        }
        $row_salle['capteurs'] = $capteurs;
        $salles[] = $row_salle;
	
    }
} else {
    echo "Aucune salle trouvée pour ce bâtiment.";
}





mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Gestion du Bâtiment</title>
	  <link rel="stylesheet" href="../styles/style_del.css">
</head>
<body>
    <h2>Bienvenue dans la gestion du bâtiment: <?php echo htmlspecialchars($id_bat); ?></h2>
    
    <h2>Departement: <?php echo htmlspecialchars($departement); ?></h2>


 <h2>Liste des Salles</h2>
   <?php if (!empty($salles)): ?>
        <?php foreach ($salles as $salle): ?>
            <h3><?php echo ($salle['NOM_salle']); ?> (Type: <?php echo ($salle['type']); ?>, Capacité: <?php echo ($salle['capacite']); ?>)</h3>
            <?php if (!empty($salle['capteurs'])): ?>
                <table border="1">
                    <tr>
                        <th>Nom du Capteur</th>
                        <th>Type</th>
                        <th>Unité</th>
                    </tr>
                    <?php foreach ($salle['capteurs'] as $capteur): ?>
                        <tr>
                            <td><?php echo ($capteur['NOM_capteur']); ?></td>
                            <td><?php echo($capteur['type']); ?></td>
                            <td><?php echo ($capteur['unite']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>Aucun capteur trouvé pour cette salle.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune salle trouvée pour ce bâtiment.</p>
    <?php endif; ?>
</body>
</html>







