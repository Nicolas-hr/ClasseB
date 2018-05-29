<?php
require_once '../lib/security.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
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

            if (isLogged()) {
                $LINKS = array(
                    "index.php" => "Accueil",
                    "uploadsForm.php" => "Mise en ligne",
                    "showNews.php" => "Les news",
                    "profil.php?action=infos" => "Profil",
                    "../lib/logout.php" =>"Logout",
                );
            } elseif (!isLogged()) {
                $LINKS = array(
                    "index.php" => "Accueil",
                    "registerForm.php" => "Inscription",
                    "loginForm.php" => "Connexion",
                    "showNews.php" => "Les news",
                );
            }


            foreach ($LINKS as $key => $value) {

                if ($key == $currentPage) {
                    echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"" . $key . " \"> " . $value . "</a></li>";
                } else {
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"" . $key . " \"> " . $value . "</a></li>";
                }


            }
            ?>
        </ul>
    </div>
</nav>
