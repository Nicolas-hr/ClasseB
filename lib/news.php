<?php
require_once '../lib/security.php';

$titre = filter_input( INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING);

if (!$titre || !$description || strlen($titre) < 2 || strlen($description) < 5 ) {
  errorAddNews($titre, $description);
  include '../php/newsForm.php';
}else {
  addNews($titre, $description);
  header('Location: ../php/showNews.php');
  exit;
}