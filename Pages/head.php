<?php
session_start();
?>
<head>
<script type="text/javascript" src="\proj230\JS\scripts.js"></script>
<link href="/proj230/CSS/sitewide.css" rel="stylesheet">
</head><!--//Standard header, with reference to the javascript file with scripts, and the CSS stylesheet.-->
<body>
<div class="content">
<<<<<<< HEAD
<?php 
if(empty($_SESSION["Username"])){
	echo'<div class="nav"><div class="login">
	<form name="login" action="login.php" method="post">
	<input placeholder="Username" type="text" name="Username">
	<input placeholder="Password" type="password" name="Password">
	<input type="submit" value="Login"></form></div>';
}else{
	echo '<div class="nav"><div class="login"><form name="logout" action="logout.php" method="post">
	Welcome Back, '.$_SESSION["FirstName"].'
	<input type="submit" value="Sign Out"></form></div>';
}?>
=======
<div class = "Header">
		<header>
		<h1>JimmyBots Park Reviews</h1>
		</header>
</div>
<div class="nav">
>>>>>>> origin/master
<a href="search.php">Search</a><a href="sresults.php">Results</a><a href="registration.php">Registration</a><a href="itemPage.html">Item</a>  
</div><div class="page"><!--//Standard Nav Bar, with links to other pages.-->
<?php
$db = new PDO('mysql:host=localhost;dbname=parks;charset=utf8mb4', 'root', 'password');
?>
