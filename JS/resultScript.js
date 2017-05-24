function checkTable(){
	var table = document.getElementById("resTable");
	if (table.rows.length == 1){
		document.getElementById("resTable").hidden = true;
		document.getElementById("Title").innerHTML = "No results could be found. <br> Please try to search again at <a href='search.php'> our search page. </a>";
		document.getElementById("mapDiv").hidden = true;
	}

}