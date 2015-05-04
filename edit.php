<?php

require("config.php");

if(!isset($_SESSION['user'])) {
header("Location: index.html");
die("Redirecting to index.html");
}

//print_r($_POST);
//Security measures
$changePass=false;
if(!empty($_POST['password'])) {
    $query = "SELECT salt FROM users WHERE id= :id";
    $query_params=array(':id'=>$_SESSION['temp_id']);
    $stmt = $db->prepare($query);
    $result = $stmt->execute($query_params);
    $row = $stmt->fetch();

    $salt = $row["salt"];
    $password = hash('sha256', $_POST['password'] . $salt);
    for($round = 0; $round < 65536; $round++){
        $password = hash('sha256', $password . $salt);
    }
    $changePass=true;
}


if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['callerid']))
{
	$query = "UPDATE users SET name = :name, username = :username, email = :email, callerid = :callerid,fax_header = :fax_header WHERE id= :id";
	if($changePass) {
        $query = "UPDATE users SET name = :name, username = :username, email = :email, callerid = :callerid ,fax_header = :fax_header, password = :password WHERE id= :id";
    }
    $query_params = array(
	':id' => $_SESSION['temp_id'],
	':name' => $_POST['name'],
	':username' => $_POST['username'],
	':email' => $_POST['email'],
	':callerid' => $_POST['callerid'],
    ':fax_header'=>$_POST['fax_header']
	);
    if($changePass) {
        $query_params[':password']=$password;
    }

	try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
	}
	catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); }
	
	header("Location: nimda.php");
}
else {
echo "Empty fields are not allowed";
}

?>
