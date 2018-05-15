<?php
session_start();

if (isset($_SESSION['userinfo']))
    header('Location:./Laby.html');
else
    header("Location: http://classe2b.eyx.ch");
?>