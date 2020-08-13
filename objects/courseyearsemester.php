<?php
class CourseyrSemester{
  
    // database connection and table name
    private $conn;
    private $table_name = "CourseYearSemesters";
  
    // object properties
    public   $CourseYearSemestersId;
    public  $CourseId;
    public $CourseSemesterId;
    public $ClientID;
    public $CreatedOn;
    public $CreatedBy;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    // select all query
    $query = "SELECT 
                CourseYearSemestersId,CourseId,CourseSemesterId,ClientID,CreatedBy
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
#CourseId,ClientID, CourseName,CreatedOn CreatedBy
function create(){


  // query to insert record
  $query = "INSERT INTO
  
              " . $this->table_name . "
          SET
          CourseId=:CourseId, ClientID=:ClientID, CourseName=:CourseName, CreatedOn=:CreatedOn,CreatedBy=:CreatedBy";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->CourseId=htmlspecialchars(strip_tags($this->CourseId));
  $this->ClientID=htmlspecialchars(strip_tags($this->ClientID));
  $this->CourseName=htmlspecialchars(strip_tags($this->CourseName));
  $this->CreatedOn= date('Y-m-d H:i:s');
  $this->CreatedBy=htmlspecialchars(strip_tags($this->CreatedBy));

  // bind values
  $stmt->bindParam(":CourseId", $this->CourseId);
  $stmt->bindParam(":ClientID", $this->ClientID);
  $stmt->bindParam(":CourseName", $this->CourseName);
  $stmt->bindParam(":CreatedOn", $this->CreatedOn);
  $stmt->bindParam(":CreatedBy", $this->CreatedBy);
 
  
  
  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;
    
}
// update the product

function update(){
  #CourseId,ClientID, CourseName,CreatedOn CreatedBy
    // update query
    $query = "UPDATE
    " . $this->table_name . "
SET
CourseName = :CourseName   
WHERE
    CourseId = :CourseId";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    
  
    // sanitize
    $this->CourseId=htmlspecialchars(strip_tags($this->CourseId));
    $this->CourseName=htmlspecialchars(strip_tags($this->CourseName));
   # $this->CreatedOn= date('Y-m-d H:i:s');
   
    // bind new values
    $stmt->bindParam(':CourseId', $this->CourseId);
    $stmt->bindParam(':CourseName', $this->CourseName);
    #$stmt->bindParam(':CreatedOn', $this->CreatedOn);
 
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the product

// delete the product
function delete(){
  
  // delete query
  $query = "DELETE FROM " . $this->table_name . " WHERE CourseId = ? ";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->CourseId=htmlspecialchars(strip_tags($this->CourseId));

  // bind Id of record to delete
  $stmt->bindParam(1, $this->CourseId);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;
}
// search students

function search($keywords){
    #CourseId,ClientID, CourseName,CreatedOn CreatedBy
  
    // select all query
    $query = "SELECT
     CourseId,ClientID, CourseName, CreatedBy
FROM
    " . $this->table_name ."
            WHERE
                CourseName LIKE ? OR CourseId LIKE ? 
            ORDER BY
            CourseId DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
  
  
    // execute query
    $stmt->execute();
  
    return $stmt;
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
