<?php
include 'head.php';
include '/../Operations/database.php';
//Include the required files.
//If the user tried to login:
if($_SERVER["REQUEST_METHOD"]=="POST"){
	//Try to find their account with the provided username and password.
	$stmt = $db->prepare("SELECT Username, FirstName, LastName, password FROM users 
		WHERE username = ?");
	$stmt->execute(array($_POST["Username"]));
    $return = $stmt->fetch();
    	//Use the password_verify function with the salt-hash value of the stored 'password' field.
    	if(password_verify($_POST["Password"], $return["password"])){
    	//If the verification was successful, setup session variables.
    	$_SESSION["Username"] = $return[0];
    	$_SESSION["FirstName"] = $return[1];
    	$_SESSION["LastName"] = $return[2];
		header("Location: ".$_POST["url"]); 
		exit();
	}
	if(empty($row[0])){
		//otherwise, print an error message.
		echo "<b>No user was found with that username and password. <br> Please try logging in again.</b><br>";
		
	}
}?>
<!-- Login form posts back to here. -->
<form name="login" action="login.php" method="post">
<input placeholder="Username" type="text" name="Username"><br>
<input placeholder="Password" type="password" name="Password">
<input type="submit" value="Login">


<?php
//Include the sitewide footer.
include 'footer.php';
?>