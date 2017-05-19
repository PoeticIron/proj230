<?php
$username = $fname = $lname = $pass = $confpass = $email = $confemail = $phno = $day = $mth = $year = $tnc = "";
$formVals = array($fname, $lname, $pass, $confpass, $email, $confemail, $phno, $day, $mth, $year, $tnc);
$postVals = array("Username", "First_Name", "Last_Name",  "Password", "Confirm_Password", "Email", "Confirm_Email", "Phone_Number", "DayB", "MthB", "YearB", "TNC");
function chckInp($val){
	$val = trim($val);
	$val = stripslashes($val);
	$val = htmlspecialchars($val);
	return $val;
}
function register(){
	include 'database.php';
	$hashstring = password_hash(chckInp($_POST["Password"]), PASSWORD_DEFAULT);
	$stmt = $db->prepare("INSERT INTO users(username, firstname, lastname, password, email, phno, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$dateStr = (chckInp($_POST["YearB"]).'-'.chckInp($_POST["MthB"]).'-'.chckInp($_POST["DayB"]));
	$stmt->execute(array(
		chckInp($_POST["Username"]),
		chckInp($_POST["First_Name"]),
		chckInp($_POST["Last_Name"]),
		$hashstring,
		chckInp($_POST["Email"]),
		chckInp($_POST["Phone_Number"]),
		$dateStr
		));
$arr = $stmt->errorInfo();
}
?>