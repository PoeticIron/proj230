<?php
//Get the database code.
include '/../Operations/database.php';
//Find the last 5 reviews for the park requested, and display these in separate 'review' divs, with their score, reviewer, and text.
$stmt = $db->prepare("SELECT ReviewScore, reviewer, ReviewText FROM reviews WHERE parkID IN
(SELECT id FROM items WHERE parkCode = '".$parkCode."') LIMIT 5;");
$stmt->execute();
foreach($stmt->fetchAll() as $row) {
		//Review Microdata included here.
		echo '<div class="review" itemscope itemtype="http://data-vocabulary.org/Review">';
		echo '<div hidden = true itemprop="itemreviewed">'.$parkName.'</div>';
		echo '<b> Reviewed By: <div itemprop="reviewer">'.$row['reviewer'].'</div></b>';
		echo '<div itemprop="description">'.$row["ReviewText"].'</div>';
		echo 'Review Score: <div itemprop = "rating">'.$row['ReviewScore'].'<img src="/proj230/Images/goldstar2.png"></div>';
		echo '</div>';
}



	
?>