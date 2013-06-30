<?php
include('sendMail.class.php');
if(isset($_SESSION['login']))
	{
		$db = new dataservice();
		$query = "Select * from admin where loginId='$_SESSION[login]'";
		$result = $db->does_exist($query);
		if($result==true)
		{
			$query = "Update request set enggId = '$_POST[EmpCode]', status = 'A' where requestId = $_POST[reqId] ";
			$result = $db->update_data($query);
			$query = "Select CustId from request where requestId = $_POST[reqId]";
			$result = $db->fetch_query($query);
			$query = "Select email from customer where loginId = '$result[CustId]'";
			$result = $db->fetch_query($query);
			$body = "Your request $_POST[reqId] is being handled by one of our competent engineer. We'll get back to you very soon";
			$subject = "Call Center Manager ";
			$mail=new sendMail();
			$mail->mailsend($result['email'],$body,$subject);
			header("Location:index.php?sec=admin");
			
		}
		else
		{
			echo "<p id=msg>You are not authorised to view this page</p>";
		}
	}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}		
?>