<?php
    require("config.php");
    if(empty($_SESSION['username'])) 
    {
        header("Location: index.php");
        die("Redirecting to index.html"); 
    }

    $menu="";
    $nav="nav_home.php";
    $body="sendfax_body.php";
    include("view/template.php");
?>