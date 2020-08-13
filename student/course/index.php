<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/database.php';
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
// instantiate database and course$course object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$course = new Course($db);
  
// query course$courses
$stmt = $course->read();
$num = $stmt->rowCount();

if($num>0){
  
    // course$courses array
    $courses_arr=array();
    $courses_arr["courses"]=array();
  
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
      
            
        $course_item=array(
            "Id" => $CourseId,
            "Client_id" => $ClientID,
            "Name" =>$CourseName,
            "createdBy" =>$CreatedBy
           
        );
  
        array_push($courses_arr["courses"], $course_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show course$courses data in json format
    echo json_encode($courses_arr, JSON_PRETTY_PRINT);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(200);
  
    // tell the user no course$courses found
    echo json_encode(
        array("message" => "No courses found.")
    );
}
