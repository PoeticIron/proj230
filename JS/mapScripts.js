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