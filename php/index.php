<?php
/*****************************************************************************
 * Auteur: Cavagna Tanguy, Günner Adar, Oliveira Francisco, Hoarau Nicolas    *                                                 *
 * Description : Ce site est un site oú l'on peut upload nos projet WEB, voir *
 *               les news du site.                                            *
 * Date de création : 08.05.2018                                              *
 ******************************************************************************/

require_once '../lib/projects.php';
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Classe 2B</title>
</head>
<body class="parallax">
<?php require_once "nav.php" ?>
<?php require_once "aside.php" ?>

<div id="main" class="mt-5 container">

    <h1 id="title" class="display-4 w-100 text-center mt-3 pb-3 mb-5 pt-4 border-bottom border-dark">
        Bienvenue sur le site de la Classe I.DA/FA-P2B
    </h1>

    <div class="card text-center mb-5">
        <div class="card-header">
            <h4 class="text-uppercase">Informations</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Qui sommes-nous?</h5>
            <p class="card-text">
                Nous sommes une classe de 2ème année de l'école d'informatique du CFPT. Chacun d'entre nous crée des
                projets que vous pourrez retrouver ici. Notre domaine de prédiliction est le software, et le
                développement d'applications.
            </p>

            <h5 class="card-title">Que faisons-nous?</h5>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3 pl-5 pr-5">
                    <img src="../images/cSharp.bmp" alt="" class="card-img-top rounded-circle mt-3 img-thumbnail">
                    <h2 class="card-title mt-3">C#</h2>
                    <p class="card-text mb-3">
                        Développement d'application
                    </p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 pl-5 pr-5">
                    <img src="../images/html.jpg" alt="" class="card-img-top rounded-circle mt-3 img-thumbnail">
                    <h2 class="card-title mt-3">HTML</h2>
                    <p class="card-text mb-3">
                        Mise en page de site web
                    </p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 pl-5 pr-5">
                    <img src="../images/js.png" alt="" class="card-img-top rounded-circle mt-3 img-thumbnail">
                    <h2 class="card-title mt-3">JS</h2>
                    <p class="card-text mb-3">
                        Scripting de site web
                    </p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 pl-5 pr-5">
                    <img src="../images/php.jpg" alt="" class="card-img-top rounded-circle mt-3 img-thumbnail">
                    <h2 class="card-title mt-3">PHP</h2>
                    <p class="card-text mb-3">
                        Intéraction serveur
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card text-center mb-5">
        <div class="card-header">
            <h4 class="text-uppercase">Projets</h4>
        </div>

        <div class="card-body">
            <?php showProjects() ?>
        </div>
    </div>

</div>

<?php include_once "footer.php" ?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
