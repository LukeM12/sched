/*
I decided to use a wrapper here since I want to use
global variables and global variables are frowned upon
*/
var Validation = (function() { 

	var goodColor = "#66cc66";
	var badColor = "#ff6666";
	var resetColor = "#ffffff";
	
	function validateFields(id, confirmMessageElement, regexString)
	{
		//var element = document.getElementById(id);//Element to validate
		/*
		Comparing the value of the element to a regex string
		*/
		if(id.value.match(regexString)){
			id.style.backgroundColor = resetColor;
			confirmMessageElement.style.color = goodColor;
			message.innerHTML = "arrow.jpeg";
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
		},

		checkPasswordMatch: function()
		{
			var password = document.getElementById('password');
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
			var passwordRegEx = /^[0-9]{2,10}$/;
			var element = document.getElementById('password');//Element to validate
			if(!validateFields(element, messageElement, passwordRegEx))
			{
				messageElement.innerHTML = "Password doesn't meet requirements. Password must be 6-8 digits long.";
			}
		},
	
		validateStudentNumberField: function()
		{
			var messageElement = document.getElementById(studentNum);
			var passwordRegEx = /^[0-9]{8,10}$/;
			
			if(!validateFields('confirmStudentNumValidate',messageElement,passwordRegEx))
			{
				messageElement.innerHTML = "Student number doesn't meet requirements. Student number must be 8-10 digits long.";
			}
		},

		validateStringField: function(id, message)
		{
			var messageElement = document.getElementById(message);
			var stringRegEx = /^[a-zA-Z]+$/;

			if(!validateFields('password',messageElement,passwordRegEx))
			{
				messageElement.innerHTML = "Name cannot contain numbers or special characters.";
			}
		
		}
	};
})();