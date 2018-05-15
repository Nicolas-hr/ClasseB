<?php
session_start();

try {
    $bd = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_squelch', 'SquelchP2B');
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
          if($mdp == $mdp2) {
             $insertmbr = $bd->prepare("INSERT INTO player(pseudo, motdepasse) VALUES(?, ?)");
             $insertmbr->execute(array($pseudo, $mdp));
			 $insertmbr = $bd->prepare("INSERT INTO progression(progression) VALUES(0)");
             $insertmbr->execute();
			  $insertmbr = $bd->prepare("INSERT INTO reglages(son) VALUES(50)");
             $insertmbr->execute();
             $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
          } else {
             $erreur = "Vos mots de passes ne correspondent pas !";
          }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
    <html>

    <head>
        <title>SQUELCH - inscription</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../CSS/cssConnexion.css">
        <link href="https://fonts.googleapis.com/css?family=Righteous&effect=3d-float" rel="stylesheet">
    </head>

    <body>
        <img class="logo" src="../IMG/truc.png">
        <div align="center">
            <h1>Inscription</h1>
            <br /><br />
            <form method="POST" action="">
                <table>
                    <tr>
                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <br />
                            <input id="submit" type="submit" name="forminscription" value="Je m'inscris"/>
                        </td>
                    </tr>
                </table>
            </form>
                <?php
         if(isset($erreur)) {
            echo '<font color="white" size="5px">'.$erreur."</font>";
         }
         ?>
            
        </div>
    </body>

    </html>
