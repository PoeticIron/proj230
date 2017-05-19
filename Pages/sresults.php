<?php 
include 'head.php';

include '/../Operations/database.php';

echo '<div class="results-table">';
echo '<table class="results-table">';
if(!($_SERVER["REQUEST_METHOD"]=="POST")){
        header("Location: /proj230/pages/search.php");
        exit();
    }
$searchType = $_POST["stype"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$name = '%'.$_POST["Name"].'%';
$suburb = '%'.$_POST["Suburb"].'%';
?>
<link rel="stylesheet" href="/proj230/CSS/results.css" type="text/css">
<?php
if($searchType == 'area'){
	$query = $db->prepare("SELECT DISTINCT(parkCode), Street, Name, suburb, id, (ABS(ABS(latitude)+?) + ABS(ABS(longitude)-?))*111 as 'Distance' FROM items ORDER BY Distance ASC LIMIT 50;");
	if($query->execute(array($lat,$lon))){
	echo '<tr class="head"><td>Park Name</td><td>Street Name</td><td>Suburb</td><td>Distance in Kilometers</td>';
    foreach($query->fetchAll() as $row) {
    echo '<tr><td>';
    echo "<a href='itemPage.php?park=".$row['parkCode']."'>".$row['Name']."</a>";
    echo '</td><td>';
    echo $row['Street'];
    echo '</td><td>';
    echo $row['suburb'];
    echo '</td><td>';
    echo round($row['Distance'], 4);
    echo '</td></tr>';
}
}
}
if($searchType == 'specific'){
	$query = $db->prepare('SELECT items.parkCode, avg(reviews.ReviewScore) as score, suburb, Street, Name FROM items join reviews On reviews.parkID = items.id WHERE items.suburb LIKE "%%" AND items.Name LIKE "%%" GROUP BY id;');
	if($query->execute(array($suburb,$name))){
    foreach($query->fetchAll() as $row) {
    echo '<tr><td>';
    echo "<a href='itemPage.php?park=".$row['parkCode']."'>".$row['Name']."</a>";
    echo '</td><td>';
    echo $row['Street'];
    echo '</td><td>';
    echo $row['score'];
    echo '</td><td>';
    echo $row['suburb'];
    echo '</td></tr>';
}
}
}



echo '</table>';
?>
