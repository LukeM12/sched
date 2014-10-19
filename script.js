var submitButton = document.getElementById('submitBut');

function clearBox(id)
{
	var comp = document.getElementById(id);
	comp.value="";
}

function validateSignUpForm()
{
	var inputFields = document.getElementsByTagName("input");
	var programField = document.getElementsByName("program");
	var courseSelField = document.getElementsByName("onOffCourse");
	var messageFields = document.getElementsByClassName("confirmMessage");
	for (var i=0; i<inputFields.length; i++){
		if(!inputFields[i].value){
			alert("Please fill in all of the fields");
			return false;
		}
	}
	if(programField[0].value == 'blank' || courseSelField[0].value == 'blank')
	{
		alert("Please choose an option in select fields.");
		return false;
	}
	/*
	I haven't found a better way to check. I was thinking of using cookies.
	*/
	for (var j=0; j<messageFields.length; j++){
		if(messageFields[j].innerHTML != "arrow.jpeg"){
			alert("Please fix the form before submitting");
			return false;
		}
	}
}

function validateStringField(id, message)
{
	var stringElement = document.getElementById(id);
	var messageElement = document.getElementById(message);
	var goodColor = "#66cc66";
    var badColor = "#ff6666";
	var resetColor = "#ffffff";
	var stringRegEx = /^[a-zA-Z]+$/;
	if(stringElement.value.match(stringRegEx)){
		stringElement.style.backgroundColor = resetColor;
        messageElement.style.color = goodColor;
        messageElement.innerHTML = "arrow.jpeg";
	}else{
		stringElement.style.backgroundColor = badColor;
        messageElement.style.color = badColor;
        messageElement.innerHTML = "Name cannot contain numbers or special characters.";
	}
	
}

function checkPasswordMatch()
{
	var password = document.getElementById('password');
	var confPassword = document.getElementById('confPass');
	var message = document.getElementById('confirmPassMatch');
	var goodColor = "#66cc66";
    var badColor = "#ff6666";
	if(password.value == confPassword.value){
        confPassword.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "arrow.jpeg";
    }else{
        confPassword.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!";
    }
}

function validatePassword()
{
	var password = document.getElementById('password');
	var message = document.getElementById('confirmPassValidate');
	var numericRegEx = /^[0-9]{2,10}$/;
	var goodColor = "#66cc66";
	var badColor = "#ff6666";
	var resetColor = "#ffffff";
	if(password.value.match(numericRegEx)){
		password.style.backgroundColor = resetColor;
        message.style.color = goodColor;
        message.innerHTML = "arrow.jpeg"
	}else{
		password.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password doesn't meet requirements. Password must be 6-8 digits long.";
	}
}

/*function addLoadEvent(funct) {
  var oldOnLoad = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = funct;
  } else {
    window.onload = function() {
      if (oldOnLoad) {
        oldOnLoad();
      }
      funct();
    }
  }
}
addLoadEvent(validateSignUpForm);
addLoadEvent(checkPasswordMatch);*/