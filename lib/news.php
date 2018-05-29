<?php
require_once 'dbConnect.php';

$titre = filter_input( INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING);

$message = "";
/*
if (!$titre || !$description || strlen($titre) < 2 || strlen($description) < 5 ) {
  errorAddNews($titre, $description, $message);
  include '../php/newsForm.php';
}else {
  addNews($titre, $description);
  header('Location: ../php/showNews.php');
  exit;
}
*/

function addNews($titre, $description){
  dbConnect();

  $req = $db->prepare('INSERT INTO tbl_news(Nm_New, Txt_Content_News) VALUES(:titre, :description)');

  $req->execute(array(
    'titre' => $titre,
    'description' => $description
    ));
	
  header('Location: ../php/showNews.php');
  exit;
 }

function errorAddNews($titre, $description, $message){
  define("SUCCESS", 1);
  define("EMPTY_TITLE", 2);
  define("EMPTY_DESCRIPTION", 3);
  define("TITLE_TOO_SHORT",4);
  define("DESCRIPTION_TOO_SHORT",5);
  
  if(!empty($titre)){
	  if(!empty($description)){
		  if(strlen($titre) >= 2){
			  if(strlen($description) >= 5){
				// Les champs ont bien été remplis
			  } else{
				  $errorNews = DESCRIPTION_TOO_SHORT;
			  }
		  } else{
			  $errorNews = TITLE_TOO_SHORT;
		  }
	  } else{
		  $errorNews = EMPTY_DESCRIPTION;
	  }
  } else{
	$errorNews = EMPTY_TITLE;
  }
  
  if (!isset($errorFile)) {
      header("Location: ../php/showNews.php?error=" . SUCCESS);
      exit;
  } else {
      header("Location: ../php/newsForm.php?error=" . $errorFile);
      exit;
  }
 }

function showNews(){
	echo "Les news :";
	echo "<br>";
	
	dbConnect();
	
	echo "<table id='news'>";
	echo "<tr> <th>Titre</th> <th>Description</th>";
	try {
	   foreach ($db->query('SELECT Nm_New, Txt_Content_News FROM tbl_news') as $row) {
		   echo "<tr> <td>" . $row['Nm_New'] . "</td> <td>" . $row['Txt_Content_News'] . "</td></tr>";
	   }
	   
	} catch (PDOException $ex) {
	   echo 'An Error occured!'; // user friendly message
	   error_log($ex->getMessage());
	}
	echo "</table>";
}

if (filter_input(INPUT_POST, 'submit')) {
    errorAddNews();
}