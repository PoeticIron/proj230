function registerCheck(doc) {
    var fn = document.forms["registerForm"]["FName"].value;
    var ln = document.forms["registerForm"]["LName"].value;
    var em = document.forms["registerForm"]["Email"].value;
    var ce = document.forms["registerForm"]["confEmail"].value;
    var us = document.forms["registerForm"]["Username"].value;
    var pw = document.forms["registerForm"]["Password"].value;
    var cpw = document.forms["registerForm"]["ConfPassword"].value;
    var dob = document.forms["registerForm"]["DOB"].value;
    var ToU = document.forms["registerForm"]["ToU"].isChecked;
    var result = true;
    if (fn == "" | fn==null) {
        document.getElementById("errFN").innerHTML="Please input a valid name!<br /> ";
        result = false;
    }
    if (ln == "" | ln==null) {
        document.getElementById("errLN").innerHTML="Please input a valid name <br />";
        result = false;
    }
    if (!(em.includes("@")) | (em.includes("."))) {
        document.getElementById("errEM").innerHTML="Please ensure that your email is valid (contains at least an \"@\" and \".\" symbol)<br />";
        result = false;
    }
    if(us.length < 5 | us.length > 20 | us=="" | us==null){
        document.getElementById("errUS").innerHTML="Please input a valid username, between 5 and 20 characters.";
        result=false;
    }
    if(pw.length < 5){
        document.getElementById("errPW").innerHTML="Please input a password with more than five characters.";
        result=false;
    }
    if(!(/\d/.test(pw)) | !(/[A-Z]/.test(pw))){
        document.getElementById("errPW").innerHTML="Please input a password with at least one capital and one number.";
    }
    if(cpw != pw){
        document.getElementById("errCPW").innerHTML="Please ensure these fields match.";
        result=false;
    }    
    if (em == "" | em==null) {
        document.getElementById("errEM").innerHTML="Please input a valid email! <br />";
        result = false;
    }
    if ((em != ce)){
		document.getElementById("errCE").innerHTML="Please ensure that these fields match<br />";
    	result=false;
    }
    date = new Date();
    date.setFullYear(date.getFullYear() - 16);
    inputDate = Date.parse(dob);
    if(inputDate > date){
        document.getElementById("errDOB").innerHTML="Users under 16 cannot register for this site.<br />";
        result = false;
    }
    if(isNaN(inputDate)){
        document.getElementById("errDOB").innerHTML="Please input your date of birth.<br />";
        result=false;
    }
    if(!ToU){
        document.getElementById("errToU").innerHTML="You must agree to the Terms of Use to register.<br />";
        result=false;
    }
	return result;
}

function showPosition(latitude, longitude) {
    var latlon = latitude + "," + longitude;

    var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="
    +latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyCvlWDjG3g5Aim2WGLsYKBH0qKnBSaAE74";
    document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'> </img>";
}
//To use this code on your website, get a free API key from Google.
//Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

function addLink(){
    var everyCell = document.getElementsByTagName('td')
    for(var i =2, cell; cell=everyCell[i];i++){
        if((i+3) % 4 == 0){
            var pName = cell.innerHTML;
            cell.innerHTML = "<a href=\\proj230\\Pages\\itemPage.html>" + pName + "</a>"
        }
    }
}

function getLocation(){
    navigator.geolocation.getCurrentPosition(displayMyPosition);
}
function displayMyPosition(position){
    showPosition(position.coords.latitude, position.coords.longitude);
    document.getElementById('mapInfo').innerHTML= "Your Coordinates: \n Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude;
}
