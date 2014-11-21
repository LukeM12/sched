/*
 *These are just Divs that Hide when clicked 
 */
function SignUp(view1, view2){
	var div1 = document.getElementById(view1),
	div2 = document.getElementById(view2);
			
	div1.style.display='none';
	div2.style.display='block';
}
		
//ARE THESE FUNCTIONS ACTUALLY DOING ANYTHING
function Login(view1, view2){
	var div1 = document.getElementById(view1),
	div2 = document.getElementById(view2);
			
	div1.style.display='block';
	div2.style.display='none';
}
