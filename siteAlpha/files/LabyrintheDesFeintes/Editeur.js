        //Constantes de blocs
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
        var _LASER_HORIZONTAL = 18;
        var _LASER_VERTICAL = 19;
        //Tableau
        var grille = new Array();
        var tailleCellule = 30;
        var tailleX;
        var tailleY;

        var typeCellule;
        var selectionX;
        var selectionY;

        var mouseIsDown = false;

        var idNiveau = "";
        var idMembre = 1;
        var nomNiveau = "";
        var saveLvL = true;
        var newLvL = "true";

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

        container.addEventListener("mousemove", MouseMove, false);
        container.addEventListener("click", changeType, false);



        function Insert() {

            var difficulte = document.getElementById("categorie").value;

            var items = listeNiveau.getElementsByTagName("li");
            newLvL = "true";
            nomNiveau = tbxNameNiveau.value;
            for (var i = 0; i < items.length; i++) {
                if (nomNiveau === items[i].innerHTML) {
                    newLvL = "false";
                    if (confirm("Voulez-vous vraiment écraser votre ancien niveau ?")) {
                        saveLvL = true;

                    } else {
                        saveLvL = false;
                    }

                    break;
                }

            }

            var categorie = difficulte;
            if (saveLvL) {
                $.ajax({
                    url: "./serveur.php",
                    type: "POST",
                    data: ({
                        idCreateur: idMembre,
                        nomNiveau: nomNiveau,
                        categorie: categorie,
                        niveau: JSON.stringify(grille),
                        newLvL: newLvL
                    }),
                    dataType: 'text',
                    success: function (reponse) {
                        window.location.reload();
                    }
                });
            }
        }

        function Initialisation() {
            // Requete qui récupère niveau de la personne par ordre alphabétique... Puis les mets dans des li clickable

            if (screen.width <= 1000) {
                console.log(screen.width);
                tailleCellule = 19;
                vosNiveaux.style.height = '100px';
                vosNiveaux.style.overflow = 'auto';
                blockssss.style.overflow = 'auto';
                blockssss.style.height = '150px';
                posMouse.style.marginTop = posMouse.style.marginTop-30 + "px";
            }else{
                tailleCellule = 30;
            }

            $.ajax({
                url: "./serveur.php",
                type: "POST",
                data: ({
                    idMembre: idMembre
                }),
                dataType: 'text',
                success: function (reponse) {

                    var level = reponse.split("|");
                    for (var i = 0; i < level.length - 1; i++) {
                        var info = level[i].split(";");
                        var li = document.createElement("li");
                        li.id = info[1];
                        li.className = "vosNiveau";
                        li.innerHTML = info[0];
                        li.clickable = true;
                        li.onclick = function () {
                            nomNiveau = this.innerHTML;
                            Ouvrir(this.id);
                        }
                        listeNiveau.appendChild(li);
                    }


                }
            });

        }

        function Clavier(event) {

            switch (event.keyCode) {

                case 49:
                    Joueur();
                    break;
                case 50:
                    Mur();
                    break;
                case 51:
                    Sol();
                    break;
                case 52:
                    Cle();
                    break;
                case 53:
                    Sortie();
                    break;
                case 54:
                    MurInvisible();
                    break;
                case 55:
                    MurTraversable();
                    break;
                case 56:
                    Caisse();
                    break;
                case 57:
                    Surprise();
                    break;
            }
        }

        function Sauvegarder() {
            if (grille == "") {
                alert("Vous n'avez pas crée de labyrinthe");
            } else {
                var checkPlayer = 0;
                var checkSortie = 0;
                var checkCle = 0;
                for (var yTemp = 0; yTemp < tailleY + 2; yTemp++) {
                    for (var xTemp = 0; xTemp < tailleX + 2; xTemp++) {
                        if (grille[xTemp][yTemp] === _JOUEUR_DE_FACE) {
                            checkPlayer++;
                        }
                        if (grille[xTemp][yTemp] === _SORTIE) {
                            checkSortie++;
                        }
                        if (grille[xTemp][yTemp] === _CLE) {
                            checkCle++;
                        }
                    }
                }
                if (checkSortie > 0 && checkPlayer == 1 && checkCle > 0) {
                    modal.style.display = "block";
                } else {
                    alert("Il manque quelque chose d'essentiel dans votre niveau");
                }
            }
        }

        function Ouvrir(grilleSend) {
            grille = JSON.parse(grilleSend);
            Dessine(grille.length - 2, grille[0].length - 2);
            grille = JSON.parse(grilleSend);

            for (var y = 0; y < tailleY + 2; y++) {
                for (var x = 0; x < tailleX + 2; x++) {
                    var caseGrille = labyrinthe.children[y * (tailleX + 2) + x];
                    TypeImage(x, y, caseGrille);
                }
            }
        }

        function MouseMove(e) {
            if (e.clientX < tailleCellule * (tailleX + 2) && e.clientY < tailleCellule * (tailleY + 3) && e.clientX > 2 * tailleCellule && e.clientY > 3 * tailleCellule) {
                selectionX = ~~((e.clientX - tailleCellule) / tailleCellule);
                selectionY = ~~((e.clientY - tailleCellule) / tailleCellule);
                lblPosition.innerHTML = selectionX + ", " + (selectionY - 1);
            }
            container.addEventListener("mousedown", mouseDown, false);
            container.addEventListener("mouseup", mouseUp, false);
            if (mouseIsDown) {
                changeType(e);
            }

        }

        function changeType(e) {
            if (e.clientX - tailleCellule < tailleCellule * (tailleX + 2) && e.clientY - tailleCellule < tailleCellule * (tailleY + 2) && e.clientX > 0 && e.clientY > 0) {
                if (selectionX > 0 && selectionY > 1 && selectionX <= tailleX && selectionY - 1 <= tailleY) {
                    selectionX = ~~((e.clientX - tailleCellule) / tailleCellule);
                    selectionY = ~~((e.clientY - 2 * tailleCellule) / tailleCellule);
                    grille[selectionX][selectionY] = typeCellule;

                    var caseGrille = labyrinthe.children[selectionY * (tailleX + 2) + selectionX];
                    TypeImage(selectionX, selectionY, caseGrille);
                }
            }
        }

        function mouseDown(e) {
            mouseIsDown = true;
        }

        function mouseUp(e) {
            mouseIsDown = false;
        }

        function Dessine(X, Y) {
            labyrinthe.innerHTML = '';
            grille = new Array();
            tailleX = ~~X;
            tailleY = ~~Y;

            if (tailleX > 28) {
                tailleX = 28;
            }
            if (tailleY > 28) {
                tailleY = 28;
            }
            if (tailleX < 5) {
                tailleX = 5;
            }
            if (tailleY < 5) {
                tailleY = 5;
            }
            tbxTailleX.value = tailleX.toString();
            tbxTailleY.value = tailleY.toString();

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

        function AjouteTP() {
            var x = ~~document.getElementById("tbxTPX").value;
            var y = ~~document.getElementById("tbxTPY").value;
            var vX = ~~document.getElementById("tbxTPVersX").value;
            var vY = ~~document.getElementById("tbxTPVersY").value;

            if (vX >= 1 && vX <= tailleX && vY >= 1 && vY <= tailleY && x >= 1 && x <= tailleX && y >= 1 && y <= tailleY) {
                grille[x][y] = 50000 + vX + (vY * 100);
                var caseGrille = labyrinthe.children[y * (tailleX + 2) + x];
                TypeImage(x, y, caseGrille);

            } else {
                alert("Arrêtez de chercher des bugs !");
            }
        }

        function Joueur() {
            typeCellule = _JOUEUR_DE_FACE;
            Selection();
        }

        function Mur() {
            typeCellule = _MUR;
            Selection();
        }

        function Sol() {
            typeCellule = _SOL;
            Selection()
        }

        function Cle() {
            typeCellule = _CLE;
            Selection();
        }

        function Sortie() {
            typeCellule = _SORTIE;
            Selection();
        }

        function MurInvisible() {
            typeCellule = _MUR_INVISIBLE;
            Selection();
        }

        function MurTraversable() {
            typeCellule = _MUR_TRAVERSABLE;
            Selection();
        }

        function Caisse() {
            typeCellule = _CAISSE;
            Selection();
        }

        function LaserHorizontal() {
            typeCellule = _LASER_HORIZONTAL;
            Selection();
        }

        function LaserVertical() {
            typeCellule = _LASER_VERTICAL;
            Selection();
        }

        function Surprise() {
            typeCellule = _BLOC_SURPRISE
            Selection();
        }

        function Selection() {
            btnJoueur.style.border = "0px solid black";
            btnMur.style.border = "0px solid black";
            btnCle.style.border = "0px solid black";
            btnSol.style.border = "0px solid black";
            btnSortie.style.border = "0px solid black";
            btnSurprise.style.border = "0px solid black";
            btnMurInvisible.style.border = "0px solid black";
            btnMurTraversable.style.border = "0px solid black";
            btnCaisse.style.border = "0px solid black";
            btnLaserV.style.border = "0px solid black";
            btnLaserH.style.border = "0px solid black";

            switch (typeCellule) {
                case _JOUEUR_DE_FACE:
                    btnJoueur.style.border = "5px solid black";
                    break;
                case _MUR:
                    btnMur.style.border = "5px solid black";
                    break;
                case _SOL:
                    btnSol.style.border = "5px solid black";
                    break;
                case _CLE:
                    btnCle.style.border = "5px solid black";
                    break;
                case _SORTIE:
                    btnSortie.style.border = "5px solid black";
                    break;
                case _BLOC_SURPRISE:
                    btnSurprise.style.border = "5px solid black";
                    break;
                case _MUR_INVISIBLE:
                    btnMurInvisible.style.border = "5px solid black";
                    break;
                case _MUR_TRAVERSABLE:
                    btnMurTraversable.style.border = "5px solid black";
                    break;
                case _CAISSE:
                    btnCaisse.style.border = "5px solid black";
                    break;
                case _LASER_HORIZONTAL:
                    btnLaserH.style.border = "5px solid black";
                    break;
                case _LASER_VERTICAL:
                    btnLaserV.style.border = "5px solid black";
                    break;
            }
        }

        function TypeImage(x, y, caseGrille) {
            var checkPlayer = 0;
            for (var yTemp = 0; yTemp < tailleY + 2; yTemp++) {
                for (var xTemp = 0; xTemp < tailleX + 2; xTemp++) {
                    if (grille[xTemp][yTemp] === _JOUEUR_DE_FACE) {
                        checkPlayer++;
                    }
                }
            }
            if (checkPlayer > 1) {
                grille[x][y] = _SOL;
                alert("Il y a déjà un joueur !");
            }
            if (x === 0 || x === tailleX + 1 || y === 0 || y === tailleY + 1) {
                caseGrille.src = "./images/BlocMur.png";
                grille[x][y] = _MUR;
            }
            if (x >= 1 && x <= tailleX && y >= 1 && y <= tailleY) {
                if (grille[x][y] === _SOL) {
                    caseGrille.src = "./images/Sol.png";
                }
                if (grille[x][y] === _JOUEUR_DE_FACE) {
                    caseGrille.src = "./images/DeFace.png";
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
                    caseGrille.src = "./images/BlocSurprise.png";
                }
                if (grille[x][y] === _MUR_INVISIBLE) {
                    caseGrille.src = "./images/MurInvisible.png";
                }
                if (grille[x][y] === _MUR_TRAVERSABLE) {
                    caseGrille.src = "./images/MurTraversable.png";
                }
                if (grille[x][y] === _CAISSE) {
                    caseGrille.src = "./images/Caisse.png";
                }
                if (grille[x][y] === _BLOC_SURPRISE) {
                    caseGrille.src = "./images/BlocSurprise.png";
                }
                if (grille[x][y] === _LASER_HORIZONTAL) {
                    caseGrille.src = "./images/LaserCentreH.png";
                }
                if (grille[x][y] === _LASER_VERTICAL) {
                    caseGrille.src = "./images/LaserCentreV.png";
                }


            }
        }
