<?php
require_once '../lib/security.php';

$titre = filter_input( INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING);

if (!$titre || !$description || strlen($titre) < 2 || strlen($descriptio) < 5 ) {
  errorAddNews($titre, $description);
  include 'signupForm.php';
}else {
  addNews($titre, $description);
  header('Location: ../php/showNews.php');
  exit;
}