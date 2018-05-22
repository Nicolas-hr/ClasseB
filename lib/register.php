<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "dbConnect.php";

//VARIALES DANS LA SESSION
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = '';
    $_SESSION['errorReg'] = [
        'firstName' => '',
        'lastName' => '',
        'username' => '',
        'password' => '',
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
        'firstName' =>'',
        'lastName' =>'',
        'email' => '',
        'username'=>'',
        'password' => '',
    ];

    $error = false;

    //Entrees par l'utilisateur
    $firstName = filter_input(INPUT_POST, 'firstNameR', FILTER_SANITIZE_EMAIL);
    $lastName = filter_input(INPUT_POST, 'lastNameR', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'emailR', FILTER_VALIDATE_EMAIL);
    $username = filter_input(INPUT_POST, 'uidR', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdR', FILTER_SANITIZE_STRING);
    $confirmPwd = filter_input(INPUT_POST, 'confirmPwdR', FILTER_SANITIZE_STRING);


    if (empty($firstName)) {
        $_SESSION['errorReg']['firstName'] = "Enter your first name";
        $error = true;
    }
    if (empty($lastName)) {
        $_SESSION['errorReg']['lastName'] = "Enter your last name";
        $error = true;
    }
    if (empty($email)) {
        $_SESSION['errorReg']['email'] = "Enter a valid email format";
        $error = true;
    }
    if (empty($username)) {
        $_SESSION['errorReg']['username'] = "Enter a username";
        $error = true;
    }
    if (empty($pwd) OR empty($confirmPwd) OR $pwd!=$confirmPwd) {

        $_SESSION['errorReg']['password'] = "The passwords don't match";
        $error = true;
    }

    if (!$error) {
        if (userVerify($username)) {
            addUser($firstName, $lastName, $email, $username, $pwd);
            header("Location:../login.php");
            exit;
        }
    }


}
header("Location:../register.php");
exit;

//FONCTIONS-------------------------------------------------------------------------------------------------------------

function userVerify($usernameVerify)
{
    $db = dbConnect();

    $username_ok = false;

    $usernameRequest = $db->prepare("SELECT Txt_Username  FROM tbl_user WHERE Txt_Username=:username");
    $usernameRequest->execute(array(":username" => $usernameVerify));

    if ($usernameRequest->rowCount() == 0) {
        $username_ok = true;
    }
    return $username_ok;
}

function addUser($firstNameUser, $lastNameUser, $emailUser, $userName, $pwdUser)
{
    $db = dbConnect();

    $salt = uniqid();
    $pwdSalt = $pwdUser . $salt;
    $pwdHash = sha1($pwdSalt);

    //Ajout dans la table user
    $userAddRequest = $db->prepare("INSERT INTO tbl_user(Txt_Username, Nm_First, Nm_Last,Txt_Email,  Txt_Password_Hash, Txt_Password_Salt) VALUES (:username, :firstname,:lastname, :email, :pwdhash, :pwdsalt )");
    $userAddRequest->execute(array(":username" => $userName, ":firstname" => $firstNameUser, ":lastname" => $lastNameUser, ":email" => $emailUser, ":pwdhash" => $pwdHash, ":pwdsalt" => $salt));


}



