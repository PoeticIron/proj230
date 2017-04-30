<?php 
include 'head.php';
echo '<form method=\'post\' action=\'sresults.php\' id="searchform">';
echo '<input type="text" name="Name">';
echo '<input type="hidden" name="lat"id="lat"><input type="hidden" id="lon"name="lon"><input type="hidden" id="stype" name="stype">';
echo '<select name="Suburb" form="searchform">';
$query = $db->prepare("SELECT DISTINCT suburb FROM items ORDER BY suburb ASC;");
if($query->execute()){
    foreach($query->fetchAll() as $row) {
    	   echo '<option value ='.$row['suburb'].'>'.$row['suburb'].'</option>';
}
}
echo '<input type="submit" value="Search By Name and Suburb" onclick="document.getElementById(\'stype\').value=\'specific\'"><br>';

?>
</select>
				<button type="button" onclick="getLocation();">Find My Location </button>
				<input type='submit' onclick="document.getElementById('stype').value='area'" value="Use My Location">
				<div id="mapInfo"></div><br><div id="mapholder"></div>
</div>