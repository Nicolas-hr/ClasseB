<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once 'newsForm.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Les news</title>
</head>
<body>
  <form action="news.php" method="post">
    <table>
      <tr>
        <td>
          <label for="titre">Titre: </label>
        </td>
        <td>
          <input type="text" name="titre" id="titre" value="<?php echo (isset($titre) ? $titre : "")?>">
        </td>
      </tr>
      <tr>
        <td>
          <label for="description">Description: </label>
        </td>
        <td>
          <input type="text" name="description" id="description" value="<?php echo (isset($description) ? $description : "")?>">
        </td>
      </tr>
    </table>
    <input type="submit" name="addAnnonce" value="Ajouter une annonce">
  </form>
</body>
</html>
