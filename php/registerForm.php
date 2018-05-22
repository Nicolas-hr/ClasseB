<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/register.css" rel="stylesheet">

    <title>Register</title>
</head>
<body>

<?php require_once 'nav.php'; ?>

<main class="container">
    <form class="form-signin">
        <div id="headerForm" class="text-center">
            <img class="mb-4 rounded" src="../images/php.jpg" alt="" width="72" height="72">

            <h1 class="h3 font-weight-normal">Inscription</h1>
        </div>

        <input type="text" id="first" name="first" class="form-control first" placeholder="Prénom" required autofocus>

        <input type="text" id="last" name="last" class="form-control" placeholder="Nom" required>

        <input type="text" id="username" name="username" class="form-control" placeholder="Pseudo" required>

        <input type="email" id="email" name="email" class="form-control" placeholder="Adresse email" required>

        <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Mot de passe" required>

        <input type="password" id="pwdConfirme" name="pwdConfirme" class="form-control last" placeholder="Confirmer votre mot de passe" required>

        <div class="checkbox mb-3 mt-3 text-center">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>

        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Inscription" name="register">
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
    </form>
</main>

<!-- JQUERY - JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
</body>
</html>
