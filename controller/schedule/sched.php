<?php

class Schedule{

    private $studentID;
    private $DB;

    public function __construct($studentID,$DB) {
        $this->studentID = $studentID;
        $this->DB = $DB;
    }
    
    public function setSectionInCoursesNeeded($DB){
        $sql = "SELECT * FROM courses_Needed WHERE studentID='".$this->studentID."' AND eligible='Y' AND term='F';";
        $eligibleClass = $DB->execute($sql);
        if(!$eligibleClass)
        {
            echo "NO RESULT";
        }
        while($row_eligibleClass = $eligibleClass->fetch_assoc()){
            $eligibleCourseSplit = explode(" ",$row_eligibleClass['courseName']);
            $format = "SELECT * FROM course WHERE subject='%s' AND courseID='%s' AND term='F' AND instruction_type='LEC';";
            $sql = sprintf($format,$eligibleCourseSplit[0],$eligibleCourseSplit[1]);
            //echo $row_eligibleClass['courseName']." ".$row_eligibleClass['term']."-------------<br/>";
            $lectures = $DB->execute($sql);
            echo $DB->getError();
            
            $this->getSection($DB, $lectures);
            /*while($row_courseInfo = $courseInfo->fetch_assoc()){
                echo $row_courseInfo['subject']." ".$row_courseInfo['courseID'].$row_courseInfo['sequence']." ".$row_courseInfo['term']." ".$row_courseInfo['startTime']."<br/>";
                if()
            }*/
            echo "<br/>";
        }
                     
    }
    
    public function getSection($DB, $lectures){
        
        //Check how many sections in that lecture
        //Only one section
        if($lectures->num_rows==1){
            $course = $lectures->fetch_assoc();
            $sql = "SELECT * FROM courses_Needed 
                    WHERE eligible='Y' AND lecSection != ''";
            $courseNeeded = $DB->execute($sql);
            echo $DB->getError();
            //First class to register
            if($courseNeeded->num_rows == 0){
                $format = "UPDATE courses_Needed SET lecSection='%s', lecDay='%s',
                           lecStartTime='%s', lecEndTime='%s' WHERE courseName='%s'";
                $sql = sprintf($format,$course['sequence'] ,$course['days'] ,$course['startTime'] ,$course['endTime'],
                                       $course['subject']." ".$course['courseID']);
                $DB->execute($sql);
            }
            else{
                $hit = false;
                while($row_courseNeeded = $courseNeeded->fetch_assoc()){
                    $courseDays = str_split($course['days']);
                    $courseNeededDays = str_split($row_courseNeeded['lecDay']);
                    
                    foreach($courseNeededDays as $daysCN)
                    {
                        foreach($courseDays as $daysC){
                            if($daysCN == $daysC){
                                if(($row_courseNeeded['lecEndTime']>$course['startTime']) && ($row_courseNeeded['lecStartTime']<$course['endTime'])){
                                    $hit = true;
                                    break 3;
                                }
                            }
                        }
                    }
                }
                if($hit == false){
                    $format = "UPDATE courses_Needed SET lecSection='%s', lecDay='%s',
                               lecStartTime='%s', lecEndTime='%s' WHERE courseName='%s'";
                    $sql = sprintf($format,$course['sequence'] ,$course['days'] ,$course['startTime'] ,$course['endTime'],
                                           $course['subject']." ".$course['courseID']);
                    $DB->execute($sql);
                }
            }
        }
        elseif($lectures->num_rows>1){
        }
    }
    
    
}

?>