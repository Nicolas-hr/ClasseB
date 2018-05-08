<?php
function showProjects() {
    echo '<table>';
    for ($i = 0; $i < 10; $i++) {
        echo '<tr>';
        echo '<td>Projet n°' . $i . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}