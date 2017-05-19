<?php // USE SESSION_DESTROY() TO DELET THIS.
include 'head.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	    session_unset();
	    session_destroy();
    	header("Location: /proj230/pages/search.php");
		exit();
    }
    ?>
