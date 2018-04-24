/*
 * Auteurs : Tanguy CAVAGNA et Quentin FORESTIER
 * Version : 1.1.4235
 * Titre   : Bomberman
 * Language: Javascript/CSS/HTML
 */

// Initialisation des variables
// Variables qui ne servent pas pour l'instant
let textures = 0;

// Variables "constantes"
let __toucheHaut = 38;
let __toucheBas = 40;
let __toucheGauche = 37;
let __toucheDroite = 39;
let __toucheW = 87;
let __toucheS = 83;
let __toucheA = 65;
let __toucheD = 68;
let __toucheNum0 = 96;
let __toucheEspace = 32;
let __nbCells = 169;
let __nbCollonnesLignes = Math.sqrt(__nbCells);
let __dossier = "/sprites";
let __url = "http://classe2b.eyx.ch/sitePrincipal/files/BombermanMulti/";
let __appelleDynamique = setInterval(showDynamique, 50);

// Variables pour les bombes
let delayExplosion = 4;
let nombreTickBombe = 0;
let bombeId = 0;

// variables pour le joueur et le plateau ( autres )
let numLigne = 1;
let idjoueur = "";
let mursCassable = [];
let nbMursCassables = Math.random() * (169 - 160) + 160;
let positionsInterdites = [14, 15, 23, 24, 27, 37, 131, 141, 144, 145, 153, 154];
//let pointSpawn = [[50, 50, 1, 1], [50, 550, 1, 11], [550, 50, 11, 1], [550, 550, 11, 11]];

let idJoueur = "";

let dynamiqueObj = new Object();
dynamiqueObj.dynamique = [];

let solsObj = new Object();
solsObj.sols = [];

if (window.location.href == __url + "game.html") {
    window.onbeforeunload = function () {
        localStorage.removeItem("joueurId");
    }
}

function startGame() {
    let joueur = new Object();

    joueur.src = __url + "img/sprites/persoFace.png";
    joueur.id = "joueur_" + Math.floor((Math.random() * 4));
    joueur.positionX = 0;
    joueur.positionY = 0;
    joueur.style = {};
    joueur.style.top = "0px";
    joueur.style.left = "0px";

    apelleDynamique(joueur);
}

/// <summary>Dessine le plateau de jeu avec le sol et les murs.</summary> 
//Sols
function retourSols(reponse) {
    var jsonReponse = JSON.parse(reponse);
    console.log(jsonReponse);

    for (let item of jsonReponse.sols) {
        let casePlateau = document.createElement("img");

        let left = item.img.style.left;
        let subLeft = left.substr(0, item.img.style.left.length - 2);
        let top = item.img.style.top;
        let subTop = top.substr(0, item.img.style.top.length - 2);

        left = parseInt(sols.offsetLeft) + parseInt(subLeft) - 50;
        top = parseInt(sols.offsetTop) + parseInt(subTop);

        casePlateau.src = item.img.src;
        casePlateau.id = item.img.id;
        casePlateau.style.left = left + "px";
        casePlateau.style.top = top + "px";
        casePlateau.style.width = "50px";
        casePlateau.style.height = "50px";
        casePlateau.style.position = "absolute";

        sols.appendChild(casePlateau);

        solsObj.sols.push({
            "img": {
                "src": casePlateau.src,
                "id": casePlateau.id,
                "style": {
                    "left": (left - sols.offsetLeft + 50) + "px",
                    "top": (top - sols.offsetTop) + "px"
                }
            }
        });
    }
}

function apelleSols() {
    $.ajax({
        url: __url + "serveur.php?load=terrainSols ",
        method: "GET",
        data: null,
        dataType: 'json',
        success: function (reponse) {
            retourSols(reponse);
        }
    });
}

//Dynamique
function retourDynamique(reponse) {
    if (window.location.href == __url + "game.html") {
        var jsonReponse = JSON.parse(reponse);
        console.log(reponse);

        dynamique.innerHTML = "";

        for (let item of jsonReponse) {
            let joueur = document.createElement("img");

            let left = parseInt(item['style']['left'].substring(0, item['style']['left'].length - 2)) + sols.offsetLeft;
            let top = parseInt(item['style']['top'].substring(0, item['style']['top'].length - 2)) + sols.offsetTop;

            joueur.src = item.src;
            joueur.id = item.id;
            joueur.style.left = left + "px";
            joueur.style.top = top + "px"
            joueur.style.width = "50px";
            joueur.style.height = "50px";
            joueur.style.position = "absolute";

            dynamique.appendChild(joueur);
        }
    }
}

function showDynamique() {
    $.ajax({
        url: __url + "serveur.php?load=terrainDynamique",
        type: "GET",
        data: null,
        dataType: 'json',
        success: function (reponse) {
            retourDynamique(reponse);
        }
    });
}

function apelleDynamique(joueur) {
    $.ajax({
        url: __url + "serveur.php",
        type: "POST",
        data: ({
            joueurAdd: JSON.stringify(joueur)
        }),
        dataType: 'text',
        success: function (reponse) {
            console.log(reponse);
            idjoueur = reponse;
            localStorage.setItem("joueurId", idjoueur);

            location.replace("game.html");
        },
        error: function (e) {
            location.replace("error.php?error=507");
        }
    });
}

/// <summary>Animation du joueur à gauche.</summary>  
function animeGauche(j) {
    if (__dossier == "/sprites") {
        j.src = "./img" + __dossier + "/persoGauche.png";
    }
}

/// <summary>Animation du joueur à droite.</summary>  
function animeDroite(j) {
    if (__dossier == "/sprites") {
        j.src = "./img" + __dossier + "/persoDroite.png";
    }
}

/// <summary>Animation du joueur en haut.</summary>  
function animeHaut(j) {
    if (__dossier == "/sprites") {
        j.src = "./img" + __dossier + "/persoArriere.png";
    }
}

/// <summary>Animation du joueur en bas.</summary>  
function animeBas(j) {
    if (__dossier == "/sprites") {}
    j.src = "./img" + __dossier + "/persoFace.png";
}

function depHaut(player) {
    setTimeout(function () {
        animeHaut(player);
    }, 150);
    player.joueurY--;

    getBoost(player.joueurX, player.joueurY, player);

    if (__dossier == "/sprites") {
        if (player.joueurY % 2 == 0) {
            player.src = "./img" + __dossier + "/persoArriereAvance.png";
        } else
            player.src = "./img" + __dossier + "/persoArriereAvance2.png";
    } else
        player.src = "./img" + __dossier + "/persoArriere.png";

    player.style.top = player.joueurY * 50 + dynamique.offsetTop + "px";
}

function depBas(player) {
    setTimeout(function () {
        animeBas(player);
    }, 150);
    player.joueurY++;

    getBoost(player.joueurX, player.joueurY, player);

    if (__dossier == "/sprites") {
        if (player.joueurY % 2 == 1) {
            player.src = "./img" + __dossier + "/persoFaceAvance.png";
        } else {
            player.src = "./img" + __dossier + "/persoFaceAvance2.png";
        }
    } else
        player.src = "./img" + __dossier + "/persoFace.png";

    player.style.top = player.joueurY * 50 + dynamique.offsetTop + "px";
}

function depGauche(player) {
    setTimeout(function () {
        animeGauche(player);
    }, 150);
    player.joueurX--;

    getBoost(player.joueurX, player.joueurY, player);

    if (__dossier == "/sprites") {
        if (player.joueurX % 2 == 1) {
            player.src = "./img" + __dossier + "/persoGaucheAvance.png";
        } else {
            player.src = "./img" + __dossier + "/persoGaucheAvance2.png";
        }
    } else
        player.src = "./img" + __dossier + "/persoGauche.png";

    player.style.left = player.joueurX * 50 + dynamique.offsetLeft + "px";
}

function depDroite(player) {
    setTimeout(function () {
        animeDroite(player);
    }, 150);
    player.joueurX++;

    getBoost(player.joueurX, player.joueurY, player);

    if (__dossier == "/sprites") {
        if (player.joueurX % 2 == 0) {
            player.src = "./img" + __dossier + "/persoDroiteAvance.png";
        } else {
            player.src = "./img" + __dossier + "/persoDroiteAvance2.png";
        }
    } else
        player.src = "./img" + __dossier + "/persoDroite.png";

    player.style.left = player.joueurX * 50 + dynamique.offsetLeft + "px";
}

function pressSpace(player) {
    if (player.nbrBombe > 0) {
        let bombe = document.createElement("img");

        bombe.src = "./img" + __dossier + "/bombe.png";
        bombe.id = "bombe_" + bombeId;
        bombe.style.position = "absolute";
        bombe.style.left = player.style.left;
        bombe.style.top = player.style.top;
        bombe.style.width = "50px";
        bombe.style.height = "50px";
        bombe.style.zIndex = 11;
        bombe.traversable = false;
        bombe.X = player.joueurX;
        bombe.Y = player.joueurY;
        bombe.nombreTickBombe = 0;
        bombe.timer = setInterval(function () {
            explose(bombe, player);
        }, 500);

        dynamique.appendChild(bombe);

        bombeId++;

        player.nbrBombe--;
    }
}

/// <summary>Récupère les entrées clavier du l'utilisateur.</summary>  
/// <param name="event" type="Event">Evenement clavier.</param>
function commandesJoueurs(event) {
    let deplacement;

    // Récupère le KeyCode de la touche préssée
    switch (event.keyCode) {
        case __toucheW:
            deplacement = 0;
            break;

        case __toucheS:
            deplacement = 2;
            break;

        case __toucheA:
            deplacement = 3;
            break;

        case __toucheD:
            deplacement = 1;
            break;

        case __toucheEspace:
            // pose bombe
            break;
    }

    updatePosition(deplacement, localStorage.getItem("joueurId"));
}

function updatePosition(dir, id) {
    $.ajax({
        url: __url + "serveur.php",
        type: "POST",
        data: ({
            joueurId: id,
            dir: dir
        }),
        dataType: 'text',
        success: function (reponse) {
            console.log(reponse)
            showDynamique();
        },
        error: function (e) {
            console.log(e);
        }
    });
}

/// <summary>Dessine la croix composée d'explosions.</summary>  
/// <param name="bombe" type="Object">L'image de la bombe.</param>  
function crossBombe(bombe, player) {
    // Initialisation des variables locales
    let haut = player.rayonExplosion;
    let bas = player.rayonExplosion;
    let gauche = player.rayonExplosion;
    let droite = player.rayonExplosion;
    let top = Number(bombe.style.top.substr(0, bombe.style.top.length - 2));
    let left = Number(bombe.style.left.substr(0, bombe.style.left.length - 2));

    //Explosion central
    bombe.src = "./img" + __dossier + "/explosion/centre_Explosion.png";
    bombe.id = "explosionCentral" + parseInt(Math.random() * 1000);
    bombe.style.position = "absolute";
    bombe.traversable = true;
    bombe.stop = setTimeout(function () {
        dureeExplosion(bombe);
    }, 500);

    for (let item of dynamique.children) {
        if (item.id.includes("bombe")) {
            if (bombe.X == item.X && bombe.Y == item.Y) {
                item.nombreTickBombe = delayExplosion;
                explose(item, player);
            }
        }
    }

    // Explosion du haut
    for (let i = 1; i <= haut; i++) {
        if (!getCellSols(bombe.X, bombe.Y - i).id.includes("Dur")) {
            if (i != haut) {
                genereExplosion("explosionHaut_" + i, top - (i * 50) + "px", left + "px", bombe.X, bombe.Y - i, "./img" + __dossier + "/explosion/haut_centre.png", player);
            } else {
                genereExplosion("explosionHaut_" + i, top - (i * 50) + "px", left + "px", bombe.X, bombe.Y - i, "./img" + __dossier + "/explosion/haut_fin.png", player);
            }

            if (getCellSols(bombe.X, bombe.Y - i).id.includes("Cassable")) {
                getCellSols(bombe.X, bombe.Y - i).src = "./img" + __dossier + "/herbe.jpg";
                getCellSols(bombe.X, bombe.Y - i).id = "sol_" + getCellSols(bombe.X - 1, bombe.Y).id.split('_')[1];
                getCellSols(bombe.X, bombe.Y - i).traversable = true;

                spawnItems(top - (i * 50) + "px", left + "px", bombe.X, bombe.Y - i);

                break;
            }
        } else {
            break;
        }
    }

    // Explosion du bas
    for (let i = 1; i <= bas; i++) {
        if (!getCellSols(bombe.X, bombe.Y + i).id.includes("Dur")) {

            if (i != bas) {
                genereExplosion("explosionBas_" + i, top + (i * 50) + "px", left + "px", bombe.X, bombe.Y + 1, "./img" + __dossier + "/explosion/bas_centre.png", player);
            } else
                genereExplosion("explosionBas_" + i, top + (i * 50) + "px", left + "px", bombe.X, bombe.Y + 1, "./img" + __dossier + "/explosion/bas_fin.png", player);

            if (getCellSols(bombe.X, bombe.Y + i).id.includes("Cassable")) {
                getCellSols(bombe.X, bombe.Y + i).src = "./img" + __dossier + "/herbe.jpg";
                getCellSols(bombe.X, bombe.Y + i).id = "sol_" + getCellSols(bombe.X - 1, bombe.Y).id.split('_')[1];
                getCellSols(bombe.X, bombe.Y + i).traversable = true;

                spawnItems(top + (i * 50) + "px", left + "px", bombe.X, bombe.Y + 1);

                break;
            }
        } else {
            break;
        }
    }

    // Explosion de gauche
    for (let i = 1; i <= gauche; i++) {
        if (!getCellSols(bombe.X - i, bombe.Y).id.includes("Dur")) {
            if (i != gauche) {
                genereExplosion("explosionGauche_" + i, top + "px", left - (i * 50) + "px", bombe.X - i, bombe.Y, "./img" + __dossier + "/explosion/gauche_centre.png", player);
            } else
                genereExplosion("explosionGauche_" + i, top + "px", left - (i * 50) + "px", bombe.X - i, bombe.Y, "./img" + __dossier + "/explosion/gauche_fin.png", player);
            if (getCellSols(bombe.X - i, bombe.Y).id.includes("Cassable")) {
                getCellSols(bombe.X - i, bombe.Y).src = "./img" + __dossier + "/herbe.jpg";
                getCellSols(bombe.X - i, bombe.Y).id = "sol_" + getCellSols(bombe.X - 1, bombe.Y).id.split('_')[1];
                getCellSols(bombe.X - i, bombe.Y).traversable = true;

                spawnItems(top + "px", left - (i * 50) + "px", bombe.X - i, bombe.Y);

                break;
            }
        } else {
            break;
        }
    }

    // Explosion de droite
    for (let i = 1; i <= droite; i++) {
        if (!getCellSols(bombe.X + i, bombe.Y).id.includes("Dur")) {
            if (i != droite) {
                genereExplosion("explosionDroite_" + i, top + "px", left + (i * 50) + "px", bombe.X + i, bombe.Y, "./img" + __dossier + "/explosion/droite_centre.png", player);
            } else
                genereExplosion("explosionDroite_" + i, top + "px", left + (i * 50) + "px", bombe.X + i, bombe.Y, "./img" + __dossier + "/explosion/droite_fin.png", player);

            if (getCellSols(bombe.X + i, bombe.Y).id.includes("Cassable")) {
                getCellSols(bombe.X + i, bombe.Y).src = "./img" + __dossier + "/herbe.jpg";
                getCellSols(bombe.X + i, bombe.Y).id = "sol_" + getCellSols(bombe.X - 1, bombe.Y).id.split('_')[1];
                getCellSols(bombe.X + i, bombe.Y).traversable = true;

                spawnItems(top + "px", left + (i * 50) + "px", bombe.X + i, bombe.Y);

                break;
            }
        } else {
            break;
        }
    }
}

/// <summary>Génère les explosions.</summary>  
/// <param name="id" type="String">L'id de la bombe.</param> 
/// <param name="top" type="String">Le style "top" de la bombe.</param>
/// <param name="left" type="String">Le style "left" de la bombe.</param>
function genereExplosion(id, top, left, x, y, src, player) {
    let boom = document.createElement("img");

    boom.src = src;
    boom.id = id + parseInt(Math.random() * 1000);
    boom.style.position = "absolute";
    boom.style.left = left;
    boom.style.top = top;
    boom.style.width = "50px";
    boom.style.height = "50px";
    boom.style.zIndex = 11;
    boom.traversable = true;
    boom.X = x;
    boom.Y = y;
    boom.stop = setTimeout(function () {
        dureeExplosion(boom);
    }, 500);

    dynamique.appendChild(boom);

    for (let item of dynamique.children) {
        if (item.id.includes("bombe")) {
            if (boom.X == item.X && boom.Y == item.Y) {
                item.nombreTickBombe = delayExplosion;
                explose(item, player);
            }
        }
    }

    for (let joueur of dynamique.children) {
        if (joueur.id.includes("joueur")) {
            if (boom.X == joueur.joueurX && boom.Y == joueur.joueurY) {
                //dynamique.removeChild(player);
                location.reload();
            }
        }
    }
}

/// <summary>Change la source de la bombe et appelle la fonction "crossBombe(Object image)".</summary>  
/// <param name="bombe" type="Object">L'image de la bombe.</param>  
function explose(bombe, player) {
    // Change la source de l'image
    if (bombe.src.includes("/img" + __dossier + "/bombe.png")) {
        bombe.src = "./img" + __dossier + "/bombeRouge.png";
    } else {
        bombe.src = "./img" + __dossier + "/bombe.png";
    }

    // Après un certain temps, explosion et retirer la bombe
    if (bombe.nombreTickBombe == delayExplosion) {
        crossBombe(bombe, player);
        player.nbrBombe++;

        bombe.nombreTickBombe = 0;
        clearInterval(bombe.timer);
    }

    bombe.nombreTickBombe++;
}

/// <summary>Fait récupérer les boost.</summary> 
function getBoost(joueurX, joueurY, player) {
    if (getElementDynamique(joueurX, joueurY).id.includes("Rayon")) {
        dynamique.removeChild(getElementDynamique(joueurX, joueurY));
        player.rayonExplosion++;
    }

    if (getElementDynamique(joueurX, joueurY).id.includes("Nbr")) {
        dynamique.removeChild(getElementDynamique(joueurX, joueurY));
        player.nbrBombeMax++;
        player.nbrBombe = player.nbrBombeMax;
    }
}

/// <summary>Fait spawn les items a la place des murs cassables.</summary>  
function spawnItems(top, left, x, y) {
    let spawnChanceItem = ~~(Math.random() * 3);

    if (spawnChanceItem == 1) {
        let whichItem = ~~(Math.random() * 2);
        let item = document.createElement("img");

        switch (whichItem) {
            // Nombre de bombes
            case 0:
                item.src = "./img" + __dossier + "/boostRayon.png";
                item.id = "boostRayonBombe_" + parseInt(Math.random() * 1000);
                item.style.position = "absolute";
                item.style.left = left;
                item.style.top = top;
                item.style.width = "50px";
                item.style.height = "50px";
                item.style.zIndex = 11;
                item.traversable = true;
                item.X = x;
                item.Y = y;

                dynamique.appendChild(item);
                break;

                // Rayon
            case 1:
                item.src = "./img" + __dossier + "/boostBombe.png";
                item.id = "boostNbrBombe_" + parseInt(Math.random() * 1000);
                item.style.position = "absolute";
                item.style.left = left;
                item.style.top = top;
                item.style.width = "50px";
                item.style.height = "50px";
                item.style.zIndex = 11;
                item.traversable = true;
                item.X = x;
                item.Y = y;

                dynamique.appendChild(item);
                break;
        }

    }
}

/// <summary>Retire la bombe de la div "dynamique".</summary>  
/// <param name="bombe" type="Object">L'image de la bombe.</param>  
function dureeExplosion(bombe) {
    dynamique.removeChild(bombe);
}

/// <summary>Retire la bombe de la div "sols".</summary>  
/// <param name="x" type="Number">La position X du joueur.</param>  
/// <param name="y" type="Number">la position Y du joueur.</param> 
/// <returns type="Number">L'emplacement dans le list d'enfants de la div "sols".</returns>   
function getCellSols(x, y) {
    return sols.children[y * __nbCollonnesLignes + x];
}

/// <summary>Retire la bombe de la div "dynamique".</summary>  
/// <param name="x" type="Number">La position X du joueur.</param>  
/// <param name="y" type="Number">la position Y du joueur.</param> 
/// <returns type="Number">L'emplacement dans le list d'enfants de la div "dynamique".</returns> 
function getElementDynamique(x, y) {
    for (let i = 0; i < dynamique.children.length; i++) {
        if (dynamique.children[i].X == x && dynamique.children[i].Y == y)
            return dynamique.children[i];
    }
    let obj = {
        traversable: true,
        id: "objNull"
    };
    return obj;
}
