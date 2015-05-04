<?php

require("config.php");
$query = "INSERT INTO register_requests (username, password, salt, email, callerid) VALUES (:username, :password, :salt, :email, :callerid)";
$query_params = array(
	':username' => abdullah,
	':password' => abdullah,
	':salt' => abdullah,
	':email' => abdullah,
	':callerid' => abdullah);
try {
$stmt = $db->prepare($query);
$result = $stmt->execute($query_params);
}
catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
?>