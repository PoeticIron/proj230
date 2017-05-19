<?php
function review($parkCode, $score, $username, $review){
	echo $review;
	include 'database.php';
	$getIDstmt = $db->prepare("SELECT id FROM items WHERE parkCode = '".$parkCode."'");
	$getIDstmt->execute();
	$parkID = $getIDstmt->fetch();
	$stmt = $db->prepare("INSERT INTO reviews(parkID, reviewer, ReviewText, ReviewScore) VALUES (?, ?, ?, ?)");
	$stmt->execute(array($parkID['id'], $username, $review, $score));

}
function chckInp($val){
	$val = trim($val);
	$val = stripslashes($val);
	$val = htmlspecialchars($val);
	return $val;
}
?>