<?php
//session_start();
//include('dataservice.php');
include('sendMail.class.php');
$db = new dataservice();
if(isset($_POST['subLogin']))
{
	$login = $_POST['loginId'];
	$pwd = $_POST['pwd'];
	$type_of_user = $_POST['type_of_user'];
	if($type_of_user=='engg')
	{
		$query = "Select password,NoOfAttempts,locked,FirstTimeLogin from employee_details where UserId='$login'";
		$result = $db->fetch_query($query);
		if($result==null)
		{
			echo "Invalid login Id. Please go to registration page to create a login Id. <a href='http://localhost/call_center/index.php?sec=Registration'>Register here </a>";
		}
		else
		{
			$password= $result['password'];
			$noOfAttempts = $result['NoOfAttempts'];
			$locked = $result['locked'];
			if($noOfAttempts<3 && $locked == 0 )
			{
				if($password == md5($pwd))
				{
					$_SESSION['login']=$login;
					if($result['3']==0)
					{
						header("Location:index.php?sec=registration_engineer&userId='$_SESSION[login]'");
					}
					else
					{
						header("Location:index.php?sec=actionEngg ");
					}
					$query = "Update employee_details set NoOfAttempts = 0 where UserId = '$login'";
					$db->update_data($query);
					$date = Date("Y/m/d");
					$query = "insert into login (LoginId,DateOfLogin) values ('$login','$date')";
					$db->insert_data($query);
				}
				else
				{
					echo "login failed";
					$query = "Update employee_details set NoOfAttempts = $noOfAttempts + 1 where UserId = '$login'";
					$db->update_data($query);
					echo "<a href='login.html'> login </a>";
				}
			}
			if($noOfAttempts==3)
			{
				echo "Account locked. Please contact admin";
				$query = "Update employee_details set locked = 1 where UserId = '$login'";
				$db->update_data($query);
			}
		} 
	}
	else if($type_of_user=='cust')
	{
		$query = "Select password,NoOfAttempts,locked, activation from customer where LoginId='$login'";
		$result = $db->fetch_query($query);
		if($result==null)
		{
			echo "Invalid login Id. Please go to registration page to create a login Id. <a href='http://localhost/call_center/index.php?sec=registration'>Register here </a>";
		}
		else
		{
			if($result['activation']!=null)
			{
				$activation = md5(uniqid(rand(), true));
				$query = "Select email from customer where LoginId='$login'";
				$result_email = $db->fetch_query($query);
				$email = $result_email['email'];
				echo "<p id=msg> Verification has not been completed <br />
				Please check your email to complete verification process
				<p>";
				$body = "Thank You for creating Account. <br />
				Please <a href = 'http://localhost/call_center/index.php?sec=verify&email=".urlencode($email)."&key=$activation' > click here </a> to complete verification process";
				$subject = "Call Center Manager ";
				$mail=new sendMail();
				$mail->mailsend($email,$body,$subject);
				header('');
			}
			else
			{
				$password= $result['password'];
				$noOfAttempts = $result['NoOfAttempts'];
				$locked = $result['locked'];
				if($noOfAttempts<3 && $locked == 0 )
				{
					if($password == md5($pwd))
					{
						//echo "login successful";
						$_SESSION['login']=$login;
						header("Location:index.php?sec=action");
						$query = "Update customer set NoOfAttempts = 0 where LoginId= '$login'";
						$db->update_data($query);
						$date = Date("Y/m/d");
						$query = "insert into login (LoginId,DateOfLogin) values ('$login','$date')";
						$db->insert_data($query);
					}
					else
					{
						echo "login failed";
						$query = "Update customer set NoOfAttempts = $noOfAttempts + 1 where LoginId= '$login'";
						$db->update_data($query);
						echo "<a href='login.html'> login </a>";
					}
				}
				if($noOfAttempts==3)
				{
					echo "Account locked. Please contact admin";
					$query = "Update customer set locked = 1 where LoginId = '$login'";
					$db->update_data($query);
				}
			}
		}	
	}
	else if($type_of_user=='admin')
	{
		$query = "Select password,NoOfAttempts,locked from admin where LoginId='$login'";
		$result = $db->fetch_query($query);
		if($result==null)
		{
			echo "Admin Rights Required!!";
		}
		else
		{
			$password= $result['password'];
			$noOfAttempts = $result['NoOfAttempts'];
			$locked = $result['locked'];
			if($noOfAttempts<3 && $locked == 0 )
			{
				if($password == md5($pwd))
				{
					$_SESSION['login']=$login;
					header("Location:index.php?sec=adminAction");
					$query = "Update admin set NoOfAttempts = 0 where LoginId= '$login'";
					$db->update_data($query);
				}
				else
				{
					echo "login failed";
					echo "$login";
					echo "<br />$password";
					$p = md5($pwd);
					echo "<br />$p";
					$query = "Update admin set NoOfAttempts = $noOfAttempts + 1 where LoginId= '$login'";
					$db->update_data($query);
					echo "<a href='login.html'> login </a>";
				}
			}
			if($noOfAttempts==3)
			{
				echo "Account locked. Please contact admin";
				$query = "Update admin set locked = 1 where LoginId = '$login'";
				$db->update_data($query);
			}
		}	
	}
	// $db->__destruct();
}


?>