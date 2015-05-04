<?php
    require("config.php");
    if(empty($_SESSION['user'])) 
    {
        header("Location: index.html");
        die("Redirecting to index.html"); 
    }
    if($_SESSION['username'] != "nimda")
    {
        header("Location: index.html");
        die("Redirecting to index.html");
    }
    if(isset($_GET['delete_id']))
    {
      	$query = "DELETE FROM users WHERE id = :id";
	$query_params = array(':id' => $_GET['delete_id']);
	try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
    }

$menu="home";
$nav="nav_admin.php";

$body="home_body.php";
include("view/template.php");
?>