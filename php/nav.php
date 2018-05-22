<?php require_once '../lib/security.php'; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Classe 2b</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);

            $LINKS = array(
                "index.php" => "Accueil",
                "uploadsForm.php" => "Mise en ligne",
                "register.php" => "Inscription",
                "login.php" => "Connexion",
                "newsForm.php" => "Les news"
            );

            foreach ($LINKS as $key => $value) {
                if (isLogged()) {
                    if ($key == $currentPage && !strpos("register", $key) && !strpos("login", $key)) {
                        echo "<li class='nav-item active'><a class='nav-link' href='" . $key . "' >" . $value . "</a></li>";
                    } else {
                        echo "<li><a class='nav-link' href='" . $key . "'>" . $value . "</a></li>";
                    }
                } else {
                    if ($key == $currentPage) {
                        echo "<li class='nav-item active'><a class='nav-link' href='" . $key . "' >" . $value . "</a></li>";
                    } else {
                        echo "<li><a class='nav-link' href='" . $key . "'>" . $value . "</a></li>";
                    }
                }
            }
            ?>
        </ul>
    </div>
</nav>
