<?php
	$park = D0228;
	$name = $db->prepare("SELECT Name FROM items WHERE parkCode = "$park);
	$street = $db->prepare("SELECT Street FROM items WHERE parkCode = "$park);
	$suburb = $db->prepare("SELECT Suburb FROM items WHERE parkCode = "$park);
	$longitude = $db->prepare("SELECT Longitude FROM items WHERE parkCode = "$park);
	$latitude = $db->prepare("SELECT Latitude FROM items WHERE parkCode = "$park);
?>

<html>
<?php include 'head.php';
?>

<?php
echo '<body onload="showPosition('.$latitude.','.$longitude.')">'
?>
		<div class="page">
		<div class = "parkName">
			<?php
				echo $name;
			?>
		</div>
		
		<div class = "parkStuff">
			<nav>
				<div id="mapholder"></div>
			</nav>
			<article>
				<h3><b>Location:</b> <?php echo $street; ?> ,<br> <?php echo $Suburb; ?><h3><br>
				average rating of the park:<br>
					2 <img src="goldstar.png">
			</article>
		</div>
</html>