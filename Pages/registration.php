<?php 
//include the standard navbar and the Registration code.
include 'head.php';
include '../Operations/register.php';
//declare the values needed for processing on this page.
$userErr = $fnameErr = $lnErr = $passErr = $confPassErr = $emailErr = $confEmailErr = $phnoErr = $DOBErr = $TnCErr = "";
$errVals = array($userErr , $fnameErr , $lnErr , $passErr , $confPassErr , $emailErr , $confEmailErr , $phnoErr , $DOBErr, $TnCErr);

//If the user has submitted a registration:
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//Loop through all of the posted Values (postVals) and scan them for errors.
	$postVals = array("Username", "First_Name", "Last_Name",  "Password", "Confirm_Password", "Email", "Confirm_Email", "Phone_Number", "DayB", "MthB", "YearB", "TNC");
	for($i = 0; $i < 8; $i++){
		if(empty($_POST[$postVals[$i]])){
			//If any of the fields are empty, throw an error.
			$errVals[$i] = "Please fill in this field.";
		}
		else{
			//If the phone number supplied is not a number, error.
			if($postVals[$i] == "Phone_Number"){
				if(!is_numeric($_POST[$postVals[$i]] )){
					$errVals[$i] = "Please input a numerical value.";
				}
			}
			if($postVals[$i] == "Username"){
				//If the username is > 16chars, error.
				$unlen = strlen(utf8_decode($_POST[$postVals[$i]]));
				if($unlen > 16){
					$errVals[$i] = "Your username must be less than 16 characters.";
				}
			}
			if($postVals[$i] == "Password"){
				//If the password is not the same as the Confirm Password field, is not in the correct length range, or has no numbers, error.
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
				//If the email doesn't match the Confirm field, or it's not a valid email, error.
				if($_POST["Email"] != $_POST["Confirm_Email"]){
					$errVals[$i+1] = "Please ensure these fields match.";
				}
			else if((!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL))){
					$errVals[$i+1] = "Please enter a valid email address.";
				}
			}
		}
	}
	//If any date field is empty, or if the numbers don't make sense for dates, error.
	if(empty($_POST["DayB"]) || empty($_POST["MthB"]) || empty($_POST["YearB"])){
		$errVals[8] = "Please input a valid date.";
	}
	else if($_POST["DayB"] > 31 || $_POST["MthB"] > 12 || $_POST["YearB"] > 2017){
		$errVals[8] = "Please check the validity of your Date of Birth.";
	}
	//Ensure the user selects the T&C box.
	if(empty($_POST["TNC"])){
		$errVals[9] = "You must accept the Terms and Conditions to register.";
	}
	//If there were *any* errors, hasErrors sets to True, and processing does not continue.
	$hasErrors = "false";
	foreach($errVals as $errVal){
		if(!(empty($errVal))){
			$hasErrors = "true";
		}
	}
	//If there were no errors, attempt to register the user.
	if($hasErrors == "false"){
		register();
	}
}?>
<!-- Grab the page-specific CSS, and begin page layout -->
<link href="/proj230/CSS/registration.css" rel="stylesheet">
<div class="Title">
New User Registration<br>
<div class="Subtitle">
Please fill out the form below and press "submit" when ready.</div><br>
</div>
<!-- declare the form, and have it post back to this page; also prevent XSS -->
<div class="form"><form name="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<?php //Loop through form variables, and display them with full necessary formatting. This includes specific input types, and creating an Error Message div for each.
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
	echo'" name="'.$value.'"><div class="errmsg">'.$errVals[$i].'</div></div>';
	$i++;
}
?>
<!-- these fields could not be included in the loop, so declare them here. PHP code is for displaying errors, and replacing values after a POST attempt.-->
<div class="field">
<div class="tripleNumber">Date of Birth:
	<input type="number" name="YearB" placeholder="Year" 	value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["YearB"];}?>>
	<input type="number" class="date" placeholder ="Month" name="MthB" value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["MthB"];}?>>
	<input type="number" class="date" placeholder = "Day" name="DayB" value=<?php if($_SERVER["REQUEST_METHOD"]=="POST"){echo $_POST["DayB"];}?>>
	<div class="errmsg"><?php echo $errVals[8]; ?></div>
</div></div>
<div class="field">I Have Read and Accept the Terms and Conditions<input name="TNC" type="checkbox"><div class="errmsg"><?php echo $errVals[9]; ?></div></div>
<div class="field"><input type="submit" value="Register"></div></form></div>
<?php
//Include the sitewide footer.
include 'footer.php';
?>