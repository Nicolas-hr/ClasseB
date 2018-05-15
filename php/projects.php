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

function uploadProject()
{
    $file_name = $_FILES['fileToUpload']['name'];
    $file_tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $zip = new ZipArchive();

    if (isset($file_name)) {
        if (!empty($file_name)) {
            $location = '../uploads/';

            if (move_uploaded_file($file_tmp_name, $location . $file_name)) {
                echo "Uploaded !";

                if ($zip->open($location . $file_name) === true) {
                    $zip->extractTo($location);
                    $zip->close();
                }
                else {
                    echo "unzip fail";
                }

                unlink($location . $file_name);
            }
        }
        else {
            echo "Choose a file";
        }
    }

    header("Location: index.php");
    exit;
}
