<?php 
//Basic logout 'page' - doesn't actually contain any page displays. Just unsets the Session and redirects back to search page.
include 'head.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	    session_unset();
	    session_destroy();
    	header("Location: /proj230/pages/search.php");
		exit();
    }
    ?>
