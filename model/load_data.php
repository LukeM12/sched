<?php
    //To load the script run "http://localhost/model/load_data.php"

    $host = "127.0.0.1";
    $user = "root";
    $password = "oops123";
    $enclosed =  '"';

    $connection = mysqli_connect($host,$user,$password,'uni');
    
    $sql = "LOAD DATA LOCAL INFILE '../model/course_data.csv'
            INTO TABLE course
            FIELDS 
                TERMINATED BY ';'
                ENCLOSED BY '".$enclosed."'
            LINES 
                TERMINATED BY '\r\n'
            IGNORE 1 LINES;";
            
    $connection->query($sql);
    echo mysqli_error($connection);

    $sql = "LOAD DATA LOCAL INFILE '../model/ce_program_course_data.csv'
            INTO TABLE ce_program
            FIELDS 
                TERMINATED BY ';'
            LINES 
                TERMINATED BY '\r\n';";

    $connection->query($sql);
    echo mysqli_error($connection);
    
    testInitTables($connection);
    $studentID = 223;
    populateCoursesNeeded($connection, $studentID);

    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/

    function testInitTables($connection) {
        //set up
        
        $sql = "INSERT INTO student(studentID, name, onCourse, password, coursesTaken) 
                values ('223', 'Bob', 'false', '111', 'ECOR1101 and MATH1104 and SYSC2004 and SYSC2001');";
        $connection->query($sql);
        echo mysqli_error($connection);
        
        $sql = "SELECT * FROM courses_Taken WHERE courseID='223';";
        $result = $connection->query($sql);
        echo mysqli_error($connection);
        $rows = $result->num_rows;
        if($rows==0){
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'ECOR', '1101');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'MATH', '1104');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'SYSC', '2004');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'SYSC', '2001');";
            $connection->query($sql);
            echo mysqli_error($connection);
        }
    }
    /** 
    * Populates courses_Needed table
    */
    function populateCoursesNeeded($connection, $studentID) {
    
        $sql = "SELECT * FROM CE_program;";
        $result_ce_req = $connection->query($sql);
        while($row_ce_req = $result_ce_req->fetch_array(MYSQLI_ASSOC)){
            $sql = "SELECT * FROM courses_Taken WHERE studentID='$studentID';";
            $result_ct = $connection->query($sql);
            checkIfCourseWasTaken($studentID, $row_ce_req, $result_ct, $connection);
        }
        mysqli_free_result($result_ce_req);
    }
    
    /**
    * Inserts one row of courses_Needed
    *
    * Compares the courseID field from ce_program against each element in courses_Taken table. If
    * there was a hit return. If there wasnt a hit insert into courses_Needed table studentID value
    * from course_Taken table and subject/courseID values from ce_program
    * 
    * @todo: Check for duplicates before inserting into table 
    */
    function checkIfCourseWasTaken($studentID, $row_ce_req, $result_ct, $connection) {
        
        while($row_ct = $result_ct->fetch_array(MYSQLI_ASSOC)){
            if($row_ct["courseID"]==$row_ce_req["courseID"]){
                return;
            }
        }
        mysqli_free_result($result_ct);
        
        $courseID = $row_ce_req["courseID"];
        
        if($studentID != 0){
            $sql = "INSERT INTO courses_Needed (studentID, subject, courseID, year, term)
                    SELECT '$studentID', CE_program.subject, CE_program.courseID, CE_program.year, CE_program.term
                    FROM CE_program
                    WHERE CE_program.courseID = '$courseID';";

            /*$sql = "INSERT INTO courses_Needed (studentID, subject, courseID)
                    VALUES ('$studentID', '$subject', '$courseID');";*/
            $connection->query($sql);
            echo mysqli_error($connection);
        }
    }
    
    
?>