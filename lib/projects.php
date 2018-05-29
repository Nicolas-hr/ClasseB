<?php
function showProjects()
{
    $dir = "../uploads/";

    echo '<div class="row">';

    foreach (scandir($dir) as $project) {
        if ($project != "." && $project != "..") {
            echo '<div class="col-sm-12 col-md-6 col-lg-4 mb-4 p-0">';
            echo '<div class="card mx-auto" style="width: 18rem;">';
            if (file_exists('../uploads/' . $project . '/projetInfo/imgRep.jpg')) {
                echo '<img class="card-img-top" src="../uploads/' . $project . '/projetInfo/imgRep.jpg" alt="Card image cap">';
            } else {
                echo '<img class="card-img-top" src="../images/default-thumbnail.jpg" alt="Card image cap">';
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $project . '</h5>';
            if (file_exists('../uploads/' . $project . '/projetInfo/description.txt')) {
                echo '<p class="card-text text-truncate">' . file_get_contents('../uploads/' . $project . '/projetInfo/description.txt') . '</p>';
            } else {
                echo '<p class="card-text">Description manquante</p>';
            }
            echo '</div>';
            echo '<div class="card-body">';
            if (file_exists('../uploads/' . $project . '/index.php')) {
                echo '<a href="../uploads/' . $project . '/index.php" class="card-link btn btn-info w-100">JOUER</a>';
            } else {
                if (file_exists('../uploads/' . $project . '/index.html')) {
                    echo '<a href="../uploads/' . $project . '/index.html" class="card-link btn btn-info w-100">JOUER</a>';
                } else {
                    echo '<a href="#" class="card-link btn btn-info w-100 disabled">JOUER</a>';
                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    echo '</div>';
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
                } else {
                    $errorFile = ZIP_ERROR;
                }

                unlink($location . $file_name);
            }
        } else {
            $errorFile = NO_CHOSSEN_FILE;
        }
    }

    if (!isset($errorFile)) {
        header("Location: ../php/uploadsForm.php?error=" . SUCCESS);
        exit;
    } else {
        header("Location: ../php/uploadsForm.php?error=" . $errorFile);
        exit;
    }
}

if (filter_input(INPUT_POST, 'submit')) {
    uploadProject();
}
