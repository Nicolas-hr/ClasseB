<?php
require_once 'dbConnect.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

function getUserId(){
	$db = dbConnect();

	$req = $db->prepare("select Id_User from tbl_user where Id_User ='".$_SESSION['id']."'");
	$req->execute();
}
