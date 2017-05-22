<?php
//Simple function to insert the review provided.
function review($parkCode, $score, $username, $review){
	echo $review;
	include 'database.php';
	//Need to get the *actually unique* ID from the items table, from the ParkCode.
	$getIDstmt = $db->prepare("SELECT id FROM items WHERE parkCode = '".$parkCode."'");
	$getIDstmt->execute();
	$parkID = $getIDstmt->fetch();
	//Once we have the ID, insert the data provided into the table.
	$stmt = $db->prepare("INSERT INTO reviews(parkID, reviewer, ReviewText, ReviewScore) VALUES (?, ?, ?, ?)");
	$stmt->execute(array($parkID['id'], chckInp($username), chckInp($review), $score));
}
//Simple function to clean up inserted data.
function chckInp($val){
	$val = trim($val);
	$val = stripslashes($val);
	$val = htmlspecialchars($val);
	return $val;
}
?>