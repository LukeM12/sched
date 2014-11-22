  
/**
 * These are "View Calls". They dynamically load HTML into the view without refreshing the page
 */
  //This is basically the Page that loads All The various rudimentary navigation
  function LoadMainPage()
    {
    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange = function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("MainBlock").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","view/pages/home_page.html",true);
    xmlhttp.send();
    }


    function LoadLoginPage()
        {
        var xmlhttp;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange = function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("MainBlock").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","view/pages/login_page.html",true);
        xmlhttp.send();
        }

   
function LoadSignupPage()
    {
    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange = function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("MainBlock").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","view/pages/signup_page.html",true);
    xmlhttp.send();
    }
/**
 * These are Server Calls. They call php files 
 */
    function SubmitForm()
    {
    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange = function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
        }
    }
 //   xmlhttp.open("POST","controller/login.php",true);
        document.getElementById("MainContent").innerHTML="Did ti worl";
    alert("Did it work");
    xmlhttp.send();
    }

