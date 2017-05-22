var map;
var ajaxRequest;
var plotlist;
var plotlayers=[];

function initmap(latitude, longitude, parkName) {
	// set up the map
	map = new L.Map('mapdiv');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 20, attribution: osmAttrib});		

	// Create the map at the designated coordinates, at ideal zoom.
	map.setView(new L.LatLng(latitude, longitude),16);
	map.addLayer(osm);
	var marker = L.marker([latitude, longitude], {title: parkName}).addTo(map);
}

function initSearchMap(latitude,longitude, zoom){
	// set up the map
	map = new L.Map('mapdiv');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 20, attribution: osmAttrib});		

	// Create the map at the designated coordinates, at ideal zoom.
	map.setView(new L.LatLng(latitude, longitude),zoom);
	map.addLayer(osm);
}
function addMarker(latitude, longitude, parkName, parkCode){
	marker = L.marker([latitude, longitude], {title: parkName}).addTo(map);
	marker.on('click', function(ev){
		window.location = "/../proj230/Pages/itemPage.php?park=" + parkCode;
	});
}

function getLocation(){
	//Just grab the user's location, then pass it to the DisplayMyPosition function.
    navigator.geolocation.getCurrentPosition(displayMyPosition);
}
function displayMyPosition(position){
	//Initialize a new map with the user's coordinates.
    initmap(position.coords.latitude, position.coords.longitude, "Your Location");
    //Display the user's coordinates on the page, and setup the form values with these as well.
    document.getElementById('mapInfo').innerHTML= "Your Coordinates: \n Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude;
    document.getElementById('lat').value= position.coords.latitude;
    document.getElementById('lon').value=position.coords.longitude;
    //make the map and the 'search by location' button visible.
    document.getElementById('locationSubmit').hidden=false;
    document.getElementById('mapdiv').hidden=false;
}
