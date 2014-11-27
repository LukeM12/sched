<?php

printCoursesNeeded();
coursesEligible();
/*
 * Description :Store the classes that the user specified that they took in the DB 
 * return: If the courses effectively got added the the uni db
 */
function printCoursesNeeded(){

    $login = $_COOKIE['user'];
    $classesTaken = array();
    $connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
    $sql = "SELECT * FROM student WHERE studentID='$login';";
    $result = $connection->query($sql);
    $user_data = $result->fetch_assoc();
    if ($user_data['newUser'] == 'T') {
        mysqli_free_result($result);
        populateCoursesNeeded($connection, $login);
    }
    echo "The courses that ".$login." needs to take are: <br />\n";
    echo "year   term   courseName <br />\n";
    $sql = "SELECT * FROM courses_Needed WHERE studentID='$login';";
    $result = $connection->query($sql);
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        echo $rows['year']."    ".$rows['term']."    ".$rows['courseName']." <br />\n";
    }
    mysqli_free_result($result);
}

    /**
    * Populates courses_Needed table
    *
    * Compares the courseID field from ce_program against each element in courses_Taken table. If
    * there was a hit return. If there wasnt a hit insert into courses_Needed table studentID value
    * from course_Taken table and subject/courseID values from ce_program
    * 
    * @todo: Check for duplicates before inserting into table 
    */
    function populateCoursesNeeded($connection, $studentID) {
    
        $sql = "SELECT * FROM ce_program;";
        $result_ce_req = $connection->query($sql);
        
        while($row_ce_req = $result_ce_req->fetch_array(MYSQLI_ASSOC)){
            $format = "SELECT * FROM courses_Taken 
                       WHERE studentID='%s' AND courseName='%s';";
            $sql = sprintf($format,$studentID,$row_ce_req['courseName']);
            $result_ct = $connection->query($sql);
            echo mysqli_error($connection);
            
            $row_ct = $result_ct->num_rows;
            if($row_ct == 0){
                $sql = "INSERT INTO courses_Needed (studentID, courseName, year, term)
                    SELECT '$studentID', ce_program.courseName, ce_program.year, ce_program.term
                    FROM ce_program
                    WHERE ce_program.courseName = '".$row_ce_req['courseName']."';";
                $connection->query($sql);
                echo mysqli_error($connection);
            }
        }
    }

	function coursesEligible(){
		//For every class inside courses_needed look at that entry
		//in course_prereq, get the prereq and check if that class
		//is inside courses_taken. If it is, put a flag on the class
		//in courses_needed that it CAN be taken
		
		
		
		$connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
		
		$sql = "SELECT * FROM courses_Needed;";
		$result_needed = $connection->query($sql);
		$row_courses_needed = $result_needed->fetch_assoc();
		//echo mysqli_error($connection);
		
		
		$sql = "SELECT * FROM course_prereq WHERE courseName = '".$row_courses_needed['courseName']."';";
		echo $sql."<br/>";
		/*
		$prereq = $connection->query($sql);
		echo mysqli_error($connection);
		$row_prereq_needed = $prereq->fetch_assoc();
		
		
		$prereqList = array();
		while($row_course_prereq = mysql_fetch_assoc($sql))
		$prereqList[] = $row_course_prereq;
		
		foreach($prereqList as $prq){
			$class1 = explode("or", $prq[firstPreReq]);
		
			$var = mysql_query("SELECT courseName FROM courses_taken WHERE courseName = '$class1[0]' OR  courseName = '$class1[1]';");
			if(mysql_num_rows($var) == 1){
				$sql =	"UPDATE courses_Needed SET eligible='Y' WHERE courseName='$result_needed';";
				$fuck = $connection->query($sql);
			}
		
		$class2 = explode("or", $prq[secondPreReq]);
		$class3 = explode("or", $prq[thirdPreReq]); 
		
		}*/
		
		
		
		
	}
	
	
	
	
?>
