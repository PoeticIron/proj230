<?php
include 'head.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$stmt = $db->prepare("SELECT username, firstname, lastname FROM users 
		WHERE username = ? AND password = ?");
if($stmt->execute(array($_POST["Username"], md5($_POST["Password"])))){
    foreach($stmt->fetchAll() as $row) {
    	$_SESSION["Username"] = $row[0];
    	$_SESSION["FirstName"] = $row[1];
    	$_SESSION["LastName"] = $row[2];
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

}

?>