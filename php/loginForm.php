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

    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>Login</title>
</head>
<body class="parallax">

<?php require_once "nav.php" ?>
<?php require_once "aside.php" ?>

<main class="container mt-5">
    <form class="form-signin" action="../lib/login.php" method="post">
        <div id="headerForm" class="text-center">
            <img class="mb-4 rounded" src="../images/logo.png" alt="" width="72" height="72">

            <h1 class="h3 font-weight-normal">Connexion</h1>
        </div>

        <input type="email" id="email" name="emailL" class="form-control first" placeholder="Adresse email" required value="<?php if (isset($_SESSION['errorLog'])) { echo $_SESSION['errorLog']['email']; } ?>">

        <input type="password" id="pwd" name="pwdL" class="form-control last" placeholder="Mot de passe" required>

        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Connexion" name="login">

        <?php
        if (isset($_SESSION['errorLog']) AND $_SESSION['errorLog'] != '') {
            echo "<div class='mt-2 alert alert-danger' role='alert' >" . $_SESSION['errorLog']['message'] . "</div>";
        }

        $_SESSION['errorLog'] = '';
        ?>

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
