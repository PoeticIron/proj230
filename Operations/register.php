<?php
//Declare the variables needed for processing.
$username = $fname = $lname = $pass = $confpass = $email = $confemail = $phno = $day = $mth = $year = $tnc = "";
$formVals = array($fname, $lname, $pass, $confpass, $email, $confemail, $phno, $day, $mth, $year, $tnc);
$postVals = array("Username", "First_Name", "Last_Name",  "Password", "Confirm_Password", "Email", "Confirm_Email", "Phone_Number", "DayB", "MthB", "YearB", "TNC");
//Simple function to cleanup insert data.
function chckInp($val){
	$val = trim($val);
	$val = stripslashes($val);
	$val = htmlspecialchars($val);
	return $val;
}
//Function for registration:
function register(){
	//Get the database code, then:
	include 'database.php';
	//Hash-salt the password; the password_hash function includes the salt in the output.
	$hashstring = password_hash(chckInp($_POST["Password"]), PASSWORD_DEFAULT);
	//Prepare the statement.
	$stmt = $db->prepare("INSERT INTO users(username, firstname, lastname, password, email, phno, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
	//Format the date string into SQL-valid date format.
	$dateStr = (chckInp($_POST["YearB"]).'-'.chckInp($_POST["MthB"]).'-'.chckInp($_POST["DayB"]));
	//Execute the INSERT, with all the values checked and cleaned.
	$stmt->execute(array(
		chckInp($_POST["Username"]),
		chckInp($_POST["First_Name"]),
		chckInp($_POST["Last_Name"]),
		$hashstring,
		chckInp($_POST["Email"]),
		chckInp($_POST["Phone_Number"]),
		$dateStr
		));
	//If there is an error with duplicate Username values, show this.
	if(strpos($stmt->errorInfo()[2], "uplicate")){
		echo '<b><div class="errmsg">This username is already in use. Please try another. </div></b>';
	}
	//Otherwise, any other errors will throw a generic error message.
	else if(($stmt->errorInfo()[2])){
		echo '<b><div class="errmsg">There was an error processing your request. Please try again. </div></b>';
	}
	else{
		//If processing was successful, display a confirmation message.
		echo '<b><div class="confmsg">Your account was successfully created. Please login when ready. </div></b>';
	}
}
?>