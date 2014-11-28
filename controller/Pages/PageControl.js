/**
 * Author : Luke Morrison
 * email : lukemorrison@cmail.carleton.ca
 */

/*************************************************
				HTML VIEW CONTENT
 */

/**
 * Description: Load the Entire Page Manually
 * return: The HTML content for the main page
 */
function LoadMainPage(){
	var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    	xmlhttp=new XMLHttpRequest();
    }
    else {// code for IE6, IE5
    	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = 
    	function(){
	    	if (xmlhttp.readyState==4 && xmlhttp.status==200){
	    		document.getElementById("Navigation").innerHTML=xmlhttp.responseText;
	        }
    	}
    //xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.open("GET","view/pages/nav_page.html",true);
    xmlhttp.send();
    }
/**
 * Description: Load the Page for signing up, into the main Div
 * return: The HTML content for the sign-up page
 */
function LoadSignupPage(){
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = 
		function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
		    }
		}
	xmlhttp.open("GET","view/pages/signup_page.html",true);
	xmlhttp.send();
	}
/**
 * Description: Load the Page for Logging in, into the main Div
 * return: The HTML content for the login page
 */
function LoadLoginPage(){
	var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
    }
	else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange = 
		function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
			  document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
			}
		}
	//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.open("GET","view/pages/login_page.html",true);
	xmlhttp.send();
}

/*************************************************
				PHP BACKEND
*/

/**
 * Description: Load the Page for Logging in, into the main Div
 * return: The HTML content for the login page
 */
function SubmitForm(){
	var xmlhttp;
	if (window.XMLHttpRequest) {// IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {// IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = 
		function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
		    }
		}
	alert("Did it work");
	//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.open("POST","controller/login.php",true);
	
	xmlhttp.send();
}


/**
 * Description: Load the Page for Logging in, into the main Div
 * return: The HTML content for the login page
 */
//function SubmitForm(){
//	var xmlhttp;
//	if (window.XMLHttpRequest) {// IE7+, Firefox, Chrome, Opera, Safari
//		xmlhttp=new XMLHttpRequest();
//	}
//	else {// IE6, IE5
//		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//	}
//	xmlhttp.onreadystatechange = 
//		function()
//		{
//			if (xmlhttp.readyState==4 && xmlhttp.status==200){
//				document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
//		    }
//		}
//	document.getElementById("MainContent").innerHTML="Did ti worl";
//	xmlhttp.open("POST","controller/login.php",true);
//	alert("Did it work");
//	xmlhttp.send();
//}

