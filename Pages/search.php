<?php 
include 'head.php';
include '/../Operations/database.php';
?>
<link rel="stylesheet" href="/proj230/CSS/search.css" type="text/css">
<form method='post' action='sresults.php' id="searchform">
<div class="searchType"> <div class="title">Search By Name and Suburb, Or... </div><br>

<input type="text" name="Name">
<input type="hidden" name="lat"id="lat"><input type="hidden" id="lon"name="lon"><input type="hidden" id="stype" name="stype">

<select name="Suburb" form="searchform">
<?php
$query = $db->prepare("SELECT DISTINCT suburb FROM items ORDER BY suburb ASC;"); //Fetch all suburbs from the database and display them in a SELECT box.
if($query->execute()){
	echo '<option value = "%%">Select a Suburb </option>';
	echo '<option value = "%%">Any Suburbs</option>';

    foreach($query->fetchAll() as $row) {
    	   echo '<option value ='.$row['suburb'].'>'.$row['suburb'].'</option>';
	}
}
?>
</select>
<input type="submit" value="Search By Name and Suburb" onclick="document.getElementById('stype').value='specific'"><br>
</div>
<div class="searchType"> <div class="title">Search By Location </div><br>
<button type="button" onclick="getLocation();">Find My Location </button>
<input type='submit' onclick="document.getElementById('stype').value='area'" value="Use My Location">
<div id="mapInfo"></div><br><div id="mapholder"></div>
</div>
<div class="searchType"> <div class="title">Filter By Review Score </div><br>
Only Include Parks with a Reviewer's Score of at Least:
<select name="minScore" form="searchform">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>	
	<option value="5">5</option>
	</select>
	<br> Include non-reviewed parks: 
	<input type="checkbox" name="nonRev" checked="true">