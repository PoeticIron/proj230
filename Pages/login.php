<?php
include 'head.php';
include '/../Operations/database.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$stmt = $db->prepare("SELECT Username, FirstName, LastName, password FROM users 
		WHERE username = ?");
	$stmt->execute(array($_POST["Username"]));
    $return = $stmt->fetch();
    	if(password_verify($_POST["Password"], $return["password"])){
    		print_r( $db->errorInfo());
    	$_SESSION["Username"] = $return[0];
    	$_SESSION["FirstName"] = $return[1];
    	$_SESSION["LastName"] = $return[2];
		header("Location: /proj230/pages/search.php"); 
		exit();
	}
	if(empty($row[0])){
		echo "<b>No user was found with that username and password. <br> Please try logging in again.</b><br>";
		echo'
			<form name="login" action="login.php" method="post">
	<input placeholder="Username" type="text" name="Username"><br>
	<input placeholder="Password" type="password" name="Password">
	<input type="submit" value="Login">';
	}
}



?>