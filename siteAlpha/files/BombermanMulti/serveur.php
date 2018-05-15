<?php
session_start();
header('Access-Control-Allow-Origin: *');

// Obtenir les informations de la map "sols"
$joueurs = [];
$terrainSols = file_get_contents("./data/mapSols.json");
$terrainDynamique = file_get_contents("./data/mapDynamique.json");
$pointSpawn = [[50, 50, 1, 1], [50, 550, 1, 11], [550, 50, 11, 1], [550, 550, 11, 11]];
$minLeft = 132;
$maxLeft = 571;
$minTop = 100;
$maxTop = 500;

if(isset($_POST['joueurId']) && isset($_POST['dir'])) {
    
    // y * nbCase + x
    
    $uid = $_POST['joueurId'];
    $dir = $_POST['dir'];
    
    if ($terrainDynamique != ""){
        $joueurs = json_decode($terrainDynamique);
    }
    
    $sols = json_decode($terrainSols);
    
    for ($i = 0; $i < count($joueurs); $i++) {
        if ($joueurs[$i]->id == $uid) {
            $left = intval(substr($joueurs[$i]->style->left, 0, -2));
            $top = intval(substr($joueurs[$i]->style->top, 0, -2));
            $positionX = intval($joueurs[$i]->positionX);
            $positionY = intval($joueurs[$i]->positionY);            
            $cases = count($sols->sols);
            switch ($dir) {
                // nord
                case 0:
                    $positionY--;
                    $numcase = intval($positionY * $cases + $positionX);
                    $sol = $sols->sols[$numcase];
                    file_put_contents("./data/log.txt", $numcase, FILE_APPEND);
                    if (strpos($sol->img->id, "mur") < 0) {
                        if ($top >= $minTop) {
                            $top = $top - 50;
                            $positionY--;
                        }
                    }
                    break;
                // est
                case 1:
                    if (strpos($sols->sols[(intval(intval($joueurs[$i]->positionY) + 1) * count($sols->sols) + intval($joueurs[$i]->positionX))]->img->id, "mur") < 0) {
                        if ($left <= $maxLeft) {
                            $left = $left + 50;
                            $positionX++;
                        }
                    }
                    break;
                // sud
                case 2:
                    if (strpos($sols->sols[(intval($joueurs[$i]->positionY)) * count($sols->sols) + intval(intval($joueurs[$i]->positionX) + 1)]->img->id, "mur") < 0) {
                        if ($top <= $maxTop) {
                            $top = $top + 50;
                            $positionY++;
                        }
                    }
                    break;
                // ouest
                case 3:
                    if (strpos($sols->sols[(intval($joueurs[$i]->positionY)) * count($sols->sols) + intval(intval($joueurs[$i]->positionX) - 1)]->img->id, "mur") < 0) {
                        if ($left >= $minLeft) {
                            $left = $left - 50;
                            $positionX--;
                        }
                    }

                    break;
            }
            
            $left = $left . "px";
            $top = $top . "px";

            $joueurs[$i]->style->left = $left;
            $joueurs[$i]->style->top = $top;
            $joueurs[$i]->positionX = $positionX;
            $joueurs[$i]->positionY = $positionY;
        
            break;
        }
    }
    
    file_put_contents("./data/mapDynamique.json", json_encode($joueurs));
}

if (isset($_POST['joueurAdd'])) {
    session_regenerate_id();
    $error = "";
    $success = "";
    $send = "";
    $joueurId = session_id();
    
    if ($terrainDynamique != ""){
        $joueurs = json_decode($terrainDynamique);
    }
    
    $newjoueur = json_decode($_POST['joueurAdd'], true);
    $newjoueur['id'] = "joueur_" . $joueurId;
    
    if(count($joueurs) == 0) {
        $spawnPoint = 0;
    }
    elseif(count($joueurs) == 1) {
        $spawnPoint = 1;
    }
    elseif(count($joueurs) == 2) {
        $spawnPoint = 2;
    }
    elseif(count($joueurs) == 3) {
        $spawnPoint = 3;
    }
    elseif(count($joueurs) > 3) {
        $error = "507";
        http_response_code(507);
        $send = $error;
    }
    
    if($error == "") {
        $left = $pointSpawn[$spawnPoint][0] + 32;
        $top = $pointSpawn[$spawnPoint][1];

        $newjoueur['style']['left'] = $left . "px";
        $newjoueur['style']['top'] = $top . "px";
        $newjoueur['positionX'] = $pointSpawn[$spawnPoint][2];
        $newjoueur['positionY'] = $pointSpawn[$spawnPoint][3];

        file_put_contents("./data/log.txt", count($joueurs), FILE_APPEND);
        array_push($joueurs, $newjoueur);
        file_put_contents("./data/mapDynamique.json", json_encode($joueurs));
        file_put_contents("./data/idsJoueurs.log", $joueurId, FILE_APPEND);

        $success = $newjoueur['id'];
        $send = $success;
    }
    
    echo $send;
}

if (isset($_GET['requete']) && $_GET['requete'] == "askId")
    echo rand(0, 4);

if (isset($_GET['load']) && $_GET['load'] == "terrainSols")
    echo json_encode(utf8_encode($terrainSols));

if (isset($_GET['load']) && $_GET['load'] == "terrainDynamique")
    echo json_encode(utf8_encode($terrainDynamique));

if (isset($_POST['jsonObjDyn']))
    file_put_contents("./data/mapDynamique.json", json_encode($_POST['jsonObjDyn']));

if (isset($_POST['jsonObjSol']))
    file_put_contents("./data/mapSols.json", json_encode($_POST['jsonObjSol']));
?>
