<?php
    require("config.php");
    if(empty($_SESSION['username'])) {
        header("Location: index.html");
        die("Redirecting to index.html"); 
    }

$menu="add_user";
$nav="nav_admin.php";

$body="add_user_body.php";
include("view/template.php");
?>