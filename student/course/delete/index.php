<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate course object
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$course = new Course($db);
  
// get course Id
$data = json_decode(file_get_contents("php://input"));
  
// set course Id to be deleted
$course->CourseId = $data->Id;

  
// delete the course
if($course->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "course was deleted."));
}
  
// if unable to delete the course
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete course."));
}
?>