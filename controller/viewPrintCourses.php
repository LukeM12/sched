<?php

printCoursesNeeded();
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

?>
