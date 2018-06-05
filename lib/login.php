<?php
require_once "dbConnect.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialiser tous les champs de la session lors de la 1ère ouverture
//VARIALES DANS LA SESSION
if (!isset($_SESSION['logged'])) {

    //Session vide -> créer tous les champs
    $_SESSION['logged'] = FALSE;
    $_SESSION['email'] = '';
    $_SESSION['emailLog'] = '';
    $_SESSION['errorLog'] = '';
    $_SESSION['id'] = -1;
}


//VARIABLES LOCALES
$email = "";
$pwd = "";


if (filter_has_var(INPUT_POST, 'login')) {

    //Connexion à la bd
    $db = dbConnect();

    //Vider le variables de session
    $_SESSION['emailLog'] = '';
    $_SESSION['errorLog'] = '';

    //Entrees par l'utilisateur
    $email = filter_input(INPUT_POST, 'emailL', FILTER_SANITIZE_EMAIL);
    $pwd = filter_input(INPUT_POST, 'pwdL', FILTER_SANITIZE_STRING);


    if (emailVerify($email)) {

        $_SESSION['emailLog'] = $email;

        if (pwdVerify($email, $pwd)) {

            $_SESSION['id'] = getId($email);
            $_SESSION['logged'] = TRUE;

            header("Location:../php/index.php");
            exit;

        } else {

            $_SESSION['errorLog'] = array(
                'message' => "Le mot de passe n'est pas valable",
                'email' => $email,
            );
        }

    } else {
        $_SESSION['errorLog'] = array(
            'message' => "L'email n'existe pas",
            'email' => $email,
        );
    }
}
header("Location:../php/loginForm.php");
exit;

//FONCTIONS-------------------------------------------------------------------------------------------------------------
function emailVerify($emailVerify)
{
    $db = dbConnect();

    $emailRequest = $db->prepare("SELECT Txt_Email 'email'  FROM tbl_email WHERE Txt_Email=:email");
    $emailRequest->execute(array(":email" => $emailVerify));


    return $emailRequest->rowCount() == 1;

}

function getId($emailVerify)
{
    $db = dbConnect();

    $id = $db->prepare("SELECT tbl_user.Id_User FROM tbl_user JOIN tbl_email ON tbl_email.Id_User = tbl_user.Id_User WHERE Txt_Email=:email");
    $id->execute(array(":email" => $emailVerify));

    $id = $id->fetch();

    return $id['Id_User'];
}

function pwdVerify($emailVerify, $pwdVerify)
{
    $db = dbConnect();

    $password_ok = false;

    $pwdRequest = $db->prepare('SELECT Txt_Password_Hash "pwdHash", Txt_Password_Salt "salt"
FROM tbl_user AS u
JOIN tbl_email AS e
ON u.Id_User=e.Id_User
WHERE e.Txt_Email=? ');
    $pwdRequest->execute(array($emailVerify));
    $pwdRequestResult = $pwdRequest->fetch();

    $pwdHash = sha1($pwdVerify . $pwdRequestResult['salt']);

    if ($pwdHash == $pwdRequestResult['pwdHash']) {
        $password_ok = true;
    }

    return $password_ok;
}