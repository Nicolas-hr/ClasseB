        //Constantes d'images
        var _SOL = 0;
        var _JOUEUR_DE_FACE = 1;
        var _JOUEUR_DE_GAUCHE = 2;
        var _JOUEUR_DE_DROITE = 3;
        var _JOUEUR_DE_DERRIERE = 4;
        var _MUR = 5;
        var _CLE = 6;
        var _SORTIE = 7;
        var _TELEPORTATION = 50000;
        var _PIQUE = 9;
        var _MUR_INVISIBLE = 10;
        var _MUR_TRAVERSABLE = 11;
        var _CAISSE = 12;
        var _BLOC_SURPRISE = 13;
        var _TIR_HAUT = 14;
        var _TIR_BAS = 15;
        var _TIR_GAUCHE = 16;
        var _TIR_DROITE = 17;
        var _LASER_CENTRE_HORIZONTAL = 18;
        var _LASER_CENTRE_VERTICAL = 19;
        var _LASER_HORIZONTAL = 20;
        var _LASER_VERTICAL = 21;

        //Constantes de KeyPress
        var _toucheHaut = 38;
        var _toucheBas = 40;
        var _toucheGauche = 37;
        var _toucheDroite = 39;
        var _toucheRecommencer = 82;

        //Tableau
        var grille = new Array();
        var tailleCellule = 30;
        var tailleX = 0;
        var tailleY = 0;
        var tutoMakup = false;

        //Joueur
        var posDebutJoueurX;
        var posDebutJoueurY;
        var joueurX = 1;
        var joueurY = 1;
        var cle = false;
        var vie;
        var tire = false;
        var listTP = [];
        var level = 0;
        var promptFichier;

        var idNiveau;

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function () {
            myModal.style.display = "none";
        }
        var modal = document.getElementById('myModal');
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }




        //Méthode de l'initialisation du programme
        function init() {
            if (screen.width <= 1000) {
                
                tailleCellule = 19;
                document.getElementById("tutoMakup").style.height = '300px';
                document.getElementById("tutoMakup").style.overflow = 'auto';
                document.getElementById("controlesTelephone").style.visibility = "visible";
                
            }else{
                document.getElementById("controlesTelephone").style.visibility = "hidden";
            }
            Ouvrir(1);
        }


        function setControl(){
            tire = !tire;
            if(tire)
                document.getElementById("btnCaisse").style.opacity = 0.2;
            else
                document.getElementById("btnCaisse").style.opacity = 0.5;
        }

        function Filtre() {

            tableauNiveaux.innerHTML = '<tr class="trNiveaux"><th id="thNiveaux1" class="thNiveaux">Nom du niveau :</th><th id="thNiveaux2" class="thNiveaux">Nom du créateur :</th><th id="thNiveaux3" class="thNiveaux">Difficulté :</th><th id="thNiveaux4" class="thNiveaux">Note :</th><th id="thNiveaux5" class="thNiveaux">Fait :</th></tr>';
            var ordre = document.getElementById("ordre").value;
            var nomNiveau = document.getElementById("tbxNameNiveau").value;
            var nomCreateur = document.getElementById("tbxNameCreator").value;
            var difficulte = "";

            for (var i = 0; i < 4; i++) {
                var check = document.getElementById('checkbox').getElementsByTagName('*')[i];
                if (check.checked) {
                    difficulte += 'OR laby_niveaux.Categorie = "' + check.value + '" ';
                }
            }


            difficulte = difficulte.substr(3);
            difficulte = "(" + difficulte + ")";



            $.ajax({
                url: "./serveur.php",
                type: "POST",
                async: false,
                data: ({
                    ordre: ordre,
                    nomNiveau: nomNiveau,
                    nomCreateur: nomCreateur,
                    difficulte: difficulte
                }),
                dataType: 'text',
                success: function (reponse) {
                    var ligne = reponse.split('|');
                    for (var i = 0; i < ligne.length - 1; i++) {
                        infos = ligne[i].split(';');
                        if (infos[5] == "false") {
                            tableauNiveaux.innerHTML += '<tr class="trNiveaux" onclick="Ouvrir(' + infos[4] + ')"><td>' + infos[0] + '</td><td>' + infos[1] + '</td><td>' + infos[2] + '</td><td>' + infos[3] + '</td><td></td></tr>';
                        } else {
                            tableauNiveaux.innerHTML += '<tr class="trNiveaux" onclick="Ouvrir(' + infos[4] + ')"><td>' + infos[0] + '</td><td>' + infos[1] + '</td><td>' + infos[2] + '</td><td>' + infos[3] + '</td><td><img src="./images/tick.png" alt="Fait"/></td></tr>';
                        }
                    }
                }
            });
        }



        function ReloadMap() {
            Ouvrir(idNiveau);
        }


        function choix() {
            modal.style.display = "block";
        }

        //Méthode pour le tutoriel
        function Tutoriel() {
            tutoMakup = !tutoMakup;

            if (tutoMakup) {
                document.getElementById("tutoMakup").style.visibility = "visible";
                btnTutoMakup.innerHTML = "Désactiver le tutoriel";
            } else {
                document.getElementById("tutoMakup").style.visibility = "hidden";
                btnTutoMakup.innerHTML = "Activer le tutoriel";
            }
        }

        //Methode pour ouvrir un niveau depuis le serveur
        function Ouvrir(lvl) {
            idNiveau = lvl;
            cle = false;
            $.ajax({
                url: "./serveur.php",
                type: "POST",
                data: ({
                    idNiveau: idNiveau
                }),
                dataType: 'text',
                success: function (reponse) {

                    grille = JSON.parse(reponse);
                    Dessine(grille.length - 2, grille[0].length - 2);
                    grille = JSON.parse(reponse);
                    for (var y = 0; y < tailleY + 2; y++) {
                        for (var x = 0; x < tailleX + 2; x++) {
                            var caseGrille = labyrinthe.children[y * (tailleX + 2) + x];
                            if (grille[x][y] === _JOUEUR_DE_FACE) {
                                posDebutJoueurX = x;
                                posDebutJoueurY = y;
                                joueurX = posDebutJoueurX;
                                joueurY = posDebutJoueurY;
                            }
                            TypeImage(x, y, caseGrille);
                        }
                    }
                    Laser();
                }
            });

        }

        //Méthode qui gère les déplacements des joueur
        function Deplacement(code) {
            var direction = "";
            boolDepl = false;
            switch (code) {
                case _toucheHaut:
                    valeurX = 0;
                    valeurY = -1;
                    boolDepl = true;
                    direction = "FACE";
                    break;
                case _toucheBas:
                    valeurX = 0;
                    valeurY = 1;
                    boolDepl = true;
                    direction = "DERRIERE";
                    break;
                case _toucheDroite:
                    valeurX = 1;
                    valeurY = 0;
                    boolDepl = true;
                    direction = "DROITE";
                    break;
                case _toucheGauche:
                    valeurX = -1;
                    valeurY = 0;
                    boolDepl = true;
                    direction = "GAUCHE";
                    break;
                case _toucheRecommencer:
                    Recommencer();
                    break;
            }

            if (boolDepl === true) {
                switch (direction) {
                    case "FACE":
                        direction = _JOUEUR_DE_DERRIERE;
                        if ((event.ctrlKey || tire) && grille[joueurX][joueurY + 1] === _CAISSE)
                            direction = _TIR_HAUT;
                        break;
                    case "DERRIERE":
                        direction = _JOUEUR_DE_FACE;
                        if ((event.ctrlKey || tire) && grille[joueurX][joueurY - 1] === _CAISSE)
                            direction = _TIR_BAS;
                        break;
                    case "GAUCHE":
                        direction = _JOUEUR_DE_GAUCHE;
                        if ((event.ctrlKey || tire) && grille[joueurX - 1][joueurY] === _CAISSE)
                            direction = _TIR_GAUCHE;
                        break;
                    case "DROITE":
                        direction = _JOUEUR_DE_DROITE;
                        if ((event.ctrlKey || tire) && grille[joueurX + 1][joueurY] === _CAISSE)
                            direction = _TIR_DROITE;
                        break;
                }
                grille[joueurX][joueurY] = direction;
                if (grille[joueurX + valeurX][joueurY + valeurY] >= _TELEPORTATION && grille[joueurX + valeurX][joueurY + valeurY] < _TELEPORTATION + 10000) {
                    grille[joueurX][joueurY] = _SOL;
                    var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
                    TypeImage(joueurX, joueurY, caseGrille);

                    var tp = grille[joueurX + valeurX][joueurY + valeurY] - 50000;
                    joueurX = ~~(tp % 100);
                    joueurY = ~~(tp / 100);

                    grille[joueurX][joueurY] = direction;
                    var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
                    TypeImage(joueurX, joueurY, caseGrille);
                } else if (grille[joueurX + valeurX][joueurY + valeurY] === _SOL || grille[joueurX + valeurX][joueurY + valeurY] === _MUR_TRAVERSABLE || grille[joueurX + valeurX][joueurY + valeurY] === _BLOC_SURPRISE || grille[joueurX + valeurX][joueurY + valeurY] === _CLE || (grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _SOL) || (grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _LASER_HORIZONTAL) || (grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _LASER_VERTICAL) || grille[joueurX + valeurX][joueurY + valeurY] === _LASER_HORIZONTAL || grille[joueurX + valeurX][joueurY + valeurY] === _LASER_VERTICAL) {


                    if ((event.ctrlKey || tire) && grille[joueurX - valeurX][joueurY - valeurY] === _CAISSE && grille[joueurX + valeurX][joueurY + valeurY] === _SOL) {

                        grille[joueurX][joueurY] = _CAISSE;
                        var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
                        TypeImage(joueurX, joueurY, caseGrille);

                        grille[joueurX - valeurX][joueurY - valeurY] = _SOL;
                        caseGrille = labyrinthe.children[(joueurY - valeurY) * (tailleX + 2) + (joueurX - valeurX)];
                        TypeImage((joueurX + valeurX), (joueurY + valeurY), caseGrille);

                        joueurY += valeurY;
                        joueurX += valeurX;
                        grille[joueurX][joueurY] = direction;

                    } else if ((grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _LASER_HORIZONTAL) || (grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _SOL) || (grille[joueurX + valeurX][joueurY + valeurY] === _CAISSE && grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] === _LASER_VERTICAL)) {
                        grille[joueurX + 2 * valeurX][joueurY + 2 * valeurY] = _CAISSE;
                        var caseGrille = labyrinthe.children[(joueurY + 2 * valeurY) * (tailleX + 2) + (joueurX + 2 * valeurX)];
                        TypeImage(joueurX + 2 * valeurX, joueurY + 2 * valeurY, caseGrille);

                        grille[joueurX][joueurY] = _SOL;
                        var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
                        TypeImage(joueurX, joueurY, caseGrille);

                        joueurY += valeurY;
                        joueurX += valeurX;
                        grille[joueurX][joueurY] = direction;

                    } else if (grille[joueurX + valeurX][joueurY + valeurY] === _LASER_HORIZONTAL ||
                        grille[joueurX + valeurX][joueurY + valeurY] === _LASER_VERTICAL) {
                        Recommencer();
                        vie--;
                    } else {
                        grille[joueurX][joueurY] = _SOL;
                        var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
                        TypeImage(joueurX, joueurY, caseGrille);

                        if (grille[joueurX + valeurX][joueurY + valeurY] === _CLE) {
                            cle = true;
                        }
                        if (grille[joueurX + valeurX][joueurY + valeurY] === _BLOC_SURPRISE) {

                            grille[joueurX + valeurX][joueurY + valeurY] = _SOL;
                            var caseGrille = labyrinthe.children[(joueurY + valeurY) * (tailleX + 2) + (joueurX + valeurX)];
                            TypeImage(joueurX + valeurX, (joueurY + valeurY), caseGrille);
                            Surprise();
                        } else {
                            joueurY += valeurY;
                            joueurX += valeurX;
                        }

                        grille[joueurX][joueurY] = direction;

                    }

                } else if (grille[joueurX + valeurX][joueurY + valeurY] === _SORTIE && cle) {

                    $.ajax({
                        url: "./serveur.php",
                        type: "POST",
                        data: ({
                            idNiveauFini: idNiveau,
                            idJoueur: 1
                        }),
                        dataType: 'text',
                        success: function (reponse) {}
                    });




                    Ouvrir(1); // en attendant



                } else if (grille[joueurX + valeurX][joueurY + valeurY] === _LASER_HORIZONTAL) {
                    vie--;
                    Recommencer();
                }
            }
            var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
            TypeImage(joueurX, joueurY, caseGrille);

            Laser();
        }

        //Fonction pour le bloc surprise
        function Surprise() {
            var typeSurprise = nombreAleatoire(1, 100);

            if (typeSurprise <= 10) {
                vie += 5
            } else if (typeSurprise <= 40) {
                vie++
            } else if (typeSurprise <= 60) {
                Recommencer();
            } else if (typeSurprise <= 90) {
                Recommencer();
                vie--;
            } else {
                Ouvrir(level);
                vie--;
            }
        }

        //Fonction des lasers
        function Laser() {
            for (var y = 0; y < tailleY + 2; y++) {
                for (var x = 0; x < tailleX + 2; x++) {
                    if (grille[x][y] === _LASER_HORIZONTAL || grille[x][y] === _LASER_VERTICAL) {
                        grille[x][y] = _SOL;
                        var caseGrille = labyrinthe.children[y * (tailleX + 2) + x];
                        TypeImage(x, y, caseGrille);
                    }
                }
            }
            for (var y = 0; y < tailleY + 2; y++) {
                for (var x = 0; x < tailleX + 2; x++) {
                    if (grille[x][y] === _LASER_CENTRE_HORIZONTAL) {
                        var pos = 1;
                        while (grille[x - pos][y] === _SOL || grille[x - pos][y] === _LASER_HORIZONTAL || (grille[x - pos][y] >= 1 && grille[x - pos][y] <= 4) || (grille[x - pos][y] >= 14 && grille[x - pos][y] <= 17)) {
                            if (x - pos === joueurX && y === joueurY) {
                                Recommencer();
                            }
                            grille[x - pos][y] = _LASER_HORIZONTAL;
                            var caseGrille = labyrinthe.children[y * (tailleX + 2) + x - pos];
                            TypeImage(x - pos, y, caseGrille);
                            pos++;
                        }
                        pos = 1;
                        while (grille[x + pos][y] === _SOL || grille[x + pos][y] === _LASER_HORIZONTAL || (grille[x + pos][y] >= 1 && grille[x + pos][y] <= 4) || (grille[x + pos][y] >= 14 && grille[x + pos][y] <= 17)) {
                            if (x + pos === joueurX && y === joueurY) {
                                Recommencer();
                            }
                            grille[x + pos][y] = _LASER_HORIZONTAL;
                            var caseGrille = labyrinthe.children[y * (tailleX + 2) + x + pos];
                            TypeImage(x + pos, y, caseGrille);
                            pos++;
                        }
                    }
                    if (grille[x][y] === _LASER_CENTRE_VERTICAL) {
                        var pos = 1;
                        while (grille[x][y - pos] === _SOL || grille[x][y - pos] === _LASER_VERTICAL || (grille[x][y - pos] >= 1 && grille[x][y - pos] <= 4) || (grille[x][y - pos] >= 14 && grille[x][y - pos] <= 17)) {
                            if (x === joueurX && y - pos === joueurY) {
                                Recommencer();
                            }
                            grille[x][y - pos] = _LASER_VERTICAL;
                            var caseGrille = labyrinthe.children[(y - pos) * (tailleX + 2) + x];
                            TypeImage(x, y - pos, caseGrille);
                            pos++;
                        }
                        pos = 1;
                        while (grille[x][y + pos] === _SOL || grille[x][y + pos] === _LASER_VERTICAL || (grille[x][y + pos] >= 1 && grille[x][y + pos] <= 4) || (grille[x][y + pos] >= 14 && grille[x][y + pos] <= 17)) {
                            if (x === joueurX && y + pos === joueurY) {
                                Recommencer();
                            }
                            grille[x][y + pos] = _LASER_VERTICAL;
                            var caseGrille = labyrinthe.children[(y + pos) * (tailleX + 2) + x];
                            TypeImage(x, y + pos, caseGrille);
                            pos++;
                        }
                    }
                }
            }
        }

        //fonction pour recommencer le niveau
        function Recommencer() {
            //Sol ou il y avait le joueur
            grille[joueurX][joueurY] = _SOL;
            var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
            TypeImage(joueurX, joueurY, caseGrille);

            //Position du nouveau joueur
            joueurX = posDebutJoueurX;
            joueurY = posDebutJoueurY;
            grille[joueurX][joueurY] = _JOUEUR_DE_FACE;
            var caseGrille = labyrinthe.children[joueurY * (tailleX + 2) + joueurX];
            TypeImage(joueurX, joueurY, caseGrille);
        }

        //fonction qui génère un nombre aléatoire
        function nombreAleatoire(min, max) {
            return Math.floor((Math.random() * max) + min);
        }

        //Méthode pour ajouter un bloc de téléportation
        function CreationTP(x, y, versX, versY) {
            grille[x][y] = 50000 + versX + (versY * 100);
        }

        //Initalise un tableau au début du programme
        function Dessine(X, Y) {
            labyrinthe.innerHTML = '';
            tailleX = X;
            tailleY = Y;

            for (var x = 0; x < tailleX + 2; x++) {
                grille[x] = new Array();

            }
            for (var y = 0; y < tailleY + 2; y++) {
                for (var x = 0; x < tailleX + 2; x++) {
                    var caseGrille = document.createElement("img");
                    caseGrille.style.width = tailleCellule + "px";
                    caseGrille.style.height = tailleCellule + "px";
                    caseGrille.style.top = (tailleCellule * (y + 2)) + "px";
                    caseGrille.style.left = (tailleCellule * (x + 1)) + "px";
                    caseGrille.draggable = false;
                    caseGrille.style.position = "absolute";
                    caseGrille.clickable = true;


                    if (x === 0 || x === tailleX + 1 || y === 0 || y === tailleY + 1)
                        grille[x][y] = _MUR;
                    else
                        grille[x][y] = _SOL;

                    TypeImage(x, y, caseGrille);

                    labyrinthe.appendChild(caseGrille);
                }
            }
        }

        //Met la bonne image 
        function TypeImage(x, y, caseGrille) {
            if (grille[x][y] === _SOL) {
                caseGrille.src = "./images/Sol.png";
            }
            if (grille[x][y] === _JOUEUR_DE_FACE) {
                caseGrille.src = "./images/DeFace.png";
            }
            if (grille[x][y] === _JOUEUR_DE_GAUCHE) {
                caseGrille.src = "./images/DeGauche.png";
            }
            if (grille[x][y] === _JOUEUR_DE_DROITE) {
                caseGrille.src = "./images/DeDroite.png";
            }
            if (grille[x][y] === _JOUEUR_DE_DERRIERE) {
                caseGrille.src = "./images/DeDerriere.png";
            }
            if (grille[x][y] === _MUR) {
                caseGrille.src = "./images/BlocMur.png";
            }
            if (grille[x][y] === _CLE) {
                caseGrille.src = "./images/Cle.png";
            }
            if (grille[x][y] === _SORTIE) {
                caseGrille.src = "./images/porte.png";
            }
            if (grille[x][y] >= _TELEPORTATION && grille[x][y] < _TELEPORTATION + 10000) {
                caseGrille.src = "./images/TP.png";
            }
            if (grille[x][y] === _PIQUE) {
                caseGrille.src = "./images/Sol.png";
            }
            if (grille[x][y] === _MUR_INVISIBLE) {
                caseGrille.src = "./images/Sol.png";
            }
            if (grille[x][y] === _MUR_TRAVERSABLE) {
                caseGrille.src = "./images/BlocMur.png";
            }
            if (grille[x][y] === _CAISSE) {
                caseGrille.src = "./images/Caisse.png";
            }
            if (grille[x][y] === _BLOC_SURPRISE) {
                caseGrille.src = "./images/BlocSurprise.png";
            }
            if (grille[x][y] === _TIR_BAS) {
                caseGrille.src = "./images/TirBas.png";
            }
            if (grille[x][y] === _TIR_HAUT) {
                caseGrille.src = "./images/TirHaut.png";
            }
            if (grille[x][y] === _TIR_GAUCHE) {
                caseGrille.src = "./images/TirGauche.png";
            }
            if (grille[x][y] === _TIR_DROITE) {
                caseGrille.src = "./images/TirDroite.png";
            }
            if (grille[x][y] === _LASER_CENTRE_HORIZONTAL) {
                caseGrille.src = "./images/LaserCentreH.png"
            }
            if (grille[x][y] === _LASER_HORIZONTAL) {
                caseGrille.src = "./images/LaserH.png"
            }
            if (grille[x][y] === _LASER_CENTRE_VERTICAL) {
                caseGrille.src = "./images/LaserCentreV.png"
            }
            if (grille[x][y] === _LASER_VERTICAL) {
                caseGrille.src = "./images/LaserV.png"
            }
        }
