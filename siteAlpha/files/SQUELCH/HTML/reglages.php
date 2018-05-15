<?php 
session_start();
	
try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

$insertmbr = $bd->prepare('SELECT reglages.son FROM reglages AS reglages JOIN player AS player ON player.idPlayer = reglages.idPlayer WHERE player.pseudo LIKE "'. 	$_SESSION['pseudo'] . '"');
$insertmbr->execute();
$son = $insertmbr->fetchAll();
$bonson = $son[0]['son'];
if(isset($_POST['sonvalue'])){
	$insertmbr = $bd->prepare('SELECT idPlayer FROM player WHERE pseudo LIKE "'. $_SESSION['pseudo'] . '"');
	$insertmbr->execute();
	$peseudo = $insertmbr->fetch();
	$insertmbr = $bd->prepare('UPDATE reglages SET son = '. $_POST['sonvalue'] .' WHERE idPlayer LIKE ' . $peseudo["idPlayer"]);
	$insertmbr->execute();
	header('Location: menu.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Reglages</title>
	<link rel="stylesheet" href="../CSS/cssReglages.css">
</head>

<body onload="load()">
	<h1 class="font-effect-3d-float">
		Réglages
	</h1>
	<form method="post" action="reglages.php">
		<div id="slidecontainer">
			Son: &nbsp;
			<input type="range" name="sonvalue" min="0" max="100" class="slider" id="son" onchange="sldValeur(this.value)">
			<div id="pourcent" style="display: inline-block;"></div>
		</div>
		<input type="submit" id="btn" name="apply" value="Appliquer" onclick="quit()">
		<div style="margin-top: 5%;">
			
		</div>
	</form>
	<p id="cache" hidden><?php echo $son[0]['son']?></p>
	<script>
		function sldValeur(valeur) {
			let vSldValue = Math.floor(valeur);
			document.getElementById("pourcent").innerHTML = vSldValue + "%";
		}

		function load() {
			document.getElementById("son").value = document.getElementById("cache").innerHTML;
			document.getElementById("pourcent").innerHTML = document.getElementById("cache").innerHTML + '%';
		}
		function quit()
		{
			window.location.replace("./menu.php");
		}

	</script>
</body>

</html>
