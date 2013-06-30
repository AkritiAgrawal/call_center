<?php
$db= new dataservice();

if($_POST['SubAddEngg']=='Submit')
{
	$query = "Select EmpCode from Employee_details where UserId='$_SESSION[login]'";
	$x = $db->fetch_query($query);
	$empCode = $x['EmpCode'];
	if($x!=null)
	{
		$pwd = md5($_POST['pwd']);
		$mobileNo=$_POST['mobileNo'];
		$day=$_POST['daydropdown'];
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
		$query="insert into Engineer_personal_details (EmpCode,MobileNo,DateOfBirth,Gender,Country,State,City,DateOfCreation) values('$empCode','$mobileNo','$date','$gender','$country','$state','$city','$CurrentDate')";
		$x=$db->insert_data($query);
		if($x==1)
		{
			$query = "Update employee_details set password = '$pwd' , FirstTimeLogin = '1' where UserId = '$_SESSION[login]'";
			$x = $db -> update_data($query);
			//echo $query;
			echo "<p id=msgSuccess>Password changed successfully <br />";
			echo "<a href='index.php?sec=login'> Login again </a></p>";
		}
		else
		{
			echo "<p id=msg>Registration failed please contact administrator</p>";
		}
	}
}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}

?>