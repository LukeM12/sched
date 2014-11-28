<?php
require_once('../model/db.php');
require_once('../controller/schedule/ScheduleClass.php');
require_once('../controller/databaseManipulation.php');

$data = $_POST['data'];
$classes = $pieces = explode("$", $data);
//foreach ($classes as $value) {
//    echo $value;
//}

populateCoursesTaken($classes);

/**
 * Description :Store the classes that the user specified that they took in the DB 
 * return: If the courses effectively got added the the uni db
 */
function populateCoursesTaken($data){

    $login = $_COOKIE['user'];
    $classesTaken = array();
    $DB = new database("uni");
    
    foreach ($data as $taken) {
        array_push($classesTaken, $taken);
    	$sql = "INSERT IGNORE INTO courses_Taken (studentID, courseName) VALUES ('$login', '$taken');";
        $DB->execute($sql);
    }
    
    $sched = new Schedule($login,$DB);
    //header('Refresh:1;url=/controller/viewPrintCourses.php');
    populateCoursesNeeded_offCourse($DB);
    
}







?>
