<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate student object
include_once '/opt/lampp/htdocs/api/objects/student.php';
  

$database = new Database();
$db = $database->getConnection();


if ($_SERVER['REQUEST_METHOD'] == 'PUT'){

$student = new Student($db);
  

$data = json_decode(file_get_contents("php://input"));


$student->id = $data->id;
$student->First_Name = $data->First_Name;
$student->Middle_Name = $data->Middle_Name;
$student->Last_Name = $data->Last_Name;
$student->Date_Birth = $data->Date_Birth;
$student->NationalId = $data->NationalId;
$student->county = $data->county;
$student->Country = $data->Country;
$student->course = $data->course;
$student->Time_to_register = $data->Time_to_register;

if($student->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "student was updated."));
}

else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update student."));
}
}

else{
    http_response_code(404);
    echo json_encode(array("message" =>"not found. we suggest {PUT} method"));
exit;
}



?>