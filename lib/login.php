<?php
require_once "dbConnect.php";

// Initialiser tous les champs de la session lors de la 1ère ouverture
//VARIALES DANS LA SESSION
if (!isset($_SESSION['logged'])) {

    //Session vide -> créer tous les champs
    $_SESSION['logged'] = FALSE;
    $_SESSION['email'] = '';
    $_SESSION['emailLog'] = '';
    $_SESSION['errorLog'] = '';
}


//VARIABLES LOCALES
$email = "";
$pwd = "";


if (filter_has_var(INPUT_POST, 'login')) {
    echo "dab";

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

        echo "lol";
        if (pwdVerify($email, $pwd)) {
            echo "dab";
            $_SESSION['email'] = $email;

            $_SESSION['logged'] = TRUE;

            header("Location:../php/index.php");
            exit;

        } else {

            $_SESSION['errorLog'] = "Le mot de passe n'est pas valable";
        }

    } else {
        $_SESSION['errorLog'] = "L'email n'existe pas";
    }
}
//header("Location:../php/loginForm.php");
//exit;

//FONCTIONS-------------------------------------------------------------------------------------------------------------
function emailVerify($emailVerify)
{
    $db = dbConnect();

    $emailRequest = $db->prepare("SELECT Txt_Email 'email'  FROM tbl_email WHERE Txt_Email=:email");
    $emailRequest->execute(array(":email" => $emailVerify));


    return $emailRequest->rowCount() == 1;

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

    $pwdHash =  sha1($pwdVerify . $pwdRequestResult['salt']);

    if ( $pwdHash== $pwdRequestResult['pwdHash']) {
        $password_ok = true;
    }

    return $password_ok;
}

function insertUser()
{

}