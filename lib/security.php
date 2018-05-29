<?php
function isLogged()
{
    if (array_key_exists('logged', $_SESSION)) {
        return $_SESSION['logged'];
    }
}

