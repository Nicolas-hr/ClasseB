<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">LOGO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Portfolio</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">A Propos</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="uploadsForm.php">Upload</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Inscription</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#">Connexion</a>
      </li>
	  <?php
        $currentPage = basename($_SERVER['PHP_SELF']);

        $LINKS = array("index.php" => "Accueil",
            "uploadsForm.php" => "Upload");

        foreach ($LINKS as $key => $value) {
            if ($key == $currentPage) {
                echo "<li><a href='" . $key . "' style='color:grey;'>" . $value . "</a></li>";
            }
            else{
                echo "<li><a href='" . $key . "'>" . $value . "</a></li>";
            }
        }


        ?>
    </ul>
  </div>
</nav>
