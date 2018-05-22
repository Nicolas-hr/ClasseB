<?php

function dbConnect()
{
    $servername = "127.0.0.1";
    $username = "root";

    $db = new PDO("mysql:host=$servername;dbname=classe2b", $username);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}
