<?php
require_once "dbConnect.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//VARIALES DANS LA SESSION
if (!isset($_SESSION['firstNameReg'])) {
    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['emailReg'] = '';
    $_SESSION['usernameReg'] = '';

    //Erreurs en session
    $_SESSION['errorReg'] = [
        'firstName' => '',
        'lastName' => '',
        'email' => '',
        'username' => '',

    ];
}

//VARIABLES LOCALES
$firstName = "";
$lastName = "";
$email = "";
$username = "";
$pwd = "";
$confirmPwd = "";
$error = false;

//Lors du click dans le bouton submit
if (filter_has_var(INPUT_POST, 'register')) {


    //Vider le variables de session
    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['emailReg'] = '';
    $_SESSION['username'] = '';
    $_SESSION['errorReg'] = [
        'firstName' => '',
        'lastName' => '',
        'username' => '',
        'email' => '',
        'password' => '',
    ];

    $error = false;

    //Entrees par l'utilisateur
    $firstName = filter_input(INPUT_POST, 'firstNameR', FILTER_SANITIZE_EMAIL);
    $lastName = filter_input(INPUT_POST, 'lastNameR', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'usernameR', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'emailR', FILTER_VALIDATE_EMAIL);
    $pwd = filter_input(INPUT_POST, 'pwdR', FILTER_SANITIZE_STRING);
    $confirmPwd = filter_input(INPUT_POST, 'confirmPwdR', FILTER_SANITIZE_STRING);


    if (empty($firstName)) {
        $_SESSION['errorReg']['firstName'] = "Veuillez entrer votre prénom";
        $error = true;
    }
    if (empty($lastName)) {
        $_SESSION['errorReg']['lastName'] = "Veuillez entrer votre prénom";
        $error = true;
    }
    if (empty($email)) {
        $_SESSION['errorReg']['email'] = "Veuillez entrer un email valide";
        $error = true;
    }
    if (empty($username)) {
        $_SESSION['errorReg']['username'] = "Veuillez entrer un nom d'utilisateur";
        $error = true;
    }
    if (empty($pwd) OR empty($confirmPwd) OR $pwd != $confirmPwd) {
        $_SESSION['errorReg']['password'] = "Les mots de passe ne se correspondent pas";
        $error = true;
    }

    if (!$error) {
        $_SESSION['firstNameReg'] = $firstName;
        $_SESSION['lastNameReg'] = $lastName;
        $_SESSION['username'] = $username;
        if (emailVerify($email)) {
            $_SESSION['emailReg'] = $email;
            addUser($firstName, $lastName, $username, $email, $pwd);
            header("Location: ../php/loginForm.php");
            exit;
        }
        else{
            $_SESSION['errorReg']['email'] = "Cet email est déjà enregistré";
        }
    }


}
header("Location:../php/registerForm.php");
exit;

//FONCTIONS-------------------------------------------------------------------------------------------------------------

function emailVerify($emailVerify)
{
    $db = dbConnect();

    $email_ok = false;

    $emailRequest = $db->prepare("SELECT Txt_Email 'email'  FROM tbl_email WHERE Txt_Email=:email");
    $emailRequest->execute(array(":email" => $emailVerify));

    if ($emailRequest->rowCount() == 0) {
        $email_ok = true;
    }
    return $email_ok;
}

function addUser($firstNameUser, $lastNameUser, $usernameUser, $emailUser, $pwdUser)
{
    $db = dbConnect();

    $salt = uniqid();
    $pwdSalt = $pwdUser . $salt;
    $pwdHash = sha1($pwdSalt);

    //Ajout dans la table user
    $userAddRequest = $db->prepare("INSERT INTO tbl_user(Nm_First, Nm_Last, Txt_Username, Txt_Password_Hash, Txt_Password_Salt) VALUES (:firstname,:lastname,:username, :pwdhash, :pwdsalt )");
    $userAddRequest->execute(array(":firstname" => $firstNameUser, ":lastname" => $lastNameUser, ":username" => $usernameUser, ":pwdhash" => $pwdHash, ":pwdsalt" => $salt));

    //Numero du dernier index de la table user
    $lastIndex = $db->lastInsertId();

    //Ajout dans la table email
    $userAddRequest = $db->prepare("INSERT INTO tbl_email(Txt_Email,Id_User) VALUES (:email,:lastUserId )");
    $userAddRequest->execute(array(":email" => $emailUser, ":lastUserId" => $lastIndex));
}



