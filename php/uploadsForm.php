<?php
include 'nav.php';

$nbError = isset($nbError) ? $nbError : "";
$errors = isset($errors) ? $errors : "";
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Formualire uploads</title>
      <style>
          .error {
              color: red;
          }
      </style>
  </head>
  <body>
    <div>
      <p>
        Vos fichier doivent être en .zip.
      </p>
    </div>
    <table>
      <tr>
        <td>
          <form action="projects.php" method="post" enctype="multipart/form-data">
                <div>
                  <span>Choisir sa partition</span>
                  <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <div>
                  <input required="" type="text" name="fileName" readonly>
                  <input type="submit" value="Upload partition" name="submit">
                </div>
            </form>
        </td>
        <td class="error">
            <?php
            if (isset($errors['extension'])) {
              echo $errors['extension'];
            }elseif (isset($errors['fileToUpload'])) {
              echo $errors['fileToUpload'];
            }elseif (isset($errors['fichierExistant'])) {
              echo $errors['fichierExistant'];
            }
            ?>
        </td>
      </tr>
    </table>
    <?php include 'footer.php'; ?>
  </body>
</html>
