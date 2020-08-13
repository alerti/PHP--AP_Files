<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate course object
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare course object
$course = new Course($db);
  
// set Id property of record to read
$course->Id = isset($_GET['Id']) ? $_GET['Id'] : die();
  
// read the details of course to be edited
$course->readOne();
  
if($course->title!=null){
  
    // create array
    $course_arr = array(
        "Id" =>  $course->Id,
        "title" => $course->title,
        
       
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($course_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user course does not exist
    echo json_encode(array("message" => "course does not exist."));
}
?>