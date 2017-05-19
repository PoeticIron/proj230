<?php
	$parkCode = $_GET['park'];
?>

<html>
<?php 
include 'head.php';
include '/../Operations/database.php';

?>


<?php
if ($park = $db->query("SELECT * FROM items WHERE parkCode = '".$parkCode."'")) {
	$row = $park->fetch(); 
echo '<body onload="showPosition(' . $row["latitude"] . ',' . $row["longitude"] . ')">'
?>
		<div class="page">
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
				average rating of the park:<br>
					2 <img src="goldstar.png">
			</article>
		</div>
<?php 
	
}
include 'reviews.php';

?>
</html>
