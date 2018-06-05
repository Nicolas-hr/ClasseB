<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../lib/security.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../images/logo.png" type="image/x-icon"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<?php if (isLogged()){ ?>
<body class="parallax">
<!-- Navabar -->
<?php require_once "nav.php" ?>
<?php require_once "aside.php" ?>

<div class="container mt-5">

    <h1 class="display-4 w-100 text-center mt-3 pb-3 border-bottom border-dark">
        Ajout d'actualité
    </h1>

    <div class="card mb-4 mt-3">
        <div class="card-header">
            <h4 class="text-center">Ajout d'actualité</h4>
        </div>
        <div class="card-body">

            <form action="../lib/news.php" method="post">
                <div class="form-group">
                    <label for="titre">Titre: </label>
                    <input type="text" class="form-control" name="titre" id="titre">
                </div>

                <div class="form-group">
                    <label for="description">Description: </label>
                    <input type="text" class="form-control" name="description" id="description">
                </div>

                <input type="submit" class="btn btn-primary" name="addAnnonce" value="Ajouter une annonce">
            </form>
            <div class="error">
                <?php
                if (filter_input(INPUT_GET, 'errorNews')) {
                    switch (filter_input(INPUT_GET, 'errorNews')) {
                        case 2:
                            echo '<div class="p-3 mb-2 bg-danger text-white">';
                            echo '<p class="mb-0">Veuillez choisir un titre à votre annonce.</p>';
                            break;

                        case 3:
                            echo '<div class="p-3 mb-2 bg-danger text-white">';
                            echo '<p class="mb-0">Veuillez mettre une description à votre annonce.</p>';
                            break;

                        case 4:
                            echo '<div class="p-3 mb-2 bg-danger text-white">';
                            echo '<p class="mb-0">Votre titre doit faire 2 carctères au minimum.</p>';
                            break;

                        case 5:
                            echo '<div class="p-3 mb-2 bg-danger text-white">';
                            echo '<p class="mb-0">Votre description doit faire 5 carctères au minimum.</p>';
                            break;
                    }
                }
                } else {
                    header('Location: loginForm.php');
                    exit;
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include 'footer.php'; ?>

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
