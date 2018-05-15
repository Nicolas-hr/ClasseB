<?php
function showProjects() {
    $dir = "../uploads/";

    echo '<table>';
    foreach (scandir($dir) as $project) {
        if ($project != "." && $project != "..") {
            echo '<tr>';
            echo '<td>' . $project . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
}

function uploadProject( )
{
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $projectFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $nbError = 0;

  $nameFile = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_STRING);

  $errors = array();

  // Verifie si le fichier est une partition
  if(isset($_POST["submit"])) {
    if($projectFileType != "zip") {
        $errors["extension"] = "Juste les fichier .zip ou les dossier sont acceptés sur ce site.";
    }
    // Check if file already exists
    elseif (file_exists($target_file)) {
       $errors["fichierExistant"] = "Sorry, file already exists.";
    }
  }

  if(count($errors) == 0){
    header("Location: index.php");
  }
}
