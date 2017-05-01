<?php
include 'head.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	    $_SESSION["Username"] = '';
    	$_SESSION["FirstName"] = '';
    	$_SESSION["LastName"] = '';
    	header("Location: /proj230/pages/search.php");
		exit();
    }
    ?>