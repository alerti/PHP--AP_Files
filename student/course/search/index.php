<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/core.php';
include_once '/opt/lampp/htdocs/api/config/database.php';
  
// instantiate course object
include_once '/opt/lampp/htdocs/api/objects/course.php';
  
// instantiate database and course object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$course = new Course($db);
  
// get keywords
$keywords=isset($_GET["name"]) ? $_GET["name"] : "";
  
// query courses
$stmt = $course->search($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // courses array
    $courses_arr=array();
    $courses_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $course_item=array(
           
            "Id" => $CourseId,
            "Client_id" => $ClientID,
            "Name" =>$CourseName,
            "createdBy" =>$CreatedBy
        
        );
  
        array_push($courses_arr["records"], $course_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show courses data
    echo json_encode($courses_arr,JSON_PRETTY_PRINT);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no courses found
    echo json_encode(
        array("message" => "No courses found.")
    );
}
?>