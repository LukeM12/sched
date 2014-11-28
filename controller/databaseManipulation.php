<?php
/*
 * Author :Volod
 * Contributor: Luke M
 * Contributor: Matt C
 */
/** 
 * Description: Retrieve the information from the student
 * @param $DB: Live Instance of the Database
 * return: a sql result of the student being requested
 */
function getStudentInfo($DB){
    $login = $_COOKIE['user'];
    $sql = "SELECT * FROM student WHERE studentID = '$login';";
    $result = $DB->execute($sql);
    return $result->fetch_assoc();
}

function populateCoursesTaken_offCourse($DB){
    $studentInfoRow = getStudentInfo($DB);
    
    foreach ($_POST['class'] as $taken) {
        array_push($classesTaken, $taken);
        $sql = "INSERT IGNORE INTO courses_Taken (studentID, courseName) VALUES ('$login', '$taken');";
        $DB->execute($sql);
    }
    echo "DONE";
}

/** 
 * Description: Populate a the courses taken from an oncourse student 
 * @param $DB: Live Instance of the Database
 */
function populateCoursesTaken_onCourse($DB){
    $studentInfoRow = getStudentInfo($DB);
    
    $toTake = $studentInfoRow['year'] - 1;
    while ($toTake != 0){
			$sql = "SELECT * FROM ce_program WHERE year ='$toTake';";
			$classes = $DB->execute($sql);
			while($row_classes = $classes->fetch_assoc()){ 
				$sql = "INSERT IGNORE INTO courses_taken (studentID, courseName) VALUES ('".$studentInfoRow['studentID']."', '".$row_classes['courseName']."')";
				$insert = $DB->execute($sql);
			}
			$toTake = $toTake - 1;					
    }
}
/**
 * Description: Populate the courses taken table from an oncourse student
 * @param $DB: Live Instance of the Database
 */
function populateCoursesNeeded_onCourse($DB){
    $studentInfoRow = getStudentInfo($DB);
    $nextLevel = $studentInfoRow['year']; 
	$dynamicLevel = $studentInfoRow['year']; 
	
	while($nextLevel < 5){
        $sql = "SELECT * FROM ce_program WHERE year ='$nextLevel';";			
        $nextClasses = $DB->execute($sql);
		while($row_nextClasses = $nextClasses->fetch_assoc()){
			if($nextLevel == $dynamicLevel){ //this is to ensure the eligibility can be set dynamically, not using hard coded values
					$sql = "INSERT IGNORE INTO courses_needed (studentID, courseName, year, term, eligible) VALUES ('".$studentInfoRow['studentID']."', '".$row_nextClasses['courseName']."', '$nextLevel','".$row_nextClasses['term']."' , 'Y')";
					$insert1 = $DB->execute($sql);
			}
			else {
					$sql = "INSERT IGNORE INTO courses_needed (studentID, courseName, year, term, eligible) VALUES ('".$studentInfoRow['studentID']."', '".$row_nextClasses['courseName']."', '$nextLevel','".$row_nextClasses['term']."' , 'N')";
					$insert2 = $DB->execute($sql);
			}
		}					
		$nextLevel = $nextLevel + 1;
	}	
}
/**
 * Description: Populate the courses Needed table from an offcourse student
 * @param $DB: Live Instance of the Database
 */
function populateCoursesNeeded_offCourse($DB){
    $studentInfoRow = getStudentInfo($DB); 
    $sql = "SELECT * FROM ce_program;";
    $result_ce_req = $DB->execute($sql);
    //Iterate each entry from ce_program and test them against the courses the user has taken
    while($row_ce_req = $result_ce_req->fetch_array(MYSQLI_ASSOC)){
        $format = "SELECT * FROM courses_Taken 
                   WHERE studentID='%s' AND courseName='%s';";
        $sql = sprintf($format,$studentID,$row_ce_req['courseName']);
        $result_ct = $DB->execute($sql);
                
        $row_ct = $result_ct->num_rows;
        if($row_ct == 0){
            $sql = "INSERT INTO courses_Needed (studentID, courseName, year, term)
                    SELECT '$studentID', ce_program.courseName, ce_program.year, ce_program.term
                    FROM ce_program
                    WHERE ce_program.courseName = '".$row_ce_req['courseName']."';";
            $DB->execute($sql);
        }
    }
    setEligibleCourses($DB, $studentInfoRow);
}
/**
 * Description: 
 * @param unknown $DB
 * @param unknown $studentInfoRow
 */
function setEligibleCourses($DB, $studentInfoRow){
    //Get the courses
    $sql = "SELECT * FROM courses_Needed WHERE studentID = '".$studentInfoRow['studentID']."';";
    
    $courses_needed = $DB->execute($sql);
    while($row_courses_needed = $courses_needed->fetch_array(MYSQLI_ASSOC)){
        //Check if the class is in prereq table. If its not then student is eligible to take it.
        //row  course Needed is a row of the course that the user needs objectively.
        $sql = "SELECT * FROM course_prereq WHERE courseName = '".$row_courses_needed['courseName']."';";
        $prereq = $DB->execute($sql);
        $row_prereq = $prereq->fetch_assoc();
        if($prereq->num_rows == 0){
            $eligible = 'Y';
        }
        else{
            $eligible = 'Y';
            //Check year
            if ($studentInfoRow['year']<$row_prereq['yearReq']){
                $eligible = 'N';
            }
            
            //Check program req
            if (strpos($row_prereq['programReq'],'ENG') !== FALSE){
                $eligible = 'Y';
            }
            elseif (strpos($row_prereq['programReq'],$studentInfoRow['program']) !== FALSE){
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
                    $result = $DB->execute($sql);
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
                    $result = $DB->execute($sql);
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
                    $result = $DB->execute($sql);
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
        $result = $DB->execute($sql);
        if ($eligible == 'Y'){
            echo $row_courses_needed['courseName']."<br/>";
        }
    }
}
?>