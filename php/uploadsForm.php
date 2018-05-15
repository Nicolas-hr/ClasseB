<?php
include 'nav.php';
require_once 'projects.php';

$nbError = isset($nbError) ? $nbError : "";
$errors = isset($errors) ? $errors : "";

if (filter_input(INPUT_POST, 'submit')) {
    uploadProject();
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Formualire uploads</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container text-left">
    <div class="row">
        <div class="col s9 m9">
            <form action="uploadsForm.php" method="post" enctype="multipart/form-data">
                <div class="custom-file">
                    <input type="file" name="fileToUpload" class="" id="fileToUpload">
                    <label class="custom-file-label" for="fileToUpload">Choose file</label>
                </div>
                <input class="btn btn-primary" type="submit" value="Upload project" name="submit">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12">
            <div class="blockquote">
                <p class="mb-0"></p>
            </div>
        </div>
    </div>
    <div class="error">
        <?php
        if (isset($errors['extension'])) {
            echo $errors['extension'];
        } elseif (isset($errors['fileToUpload'])) {
            echo $errors['fileToUpload'];
        } elseif (isset($errors['fichierExistant'])) {
            echo $errors['fichierExistant'];
        }
        ?>
    </div>
</div>

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
