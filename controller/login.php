<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca

     Description : login.php handles the main functions required for this app.
     -->
<?php
    require_once("../model/db.php");
    require_once("../install.php");
    $data = new database("uni");
    $studentID = $_POST['StudentNum']; 
    $password = $_POST['Password']; 
    Login($data,$studentID,$password );

    /**
     * 
     * @param $data - the database
     * @param $studentID - the users id 
     * @param $password - the user password
     */
   function Login($data,$studentID,$password ){
		$sql = 'SELECT * FROM student WHERE studentID=\''.$studentID.'\'';		
		$rows = $data->execute($sql); //Retrieve user from table 
		echo $data->getError();
		$num = $rows->num_rows;
		//If we do get a result..
		if($num>0)
		{
            //Set log on cookie
			$user_info = $data->fetchAssoc($rows); //Fetch user info
			$db_password = $user_info['password'];
			$password = $_POST['Password'];
			//If the password is correct
			if($password == $db_password){
				setcookie("user", $studentID, time() + 3600, "/");
                if ($user_info['newUser'] == 'T' && $user_info['onCourse'] == 'F'){
                	$value = "Hello World";
                	loadOffCoursePage();      	
                }
				else if ($user_info['newUser'] == 'T' && $user_info['onCourse'] == 'T'){
        			echo " NOw you are logged in, take an action";
                }	
			}
			else {
				echo "Password is incorrect. Please enter a valid password.";
			}
		}
		else
		{
            echo "<br>Account#".$studentID . " does not exist. Please create an account\n";
		}
	}
    /**
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/
    function displayStudent($result){
        foreach($result as $row) {
                echo "<tr>";
                echo "<td><b>" . $row['studentID'] . "</b></td>";
                echo "<td> <h1>" . $row['name'] . "</h1></td>";
                echo "</tr>";        
            //Insert the test here;
        }
    }

    function loadOffCoursePage(){
		 require('../view/offCourse.html'); 
	 }
?>