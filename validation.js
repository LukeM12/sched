/*
I decided to use a wrapper here since I want to use
global variables and global variables are frowned upon
*/
var Validation = (function() { 

	var goodColor = "#66cc66";
	var badColor = "#ff6666";
	var resetColor = "#ffffff";
	
	function validateFields(id, confirmMessageElement, isMatch)
	{
		//var element = document.getElementById(id);//Element to validate
		/*
		Comparing the value of the element to a regex string
		*/
		if(isMatch){
			id.style.backgroundColor = resetColor;
			confirmMessageElement.style.color = goodColor;
			return true;
		}else{
			id.style.backgroundColor = badColor;
			confirmMessageElement.style.color = badColor;
			return false;
		}
	}
	
	return {
	
		clearbox: function(id)
		{
			var comp = document.getElementById(id);
			comp.value="";
		},
	
		validateSignUpForm: function()
		{
			var inputFields = document.getElementsByClassName("singupField");
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
		},
		
		validateLoginForm: function()
		{
			var inputFields = document.getElementsByClassName("loginField");
			for (var i=0; i<inputFields.length; i++){
				if(!inputFields[i].value){
					alert("Please fill in all of the fields");
					return false;
				}
			}
		},

		checkPasswordMatch: function()
		{
			var password = document.getElementById('singupPassword');
			var confPassword = document.getElementById('confPass');
			var message = document.getElementById('confirmPassMatch');
			if(password.value == confPassword.value){
				confPassword.style.backgroundColor = goodColor;
				message.style.color = goodColor;
				message.innerHTML = "arrow.jpeg";
			}else{
				confPassword.style.backgroundColor = badColor;
				message.style.color = badColor;
				message.innerHTML = "Passwords Do Not Match!";
			}
		},

		validatePassword: function()
		{
			var messageElement = document.getElementById('confirmPassValidate');
			var fieldElement = document.getElementById('singupPassword');//Element to validate	
			var valueMatch = /^[0-9]{2,10}$/.test(fieldElement.value);

			if(!validateFields(fieldElement, messageElement, valueMatch))
			{
				messageElement.innerHTML = "Password doesn't meet requirements. Password must be 6-8 digits long.";
			}
			else
			{
				messageElement.innerHTML = "arrow.jpeg";
			}
		},
		
		validateStringField: function(id, message)
		{
			var messageElement = document.getElementById(message);
			var fieldElement = document.getElementById(id);
			var valueMatch = /^[a-zA-Z]+$/.test(fieldElement.value);

			if(!validateFields(fieldElement,messageElement,valueMatch))
			{
				messageElement.innerHTML = "Name cannot contain numbers or special characters.";
			}
			else
			{
				messageElement.innerHTML = "arrow.jpeg";
			}
		
		},
	
		validateStudentNumberField: function()
		{
			var messageElement = document.getElementById('confirmStudentNumValidate');
			var fieldElement = document.getElementById('signupStudentNum');
			var valueMatch = /^[0-9]{8,10}$/.test(fieldElement.value);
			
			if(!validateFields(fieldElement,messageElement,valueMatch))
			{
				messageElement.innerHTML = "Student number doesn't meet requirements. Student number must be 8-10 digits long.";
			}
			else
			{
				messageElement.innerHTML = "arrow.jpeg";
			}
		}
	};
})();