<?php
function isLogged()
{
    if (array_key_exists('logged', $_SESSION)) {
        return $_SESSION['logged'];
    }
}

function addNews($titre, $description){
  try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=classe2b; charset=utf8mb4', 'root');
  } catch (Exception $e) {
    die("erreur : ". $e->getMessage());
  }

  $req = $db->prepare('INSERT INTO tbl_news(Nm_New, Txt_Content_News) VALUES(:titre, :description)');

  $req->execute(array(
    'titre' => $titre,
    'description' => $description
    ));
}

function errorAddNews($titre, $description, $message)
{
  if(strlen($titre) < 2 ){
	  $message = "titre trop court";
  }elseif(empty($titre)){
  $message = "Il faut un titre";
  }
  
  if(strlen($description) < 5){
	  $message = "Description trop courte";
  }elseif(empty($description)){
	  $message = "Vous devez mettre une description";
  }
}

function showNews(){
	echo "Les news :";
	echo "<br>";
    $db = new PDO('mysql:host=127.0.0.1;dbname=classe2b; charset=utf8mb4', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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