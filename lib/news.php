<?php
function addNews($titre, $description)
{
  try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=classe2b;charset=utf8mb4', 'root');
  } catch (Exception $e) {
    die("erreur : ". $e->getMessage());
  }

  $req = $db->prepare('INSERT INTO tbl_user(Nm_News, Txt_Contents_News) VALUES(:titre, :description)');
  $salt = uniqid();

  $req->execute(array(
    'titre' => $titre,
    'description' => $description
    ));}

function errorAddNews($titre, $description)
{
  
}
 ?>
