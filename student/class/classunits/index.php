<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
include_once '/opt/lampp/htdocs/api/config/database.php';
include_once '/opt/lampp/htdocs/api/objects/classunits.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 
// instantiate database and applicant object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$applicant = new ClassUnits($db);
  
// query StudentApplication
$stmt = $applicant->read();
$num = $stmt->rowCount();

if($num>0){
  
    // applicants array
    $applications=array();
    $applications["Units"]=array();
  
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
      
        // object properties
        $application_item=array(
          "ClassUnitsId"=> $ClassUnitsId,
          "ClassId"=>  $ClassId,
          "AcademicYearSemestersId"=>  $AcademicYearSemestersId,
          "CourseYearSemestersUnitsId"=> $CourseYearSemestersUnitsId,
          "CreatedBy"=>   $CreatedBy
          
       
       
        );
  
        array_push($applications["Units"], $application_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show applicants data in json format
    echo json_encode($applications,JSON_PRETTY_PRINT);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no applicants found
    echo json_encode(
        array("message" => "No Units found.")
    );
}
 }
 else{
     http_response_code(405);
     echo json_encode(array("message" => "use correct request method"));
 }
