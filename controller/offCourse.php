<?php

//$da = json_decode(stripslashes($_POST['data']));
$data = $_POST['data'];
$classes = $pieces = explode("$", $data);
foreach ($classes as $value) {
    echo $value;
}
  // here i would like use foreach:

  //foreach($da as $d){
   //  echo $d;
  //}
populateCoursesTaken($classes);

/**
 * Description :Store the classes that the user specified that they took in the DB 
 * return: If the courses effectively got added the the uni db
 */
function populateCoursesTaken($data){

    $login = $_COOKIE['user'];
    $classesTaken = array();
    $connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
    
    foreach ($data as $taken) {
        array_push($classesTaken, $taken);
    	$sql = "INSERT IGNORE INTO courses_Taken (studentID, courseName) VALUES ('$login', '$taken');";
        $connection->query($sql);
    }
    header('Refresh:1;url=/controller/viewPrintCourses.php');
}







?>
