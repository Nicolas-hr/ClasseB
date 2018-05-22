<?php
require_once '../lib/security.php';

$titre = filter_input( INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
$description = filter_input( INPUT_POST, 'description', FILTER_SANITIZE_STRING);

