<?php 
include 'head.php';
//TO DO: check username and email in-usage,  
$username = $fname = $lname = $pass = $confpass = $email = $confemail = $phno = $day = $mth = $year = $tnc = "";
$userErr = $fnameErr = $lnErr = $passErr = $confPassErr = $emailErr = $confEmailErr = $phnoErr = $DOBErr = $TnCErr = "";
$formVals = array($fname, $lname, $pass, $confpass, $email, $confemail, $phno, $day, $mth, $year, $tnc);
$errVals = array($userErr , $fnameErr , $lnErr , $passErr , $confPassErr , $emailErr , $confEmailErr , $phnoErr , $DOBErr, $TnCErr);
$postVals = array("Username", "First_Name", "Last_Name",  "Password", "Confirm_Password", "Email", "Confirm_Email", "Phone_Number", "DayB", "MthB", "YearB", "TNC");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	for($i = 0; $i < 8; $i++){
		if(empty($_POST[$postVals[$i]])){
			$errVals[$i] = "Please fill in this field.";
		}
		else{
			if($postVals[$i] == "Phone_Number"){
				if(!is_numeric($_POST[$postVals[$i]] )){
					$errVals[$i] = "Please input a numerical value.";
				}
			}
			if($postVals[$i] == "Password"){
				$pwlen = strlen(utf8_decode($_POST[$postVals[$i]]));
				if($_POST["Password"] != $_POST["Confirm_Password"]){
					$errVals[$i+1] = "Please ensure that these fields match.";
				}
				else if($pwlen < 6 || $pwlen > 20){
					$errVals[$i] = "Please ensure your password is between 6 and 20 characters.";
				}
				else if( !(preg_match('/\\d/', $_POST["Password"]))){
					$errVals[$i] = "Please ensure that your password has at least 1 numeric character.";
				}
			}
			if($postVals[$i] == "Email"){
				if($_POST["Email"] != $_POST["Confirm_Email"]){
					$errVals[$i+1] = "Please ensure these fields match.";
				}
			else if((!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL))){
					$errVals[$i+1] = "Please enter a valid email address.";
				}
			}
		}
	}
	if(empty($_POST["DayB"]) || empty($_POST["MthB"]) || empty($_POST["YearB"])){
		$errVals[8] = "Please input a valid date.";
	}
	else if($_POST["DayB"] > 31 || $_POST["MthB"] > 12 || $_POST["YearB"] > 2017){
		$errVals[8] = "Please check the validity of your Date of Birth.";
	}
	if(empty($_POST["TNC"])){
		$errVals[9] = "You must accept the Terms and Conditions to register.";
	}


function chckInp($val){
	$val = trim($val);
	$val = stripslashes($val);
	$val = htmlspecialchars($val);
	return $val;
}
$hasErrors = "false";
foreach($errVals as $errVal){
	if(!(empty($errVal))){
		$hasErrors = "true";
	}
}

if($hasErrors == "false"){
	$stmt = $db->prepare("INSERT INTO users(username, firstname, lastname, password, email, phno, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$dateStr = (chckInp($_POST["YearB"]).'-'.chckInp($_POST["MthB"]).'-'.chckInp($_POST["DayB"]));
	echo $dateStr;
	$stmt->execute(array(
		chckInp($_POST["Username"]),
		chckInp($_POST["First_Name"]),
		chckInp($_POST["Last_Name"]),
		md5(chckInp($_POST["Password"])),
		chckInp($_POST["Email"]),
		chckInp($_POST["Phone_Number"]),
		$dateStr
		));
$arr = $stmt->errorInfo();
print_r($arr);
}
}
?>
<link href="/proj230/CSS/registration.css" rel="stylesheet">
<div class="Title">
New User Registration<br>
<div class="Subtitle">
Please fill out the form below and press "submit" when ready.</div><br>
</div>
<div class="form"><form name="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<?php //Loop through form variables, and display them with full necessary formatting.
$values = array("Username", "First_Name", "Last_Name",  "Password", "Confirm_Password", "Email", "Confirm_Email", "Phone_Number");
$i = 0;
foreach($values as $value){
	echo '<div class="field">'.str_replace('_', ' ', $value).':';
	$inputType="text";
	if($value == "Password" || $value == "Confirm_Password"){
		$inputType= "password";
	}
	if($value=="Email" || $value == "Confirm_Email"){
		$inputType="email";
	}
	if($value=="Phone_Number"){
		$inputType="number";
	}
	echo '<input type="'.$inputType.'" value = "';
	if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST[$postVals[$i]]; };
	echo'" name="'.$value.'"><div class="errmsg">'.$errVals[$i].'</div>';
	$i++;
}
?>
<div class="tripleNumber">Date of Birth:
	<input type="number" name="YearB" placeholder="Year" 	value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["YearB"];}?>>
	<input type="number" class="date" placeholder ="Month" name="MthB" value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["MthB"];}?>>
	<input type="number" class="date" placeholder = "Day" name="DayB" value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["DayB"];}?>>
	<div class="errmsg"><?php echo $errVals[8]; ?></div>
</div>
<div class="field">I Have Read and Accept the Terms & Conditions: <input name="TNC" type="checkbox"><div class="errmsg"><?php echo $errVals[9]; ?></div>
<div class="field"><input type="submit" value="Register">