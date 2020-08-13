<?php
class StudentRegister{
  
    // database connection and table name
    private $conn;
    private $table_name = "StudentRegistration";

  
    // object properties
    public $StudentRegistrationId;
    public $StudentApplicationId;
    public $ClientID;
    public $StudentId;
    public $ClassId;
  
    public $CreatedOn;
    public $CreatedBy;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
  
    // select all query
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $query = "SELECT
                	StudentRegistrationId,StudentApplicationId,ClientID,StudentId,ClassId,CreatedBy
            FROM
                " . $this->table_name . " 
            ORDER BY
            CreatedOn DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
else{
    http_response_code(405);
    echo json_encode(array("message" =>"use correct request method. we suggest GET"));
}
}
// create product 

function create(){
  
    function uniqidReal($lenght = 13) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
      }
      function cliedntid(){
        $key = uniqid();
        $key2=hexdec($key);
        return ceil($key2);
      }
   // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
            StudentId=:StudentId,ClientID=:ClientID, AdmissionNumber=:AdmissionNumber, FirstName=:FirstName, MiddleName=:MiddleName, LastName=:LastName,NationalID=:NationalID,Status=:Status,CountyId=:CountyId,CreatedOn=:CreatedOn,CreatedBy=:CreatedBy";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->StudentId=uniqidReal();
    $this->ClientID=cliedntid();
    $this->AdmissionNumber=htmlspecialchars(strip_tags($this->AdmissionNumber));
    $this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
    $this->MiddleName=htmlspecialchars(strip_tags($this->MiddleName));
    $this->LastName=htmlspecialchars(strip_tags($this->LastName));
    $this->NationalID=htmlspecialchars(strip_tags($this->NationalID));
    $this->Status=htmlspecialchars(strip_tags($this->Status));
    $this->CountyId=htmlspecialchars(strip_tags($this->CountyId));
    $this->CreatedOn= date('Y-m-d H:i:s');
    $this->CreatedBy=htmlspecialchars(strip_tags($this->CreatedBy));
  
  
    // bind values
    $stmt->bindParam(":StudentId", $this->StudentId);
    $stmt->bindParam(":ClientID", $this->ClientID);
    $stmt->bindParam(":AdmissionNumber", $this->AdmissionNumber);
    $stmt->bindParam(":FirstName", $this->FirstName);
    $stmt->bindParam(":MiddleName", $this->MiddleName);
    $stmt->bindParam(":LastName", $this->LastName);
    $stmt->bindParam(":NationalID", $this->NationalID);
    $stmt->bindParam(":Status", $this->Status);
    $stmt->bindParam(":CountyId", $this->CountyId);
    $stmt->bindParam(":CreatedOn", $this->CreatedOn);
    $stmt->bindParam(":CreatedBy", $this->CreatedBy);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}



// used when filling up the update product form 

function readOne(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    // query to read single record
    $query = "SELECT
                StudentId,ClientID,AdmissionNumber,FirstName,MiddleName,LastName,NationalID,Status,CountyId,CreatedOn,	CreatedBy
            FROM
                " . $this->table_name ."
            WHERE
            StudentId = ?
            LIMIT
                0,1";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind id of product to be updated
    $stmt->bindParam(1, $this->StudentId);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->StudentId = $row['StudentId'];
    $this->ClientID = $row['ClientID'];
    $this->AdmissionNumber = $row['AdmissionNumber'];
    $this->FirstName = $row['FirstName'];
    $this->MiddleName = $row['MiddleName'];
    $this->LastName = $row['LastName'];
    $this->NationalID = $row['NationalID'];
    $this->Status = $row['Status'];
    $this->CountyId = $row['CountyId'];
    $this->CreatedOn = $row['CreatedOn'];
    $this->CreatedBy = $row['CreatedBy'];
}
else{
    http_response_code(405);
    echo json_encode(array("message" =>"use correct request method. we suggest GET"));
}
}
// update the product

function update(){
   
    // update query
    $query = "UPDATE
                " . $this->table_name . "  
            SET 
             
                ClientID = :ClientID,
                AdmissionNumber = :AdmissionNumber,
                FirstName = :FirstName,
                MiddleName = :MiddleName,
                LastName = :LastName,
                NationalID = :NationalID,
                Status = :Status,
                CountyId = :CountyId,
                CreatedOn=:CreatedOn
                CreatedBy=:CreatedBy
            
            WHERE
            StudentId = :StudentId";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    
   
    // sanitize
    $this->StudentId=htmlspecialchars(strip_tags($this->StudentId));
    $this->ClientID=htmlspecialchars(strip_tags($this->ClientID));
    $this->AdmissionNumber=htmlspecialchars(strip_tags($this->AdmissionNumber));
    $this->FirstName=htmlspecialchars(strip_tags($this->FirstName));
    $this->MiddleName=htmlspecialchars(strip_tags($this->MiddleName));
    $this->LastName=htmlspecialchars(strip_tags($this->LastName));
    $this->NationalID=htmlspecialchars(strip_tags($this->NationalID));
    $this->Status=htmlspecialchars(strip_tags($this->Status));
    $this->CountyId=htmlspecialchars(strip_tags($this->CountyId));
    $this->CreatedOn=htmlspecialchars(strip_tags($this->CreatedOn));
    $this->CreatedBy=htmlspecialchars(strip_tags($this->CreatedBy));
    
  
   
    // bind new values
    $stmt->bindParam(':StudentId', $this->StudentId);
    $stmt->bindParam(':ClientID', $this->ClientID);
    $stmt->bindParam(':AdmissionNumber', $this->AdmissionNumber);
    $stmt->bindParam(':FirstName', $this->FirstName);
    $stmt->bindParam(':MiddleName', $this->MiddleName);
    $stmt->bindParam(':LastName', $this->LastName);
    $stmt->bindParam(':NationalID', $this->NationalID);
    $stmt->bindParam(':Status', $this->Status);
    $stmt->bindParam(':CountyId', $this->CountyId);
    $stmt->bindParam(':CreatedOn', $this->CreatedOn);
    $stmt->bindParam(':CreatedBy', $this->CreatedBy);
   
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;

}

// delete the product

// delete the product
function delete(){
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE StudentId = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->StudentId=htmlspecialchars(strip_tags($this->StudentId));
  
    // bind StudentId of record to delete
    $stmt->bindParam(1, $this->StudentId);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}

// search students

function search($keywords){
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    // select all query
    $query = "SELECT
     StudentId,ClientID,AdmissionNumber,FirstName,MiddleName,LastName,NationalID,Status,CountyId,CreatedOn,	CreatedBy
FROM
    " . $this->table_name ."
            WHERE
            FirstName LIKE ? OR StudentId LIKE ? OR LastName LIKE ?
            ORDER BY
            CreatedOn DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
/*
// read students with pagination
public function readPaging($from_record_num, $records_per_page){
  
    // select query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  
    // execute query
    $stmt->execute();
  
    // return values from database
    return $stmt;
}
// used for paging students
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    return $row['total_rows'];
} */
}
?>
