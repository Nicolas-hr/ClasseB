<?php
require_once '../lib/security.php';
require_once '../lib/dbConnect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$actions = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);

if ($actions == null) {
    header('Location: ./profil.php?action=infos');
    exit;
}

if (!isLogged()) {
    header('Location: ./index.php');
    exit;
}

$bdd = dbConnect();

$infosPerso = $bdd->prepare("SELECT * 
                             FROM Tbl_User
                             JOIN Tbl_Email ON Tbl_Email.Id_User = Tbl_User.Id_User
                             WHERE Tbl_User.Id_User = :id");

$infosPerso->execute(array(':id' => $_SESSION['id']));

$infosPerso = $infosPerso->fetch();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Profil</title>
</head>
<body>

<?php require_once 'nav.php'; ?>

<div class="container">
    <div class="row mt-5">
        <!--  Left side  -->
        <div class="col-sm-2 col-md-2 col-lg-2">
            <img src="../images/<?php echo $infosPerso['Txt_Image_Profil'] ?>" class="rounded-circle w-100"
                 alt="Image de profil">

            <!--  Links  -->
            <div id="link" class="mt-3">
                <a href="./profil.php?action=infos" class="d-block text-center mt-2">Infos</a>
                <a href="./profil.php?action=confidentialite" class="d-block text-center mt-2">Confidentialité</a>
            </div>
        </div>

        <!--  Right side  -->
        <div class="col-sm-10 col-md-10 col-lg-10 border-left">

            <!--  Obligé de faire ce décalage dégueux pour pas faire d'erreur  -->
            <?php if ($actions === "infos") : ?>
                <?php
                if ($infosPerso['Txt_Description_Profil'] != null) {
                    echo $infosPerso['Txt_Description_Profil'];
                } else { ?>
                    <p>
                        Pas de description pour le moment.
                    </p>
                <?php } ?>
            <?php elseif ($actions === "confidentialite"): ?>
                <form action="../lib/updateProfil.php" method="post" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="first">Prénom</label>
                        <input type="text" class="form-control" name="first" id="first"
                               value="<?php echo $infosPerso['Nm_First']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="last">Nom</label>
                        <input type="text" class="form-control" name="last" id="last"
                               value="<?php echo $infosPerso['Nm_Last']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                               value="<?php echo $infosPerso['Txt_Email']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" class="form-control" name="mdp" id="mdp">
                    </div>

                    <div class="form-group">
                        <label for="mdpConfirm">Confirmer votre mot de passe</label>
                        <input type="password" class="form-control" name="mdpConfirm" id="mdpConfirm">
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="fileToUpload" class="" id="fileToUpload">
                            <label class="custom-file-label" for="fileToUpload">Choisir une image</label>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">

                    <input type="submit" class="btn btn-primary" name="update" value="Mettre à jour">
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

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
