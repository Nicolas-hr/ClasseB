<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../lib/dbConnect.php";

//VARIALES DANS LA SESSION
if (!isset($_SESSION['firstNameReg'])) {
    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['emailReg'] = '';
    $_SESSION['errorReg'] = [
        'firstName' => '',
        'lastName' => '',
        'email' => '',
        'password' => '',
    ];
}

//VARIABLES LOCALES
$firstName = "";
$lastName = "";
$email = "";
$pwd = "";
$error = false;


//Lors du click dans le bouton submit
if (filter_has_var(INPUT_POST, 'register')) {


    //Vider le variables de session
    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['emailReg'] = '';
    $_SESSION['errorReg'] = [
        'firstName' => '',
        'lastName' => '',
        'email' => '',
        'password' => '',
    ];

    $error = false;

    //Entrees par l'utilisateur
    $firstName = filter_input(INPUT_POST, 'firstNameR', FILTER_SANITIZE_EMAIL);
    $lastName = filter_input(INPUT_POST, 'lastNameR', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'emailR', FILTER_VALIDATE_EMAIL);
    $pwd = filter_input(INPUT_POST, 'pwdR', FILTER_SANITIZE_STRING);


    if (empty($firstName)) {
        $_SESSION['errorReg']['firstName'] = "Le prénom rentré n'est pas valable";
        $error = true;
    }
    if (empty($lastName)) {
        $_SESSION['errorReg']['lastNameReg'] = "Le prénom rentré n'est pas valable";
        $error = true;
    }
    if (empty($email)) {
        $_SESSION['errorReg']['email'] = "L'email rentré n'est pas valable";
        $error = true;
    }
    if (empty($pwd)) {
        $_SESSION['errorReg']['password'] = "Le mot de passe rentré n'est pas valable";
        $error = true;
    }
    if (!$error) {
        if (emailVerify($email)) {
            addUser($firstName, $lastName, $email, $pwd);
            header("Location:../login.php");
            exit;
        } else {
            $_SESSION['errorReg'] = "L'email n'est pas valable.";
        }
    }


}
header("Location:../register.php");
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

function addUser($firstNameUser, $lastNameUser, $emailUser, $pwdUser)
{
    $db = dbConnect();

    $salt = uniqid();
    $pwdSalt = $pwdUser . $salt;
    $pwdHash = sha1($pwdSalt);

    //Ajout dans la table user
    $userAddRequest = $db->prepare("INSERT INTO tbl_user(Nm_First, Nm_Last, Txt_Password_Hash, Txt_Password_Salt) VALUES (:firstname,:lastname, :pwdhash, :pwdsalt )");
    $userAddRequest->execute(array(":firstname" => $firstNameUser, ":lastname" => $lastNameUser, ":pwdhash" => $pwdHash, ":pwdsalt" => $salt));

    //Numero du dernier index de la table user
    $lastIndex = $db->lastInsertId();

    //Ajout dans la table email
    $userAddRequest = $db->prepare("INSERT INTO tbl_email(Txt_Email,Id_User) VALUES (:email,:lastUserId )");
    $userAddRequest->execute(array(":email" => $emailUser, ":lastUserId" => $lastIndex));
}



