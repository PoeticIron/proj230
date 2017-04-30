
<head>
<script type="text/javascript" src="\proj230\JS\scripts.js"></script>
<link href="/proj230/CSS/sitewide.css" rel="stylesheet">
</head><!--//Standard header, with reference to the javascript file with scripts, and the CSS stylesheet.-->
<body>
<div class="content">
<div class="nav">
<a href="search.php">Search</a><a href="sresults.php">Results</a><a href="registration.php">Registration</a><a href="itemPage.html">Item</a>  
</div><div class="page"><!--//Standard Nav Bar, with links to other pages.-->
<?php
$db = new PDO('mysql:host=localhost;dbname=parks;charset=utf8mb4', 'root', 'password');
?>