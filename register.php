<?php

require("config.php");

if(empty($_POST['username']))
{ die("Please enter a Username."); }
if(empty($_POST['password']))
{ die("Please enter a Password."); }
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
{ die("Invalid E-Mail Address"); } 

//Check if the username has already been taken
$query = "SELECT 1 FROM users WHERE username = :username";
$query_params = array(':username' => $_POST['username']);
try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
}
catch(PDOException $ex) { die("Failed to run query" . $ex->getMessage()); }
$row = $stmt->fetch();
if($row) { die("This email Id is already registered."); }

//Add row to Database
$query = "INSERT INTO register_requests (name, username, password, salt, email, callerid,fax_header) VALUES
        (:name, :username, :password, :salt, :email, :callerid,:fax_header)";

//Security measures
$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
$password = hash('sha256', $_POST['password'] . $salt);
for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
$fax_header="";
if($_POST['fax_header']!="") {
    $fax_header=$_POST['fax_header'];
}
$query_params = array(
	':name' => $_POST['name'],
	':username' => $_POST['username'],
	':password' => $password,
	':salt' => $salt,
	':email' => $_POST['email'],
	':callerid' => $_POST['callerid'],
    ':fax_header'=>$fax_header,
    );
try {
$stmt = $db->prepare($query);
$result = $stmt->execute($query_params);
}
catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
if ($_SESSION['username'] == 'nimda')
{
header("Location: nimda.php");
die("Redirecting to nimda.php");
}
else {
header("Location: success.php?message=reg_success");
die("Redirecting to index.php");
}

?>
