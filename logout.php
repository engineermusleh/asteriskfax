<?php 
    require("config.php");

    unset($_SESSION['username']);
    unset($_SESSION['user']);
    header("Location: index.php");
    die("Redirecting to: index.php");
?>