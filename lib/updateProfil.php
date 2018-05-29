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
$file_name = $_FILES['fileToUpload']['name'];
$file_tmp_name = $_FILES['fileToUpload']['tmp_name'];

if ($first != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_User SET Nm_First = :updatedName WHERE Id_User = :id");
    $updateFirst->execute(array(':updatedName' => $first, ':id' => $id));
}

if ($last != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_User SET Nm_Last = :updatedLast WHERE Id_User = :id");
    $updateFirst->execute(array(':updatedLast' => $last, ':id' => $id));
}

if ($email != null) {
    $updateFirst = $bdd->prepare("UPDATE Tbl_Email SET Txt_Email = :updatedEmail WHERE Txt_Email LIKE :email");
    $updateFirst->execute(array(':updatedEmail' => $email, ':email' => $_SESSION['email']));
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

if (isset($file_name)) {
    if (!empty($file_name)) {
        $location = '../images/';

        $image = imagecreatefromjpeg($file_tmp_name);

        $thumb_width = 150;
        $thumb_height = 150;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg($thumb, $location . $file_name, 80);

        $updateImage = $bdd->prepare("UPDATE Tbl_User SET Txt_Image_Profil = :image WHERE Id_User = :id");
        $updateImage->execute(array(':image' => $file_name, 'id' => $id));
    }
}

header('Location: ../php/profil.php?action=infos');
exit;