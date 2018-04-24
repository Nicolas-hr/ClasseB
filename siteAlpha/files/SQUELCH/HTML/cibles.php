<?php
session_start();
$mission = filter_input(INPUT_GET, 'mission');
?>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Cibles</title>
        <link rel="stylesheet" type="text/css" href="../CSS/cibles.css">
        <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
    </head>

    <body onload="mouvementCible()">

        <div id="all">
            <div id="jeu">
                <label id="score">Score: 0</label>
                <label id="accuracy">Temps restant: 25</label>
                <label id="clicks">Tirs: 0</label>
                <div id="cibleCanevas">
                    <div id="cibles">
                    </div>
                </div>
            </div>
        </div>
        <div id="mission"><?php echo $mission;?></div>
        <script>
                        var enJeu = true;
            var timer = setInterval(temps, 1000);
            var timerFin = setTimeout(fin, 25000);
            var timerAnim = setTimeout(sauce, 499);

            timer.enable = true;

            var time = 25;
            var point = 0;
            var nbrClicks = 0;
            var hit = 0;
            var sauce = 1;
            var accuracy = 0;
            var nbr0Point = 0;
            var nbr1Point = 0;
            var nbr2Point = 0;
            var nbr3Point = 0;
            var nbr4Point = 0;
            var nbr5Point = 0;

            function mouvementCible() {
                all.addEventListener("click", clicks);
                var listeDiv = [];
                var taillecible = 100;

                for (var i = 1; i < 7; i++) {
                    var nomcible = "cible" + i;
                    nomcible = document.createElement("div");

                    //changement de la couleur
                    if (i === 1) {
                        nomcible.style.backgroundColor = "#ffffff";
                        nomcible.addEventListener("click", function () {
                            nbr1Point++;
                            nbr0Point--;
                        });
                    } else if (i === 2) {
                        nomcible.style.backgroundColor = "#000000";
                        nomcible.addEventListener("click", function () {
                            nbr2Point++;
                            nbr1Point--;
                        });
                    } else if (i === 3) {
                        nomcible.style.backgroundColor = "#00a5ff";
                        nomcible.addEventListener("click", function () {
                            nbr3Point++;
                            nbr2Point--;
                        });
                    } else if (i === 4) {
                        nomcible.style.backgroundColor = "#fc2323";
                        nomcible.addEventListener("click", function () {
                            nbr4Point++;
                            nbr3Point--;
                        });
                    } else if (i === 5) {
                        nomcible.style.backgroundColor = "#fce00f";
                        nomcible.addEventListener("click", function () {
                            nbr5Point++;
                            nbr4Point--;
                        });
                    } else {
                        cibleCanevas.addEventListener("click", function () {
                            nbr0Point++;
                        })
                    }

                    nomcible.style.padding = "1px";
                    if (i > 1) {
                        nomcible.style.marginTop = "10px";
                        nomcible.style.marginLeft = "10px";
                    } else {
                        nomcible.style.marginTop = "270px";
                        nomcible.style.marginLeft = "570px";
                    }

                    nomcible.style.width = taillecible + "px";
                    nomcible.style.height = taillecible + "px";
                    nomcible.style.borderRadius = taillecible + "px";
                    nomcible.draggable = false;
                    taillecible -= 21;
                    listeDiv.push(nomcible);

                    if (i > 1) {
                        listeDiv[i - 2].appendChild(nomcible);
                    } else {
                        cibles.appendChild(nomcible);
                        nomcible.style.border = "solid 1px black";
                        nomcible.addEventListener("click", bouger);
                    }
                    nomcible.addEventListener("click", points);
                }
                cibles.children[0].style.animationName = "flipInX";
                cibles.children[0].style.animationDuration = "0.5s";
                cibles.children[0].style.animationIterationCount = "infinite";
                cibles.children[0].style.animationPlayState = "running";
                timerAnim.enable = true;
            }

            function points() {
                // tant que nous somme en jeu la cible bouge quand on clique dessus
                enJeu = true;
                point++;
                document.getElementById("score").innerHTML = "Score: " + point;
            }

            function clicks() {
                nbrClicks++;
                document.getElementById("clicks").innerHTML = "Tirs: " + nbrClicks;
                precision();
            }

            function bouger()
            {
                hit++;
                // mouvement aléatoire de la cible sur la page

                let top = Math.floor((Math.random() * 620));
                cibles.children[0].style.marginTop = top + "px";
                let left = Math.floor((Math.random() * 1050));
                cibles.children[0].style.marginLeft = left + "px";

                window.clearTimeout(timerAnim);

                cibles.children[0].style.animationName = "flipInX";
                cibles.children[0].style.animationDuration = "0.5s";
                cibles.children[0].style.animationIterationCount = "infinite";
                cibles.children[0].style.animationPlayState = "running";
                timerAnim.enable = true;
                timerAnim = setTimeout(sauce, 499);
            }

            function sauce() {
                cibles.children[0].style.animationPlayState = "paused";
                timerAnim.enable = false;
            }

            function precision() {
                accuracy = Math.floor(100 * hit / nbrClicks);
            }

            function temps() {
                if (time !== 0)
                {
                    time--;
                    document.getElementById("accuracy").innerHTML = "Temps restant: " + time;
                } else
                {
                    enjeu = false;
                    timer.enable = false;
                }
            }
            function fin() {              
                document.location.replace("score.php?point="+ point +"&nbrClicks=" + nbrClicks+ "&hit=" + hit + "&accuracy=" + accuracy + 
                        "&nbr1Point=" + nbr1Point + "&nbr2Point=" + nbr2Point+ "&nbr3Point=" + nbr3Point+ "&nbr4Point=" +
                        nbr4Point+ "&nbr5Point=" + nbr5Point + "&mission=" + document.getElementById("mission").innerHTML);
            }
        </script>
    </body>
</html>
