<?php
require_once  __DIR__.'\DB_Function.php';
$db = new DB_Function();

//json response array
$response=array("error" => FALSE);
 echo"if will enter";

if(isset($_GET['Name']) && isset($_GET['ID']) && isset($_GET['Email'])){
//receiving   the post params
	$Name=$_GET['Name'];
	$ID=$_GET['ID'];
	$Email=$_GET['Email'];
		
     //check if user is already existed with the same phone number

	 if($db->isUserExisted($Email)){
        //user already existed
	
      $response["error"] = TRUE;
      $response["error_msg"] = "User already existed with".$Email;
      echo json_encode($response);
      }
      else{
     //create a new user
          $user=$db->storeUser($Name,$ID,$Email);
             if($user){

	             $response["error"] = FALSE;
	             $response["user_info"]["Name"]= $user["Name"];
	             $response["user_info"]["ID"]= $user["ID"];
	             $response["user_info"]["Email"]= $user["Email"];
	             echo json_encode($response);
                 }
             else{
             //user failed to store
             $response["error"]=TRUE;
	         $response["error_msg"]="Unknown error occured in registration!";
	         echo json_encode($response);
            }

        }
    }
	
     else{
	 $response["error"]=TRUE;
	 $response["error_msg"]="Required parameters(Name,ID,Email)is missing";
	 echo json_encode($response);
    }
	
?>