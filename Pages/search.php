<?php 
include 'head.php';
include '/../Operations/database.php';
?>
<form method='post' action='sresults.php' id="searchform">
<input type="text" name="Name">
<input type="hidden" name="lat"id="lat"><input type="hidden" id="lon"name="lon"><input type="hidden" id="stype" name="stype">
<select name="Suburb" form="searchform">
<?php
$query = $db->prepare("SELECT DISTINCT suburb FROM items ORDER BY suburb ASC;"); //Fetch all suburbs from the database and display them in a SELECT box.
if($query->execute()){
    foreach($query->fetchAll() as $row) {
    	   echo '<option value ='.$row['suburb'].'>'.$row['suburb'].'</option>';
	}
}
?>
</select>
<input type="submit" value="Search By Name and Suburb" onclick="document.getElementById('stype').value='specific'"><br>
<button type="button" onclick="getLocation();">Find My Location </button>
<input type='submit' onclick="document.getElementById('stype').value='area'" value="Use My Location">
<div id="mapInfo"></div><br><div id="mapholder"></div>
</div>