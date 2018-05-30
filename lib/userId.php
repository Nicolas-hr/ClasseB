<?php
require_once 'dbConnect.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

function getUserId(){
	$db = dbConnect();

	$req = $db->prepare("SELECT Id_User FROM tbl_user WHERE Id_User = ? ");
	$req->execute(array($_SESSION['id']));
	$req = $req->fetch();
	
	return $req['Id_User'];
}
