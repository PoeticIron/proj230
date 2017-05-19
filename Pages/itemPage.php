<?php 
	$parkCode = $_GET['park'];
?>
<link rel="stylesheet" href="/proj230/CSS/park.css" type="text/css">
<?php
include 'head.php';
include '/../Operations/database.php';
if ($park = $db->query("SELECT * FROM items WHERE parkCode = '".$parkCode."'")) {
	$row = $park->fetch(); 
echo '<body onload="showPosition(' . $row["latitude"] . ',' . $row["longitude"] . ')">'
?>
		<div class = "parkName">
			<?php
				echo $row["Name"];
			?>
		</div>
		
		<div class = "parkStuff">
			<nav>
				<div id="mapholder"></div>
			</nav>
			<article>
				<h3><b>Location:</b> <?php echo $row["Street"];?> ,<br> <?php echo $row["suburb"];?> <h3><br>
				Average rating of the park:<br>
					2 <img src="/proj230/Images/goldstar2.png">
			</article>
		</div>
<?php 
	
}
if(!(empty($_SESSION["Username"]))){
include 'reviews.php';
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		include '/../Operations/review.php';
		echo $_POST['Review'];
		review($parkCode, $_POST['star'], $_SESSION['Username'], $_POST['Review']);
	}
}
else{
	echo 'Please sign in to post reviews.';
}
?>
