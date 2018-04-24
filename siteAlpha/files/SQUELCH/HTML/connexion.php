<?php
session_start();

try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if(isset($_POST['formconnexion'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($pseudo) AND !empty($mdpconnect)) {
      $requser = $bd->prepare("SELECT * FROM player WHERE pseudo = ? AND motdepasse = ?");
      $requser->execute(array($pseudo, $mdpconnect));
      $userexist = $requser->rowCount();
      echo $userexist;
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['idPlayer'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         header("Location: menu.php?pseudo=" . $_SESSION['pseudo']);
      } else {
         $erreur = "Mauvais pseudo ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
    <html>

    <head>
        <title>SQUELCH: Connexion</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../CSS/cssConnexion.css">
        <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
    </head>

    <body>
        <img class="logo" src="../IMG/truc.png">
        <div id="center" align="center">
            <h1>Connexion</h1>
            <form method="POST" action="">
                <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" />
                <br />
                <input type="password" name="mdpconnect" placeholder="Mot de passe" /><br />
                <input id="submit" type="submit" name="formconnexion" id="btn" class="btnsMenu" value="Se connecter !"/>
            </form>
            <p id="error">
                <?php
         if(isset($erreur)) {
            echo '<font color="white" size="13rem">'.$erreur."</font>";
         }
         ?>
            </p>
            &nbsp;
            <a href="inscription.php">S'inscrire</a>
        </div>
    </body>

    </html>
