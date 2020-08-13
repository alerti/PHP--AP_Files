<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '/opt/lampp/htdocs/api/config/database.php';
include_once '/opt/lampp/htdocs/api/objects/units.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET'){ 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$product = new Units($db);
  
// query student
$stmt = $product->read();
$num = $stmt->rowCount();

if($num>0){
  
    // products array
    $products_arr=array();
    $products_arr["Units"]=array();
  
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
      
      
        $product_item=array(
            "UnitId" => $UnitId,
            "ClientID" => $ClientID,
            "UnitName" => $UnitName,
            "UnitHours" => $UnitHours,
            "CreatedBy" => $CreatedBy
        );
  
        array_push($products_arr["Units"], $product_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($products_arr,JSON_PRETTY_PRINT);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No units found.")
    );
}
 }
 else{
     http_response_code(405);
     echo json_encode(array("message" => "use correct request method"));
 }
