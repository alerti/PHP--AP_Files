<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
  
// get database connection
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate student object
include_once '/opt/lampp/htdocs/api/objects/student.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare student object
$student = new Student($db);
  
// get student id
$data = json_decode(file_get_contents("php://input"));
  
// set student id to be deleted
$student->StudentId = $data->StudentId;
  
// delete the student
if($student->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "student was deleted."));
}
  
// if unable to delete the student
else{
  
    // set response code - 503 service unavailable
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete student."));
}
?>