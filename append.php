<?php
require_once('model/db.php');

$DB = new database("uni");
$sql = "SELECT * FROM student WHERE studentID='223'";
$result = $DB->execute($sql);
$DB->getError();

$user = $DB->fetchAssoc($result);
$courseTakenArray = explode(",",$user['coursesTaken']);
appendToFile($courseTakenArray, $DB);

//appendToFile($course_taken_by_user);

function appendToFile($courses_taken_array, $DB){
    $week = simplexml_load_file('week_timetable.xml');
    
    for($i = 0; $i < count($courses_taken_array); $i++){
        $course = $courses_taken_array[$i];
        $sql = "SELECT * FROM course WHERE courseID='$course'";
        $result = $DB->execute($sql);
        echo $DB->getError();
        
        $courseData = $DB->fetchAssoc($result);
        //echo $courseData['startTime'];
        
    }
}

?>