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
    define("SUCCESS", 1);
    define("NO_CHOSSEN_FILE", 2);
    define("ZIP_ERROR", 3);

    $file_name = $_FILES['fileToUpload']['name'];
    $file_tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $zip = new ZipArchive();

    if (isset($file_name)) {
        if (!empty($file_name)) {
            $location = '../uploads/';

            if (move_uploaded_file($file_tmp_name, $location . $file_name)) {
                if ($zip->open($location . $file_name) === true) {
                    $zip->extractTo($location);
                    $zip->close();
                }
                else {
                    $errorFile = ZIP_ERROR;
                }

                unlink($location . $file_name);
            }
        }
        else {
            $errorFile = NO_CHOSSEN_FILE;
        }
    }

    if (!isset($errorFile)) {
        header("Location: uploadsForm.php?error=" . SUCCESS);
        exit;
    } else {
        header("Location: uploadsForm.php?error=" . $errorFile);
        exit;
    }
}
