<?php 
include 'head.php';
echo '<table>';
if(!($_SERVER["REQUEST_METHOD"]=="POST")){
        header("Location: /proj230/pages/search.php");
        exit();
    }
$searchType = $_POST["stype"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$name = '%'.$_POST["Name"].'%';
$suburb = '%'.$_POST["Suburb"].'%';
if($searchType == 'area'){
	$query = $db->prepare("SELECT *, (ABS(ABS(latitude)+?) + ABS(ABS(longitude)-?))*111 as 'Distance' FROM items ORDER BY Distance ASC LIMIT 50;");
	if($query->execute(array($lat,$lon))){
	echo '<tr><td>Park Name</td><td>Street Name</td><td>Suburb</td><td>Distance in Kilometers</td>';
    foreach($query->fetchAll() as $row) {
    echo '<tr><td>';
    echo $row['Name'];
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
	$query = $db->prepare("SELECT * FROM items WHERE Suburb LIKE ? AND Name Like ?");
	if($query->execute(array($suburb,$name))){
    foreach($query->fetchAll() as $row) {
    echo '<tr><td>';
    echo $row['Name'];
    echo '</td><td>';
    echo $row['Street'];
    echo '</td><td>';
    echo $row['suburb'];
    echo '</td></tr>';
}
}
}



echo '</table>';
?>