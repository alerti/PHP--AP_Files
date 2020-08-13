<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/core.php';
  
// get database connection
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate student object
include_once '/opt/lampp/htdocs/api/objects/student.php';
  
  
// instantiate database and student object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$student = new Student($db);
  
// get keywords
$keywords=isset($_GET["id"]) ? $_GET["id"] : "";
  
// query students
$stmt = $student->search($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // students array
    $students_arr=array();
    $students_arr["Students"]=array();
  
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
  
        $student_item=array(
           
            "StudentId" => $StudentId,
            "ClientID" => $ClientID,
            "AdmissionNumber" => $AdmissionNumber,
            "FirstName" => $FirstName,
            "MiddleName" => $MiddleName,
            "LastName" => $LastName,
            "NationalID" => $NationalID,
            "Status" => $Status,
            "CountyId" => $CountyId,
            "CreatedOn" => $CreatedOn,
            "CreatedBy" => $CreatedBy
        
        );
  
        array_push($students_arr["Students"], $student_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    
    echo json_encode($students_arr, JSON_PRETTY_PRINT);
   
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no students found
    echo json_encode(
        array("message" => "No students found.")
    );
}
?>