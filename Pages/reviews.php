<?php
include '/../Operations/database.php';
$stmt = $db->prepare("SELECT ReviewScore, reviewer, ReviewText FROM reviews WHERE parkID IN
(SELECT id FROM items WHERE parkCode = '".$parkCode."') LIMIT 5;");
$stmt->execute();
foreach($stmt->fetchAll() as $row) {
		echo '<div class="review">';
		echo '<b> Reviewed By: '.$row['reviewer'].'</b><br>';
		echo $row["ReviewText"];
		echo '<br>Review Score: '.$row['ReviewScore'].'<img src="/proj230/Images/goldstar2.png">';
		echo '</div>';
}



	
?>