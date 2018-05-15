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
  echo "upload projet";
}
