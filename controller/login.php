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
     * @param unknown $data - the database
     * @param unknown $studentID - the users id 
     * @param unknown $password - the user password
     */
   function Login($data,$studentID,$password ){
		
		// Minimum req to prevent php injection
		/*$sql = sprintf(
				"SELECT*FROM users WHERE student_num='%s'",
				$data->realEscStr($login));
				*/
        
		$sql = 'SELECT * FROM student WHERE studentID=\''.$studentID.'\'';		
		$rows = $data->execute($sql); //Retrieve user from table 
		echo $data->getError();
		$num = $rows->num_rows;
		
		if($num>0)
		{
            //This is where the cookie is set
			$user_info = $data->fetchAssoc($rows); //Fetch user info
			$db_password = $user_info['password'];
			$password = $_POST['Password'];
			if($password == $db_password)
            {
				setcookie("user", $studentID, time() + 3600, "/");
                
                if ($user_info['newUser'] == 'T' && $user_info['onCourse'] == 'F')
                {
                    header('Refresh:1;url=/view/offCourse.html');
                }
			}
			else
            {
				echo "Password is incorrect. Please enter a valid password.";
                header('Refresh:1;url=/');
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

    
    
?>
