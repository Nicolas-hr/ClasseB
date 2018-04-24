<?php
session_start();
try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
	$infoResume = $bd->query('SELECT progression.progression FROM progression AS progression JOIN player AS p ON p.idPlayer = progression.idJoueur WHERE p.pseudo LIKE "' . $_SESSION['pseudo'] . '"');
	$infoResume->execute();
	$resume = $infoResume->fetch();
?>
    <!DOCTYPE html>
    <html>

    <head>

        <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Menu</title>
        <link rel="stylesheet" href="../CSS/cssMode.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    </head>

    <body onload="load()">

        <h1 class="font-effect-3d-float" id="titre">
            Selection de la mission
        </h1>
        <div id="mapContainer">
            <img id="map" src="../IMG/vrecarte.png">
            <div id="mission1C">
                <img id="mission1" onclick="<?php 
                    if($resume['progression'] >= 0)
                    {
                       echo 'clik(1)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 1)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission2C">
                <img id="mission2" onclick="<?php 
                    if($resume['progression'] >= 1)
                    {
                       echo 'clik(2)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 2)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission3C">
                <img id="mission3" onclick="<?php 
                    if($resume['progression'] >= 2)
                    {
                       echo 'clik(3)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 3)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission4C">
                <img id="mission4" onclick="<?php 
                    if($resume['progression'] > 3)
                    {
                       echo 'clik(4)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 4)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission5C">
                <img id="mission5" onclick="<?php 
                    if($resume['progression'] >= 4)
                    {
                       echo 'clik(5)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 5)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission6C">
                <img id="mission6" onclick="<?php 
                    if($resume['progression'] >= 5)
                    {
                       echo 'clik(6)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 6)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission7C">
                <img id="mission7" onclick="<?php 
                    if($resume['progression'] >= 6)
                    {
                       echo 'clik(7)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 7)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission8C">
                <img id="mission8" onclick="<?php 
                    if($resume['progression'] >= 7)
                    {
                       echo 'clik(8)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 8)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
            <div id="mission9C">
                <img id="mission9" onclick="<?php 
                    if($resume['progression'] >= 8)
                    {
                       echo 'clik(9)';
                    }
                ?>" class="icon" src="../IMG/<?php 
                                      if($resume['progression'] > 9)
                                      {
                                          echo 'medaille.png';
                                      }
                                      else
                                      {
                                          echo 'crossmap.png';
                                      }
                                      ?>">
            </div>
        </div>
        <p>
            <a href="menu.php"><button id="btnReglages" class="btnsMenu">Retour au menu</button></a>
        </p>
        <div id="cache" hidden="hidden"><?php echo $resume['progression'];?></div>
        <script type="text/javascript">
            function clik(name) {
                window.location.replace('./resume.php?mission=' + name);
            }

            function load() {
                var img1 = document.getElementById('mission1C');
                var img2 = document.getElementById('mission2C');
                var img3 = document.getElementById('mission3C');
                var img4 = document.getElementById('mission4C');
                var img5 = document.getElementById('mission5C');
                var img6 = document.getElementById('mission6C');
                var img7 = document.getElementById('mission7C');
                var img8 = document.getElementById('mission8C');
                var img9 = document.getElementById('mission9C');
                var prog = parseInt(document.getElementById("cache").innerHTML);
                switch (prog) {
                    case 1:
                        img1.style.animationName = "pulse";
                        img1.style.animationDuration = "1s";
                        img1.style.animationIterationCount = "infinite";
                        break;
                    case 2:
                        img2.style.animationName = "pulse";
                        img2.style.animationDuration = "1s";
                        img2.style.animationIterationCount = "infinite";
                        break;
                    case 3:
                        img3.style.animationName = "pulse";
                        img3.style.animationDuration = "1s";
                        img3.style.animationIterationCount = "infinite";
                        break;
                    case 4:
                        img4.style.animationName = "pulse";
                        img4.style.animationDuration = "1s";
                        img4.style.animationIterationCount = "infinite";
                        break;
                    case 5:
                        img5.style.animationName = "pulse";
                        img5.style.animationDuration = "1s";
                        img5.style.animationIterationCount = "infinite";
                        break;
                    case 6:
                        img6.style.animationName = "pulse";
                        img6.style.animationDuration = "1s";
                        img6.style.animationIterationCount = "infinite";
                        break;
                    case 7:
                        img7.style.animationName = "pulse";
                        img7.style.animationDuration = "1s";
                        img7.style.animationIterationCount = "infinite";
                        break;
                    case 8:
                        img8.style.animationName = "pulse";
                        img8.style.animationDuration = "1s";
                        img8.style.animationIterationCount = "infinite";
                        break;
                    case 9:
                        img9.style.animationName = "pulse";
                        img9.style.animationDuration = "1s";
                        img9.style.animationIterationCount = "infinite";
                        break;
                }
                music();
            }
            function music() {
            var myAudio = new Audio('../IMG/military_Music.mp3');
            if (typeof myAudio.loop == 'boolean') {
                myAudio.loop = true;
            } else {
                myAudio.addEventListener('ended', function() {
                    this.currentTime = 0;
                    this.play();
                }, false);
            }
            myAudio.volume = 0.1;
            myAudio.play();
        }

        </script>
    </body>

    </html>
