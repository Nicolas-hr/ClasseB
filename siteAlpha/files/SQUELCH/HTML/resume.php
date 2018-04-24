<?php
session_start();

$resume = null;

try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if(isset($_GET['mission'])) {
    $idmission = $_GET['mission'];
	$infoResume = $bd->query('SELECT * FROM mission WHERE idmission = ' . $idmission);
	$infoResume->execute();
	$resume = $infoResume->fetch();
}
else {
	echo "erreur d'envoi";
}
?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title> Cibles</title>
        <link rel="stylesheet" type="text/css" href="../CSS/cssResume.css">
        <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
    </head>

    <body onload="onload()">
        <div id="all">
            <div id="scoreDiv">
                <h1>Briefing</h1>
                <img id="classified" draggable="false" src="../IMG/classified.png">
                <table>
                    <tr>
                        <td>
                            <p id="agentName"><b>Agent Name: </b></p>
                        </td>
                        <td>
                            <?php echo $_SESSION['pseudo'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p id="missionNbr"><b>Mission Number:</b></p>
                        </td>
                        <td id="numMission"><?php if(isset($resume)) { echo $resume['idmission']; }?></td>
                    </tr>
                    <tr>
                        <td>
                            <p id="missionCode"><b>Mission Code: </b></p>
                        </td>
                        <td >
                            <?php if(isset($resume)) { echo $resume['codemission']; }?>
                        </td>
                    </tr>
                </table>
                <br>
                <br><br>
                <p id="missionDesc"><b>Mission Description: </b></p>
                <p id="missionDescFull">
                    <?php if(isset($resume)) { echo utf8_encode($resume['descriptionmission']); }?>
                </p>
                <p id="date"></p>
                <img id="start" onclick="animationStart()" draggable="false" src="../IMG/briefingStart.png">
            </div>
        </div>

        <script type="text/javascript">
            var mission;

            var img = document.getElementById('classified');
            var img2 = document.getElementById('start');

            function onload() {
                img.style.visibility = "hidden";
                getTime();
                mission = localStorage.getItem("mission");
                localStorage.clear();
            }

            function getTime() {
                var date = new Date();
                document.getElementById("date").innerHTML = "<b>Paris, " + date.getDate() + "." + (date.getMonth() + 1) + "." + date.getFullYear() + "</b>";
            }

            function animationStart() {
                img2.style.animationPlayState = "pause";
                img2.style.animationName = "fadeOut";
                img2.style.animationDuration = "3s";
                img2.style.animationIterationCount = "1";
                img.style.visibility = "visible";
                img.style.animationName = "fadeIn";
                img.style.animationDuration = "3s";
                img.style.animationIterationCount = "1";
                var timerFin = setTimeout(fin, 2750);
            }

            function fin() {
                window.location.replace('./cibles.php?mission='+ document.getElementById("numMission").innerHTML);
            }

        </script>
    </body>

    </html>
