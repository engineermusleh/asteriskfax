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

    if(isset($_GET['edit_id']))
    {
	$query = "SELECT name, username, email, callerid,fax_header FROM users WHERE id = :id";
	$query_params = array(':id' => $_GET['edit_id']);
        try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
	$row = $stmt->fetch();
        }
        catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
    }
    $_SESSION['temp_id'] = $_GET['edit_id'];

$menu="edit_user";
$nav="nav_admin.php";

$body="edit_user_body.php";
include("view/template.php");
?>