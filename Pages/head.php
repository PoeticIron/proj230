<?php
//Continue the current session.
session_start();
?>
<head>
<!-- All pages get the scripts.js and the sitewide CSS standard. -->
<script type="text/javascript" src="\proj230\JS\scripts.js"></script>
<link href="/proj230/CSS/sitewide.css" rel="stylesheet">
</head>
<body>
<!-- Also, all pages content is placed within the 'content' div. -->
<div class="content">

<!-- Standard sitewide Title bar and navbar. -->
<div class = "Header">
		<header>
		<h1>Proj230 Park Reviews</h1>
		</header>
</div>
<div class="nav">

<?php 
if(empty($_SESSION["Username"])){
	//If the user is not signed in, display the login form at the top of the page.
	echo'
	<form name="login" action="login.php" method="post">
	<input placeholder="Username" type="text" name="Username">
	<input placeholder="Password" type="password" name="Password">';
	//Post the current url of whatever page we're on right now as well.
	echo '<input type="hidden" value="'.$_SERVER['REQUEST_URI'].'"" name = "url">';
	echo '<input type="submit" value="Login"></form>';
}else{
	//Otherwise, show that they are logged in with a nice message, and display the logout button.
	echo '<form name="logout" action="logout.php" method="post">
	Welcome Back, '.$_SESSION["FirstName"].'
	<input type="submit" value="Sign Out"></form>';
}?>
<a href="search.php">Search for Parks</a><a href="DEBUG.php">DEBUG </a><a href="registration.php">Register An Account</a><a href="itemPage.php?park=D1061">View an Example Park</a>  
</div><div class="page"><!--//Standard Nav Bar, with links to other pages.-->

