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

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
  <!-- Navabar -->
  <?php include 'nav.php'; ?>
  
  <form action="../lib/news.php" method="post">
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
  <div class="error">
    <?php
    if (filter_input(INPUT_GET, 'error')) {
		switch (filter_input(INPUT_GET, 'error')){
			case 2:
            echo '<div class="p-3 mb-2 bg-danger text-white">';
            echo '<p class="mb-0">Veuillez choisir un titre à votre annonce.</p>';
            break;
			
			case 3:
            echo '<div class="p-3 mb-2 bg-danger text-white">';
            echo '<p class="mb-0">Veuillez mettre une description à votre annonce.</p>';
            break;
		}
	}
  
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
