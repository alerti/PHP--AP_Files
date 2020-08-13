<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
  
// get database connection
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate student object
include_once '/opt/lampp/htdocs/api/objects/student.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare student object
$student = new Student($db);
  
// set ID property of record to read
$student->id = isset($_GET['StudentId']) ? $_GET['StudentId'] : die();
 
// read the details of student to be edited
$student->readOne();
  
if($student->First_Name!=null){
  
    $student_arr = array(
        "StudentId" => $StudentId,
        "ClientID" => $ClientID,
        "AdmissionNumber" => $AdmissionNumber,
        "FirstName" => $FirstName,
        "MiddleName" => $MiddleName,
            "LastName" => $LastName,
            "NationalID" => $NationalID,
            "Status" => $Statusi,
            "CountyId" => $CountyId,
            "CreatedOn" => $CreatedOn,
            "CreatedBy" => $CreatedBy
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($student_arr);
}



  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user student does not exist
    echo json_encode(array("message" => "student does not exist."));
}
 
?>