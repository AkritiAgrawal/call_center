<?php
if(isset($_SESSION['login']))
{
	$db = new dataservice();
	$query = "Select FirstName from customer where LoginId='$_SESSION[login]'";
	$result = $db->fetch_query($query);
	if($result!=null)
	{
		if(isset($_POST['CallMe']))
		{
			$phNo= mysql_real_escape_string($_POST['PhNo']);
			$time=$_POST['timeToCall'];
			$date = Date("Y/m/d");
			$query = "insert into CallBack (CustId,Status,DateOfSubmission,PhoneNo,timeToContact) values ('$_SESSION[login]','O','$date','$phNo','$time')";
			$pk = $db->insertdata_with_pkreturn($query);
			echo "<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />";
			echo "<p id=msgSuccess>Thank you for contacting us.
			<br />We'll call you on the number and time you want.</p>";
			$query = "Select EmpCode from employee_details where Grade != 'L1' and  ReqCount = (SELECT MIN( reqCount ) FROM employee_details where grade !='L1' ) ";
			$result = $db->fetch_query($query);
		//	echo $query;
			$query = "Update CallBack set EnggId = '$result[EmpCode]',status = 'A' where CallBackId = '$pk' " ;
			//echo $query;
			$db->update_data($query); 
			$query = "Update employee_details set ReqCount = ReqCount + 1 where EmpCode = '$result[EmpCode]' " ;
			$db->update_data($query); 
		}
		else
		{
?>
<script type="text/javascript">

	function validate()
	{
		var mobile = document.CallBack.PhNo;
		
		if(isEmpty(mobile)==false)
		{
			if(isNumber(mobile)==false)
			{
				alert("Phone number should be numeric");
				mobile.focus();
				return false;
			}
			if(isMobile(mobile.value)==false)
			{
				alert("Mobile Number should contain 10 digits only");
				mobile.focus();
				return false;
			}
		}
		else
		{
			alert("In Validate"+ mobile);
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
	function isMobile(str)
	{
		if(str.length==10)
		{	
			return true;
		}
		return false;
	}
	function isNumber(str)
	{
		if(isNaN(str.value)==true)
		{
			return false;
		}
		return true;
	}
</script>
			<br />
			<br />
			<h3 style="left:100px;  position:relative;">
				Request a Call Back
			</h3>
			<br />
			<br />
			<br />
			<br />
			<p>
			<b>Phone</b>
			</p>
			<p>Call our toll-free Customer Service number:</p>
			<br />
			<br />
			<p>
			To talk with us, please enter your phone number.</p>
			<p>(You'll need an open phone line to receive this call)
			</p>
			<br />
			<br />
			<p>Your Number:</p>
			<form name="CallBack" action="index.php?sec=ClickToCallBack" method="post" onsubmit="return validate();">
				<table>
					<tr>
						<td>	
							<input name="PhNo" type="text" />
						</td>
					</tr>
					<tr>
						<td>	
							<p>When to Call: </p>
						</td>
						<td>	
							<Select name="timeToCall">
								<option value="0:00">0:00</option>
								<option value="0:30">0:30</option>
								<option value="1:00">1:00</option>
								<option value="1:30">1:30</option>
								<option value="2:00">2:00</option>
								<option value="2:30">2:30</option>
								<option value="3:00">3:00</option>
								<option value="3:30">3:30</option>
								<option value="4:00">4:00</option>
								<option value="4:30">4:30</option>
								<option value="5:00">5:00</option>
								<option value="5:30">5:30</option>
								<option value="6:00">6:00</option>
								<option value="6:30">6:30</option>
								<option value="7:00">7:00</option>
								<option value="7:30">7:30</option>
								<option value="8:00">8:00</option>
								<option value="8:30">8:30</option>
								<option value="9:00">9:00</option>
								<option value="9:30">9:30</option>
								<option value="10:00">10:00</option>
								<option value="10:30">10:30</option>
								<option value="11:00">11:00</option>
								<option value="11:30">11:30</option>
								<option value="12:00">12:00</option>
								<option value="12:30">12:30</option>
								<option value="13:00">13:00</option>
								<option value="13:30">13:30</option>
								<option value="14:00">14:00</option>
								<option value="14:30">14:30</option>
								<option value="15:00">15:00</option>
								<option value="15:30">15:30</option>
								<option value="16:00">16:00</option>
								<option value="16:30">16:30</option>
								<option value="17:00">17:00</option>
								<option value="17:30">17:30</option>
								<option value="18:00">18:00</option>
								<option value="18:30">18:30</option>
								<option value="19:00">19:00</option>
								<option value="19:30">19:30</option>
								<option value="20:00">20:00</option>
								<option value="20:30">20:30</option>
								<option value="21:00">21:00</option>
								<option value="21:30">21:30</option>
								<option value="22:00">22:00</option>
								<option value="22:30">22:30</option>
								<option value="23:00">23:00</option>
								<option value="23:30">23:30</option>
							</Select>
						</td>
					</tr>
					<tr>
						<td colspan="3">	
							<input name="CallMe" type="submit" value="Call Me" />
						</td>
					</tr>
				</table>
			</form>
	<?php
		}
	}
	else
	{
		echo "<p id=msg> Login as Customer to view this page</p>";
	}
}
else
	{
		echo "<p id=msg> Login required to view this page</p>";
	}	