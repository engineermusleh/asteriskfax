<?php
include("config.php");
$menu="";
$nav="nav_home.php";
$body="success_body.php";

$msg=$_GET["message"];
include("view/template.php");

header('Refresh: 10;url=index.php');
?>
