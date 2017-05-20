<?php 
	$parkCode = $_GET['park'];
?>
<link rel="stylesheet" href="/proj230/CSS/park.css" type="text/css">
<?php
include 'head.php';
include '/../Operations/maps.php';
include '/../Operations/database.php';
if ($park = $db->query('SELECT items.id, latitude, longitude, Name, Street, suburb, cast(avg(reviews.ReviewScore) as decimal(2,1)) as ReviewScore FROM items LEFT JOIN reviews on reviews.parkID = items.id WHERE parkCode = "'.$parkCode.'" GROUP BY id;')) {
	$row = $park->fetch(); 
?>
		<div class = "parkName">
			<?php
				echo (ucwords(strtolower($row["Name"])));
			?>
		</div><br>
		
		<div class = "parkDetails">
				<div id="mapdiv"></div>
				<div id="parkInfo">
				<script type="text/javascript" src="\proj230\JS\mapScripts.js"></script>
				<?php echo'<script> initmap(' . $row["latitude"] . ',' . $row["longitude"] . ',"'.ucwords(strtolower($row["Name"])).'")</script>'; ?>
				<h3><b>Location:</b> <?php echo (ucwords(strtolower($row["Street"])));?> ,<br> <?php echo (ucwords(strtolower($row["suburb"])));?> <h3><br>
				Average Rating of the Park:<br>
				<?php 
				if(!empty($row['ReviewScore'])){
					echo $row["ReviewScore"]; 
				}
				else{
					echo '--';
				}?><img src="/proj230/Images/goldstar2.png"></h3></h3></div><br>
		</div>
		<div class="reviews">
			<h1>User Reviews</h1>

<?php 
	
}
if(!(empty($_SESSION["Username"]))){
include 'reviewForm.php';
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		include '/../Operations/review.php';
		echo $_POST['Review'];
		review($parkCode, $_POST['star'], $_SESSION['Username'], $_POST['Review']);
	}
}
else{
	echo 'Please sign in to post reviews.<br>';
}

include 'reviews.php';

?>
