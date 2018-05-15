<?php

session_start();try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
};

$missionNumber = filter_input(INPUT_GET, 'mission');
$hits = filter_input(INPUT_GET, 'hit');
$fired = filter_input(INPUT_GET, 'nbrClicks');
$accuracy = filter_input(INPUT_GET, 'accuracy');
$point1 = filter_input(INPUT_GET, 'nbr1Point');
$point2 = filter_input(INPUT_GET, 'nbr2Point');
$point3 = filter_input(INPUT_GET, 'nbr3Point');
$point4 = filter_input(INPUT_GET, 'nbr4Point');
$point5 = filter_input(INPUT_GET, 'nbr5Point');
$points = filter_input(INPUT_GET, 'point');

$newprogression = $missionNumber+1;

$insertmbr = $bd->prepare('SELECT idPlayer FROM player WHERE pseudo LIKE "'. $_SESSION['pseudo'] . '"');
$insertmbr->execute();
$peseudo = $insertmbr->fetch();

$insertmbr = $bd->prepare("UPDATE progression SET progression = ". $newprogression ."  WHERE idJoueur LIKE " .$peseudo["idPlayer"]. "");
$insertmbr->execute();

$insertmbr = $bd->prepare('SELECT mission'.$missionNumber.'Score FROM progression WHERE idJoueur LIKE ' .$peseudo["idPlayer"]);
$insertmbr->execute();
$score = $insertmbr->fetch();

if($score['mission'.$missionNumber.'Score'] < $points)
{
	$insertmbr = $bd->prepare('UPDATE progression SET mission'.$missionNumber.'Score = '. $points .'  WHERE idJoueur LIKE ' .$peseudo["idPlayer"]);
	$insertmbr->execute();
}
?>

	<html>

	<head>
		<meta charset="UTF-8">
		<title>Rapport de mission</title>
		<link rel="stylesheet" type="text/css" href="../CSS/cssRapport.css">
		<link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
	</head>

	<body onload="onload()">
		<div id="all">
			<div id="scoreDiv">
				<h1>Rapport</h1>
				<p id="agentName"><b>Agent Name: <?php echo $_SESSION['pseudo'] ?></b></p>
				<p id="missionNbr"><b>Mission Number: <?php echo $missionNumber; ?></b></p>
				<p><img id="success" draggable="false" src="../IMG/success.png"></p>
				<p id="Statistics"><b>Statistics: </b><br><b>-------------------------------------------------------------------------------------------</b></p>
				<table>
					<tr>
						<?php
                        echo '<td><b>Target hit: </b> </td>';
                        echo '<td><b>' . $hits . '</b></td>';
                        echo '<td><b>1 points: </b> </td>';
                        echo '<td><b>' . $point1 . '</b></td>';
                        ?>

					</tr>
					<tr>
						<?php
                        echo '<td><b>Bullets fired: </b></td>';
                        echo '<td><b>' . $fired . '</b></td>';
                        echo '<td><b>2 points: </b></td>';
                        echo '<td><b>' . $point2 . '</b></td>';
                        ?>
					</tr>
					<tr>
						<?php
                        echo '<td><b>Accuracy: </b></td>';
                        echo '<td><b>' . $accuracy . ' % </b></td>';
                        echo '<td><b>3 points: </b></td>';
                        echo '<td><b>' . $point3 . '</b></td>';
                        ?>

					</tr>
					<tr>
						<?php
                        echo '<td><b>Total points: </b></td>';
                        echo '<td><b>' . $points . '</b></td>';
                        echo '<td><b>4 points: </b></td>';
                        echo '<td><b>' . $point4 . '</b></td>';
                        ?>
					</tr>
					<tr>
						<td>----------------</td>
						<td>----------------</td>
						<?php
                        echo '<td><b>5 points: </b></td>';
                        echo '<td><b>' . $point5 . '</b></td>';
                        ?>
					</tr>
				</table>
				<p><b>-------------------------------------------------------------------------------------------</b></p>
				<p id="lieu"><b>Lieu: Geneve</b></p>
				<p id="menu"><a href="menu.php"><button id="btnReglages" class="btnsMenu">Retour au menu</button></a></p>
			</div>
		</div>
		<script type="text/javascript">
			var img = document.getElementById('success');

			function onload() {
				img.style.visibility = "hidden";
				img.style.visibility = "visible";
				img.style.animationName = "fadeIn";
				img.style.animationDuration = "3s";
				img.style.animationIterationCount = "1";
			}

		</script>
	</body>

	</html>
