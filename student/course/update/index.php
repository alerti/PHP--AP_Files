<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate course object
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
$database = new Database();
$db = $database->getConnection();
  

$course = new Course($db);
  

$data = json_decode(file_get_contents("php://input"));
#CourseId,ClientID, CourseName,CreatedOn CreatedBy
$course->CourseId = $data->Id;
$course->ClientID = $data->Client_id;
$course->CourseName = $data->Name;
$course->CreatedBy = $data->createdBy;

if($course->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "course was updated."));
}

else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update course."));
}
?>











