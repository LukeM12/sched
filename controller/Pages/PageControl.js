  

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
        document.getElementById("Navigation").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","view/pages/nav_page.html",true);
    xmlhttp.send();
   /* var xmlhttp;
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
    xmlhttp.send();*/
    }
    /* This page loads and displays the content in the login page */
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
            document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","view/pages/signup_page.html",true);
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
          document.getElementById("MainContent").innerHTML=xmlhttp.responseText;
          }
      }
      xmlhttp.open("GET","view/pages/login_page.html",true);
      xmlhttp.send();
    }
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
    xmlhttp.open("POST","controller/login.php",true);
    alert("Did it work");
    xmlhttp.send();
    }


