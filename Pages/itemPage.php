<?php
if (!isset($_GET["park"])){
    //If the user got to this page without a park value, they shouldn't be here. Send them back to the search page.
    header("Location: /proj230/pages/search.php");
    exit();
}
//Get the ParkCode supplied from the search results page, and include both Maps and Database code.
$parkCode = $_GET['park'];
include 'head.php';
include '/../Operations/maps.php';
include '/../Operations/database.php';
//Attempt to grab all of the relevant park's details as supplied from the parkCode. 
if ($park = $db->query('SELECT items.id, latitude, longitude, Name, Street, suburb, cast(avg(reviews.ReviewScore) as decimal(2,1)) as ReviewScore 
						FROM items LEFT JOIN reviews on reviews.parkID = items.id 
						WHERE parkCode = "'.$parkCode.'" 
						GROUP BY id;')) 
	{//Note that this is unclosed; if the SQL query is unsuccessful, nothing should be displayed - better than throwing lots of errors.
	$row = $park->fetch(); 
	
?>
<!-- Grab the page-specific CSS, and begin page layout -->
<link rel="stylesheet" href="/proj230/CSS/park.css" type="text/css">
		<div class = "parkName">
			<?php
			//Display the park's name from the SQL call.
				echo (ucwords(strtolower($row["Name"])));
			?>
		</div><br>
		
		<div class = "parkDetails">
			<!-- Map generation - call script, run initmap() with latitude and longitude specified.-->
				<div id="mapdiv"></div>
				<script type="text/javascript" src="\proj230\JS\mapScripts.js"></script>
				<?php //Display park details from the SQL query.
				echo'<script> initmap(' . $row["latitude"] . ',' . $row["longitude"] . ',"'.ucwords(strtolower($row["Name"])).'")</script>'; ?>
				<div id="parkInfo">
				<h3><b>Location:</b> <?php echo (ucwords(strtolower($row["Street"])));?> ,<br> <?php echo (ucwords(strtolower($row["suburb"])));?> <h3><br>
				Average Rating of the Park:<br>
				<?php 
				//If the park has a reviewScore, display it.
				if(!empty($row['ReviewScore'])){
					echo $row["ReviewScore"]; 
				}
				else{
					echo '--';
				}?><img src="/proj230/Images/goldstar2.png"></h3></h3></div><br>
		</div>
		<!-- Commence displaying reviews. -->
		<div class="reviews">
			<h1>User Reviews</h1>

<?php 
}
//Determine if the user has already reviewed this park.
$alreadyReviewed = false;
//If they are signed in:
if(isset($_SESSION['Username'])){
	//Query the database to find any reviews of this park by this user.
	$query = $db->prepare('SELECT * FROM reviews 
						   WHERE reviewer = ? AND parkID = 
						   (SELECT id FROM items WHERE parkCode = ?)');
	$query->execute(array($_SESSION["Username"], $parkCode));
	if(!empty($query->fetch())){
		//If there is a result returned, do not allow them to review here.
		$alreadyReviewed = true;
	}
}
if($alreadyReviewed){
	//Prevent the user from submitting another review.
	echo 'You have already reviewed this park.';
}
//Otherwise, If the user is not signed in, don't allow them to post reviews. Instead simply display a message.
else if(!(empty($_SESSION["Username"]))){
	//if they are signed in, include the review form and allow them to review the park.
	include 'reviewForm.php';
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		include '/../Operations/review.php';
		//run the review function with supplied values.
		review($parkCode, $_POST['star'], $_SESSION['Username'], $_POST['Review']);
	}
}
else{
	echo 'Please sign in to post reviews.<br>';
}
//Finally, display the reviews of the park.
include 'reviews.php';
?>
