<?php
	include('password.php');
	include('sendMail.class.php');
	if(isset($_SESSION['login']))
	{
		$db = new dataservice();
		$query = "Select * from admin where loginId='$_SESSION[login]'";
		$result = $db->does_exist($query);
		if($result==true)
		{
			if(isset($_POST['SubNewEngg']))
			{
				$fname=mysql_real_escape_string($_POST['fName']);
				$lname=mysql_real_escape_string($_POST['lName']);
				$email= mysql_real_escape_string($_POST['email']);
				$UserId = substr($fname,0,3);
				$UserId = $UserId.substr($lname,0,3);
				$CurrentDate= Date("Y/m/d");
				//echo $CurrentDate;
				$p = new password();
				$pass = $p->generatePassword();
				$query = "Insert into employee_details (grade,designation,department,dateOfJoining,UserId,Password,EmailId,FirstName,LastName) values ('".$_POST['grade']."','".$_POST['designation']."','".$_POST['department']."','".$CurrentDate."','".$UserId."','".md5($pass)."','".$email."','".$fname."','".$lname."') ";
				$db->insert_data($query);
				$subject = "Confirm Account";
				$body = "Welcome to ABC Call Center please login with <br />
				userName : $UserId , <br />
				password : $pass  <br />
				<a href = 'http://localhost/call_center/index.php?sec=login' > Login </a> 
				";
				$mail=new sendMail();
				$mail->mailsend($email,$body,$subject);
				header("Location:index.php?sec=adminAction");
			}
			else
			{
?>
					<script type="text/javascript">

						function validate()
						{
							var fname = document.newEngg.fName;
							if(isEmpty(fname))
							{
								alert("First name cannot be empty");
								fname.focus();
								return false;
							}
							if(isAlphabet(fname)==false)
							{
								alert("First name cannot contain numbers");
								fname.focus();
								return false;
							}
							
							var lname = document.newEngg.lName;
							if(isEmpty(lname))
							{
								alert("Last name cannot be empty");
								lname.focus();
								return false;
							}
							if(isAlphabet(lname)==false)
							{
								alert("Last name cannot contain numbers");
								fname.focus();
								return false;
							}
							var email = document.newEngg.email;
							if(isEmpty(email)==true)
							{
								alert("Email address cannot be empty");
								email.focus();
								return false;
							}
							if(isEmail(email)==false)
							{
								alert("Not a valid e-mail address");
								email.focus();
								return false;
							}
							
							return true;
						}

						function isEmpty(str)
						{
							var str1 = str.value;
							if(str1.length==0)
							{
								return true;
							}
							return false;
						}

						function isAlphabet(str)
						{
							var alphaExp = /^[a-zA-Z]+$/;
							if(str.value.match(alphaExp)){
								return true;
							}
							return false;
						}
						
						function isEmail(str)
						{
							var x = str.value;
							var atpos=x.indexOf("@");
							var dotpos=x.lastIndexOf(".");
							if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
							{
								return false;
							}
							return true;
						}

						</script>

				</head>
				<body>
					<br />
<br />
<h3 style="left:50px;  position:relative;">
	Add New Engineer
</h3>
<br />
<br />
<br />
<br />
					<form name="newEngg" method = "post" action = "index.php?sec=NewEngg" onsubmit = "return validate();">
						<table border = "1" cellpadding = "2" cellspacing = "2">
							<tr>
								<td>First Name :</td>
								<td><input type="text" name="fName" /></td>
							</tr>
							<tr>
								<td>Last Name :</td>
								<td><input type="text" name="lName" /></td>
							</tr>
							<tr>
								<td>Email Id :</td>
								<td><input type="email" name="email" /></td>
							</tr>
							<tr>
								<td>Grade</td>
								<td>
									<select name="grade">
										<option value="L1">L1</option>
										<option value="L2">L2</option>
										<option value="L3">L3</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Designation</td>
								<td>
									<select name="designation">
										<option value="TL">Team Lead</option>
										<option value="JE">Junior Engineer</option>
										<option value="SE">Senior Engineer</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Department</td>
								<td>
									<select name="department">
										<option value="Finance">Finance</option>
										<option value="HR">Human Resource</option>
										<option value="Tech">Technical</option>
										<option value="Marketing">Marketing</option>
									</select>
								</td>	
							</tr>	
							<tr>
								<td><input type="submit" name="SubNewEngg" value="Submit" /></td>
								<td><input type="reset" name="reset" value="Cancel"</td>
							</tr>
						</table>
					</form>
				</body>
		</html>
				
<?php
				}
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