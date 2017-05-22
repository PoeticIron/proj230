<?php 
include 'head.php';
include '/../Operations/maps.php';
include '/../Operations/database.php';
//Include the standard nav bar etc, as well as the database code.
?>
<link rel="stylesheet" href="/proj230/CSS/search.css" type="text/css">
<script type="text/javascript" src="\proj230\JS\mapScripts.js"></script>
<div class="Title">
Search The Park Database<br></div>
<!-- Fetch the CSS specific to this page. -->
<form method='post' action='sresults.php' id="searchform">
<div class="searchType"> <div class="title">Search By Name and Suburb, Or... </div><br>
<!-- Create the form for searching, then create the first searchType subdivision for Name and Suburb searches. -->
<input type="text" placeholder="Enter a Park Name" name="Name">
<input type="hidden" name="lat"id="lat"><input type="hidden" id="lon"name="lon"><input type="hidden" id="stype" name="stype">
<!-- Hidden inputs allow passing values not manually entered to the search results page. -->
<select name="Suburb" form="searchform">
<?php
//This query grabs each suburb from the full list of parks, and displays them in the Select box.
$query = $db->prepare("SELECT DISTINCT suburb FROM items ORDER BY suburb ASC;"); 
if($query->execute()){
	//These two are the default/any values which allow ignoring the Suburb section entirely.
	echo '<option value = "%%">Select a Suburb </option>';
	echo '<option value = "%%">Any Suburbs</option>';
	//Display all suburbs.
    foreach($query->fetchAll() as $row) {
    	   echo '<option value ='.$row['suburb'].'>'.$row['suburb'].'</option>';
	}
}
?>
</select>
<!-- the 'submit' button here also changes the searchtype (stype) value to 'specific' before passing to the Sresults page to tell that page what search type the user selected. -->
<input type="submit" value="Search By Name and Suburb" onclick="document.getElementById('stype').value='specific'"><br>
</div>
<!-- the second 'searchType' is location-based. Declare and create it here. -->
<div class="searchType"> <div class="title">Search By Location </div><br>
<!-- User must 'get location' before they can use it for a search. -->
<button type="button" onclick="getLocation();">Find My Location </button>
<!-- Button here is hidden until location is found. On select, it changes the searchType value to 'area' for the results page. -->
<input type='submit' id='locationSubmit' hidden='true' onclick="document.getElementById('stype').value='area'" value="Use My Location">
<div id="mapInfo"></div><br><div id="mapdiv" hidden='true'></div>
</div>
<!-- Not a separate 'type' of search, the filter here by default does nothing (parks can't have less than 1 score, and non-reviewed parks are included default) -->
<div class="searchType"> <div class="title">Filter By Review Score </div><br>
<!-- this allows for filtering of minimum score, which is passed to the sresults page.-->
Only Include Parks with a Reviewer's Score of at Least:
<select name="minScore" form="searchform">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>	
	<option value="5">5</option>
	</select>
	<br> Include non-reviewed parks: 
	<!-- simple boolean to select or deselect non-reviewed (null score) parks.-->
	<input type="checkbox" name="nonRev" checked="true">
	<?php
//Include the sitewide footer.
include 'footer.php';
?>