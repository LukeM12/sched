<?php

class Schedule {

    public function __construct($studentID, $DB) {
        $this->studentID = $studentID;
        $this->DB = $DB;
    }
    
    public function fetchAssocFromTable($tableName) {
        $sql = "SELECT * FROM ".$tableName." WHERE studentID='".$this->studentID."';";
        $result = $this->DB->execute($sql);
        return $result->fetch_assoc();
    }
    
    public function setSectionInCoursesNeeded(){
        fetchAssocFromTable('courses_Needed');
    }
}

?>