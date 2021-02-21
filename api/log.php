<?php
require_once 'DB_Function.php';
$db=new DB_Function();

//json response array
$response=array("error"=>FALSE);//get the user 

if(isset($_GET['ID'] ))
	  {

//receive post param
	$ID = $_GET['ID'];



	
	$user = $db->getUser($ID);
     
	if($user!=false) 
	{
//user is found
	$response["error"] = FALSE;
	$response["user_info"]["Name"]= $user["Name"];
	$response["user_info"]["ID"]= $user["ID"];
	$response["user_info"]["Email"]= $user["Email"];
	echo json_encode($response);
  }
else{
//user is not found with the credentials

$response["error"]=TRUE;
$response["error_msg"]="Login credentials are Wrong.Please try again!";
echo json_encode($response);
}
	 }
else{
//required post params is missing
$response["error"]=TRUE;
$response["error_msg"]="Required parameters are missing!";
echo json_encode($response);
}

?>
