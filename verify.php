<?php
if (isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',
 $_GET['email'])) {
 $email = $_GET['email'];
}
if (isset($_GET['key']) && (strlen($_GET['key']) == 32))
 //The Activation key will always be 32 since it is MD5 Hash
 {
 $key = $_GET['key'];
}

if (isset($email) && isset($key)) {

 // Update the database to set the "activation" field to null
	
	$db = new dataservice();
	
	 $query_activate_account = "UPDATE customer SET Activation=NULL WHERE(Email ='$email' AND Activation='$key')LIMIT 1";
	 //echo $query_activate_account;
	 $result_activate_account = $db->update_data($query_activate_account);

 // Print a customized message:
 if ($result_activate_account == 1) //if update query was successfull
 {
 echo '<div><p id=msgSuccess>Your account is now active. You may now <a href="http://localhost/call_center/index.php?sec=login">Log in</a></p></div>';

 } else {
 echo '<div><p id=msg>Oops !Your account could not be activated. Please recheck the link or contact the system administrator.</p></div>';

 }

// $db->__destruct();

} else {
 echo '<div><p id=msg>Error Occured .</p></div>';
}

?>