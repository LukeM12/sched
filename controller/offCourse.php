<?php
populateCoursesTaken();
/*
 * Description :Store the classes that the user specified that they took in the DB 
 * return: If the courses effectively got added the the uni db
 */
function populateCoursesTaken(){

    $login = $_COOKIE['user'];
    $classesTaken = array();
    $connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
    
    foreach ($_POST['class'] as $taken) {
        array_push($classesTaken, $taken);
    	$sql = "INSERT INTO courses_Taken (studentID, courseName) VALUES ('$login', '$taken');";
        $connection->query($sql);
        /*if($connection->query($sql)){
            echo "The record is added";
        }
        else{
            echo "The record cannot be added ". mysqli_error($connection);
        }*/
    }
    //print_r($classesTaken);
    header('Refresh:1;url=/controller/viewPrintCourses.php');
}







?>
