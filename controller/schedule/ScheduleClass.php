<?php

class Schedule{

    private $studentID;
    private $DB;
	
    public function __construct($studentID,$DB) {
        $this->studentID = $studentID;
        $this->DB = $DB;
    }
    /** 
     * Description: Looks for a non conflicting section for each eligible class in fall and winter
     * @param $DB: database object
     */
    public function setSectionInCoursesNeeded($DB){
        $sql = "SELECT * FROM courses_Needed WHERE studentID='".$this->studentID."' AND eligible='Y' AND term='F';";
        $eligibleClass = $DB->execute($sql);
        while($row_eligibleClass = $eligibleClass->fetch_assoc()){
            $eligibleCourseSplit = explode(" ",$row_eligibleClass['courseName']);
            $format = "SELECT * FROM course WHERE subject='%s' AND courseID='%s' AND term='F' AND instruction_type='LEC';";
            $sql = sprintf($format,$eligibleCourseSplit[0],$eligibleCourseSplit[1]);
            $lectures = $DB->execute($sql);
            echo $DB->getError();
            
            $this->getSection($DB, $lectures);
        }
        
        $sql = "SELECT * FROM courses_Needed WHERE studentID='".$this->studentID."' AND eligible='Y' AND term='W';";
        $eligibleClass = $DB->execute($sql);
        while($row_eligibleClass = $eligibleClass->fetch_assoc()){
            $eligibleCourseSplit = explode(" ",$row_eligibleClass['courseName']);
            $format = "SELECT * FROM course WHERE subject='%s' AND courseID='%s' AND term='W' AND instruction_type='LEC';";
            $sql = sprintf($format,$eligibleCourseSplit[0],$eligibleCourseSplit[1]);
            $lectures = $DB->execute($sql);
            echo $DB->getError();
            
            $this->getSection($DB, $lectures);
        }
                     
    }
    /** 
     * Check how many sections in that lecture
     * @param $DB : Live instance of the database
     * @param $lectures: Sql result form a previous cal to the server
     */
    public function getSection($DB, $lectures){
        //One or more sections
        if($lectures->num_rows>=1){
            $course = $lectures->fetch_assoc();
            $sql = "SELECT * FROM courses_Needed 
                    WHERE eligible='Y' AND lecSection != ''";
            $courseNeeded = $DB->execute($sql);
            echo $DB->getError();
            //First class to register
            if($courseNeeded->num_rows == 0){
                $format = "UPDATE courses_Needed SET registered = 'Y', lecSection='%s', lecDay='%s',
                           lecStartTime='%s', lecEndTime='%s' WHERE courseName='%s'";
                $sql = sprintf($format,$course['sequence'] ,$course['days'] ,$course['startTime'] ,$course['endTime'],
                                       $course['subject']." ".$course['courseID']);
                $DB->execute($sql);
            }
            //Classes already exist
            else{
                $hit = false;
                //Get class data
                while($row_courseNeeded = $courseNeeded->fetch_assoc()){
                    $courseDays = str_split($course['days']);
                    $courseNeededDays = str_split($row_courseNeeded['lecDay']);
                    
                    foreach($courseNeededDays as $daysCN)
                    {
                        foreach($courseDays as $daysC){
                            if($daysCN == $daysC){
                                if( ($row_courseNeeded['lecStartTime']<$course['startTime'] && $row_courseNeeded['lecEndTime']>$course['startTime']) ||
                                    ($row_courseNeeded['lecStartTime']<$course['endTime'] && $row_courseNeeded['lecEndTime']>$course['endTime']) ){
                                    $hit = true;
                                    break 3;
                                }
                            }
                        }
                    }
                }
                if($hit == false){
                    $format = "UPDATE courses_Needed SET registered = 'Y', lecSection='%s', lecDay='%s',
                               lecStartTime='%s', lecEndTime='%s' WHERE courseName='%s'";
                    $sql = sprintf($format,$course['sequence'] ,$course['days'] ,$course['startTime'] ,$course['endTime'],
                                           $course['subject']." ".$course['courseID']);
                    $DB->execute($sql);
                }
            }
        }
    }
    
    /** 
     * Prints all the non conflict courses that a student is registered into a table 
     * @param $DB : Live instance of the database
     */
    
    public function printTable($DB){
        $sql = "SELECT * FROM courses_Needed WHERE term = 'F' AND eligible = 'Y' AND registered ='Y';";
        $result_fall = $DB->execute($sql);
        echo "FALL courses:<br/><table><tr><th>CourseName</th><th>Section</th><th>Days</th><th>StartTime</th><th>EndTime</th></tr>";
        while ($courses_registered_fall = $result_fall->fetch_assoc()){
            echo "<tr><td>".$courses_registered_fall['courseName']."</td><td>".$courses_registered_fall['lecSection']."</td><td>".$courses_registered_fall['lecDay']."</td><td>".$courses_registered_fall['lecStartTime']."</td><td>".$courses_registered_fall['lecEndTime']."</td></tr>";
        }
        echo "</table><br/>";
        
        $sql = "SELECT * FROM courses_Needed WHERE term = 'W' AND eligible = 'Y' AND registered ='Y';";
        $result_winter = $DB->execute($sql);
        echo "Winter courses:<br/><table><tr><th>CourseName</th><th>Section</th><th>Days</th><th>StartTime</th><th>EndTime</th></tr>";
        while ($courses_registered_winter = $result_winter->fetch_assoc()){
            echo "<tr><td>".$courses_registered_winter['courseName']."</td><td>".$courses_registered_winter['lecSection']."</td><td>".$courses_registered_winter['lecDay']."</td><td>".$courses_registered_winter['lecStartTime']."</td><td>".$courses_registered_winter['lecEndTime']."</td></tr>";
        }
        echo "</table><br/>";
        
    }
}

?>