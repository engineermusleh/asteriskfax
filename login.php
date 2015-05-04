<?php
require("config.php");
$submitted_username = '';
$_username = $_SESSION['username'];
$_password = $_SESSION['password'];
if(!empty($_POST)) {
	$query = "SELECT id, username, password, salt, email, callerid FROM users WHERE username = :username";
    $query_params = array(':username' => $_POST['username']);
try {
	$stmt = $db->prepare($query);
	$result = $stmt->execute($query_params);
}

catch(PDOException $ex) {
    die("Failed to run query: " . $ex->getMessage());
}
$login_ok = false;
$row = array();
$row = $stmt->fetch();
if($row){
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++){
                $check_password = hash('sha256', $check_password . $row['salt']);
            } 
            if($check_password === $row['password']){
                $login_ok = true;
            } 
            if($login_ok){
            unset($row['salt']); 
            unset($row['password']); 
            $_SESSION['username'] = $row['username'];
	    $_SESSION['callerid'] = $row['callerid'];
            $_SESSION['user'] = $row;
	    $_SESSION['email'] = $row['email'];
            if ($_SESSION['username'] === "nimda") {
                header("Location: registration_request.php");
                die("Redirecting to: registration_request.php");
            } else {
                    header("Location: sendfax.php");
                    die("Redirecting to: sendfax.php");
            }
     } else{
                header("Location: success.php?message=wrong_credential");
            }
        }
    else {
        header("Location: success.php?message=unregistered_user");
    }
} else {
    header("Location: success.php?message=wrong_credential");
}
?>
