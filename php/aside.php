<?php
require_once '../lib/security.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<div class="fixed-top bg-dark text-white h-100 text-center" style="width: 75px; font-size: 0.8rem; margin-top: 52px;">
    <nav class="navbar navbar-expand-lg navbar-light pl-0">
        <ul class="navbar-nav flex-column">

            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);

            if (isLogged()) {
                $LINKS = array(
                    "index.php" => "Accueil",
                    "showNews.php" => "Les news",
                    "uploadsForm.php" => "Mise en ligne",
                    "profil.php" => "Profil",
                    "../lib/logout.php" => "Logout",
                );
            } elseif (!isLogged()) {
                $LINKS = array(
                    "index.php" => "Accueil",
                    "showNews.php" => "Les news",
                    "registerForm.php" => "Inscription",
                    "loginForm.php" => "Connexion",
                );
            }

            $images = array(
                'index.php' => '<i class="fas fa-home" style="font-size: 2.5rem;"></i>',
                'uploadsForm.php' => '<i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem;"></i>',
                'showNews.php' => '<i class="fas fa-newspaper" style="font-size: 2.5rem;"></i>',
                'profil.php' => '<i class="fas fa-user-alt" style="font-size: 2.5rem;"></i>',
                'registerForm.php' => '<i class="fas fa-user-plus" style="font-size: 2.5rem;"></i>',
                'loginForm.php' => '<i class="fas fa-sign-in-alt" style="font-size: 2.5rem;"></i>',
                '../lib/logout.php' => '<i class="fas fa-sign-out-alt" style="font-size: 2.5rem;"></i>',
            );


            foreach ($LINKS as $key => $value) {
                if ($key == $currentPage) {
                    echo "<li class=\"nav-item text-info active\"><a class=\"nav-link text-info\" href=\"" . $key . " \"> " . $images[$key] . $value . "</a></li>";
                } else {
                    echo "<li class=\"nav-item text-light\"><a class=\"nav-link text-light\" href=\"" . $key . " \"> " . $images[$key] . $value . "</a></li>";
                }
            }
            ?>
        </ul>
    </nav>
</div>
