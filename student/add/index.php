<?php
// required headers
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '/opt/lampp/htdocs/apii/config/database.php';
include_once '/opt/lampp/htdocs/apii/objects/student.php';
  
$database = new Database();
$db = $database->getConnection();
  
$student = new Student($db);
if($_SERVER['REQUEST_METHOD']==='POST'){
// get posted data
$data = json_decode(file_get_contents("php://input"));


// make sure data is not empty


if(
   
    
    !empty($data->AdmissionNumber) && 
    !empty($data->FirstName) &&
    !empty($data->MiddleName) && 
    !empty($data->LastName) && 
    !empty($data->NationalID) &&   
    !empty($data->Status) && 
    !empty($data->CountyId) && 
    !empty($data->CreatedBy) 
  
){
    
  
   
    
 
    // set student property values
   
    $student->AdmissionNumber = $data->AdmissionNumber;
    $student->FirstName = $data->FirstName;
    $student->MiddleName = $data->MiddleName;
    $student->LastName = $data->LastName;
    $student->NationalID = $data->NationalID;
    $student->Status = $data->Status;
    $student->CountyId = $data->CountyId;
    $student->CreatedBy = $data->CreatedBy;
   
  
   
  
    if($student->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Student was created."));
    }
   
    

    // if unable to create the student, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(200);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create Student."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create Student. Data is incomplete."));
}

}
else{
    http_response_code(405);
    echo json_encode(array("message"=>"use correct request method"));
}



?>