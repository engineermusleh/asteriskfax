<?php
    require("config.php");
    if(empty($_SESSION['username'])) 
    {
        header("Location: index.html");
        die("Redirecting to index.html"); 
    }
    if($_SESSION['username'] != "nimda")
    {
        header("Location: index.html");
        die("Redirecting to index.html");
    }
    if(isset($_GET['activate_id']))
    {
	$query1 = "SELECT * FROM register_requests WHERE id = :id";
        	$query1_params = array(':id' => $_GET['activate_id']);
	try {
	$stmt = $db->prepare($query1);
	$result = $stmt->execute($query1_params);
	}
	catch(PDOException $ex) { die("Failed to run query" . $ex->getMessage()); }
	$row = $stmt->fetch();
	//print_r($row);
	
	$query2 = "INSERT INTO users (name, username, password, salt, email, callerid) 		VALUES  (:name, :username, :password, :salt, :email, :callerid)";
	$query2_params = array(
	':name' => $row['name'],
	':username' => $row['username'],
	':password' => $row['password'],
	':salt' => $row['salt'],
	':email' => $row['email'],
	':callerid' => $row['callerid']);
	try {
	$stmt = $db->prepare($query2);
	$result = $stmt->execute($query2_params);
	}
	catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
	
	$query = "DELETE FROM register_requests WHERE id = :id";
	$query_params = array(':id' => $_GET['activate_id']);
	try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
	exec("/var/www/html/WebFax-qaq3ZMvoQR/notifyemail ".$row['email'] . " " . $row['name']);
	}
	catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
    }
    if(isset($_GET['reject_id']))
    {
	$query = "DELETE FROM register_requests WHERE id = :id";
	$query_params = array(':id' => $_GET['reject_id']);
	try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
    }
$menu="req_user";
$nav="nav_admin.php";

$body="user_requests_body.php";
include("view/template.php");
?>