<?php

$connection = new database("uni");//mysqli_connect("127.0.0.1", "root", "oops123", "uni");
printCoursesNeeded($connection);
/*
 * Description :Store the classes that the user specified that they took in the DB 
 *@param : connection, a current connection to the database 
 * return: If the courses effectively got added the the uni db
 */
function printCoursesNeeded($connection){

    $login = $_COOKIE['user'];
    $classesTaken = array();
    $sql = "SELECT * FROM student WHERE studentID='$login';";
    $result = $connection->query($sql);
    $user_data = $result->fetch_assoc();

    //We need to populate the courses that the user is required to take 
    if ($user_data['newUser'] == 'T') {
        populateCoursesNeeded($connection, $login);
    }
    coursesEligible($connection, $user_data);
    /*echo "The courses that ".$login." needs to take are: <br />\n";
    echo "year   term   courseName <br />\n";
    $sql = "SELECT * FROM courses_Needed WHERE studentID='$login';";
    $result = $connection->query($sql);
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        echo $rows['year']."    ".$rows['term']."    ".$rows['courseName']." <br />\n";
    }*/
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
        //Iterate each entry from ce_program and test them against the courses the user has taken
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

    /*
     *Description: coursesEligable takens the user ID, and the connection and 
     *
     */
    function coursesEligible($connection, $userData){
        echo $userData['studentID']." is eligible to take:<br/>";
		$sql = "SELECT * FROM courses_Needed WHERE studentID = '".$userData['studentID']."';";
		$courses_needed = $connection->query($sql);
		while($row_courses_needed = $courses_needed->fetch_array(MYSQLI_ASSOC)){
            //Check if the class is in prereq table. If its not then student is eligible to take it.
            //row  course Needed is a row of the course that the user needs objectively.
            $sql = "SELECT * FROM course_prereq WHERE courseName = '".$row_courses_needed['courseName']."';";
            $prereq = $connection->query($sql);
            $row_prereq = $prereq->fetch_assoc();
            if($prereq->num_rows == 0){
                $eligible = 'Y';
            }
            else{
                $eligible = 'Y';
                //Check year
                if ($userData['year']<$row_prereq['yearReq']){
                    $eligible = 'N';
                }
                
                //Check program req
                if (strpos($row_prereq['programReq'],'ENG') !== FALSE){
                    $eligible = 'Y';
                }
                elseif (strpos($row_prereq['programReq'],$userData['program']) !== FALSE){
                    $eligible = 'Y';
                }
                elseif(empty($row_prereq['programReq'])){
                    $eligible = 'Y';
                }
                else{
                    $eligible = 'N';
                }
                
                /*Check courses prereq
                * At most course can have up to 3 prerequisites(i.e. ecor1000 AND sysc2002 AND elec3500). Each one can be a choice between other courses (i.e. sysc2003 OR sysc2001)
                * Check non-empty PreReq column (i.e. firstPreReq, secondPreReq or thirdPreReq) if the courses that they contain were taken by the student. If they were, thats an eligible
                * hit. If the hits correspond to the count then the course meets the prerequisite requirement.
                */
                $count = 0;
                $hit = 0;
                if(!empty($row_prereq['firstPreReq'])){
                    $count++;
                    $arrayPreReqCourses = explode(' OR',$row_prereq['firstPreReq']);
                    foreach($arrayPreReqCourses as $course){
                        $course = trim($course);
                        $sql = "SELECT courseName FROM courses_Taken WHERE courseName ='".$course."';";
                        $result = $connection->query($sql);
                        if($result->num_rows != 0){ 
                            $hit++;
                            break;
                        }
                    }
                }
                if(!empty($row_prereq['secondPreReq'])){
                    $count++;
                    $arrayPreReqCourses = explode(' OR',$row_prereq['secondPreReq']);
                    foreach($arrayPreReqCourses as $course){
                        $course = trim($course);
                        $sql = "SELECT courseName FROM courses_Taken WHERE courseName ='".$course."';";
                        $result = $connection->query($sql);
                        if($result->num_rows != 0){
                            $hit++;
                            break;
                        }
                    }
                }
                if(!empty($row_prereq['thirdPreReq'])){
                    $count++;
                    $arrayPreReqCourses = explode(' OR',$row_prereq['thirdPreReq']);
                    foreach($arrayPreReqCourses as $course){
                        $course = trim($course);
                        $sql = "SELECT courseName FROM courses_Taken WHERE courseName ='".$course."';";
                        $result = $connection->query($sql);
                        if($result->num_rows != 0){
                            $hit++;
                            break;
                        }
                    }
                }
                if($hit != $count){
                    $eligible = 'N';
                }
                //echo $row_prereq['courseName'].": ".$eligible."<br/>"; 
            }
            $sql = "UPDATE courses_Needed SET eligible='".$eligible."' WHERE courseName = '".$row_courses_needed['courseName']."';";
            $result = $connection->query($sql);
            if ($eligible == 'Y'){
                echo $row_courses_needed['courseName']."<br/>";
            }
		}	
	}

?>
