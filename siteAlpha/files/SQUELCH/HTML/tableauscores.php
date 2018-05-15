<?php

session_start();

try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
	$insertmbr = $bd->prepare('SELECT player.pseudo, progression.mission'. $_POST['selectedMission'].'Score FROM player AS player JOIN progression AS progression ON progression.idJoueur = player.idPlayer GROUP BY 1 ORDER BY 2 DESC LIMIT 5');
	$insertmbr->execute();
	$top = $insertmbr->fetchAll();
	$topRows = $insertmbr->rowCount();
?>
	<html>

	<head>

		<link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Menu</title>
		<link rel="stylesheet" href="../CSS/cssScores.css">
	</head>

	<body>

		<h1 class="font-effect-3d-float" id="titre">
			Scores
		</h1>
		<form method="post" action="tableauscores.php">
			<p id="select">
			Mission N° 
			<input type="number" value="1" name="selectedMission" value="" id="mimi" min="1" max="9"> 
			<input type="image" src="../IMG/refresh.png" alt="Submit" id="btn" name="submitScore"> 
			</p>
		</form>
		<table class="tableau">
			<thead>
				<tr id="hop">
					<th style="font-weight: bold;">#</th>
					<th style="font-weight: bold;">Pseudo</th>
					<th style="font-weight: bold;">Score</th>
				</tr>
			</thead>

			<?php
			if(isset($_POST['selectedMission']))
			{
				echo '<tbody style="text-align: center">';
			for($i = 0; $i < $topRows; $i++) {
				echo '<tr>';
				echo '<td>' . (intval($i + 1)) . '</td>';
				echo '<td>' . $top[$i]['pseudo'] . '</td>';
				echo '<td>' . $top[$i]['mission' . $_POST['selectedMission'] . 'Score'] . '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			}
			
			?>
		</table>
		<p>
			<a href="menu.php"><button id="btnReglages" class="btnsMenu">Retour au menu</button></a>
		</p>
		<script type="text/javascript">


		</script>
	</body>

	</html>
