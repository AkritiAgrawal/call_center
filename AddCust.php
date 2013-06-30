<?php
include('sendMail.class.php');
$db= new dataservice();

if($_POST['SubAddCust']=='Submit')
{
	$loginId=mysql_real_escape_string($_POST['loginId']);
	$query = "Select FirstName from Customer where LoginId='$loginId'";
	$x = $db->does_exist($query);
	if($x==0)
	{
		$fname=mysql_real_escape_string($_POST['fName']);
		$mname=mysql_real_escape_string($_POST['mName']);
		$lname=mysql_real_escape_string($_POST['lName']);
		$pwd = md5($_POST['pwd']);
		$email= mysql_real_escape_string($_POST['email']);
		$mobileNo=$_POST['mobileNo'];
		$day=$_POST['daydropdown'];
	//	echo $day;
		$month=$_POST['monthdropdown'];
		$year=$_POST['yeardropdown'];
		$gender=$_POST['gender'];
		if($gender=='male')
		{
			$gender=0;
		}
		else
		{
			$gender=1;
		}
		$country=$_POST['country'];
		$state=mysql_real_escape_string($_POST['state']);
		$city=mysql_real_escape_string($_POST['city']);
		$date=$year."/".$month."/".$day;
		$CurrentDate= Date("Y/m/d");
		$activation = md5(uniqid(rand(), true));
		$query="insert into Customer (FirstName,MiddleName,LastName,LoginId,Password,Email,MobileNo,DateOfBirth,Gender,Country,State,City,DateOfCreation,locked,noOfAttempts,activation) values('$fname','$mname','$lname','$loginId','$pwd','$email','$mobileNo','$date','$gender','$country','$state','$city','$CurrentDate',0,0,'$activation')";
		
		$x=$db->insert_data($query);
		
		if($x==1)
		{
			echo "<p id=msgSuccess>Registered Successfully <br />
			Please check your email to confirm verification process
			</p>";
			$body = "Thank You for creating Account. <br />
			Please <a href = 'http://localhost/call_center/index.php?sec=verify&email=".urlencode($email) . "&key=$activation' > click here </a> to complete verification process";
			$subject = "Call Center Manager ";
			$mail=new sendMail();
			$mail->mailsend($email,$body,$subject);
		}
		else
		{
			echo "<p id=msg>Registration failed please contact administrator</p>";
		}
	}
	else
	{
		echo "<p id=msg>Login Id already exists. Please choose another id</p>";
	}
}
?>