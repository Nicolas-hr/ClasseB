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
?>
<!DOCTYPE html>
<html>

<head>

    <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Menu</title>
    <link rel="stylesheet" href="../CSS/cssMenu.css">
</head>
<header>
    <p id="profil">
        <a href="profil.php"><button id="profilbtn" class="hvr-underline-from-center"><?php echo $_SESSION['pseudo'] ?></button></a>
    </p>
</header>

<body onload="music()">
    <!--<h1 class="font-effect-3d-float" id="titre">
            SQUELCH!
        </h1>-->
    <img class="logo" src="../IMG/logotransparent.png">
    <div id="container">
        <p>
            <a href="selectionMode.php"><button id="btnJouer" class="btnsMenu">Jouer!</button></a>
        </p>
        <p>
            <a href="tableauscores.php"><button id="btnScores" class="btnsMenu">Tableau des scores</button></a>
        </p>
        <p>
            <a href="reglages.php"><button id="btnReglages" class="btnsMenu">Options</button></a>
        </p>
        <p id="cache"hidden>
        	<?php echo $son[0]['son'] ?>
        </p>
    </div>
    <script type="text/javascript">
        function music() {
            var myAudio = new Audio('../IMG/bandeson.wav');
            if (typeof myAudio.loop == 'boolean') {
                myAudio.loop = true;
            } else {
                myAudio.addEventListener('ended', function() {
                    this.currentTime = 0;
                    this.play();
                }, false);
            }
            myAudio.volume = document.getElementById("cache").innerHTML / 100;
            myAudio.play();
        }

    </script>
</body>

</html>
