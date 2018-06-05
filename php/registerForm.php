<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="../images/logo.png" type="image/x-icon"/>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/register.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <title>Register</title>
</head>
<body class="parallax">

<?php require_once "nav.php" ?>
<?php require_once "aside.php" ?>

<main class="container mt-5">
    <form class="form-signin" action="../lib/register.php" method="post">
        <div id="headerForm" class="text-center">
            <img class="mb-4 rounded" src="../images/logo.png" alt="" width="72" height="72">

            <h1 class="h3 font-weight-normal">Inscription</h1>
        </div>

        <input type="text" id="first" name="firstNameR" class="form-control first" placeholder="Prénom" required
               autofocus value="<?php if (isset($_SESSION['firstNameReg']) AND $_SESSION['firstNameReg'] != '') {
            echo $_SESSION['firstNameReg'];
        } ?>">


        <input type="text" id="last" name="lastNameR" class="form-control" placeholder="Nom" required
               value="<?php if (isset($_SESSION['lastNameReg']) AND $_SESSION['lastNameReg'] != '') {
                   echo $_SESSION['lastNameReg'];
               } ?>">

        <input type="text" id="username" name="usernameR" class="form-control" placeholder="Pseudo" required
               value="<?php if (isset($_SESSION['username']) AND $_SESSION['username'] != '') {
                   echo $_SESSION['username'];
               } ?>">

        <input type="email" id="email" name="emailR" class="form-control" placeholder="Adresse email" required
               value="<?php if (isset($_SESSION['emailReg']) AND $_SESSION['emailReg'] != '') {
                   echo $_SESSION['emailReg'];
               } ?>">

        <input type="password" id="pwd" name="pwdR" class="form-control" placeholder="Mot de passe" required>

        <input type="password" id="pwdConfirme" name="confirmPwdR" class="form-control last"
               placeholder="Confirmer votre mot de passe" required>

        <input class="btn btn-lg btn-primary btn-block rounded" type="submit" value="Inscription" name="register">

        <?php {


            if (isset($_SESSION['errorReg'])) {
                foreach ($_SESSION['errorReg'] as $value) {
                    if ($value != "") {
                        echo "<div class='mt-2 alert alert-primary' role='alert' >" . $value . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button></div>";

                    }
                }
            }
        }
        $_SESSION['errorReg'] = [
            'firstName' => '',
            'lastName' => '',
            'username' => '',
            'email' => '',
            'password' => '',
        ];
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
