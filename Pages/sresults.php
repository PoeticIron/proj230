<?php 
include 'head.php';
include '/../Operations/maps.php';
include '/../Operations/database.php';
//include all necessary files, and the standard navbar etc. 
echo '<div class="results-table">';
echo '<table class="results-table">';
//Commence table construction
if(!($_SERVER["REQUEST_METHOD"]=="POST")){
    //If the user got to this page without a POST request, they shouldn't be here. Send them back to the search page.
        header("Location: /proj230/pages/search.php");
        exit();
    }
//Declare all the form values from the search page. Some are surrounded with % for LIKE-querying.
$searchType = $_POST["stype"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$name = '%'.$_POST["Name"].'%';
$suburb = '%'.$_POST["Suburb"].'%';
$minScore = $_POST["minScore"];
$IncludeNoReview = isset($_POST["nonRev"]);
$zoom = 14;
?>
<link rel="stylesheet" href="/proj230/CSS/results.css" type="text/css">
<div class="Title">
Your Search Results<br></div>
<?php
//Perform Area-based search
if($searchType == 'area'){
    //Set value for whether or not the user wants null-score parks. Will be injected into SQL query.
    $notNull = "IS NULL";
    if(!$IncludeNoReview){
        $notNull = "IS NOT NULL";
    }
    //Declare and format the SQL query, with the $notNull value inserted.
    $queryString = "SELECT DISTINCT(parkCode), latitude, longitude, Street, Name, suburb, id, 
        cast(avg(reviews.ReviewScore) as decimal(2,1)) as score, (ABS(ABS(latitude)+?) + ABS(ABS(longitude)-?))*111 as 'Distance' 
        FROM items LEFT JOIN reviews ON items.id = reviews.parkID 
        GROUP BY items.id 
        HAVING(avg(reviews.ReviewScore) >= ?) OR (avg(reviews.ReviewScore) ".$notNull.")
        ORDER BY Distance ASC LIMIT 50;";
    //Prepare the query, then execute it with the latitude, longitude and minScore values supplied by search form.
	$query = $db->prepare($queryString);
	if($query->execute(array($lat,$lon, $minScore))){
        //If it executes successfully, Display a table.
	echo '<tr class="head"><td>Park Name</td><td>Street Name</td><td>Suburb</td><td>Distance in Kilometers</td><td>Score</td>';
    ?>
        <!-- Map generation - call script, run initmap() with latitude and longitude specified.-->
        <div id="mapdiv"></div><br>
        <script type="text/javascript" src="\proj230\JS\mapScripts.js"></script>
        <?php echo'<script> initSearchMap(' . $lat . ',' . $lon .','.$zoom.')</script>'; 
        //For each result found, add a marker to the map with the coordinates and Name specified (this script also adds links to markers). Then, add the values to the table.
    foreach($query->fetchAll() as $row) {
    echo'<script> addMarker(' . $row['latitude'] . ',' . $row['longitude'] .',"'. ucwords(strtolower($row['Name'])) . '","' .$row["parkCode"].'")</script>'; 
    echo '<tr><td>';
    echo "<a href='itemPage.php?park=".$row['parkCode']."'>".ucfirst(strtolower($row['Name']))."</a>";
    echo '</td><td>';
    echo ucfirst(strtolower($row['Street']));
    echo '</td><td>';
    echo ucfirst(strtolower($row['suburb']));
    echo '</td><td>';
    echo round($row['Distance'], 4);
    echo '</td><td><b>';
    //If the result has no score, place -- where score should be. Otherwise, place its score to 1 decimal place.
    if(empty($row['score'])){
    echo '--&nbsp&nbsp&nbsp<img src="/proj230/Images/goldstar2.png">';
    }
    else{
    echo $row['score'].'<img src="/proj230/Images/goldstar2.png">';
}
    echo '</b></td></tr>';

}
}
}
if($searchType == 'specific'){
    //SQL query to find based on park name or suburb.
    //We can't do the NotNull insert here because the first query needs to return scores. As such,
    //We split the queries into two separate ones, for reviewed and non-reviewed parks.
	$query = $db->prepare("SELECT items.parkCode, items.latitude, items.longitude, cast(avg(reviews.ReviewScore) as decimal(2,1)) as score, suburb, Street, Name 
        FROM items join reviews On reviews.parkID = items.id 
        WHERE items.suburb LIKE ? AND items.Name LIKE ?  
        GROUP BY id 
        HAVING(avg(reviews.ReviewScore) >= ?) 
        ORDER BY score DESC;");//Query selects all valid fields, sorts by the search values and filters on minScore.
    $NonReviewed = $db->prepare("SELECT items.parkCode, latitude, longitude, id, suburb, Street, Name 
        FROM items
        WHERE suburb LIKE ? AND Name LIKE ? AND id NOT IN (SELECT parkID FROM reviews) 
        LIMIT 40;");//Query here is simpler since we don't have to consider two tables. Select the first 40 parks which match the search criteria, and are NOT in the list of reviewed parks.
    //Declare table.
    echo '<tr class="head"><td>Park Name</td><td>Street Name</td><td>Score</td><td>Suburb</td>';
    if($suburb != "%%"){
        $zoom = 15;//If the suburb is specified, results are going to be clustered more. As such, zoom in a bit more.
    }
	if($query->execute(array($suburb,$name,$minScore))){
        ?>
     <!-- Map generation - call script, run initmap() with latitude and longitude from the first result.-->
        <div id="mapdiv"></div><br>
        <script type="text/javascript" src="\proj230\JS\mapScripts.js"></script>
        <?php 
        $firstResult = $query->fetch();
        echo'<script> initSearchMap('.$firstResult["latitude"].','. $firstResult["longitude"].', 12);</script>'; 
    $query->execute();
    foreach($query->fetchAll() as $row) {//Execute the first query and loop through results
        //Add a map marker for each result, then a table entry, same as above.
        echo'<script> addMarker(' . $row['latitude'] . ',' . $row['longitude'] .',"'. ucwords(strtolower($row['Name'])) . '","' .$row["parkCode"].'")</script>'; 
        echo '<tr><td>';
        echo "<a href='itemPage.php?park=".$row['parkCode']."'>".ucfirst(strtolower($row['Name']))."</a>";
        echo '</td><td>';
        echo ucfirst(strtolower($row['Street']));
        echo '</td><td><b>';
        echo $row['score'].'<img src="/proj230/Images/goldstar2.png">';
        echo '</b></td><td>';
        echo ucfirst(strtolower($row['suburb']));
        echo '</td></tr>';
}
}
    //If the user also asked for Non Reviewed parks, display them in a similar manner.
    if($NonReviewed->execute(array($suburb,$name)) && $IncludeNoReview == true){
        if(empty($firstResult)){
            $firstResult = $NonReviewed->fetch();
            echo'<script> initSearchMap('.$firstResult["latitude"].','. $firstResult["longitude"].','.$zoom.');</script>'; 
        }
    foreach($NonReviewed->fetchAll() as $row){
        echo'<script> addMarker(' . $row['latitude'] . ',' . $row['longitude'] .',"'. ucwords(strtolower($row['Name'])) . '","' .$row["parkCode"].'")</script>'; 
        echo '<tr><td>';
        echo "<a href='itemPage.php?park=".$row['parkCode']."'>".ucfirst(strtolower($row['Name']))."</a>";
        echo '</td><td>';
        echo ucfirst(strtolower($row['Street']));
        echo '</td><td><b>';
        echo '--&nbsp&nbsp&nbsp<img src="/proj230/Images/goldstar2.png">';
        echo '</b></td><td>';
        echo ucfirst(strtolower($row['suburb']));
        echo '</td></tr>';
    }
}
}
echo '</table>';//Close the table.
//Include the sitewide footer.
include 'footer.php';
?>
