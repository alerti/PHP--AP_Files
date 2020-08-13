<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate course object
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
$database = new Database();
$db = $database->getConnection();
  
$course = new Course($db);
if($_SERVER['REQUEST_METHOD']==='POST'){
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty

if(
  
    !empty($data->Id) &&
    !empty($data->Client_id)&&
    !empty($data->Name) &&
    !empty($data->createdBy) 
    
){
    // set course property valu
  
    $course->CourseId = $data->Id;
    $course->ClientID = $data->Client_id;
    $course->CourseName = $data->Name;
    $course->CreatedBy= $data->createdBy;
    
   
  
    // create the course
    if($course->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "course was created."));
    }
  
    // if unable to create the course, tell the user
    else{
  

        http_response_code(200);
  
        // tell the user
        echo json_encode(array("message" => "Oops course not created.Mayb a similar course is already created? Confirm that
        else try again"));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create course. Data is incomplete."));
}
}
else{
    http_response_code(405);
    echo json_encode(array("message"=>"use correct request method"));
}
?>