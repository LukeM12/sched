  

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
    xmlhttp.open("GET","view/pages/signup_page.html",true);
    xmlhttp.send();
    }