function registerCheck(doc) {
    var fn = document.forms["registerForm"]["FName"].value;
    var ln = document.forms["registerForm"]["LName"].value;
    var em = document.forms["registerForm"]["Email"].value;
    var ce = document.forms["registerForm"]["confEmail"].value;

    var result = true;
    if (fn == "" | fn==null) {
        document.getElementById("errFN").innerHTML="Please input a valid name!<br /> ";
        document.getElementById("fnbr").innerHTML="<br />";
        result = false;
    }
    if (ln == "" | ln==null) {
        document.getElementById("errLN").innerHTML="Please input a valid name <br />";
        document.getElementById("lnbr").innerHTML="<br />";
        result = false;
    }
    if (!(em.includes("@")) | (em.includes("."))) {
        document.getElementById("errEM").innerHTML="Please ensure that your email is valid (contains at least an \"@\" and \".\" symbol)<br />";
        document.getElementById("embr").innerHTML="<br />";
        result = false;
    }
    if (em == "" | em==null) {
        document.getElementById("errEM").innerHTML="Please input a valid email! <br />";
        document.getElementById("embr").innerHTML="<br />";
        result = false;
    }
    if (true){
		document.getElementById("errCE").innerHTML="Please ensure that these fields match<br />";
    	document.getElementById("cebr").innerHTML = "<br />";
    	result=false;
    }
	return result;
}
