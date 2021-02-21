<?php
class DB_Function {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }

/**
*Storing new user
*returns user details
*/
public function storeUser($Name,$ID,$Email){
$stmt = $this->conn->prepare("INSERT INTO user_info(Name,ID,Email) VALUES(?,?,?)");
$stmt->bind_param("sss",$Name,$ID,$Email);
$result=$stmt->execute();
$stmt->close();

if($result){

 if($stmt=$this->conn->prepare("SELECT *FROM user_info WHERE ID= ?"))
 {
    $stmt->bind_param("s",$ID);
    $stmt->execute();
    $user=$stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $user;
}
else
{
echo " DATABAse query error";

}
}
else{
return false;
	}
}

/**
*get user by mobileNumber and password
*/

public function getUser($ID){

$stmt=$this->conn->prepare("SELECT * FROM user_info WHERE ID=?");
$stmt->bind_param("s",$ID);
	
	
	if($stmt->execute()){
		$user=$stmt->get_result()->fetch_assoc();
		$stmt->close();

//verifying user password-

	$server_ID=$user['ID'];

//check for password equality

	if($server_ID==$ID){

//user authentication details are correct

	return $user;

	}
   }
	
else{

    return NULL;
	}
}
  

public function isUserExisted($Email){

$stmt=$this->conn->prepare("SELECT * from user_info WHERE Email=?");
$stmt->bind_param("s",$Email);
$stmt->execute();
$stmt->store_result();

	if($stmt->num_rows>0){
//user existed
	$stmt->close();
return true;
}
else{
//user not existed 
$stmt->close();
return false;
	}
}

public function getAllUser(){
$stmt=$this->conn->prepare("SELECT * FROM user_info ");

	if($stmt->execute()){
$rows=array();
$result=$stmt->get_result();
while($r=$result->fetch_assoc()){

$rows[]=$r;
}

print json_encode($rows);
$stmt->close();
}
 else{

return NULL;

}
}

?>

