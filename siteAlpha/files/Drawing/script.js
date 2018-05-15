var el = document.getElementById('canvas');
var ctx = el.getContext('2d');

var isDrawing;
var couleur_fond;
var isGomming;
var lineWidth = 1;


el.onmousedown = function(e) {
    isDrawing = true;
    ctx.lineWidth = lineWidth;
    ctx.lineJoin = ctx.lineCap = 'round';

    ctx.moveTo(e.clientX, e.clientY);
};

el.onmousemove = function(e) {
    if (isDrawing) {
        ctx.lineTo(e.clientX, e.clientY);
        ctx.stroke();
    };
};

// couleur aléatoire
el.addEventListener("onkeypress", () => couleurRandom(event), false);

function couleurRandom(event) {
    if (event.which == 97 && isDrawing && !isGomming) {
        ctx.strokeStyle = getRandomColor();
        ctx.beginPath();
    }
}

function getRandomColor() {
    var lastColor = ctx.strokeStyle;
    var length = 6;
    var chars = '0123456789ABCDEF';
    var hex = '#';
    while(length--) hex += chars[(Math.random() * 16) | 0];
    if (hex == couleur_fond)
        return lastColor;
    else
        return hex;
}


el.onmouseup = function() {
    isDrawing = false;
};

ctx.fillStyle ="#FFFFFF";
ctx.fillRect(0, 0, 1500, 930);
//Choisi stylo
document.getElementById('stylo').addEventListener('click', function() {
    var couleur = document.getElementById("myColor").value;
    ctx.strokeStyle = couleur;
    ctx.beginPath();
    isGomming = true;
});
//Choisi gomme
document.getElementById('gomme').addEventListener('click', function() {
    couleur_fond = document.getElementById("myColor2").value;
    ctx.strokeStyle = couleur_fond;
    ctx.beginPath();
    isGomming = true;
});
//Changement d'épaisseur
document.getElementById('petit').addEventListener('click', function() {
    lineWidth = 1;
    ctx.beginPath();
});
document.getElementById('normal').addEventListener('click', function() {
    lineWidth = 10;
    ctx.beginPath();
});
document.getElementById('grand').addEventListener('click', function() {
    lineWidth = 20;
    ctx.beginPath();
});
document.getElementById('enorme').addEventListener('click', function() {
    lineWidth = 30;
    ctx.beginPath();
});

//Changemennt de couleur
function changeColor(){
    var couleur = document.getElementById("myColor").value;
    ctx.strokeStyle = couleur;
    ctx.beginPath();
};
//Changemennt de couleur de fond
function changeColor2(){
    var couleur_fond = document.getElementById("myColor2").value;
    ctx.fillStyle = couleur_fond;
    ctx.fillRect(0, 0, 1500, 930);
    ctx.beginPath();
};
//Efface le canvas
document.getElementById('effacer').addEventListener('click', function() {
    var s = document.getElementById ("canvas");
    var w = s.width;
    s.width = 10;
    s.width = w;

    //Garde la couleur déja choisi
    var couleur = document.getElementById("myColor").value;
    ctx.strokeStyle = couleur;


    //Garde la couleur de fond déja choisi
    var couleur_fond = document.getElementById("myColor2").value;
    ctx.fillStyle = couleur_fond;
    ctx.fillRect(0, 0, 1500, 930);
    ctx.beginPath();
});

//Ouvre une image
function draw(ev) {
    console.log(ev);
    var ctx = document.getElementById('canvas').getContext('2d'),
        img = new Image(),
        f = document.getElementById("uploadimage").files[0],
        url = window.URL || window.webkitURL,
        src = url.createObjectURL(f);

    img.src = src;
    img.onload = function() {
        ctx.drawImage(img, 0, 0);
        url.revokeObjectURL(src);
    }
    ctx.beginPath();
};
document.getElementById("uploadimage").addEventListener("change", draw, false);

function save(){
    var c=document.getElementById("canvas");
    var d=c.toDataURL("image/png");
    var w=window.open('about:blank','image from canvas');
    w.document.write("<img src='"+d+"' alt='from canvas'/>");
    var link = document.createElement("a");
    link.setAttribute("href", d);
    link.setAttribute("download", "MonDessin.png");
    link.click();
}
