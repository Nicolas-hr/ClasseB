<?php
function isLogged() {
    return isset($_SESSION['logged']) && $_SESSION['logged'] == "connected";
//    return true;
}