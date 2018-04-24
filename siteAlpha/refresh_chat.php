<?php
session_start();

try {
  $database = new PDO('mysql:host=pnwd.myd.infomaniak.com;dbname=pnwd_classe2b', 'pnwd_tanguyCvgn', 'GmanG1pomCTdelicieu!');
} catch (PDOException $e) {
  echo "échec de la connexion : ". $e->getMessage();
}

if (isset($_POST['sendmessage'])) {
  if(!empty($_POST['message'])){
    $messageChat = FILTER_INPUT(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $date = date("Y-m-d H:i:s");
    $insertmessage = $database->prepare('INSERT INTO messages(message, owner, date) VALUES(?,?,?)');
    $insertmessage->execute(array($messageChat, $_SESSION['userinfo']['id'], $date));
}
  else{
    $message = "veuillez entrer qqch";
  }
}
$getMessages = $database->prepare('SELECT * FROM messages');
$getMessages->execute();
?>
    <ul style="list-style-type: none;">
        <?php 
                while ($a = $getMessages->fetch()) {
                    $_SESSION['nbrow_now'] = $getMessages->rowCount();
                    if($_SESSION['nbrow_now']!=$_SESSION['nbrow_old']){
                        $_SESSION['nbrow_old'] = $_SESSION['nbrow_now'];
                        echo "<script>scrollBottom();</script>";
                    }
                    $getOwner = $database->prepare("SELECT pseudo_user from membres WHERE id_user=".$a['owner']);
                    $getOwner->execute();
                    $resultatOwner = $getOwner->fetch();
                                        
                    $ancienMessage = $database->prepare('SELECT * FROM messages WHERE id = ' . (intval($a['id']) - 1));
                    $ancienMessage->execute();
                    $ancienValue = $ancienMessage->fetch();
                    
                    if($_SESSION['userinfo']['pseudo']==$resultatOwner['pseudo_user']) { 
                ?>
            <li style="color: blue; margin-bottom: 1.5%;">
               <span style="color: white;"><?php if($a['owner'] != $ancienValue['owner']) { echo $resultatOwner['pseudo_user'] . ': </br>'; } ?></span>
                <?=$a['message']?>
                    <?php } else{ ?>
                    <li style="color: black; margin-bottom: 1.5%;">
                       <span style="color: white;"><?php if($a['owner'] != $ancienValue['owner']) { echo $resultatOwner['pseudo_user'] . ': </br>'; } ?></span>
                        <?=$a['message']?>
                            <?php } ?>
                            
                    </li>
        <?php } ?>
    </ul>
