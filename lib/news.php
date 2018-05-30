<?php
require_once 'dbConnect.php';
require_once 'userId.php';

function addNews($titre, $description)
{
    $userId = getUserId();
    $db = dbConnect();

    $req = $db->prepare('INSERT INTO tbl_news(Nm_New, Txt_Content_News, Id_User) VALUES(:titre, :description, :userId)');

    $req->execute(array(
        'titre' => $titre,
        'description' => $description,
        'userId' => $userId
    ));

    header('Location: ../php/showNews.php');
    exit;
}

function errorAddNews()
{
    define("SUCCESS", 1);
    define("EMPTY_TITLE", 2);
    define("EMPTY_DESCRIPTION", 3);
    define("TITLE_TOO_SHORT", 4);
    define("DESCRIPTION_TOO_SHORT", 5);

    $errorNews = -1;
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);

    if ($titre != null) {
        // Du texte à été mis dans le champs titre
        if ($description != null) {
            // Du texte à été mis dans le champs description
            if (strlen($titre) >= 2) {
                // Le titre fais 2 caractère au minimum
                if (strlen($description) >= 5) {
                    // La description fait 5 caractères minimum
                    // Les champs ont bien été remplis
                } else {
                    $errorNews = DESCRIPTION_TOO_SHORT;
                }
            } else {
                $errorNews = TITLE_TOO_SHORT;
            }
        } else {
            $errorNews = EMPTY_DESCRIPTION;
        }
    } else {
        $errorNews = EMPTY_TITLE;
    }

    if ($errorNews == -1) {
        addNews($titre, $description);
    } else {
        header("Location: ../php/newsForm.php?errorNews=" . $errorNews);
        exit;
    }
}

function showNews()
{
    $db = dbConnect();

    echo '
    <div class="card mb-3 mt-3">
        <div class="card-body">';

    try {
        foreach ($db->query('SELECT Nm_New, Txt_Content_News FROM tbl_news') as $row) {
            echo "<h5>" . $row['Nm_New'] . "</h5> <p>" . $row['Txt_Content_News'] . "</p>";
        }

    } catch (PDOException $ex) {
        echo 'An Error occured!'; // user friendly message
        error_log($ex->getMessage());
    }

    echo '
        </div>
    </div>';
}

if (filter_input(INPUT_POST, 'addAnnonce')) {
    errorAddNews();
}