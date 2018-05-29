<?php
require_once 'security.php';
require_once 'dbConnect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$bdd = dbConnect();

$first = filter_input(INPUT_POST, 'first', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
$last = filter_input(INPUT_POST, 'last', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
$mdpC = filter_input(INPUT_POST, 'mdpConfirm', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);

if ($first != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_User SET Nm_First = :updatedName WHERE Id_User = :id");
    $updateFirst->execute(array(':updatedName' => $first,':id' => $id));
}

if ($last != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_User SET Nm_Last = :updatedLast WHERE Id_User = :id");
    $updateFirst->execute(array(':updatedLast' => $last,':id' => $id));
}

if ($email != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_Email SET Txt_Email = :updatedEmail WHERE Txt_Email LIKE :email");
    $updateFirst->execute(array(':updatedEmail' => $email,':email' => $_SESSION['email']));
}

if ($mdp != null && $mdpC != null) {
    if ($mdp === $mdpC) {
        $salt = $bdd->prepare("SELECT Txt_Password_Salt FROM Tbl_User WHERE Id_User = :id");
        $salt->execute(array(':id' => $id));
        $salt = $salt->fetch();

        $updateMdp = $bdd->prepare("UPDATE Tbl_User SET Txt_Password_Hash = :mdp WHERE Id_User = :id");
        $updateMdp->execute(array(':mdp' => sha1($mdp . $salt['Txt_Password_Salt']), ':id' => $id));
    }
}

header('Location: ../php/profil.php?action=infos');
exit;