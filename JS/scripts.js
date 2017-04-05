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
