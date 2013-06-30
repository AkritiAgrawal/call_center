<script language="javascript" type="text/javascript">
	
	function openURL(text)
	{
		var s = text;
		if(s=="SubAnRequest")
		{
			window.location="http://localhost/call_center/index.php?sec=request";
		}
		else if(s=="SubCheckStatus")
		{
			window.location="http://localhost/call_center/index.php?sec=status";
		}
	}
</script>
<?php
include('sendMail.class.php');
if(isset($_SESSION['login']))
{
	$db = new dataservice();
	$query = "Select FirstName from customer where LoginId='$_SESSION[login]'";
	//echo $query;
	$result = $db->fetch_query($query);
	if($result!=null)
	{
		if(isset($_POST['SubReq']))
		{
			$db = new dataservice();
			$problem =mysql_real_escape_string($_POST["problem"]);
			$date = Date("Y/m/d");
			$query = "insert into Request (CustId,Status,DateOfSubmission,Description) values ('$_SESSION[login]','O','$date','$problem')";
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
			echo "<p id=msgSuccess>Request Id is $pk, Please save this for future references</p>";
			$query = "Select EmpCode from employee_details where Grade != 'L1' and  ReqCount = (SELECT MIN( reqCount ) FROM employee_details where grade !='L1' ) ";
			$result = $db->fetch_query($query);
			$query = "Update Request set EnggId = '$result[EmpCode]',status = 'A' where requestId = '$pk' " ;
			$db->update_data($query); 
			$query = "Update employee_details set ReqCount = ReqCount + 1 where EmpCode = '$result[EmpCode]' " ;
			$db->update_data($query); 
			$query = "Select email from customer where loginId = '$_SESSION[login]'";
			$result = $db ->fetch_query($query);
			
			$body = "Your request no. $pk is being handled by one of our competent engineer. We'll get back to you very soon";
			$subject = "Call Center Manager ";
			$mail=new sendMail();
			$mail->mailsend($result['email'],$body,$subject);
			
			?>
		<form action="" method="post" name="StatusNav" >
						<table>
							<tr>
								<td><input type="button" name="SubAnRequest" value= "Submit Another Request" onclick = "openURL(this.name);" /></td>
								<td><input type="submit" name="SubCheckStatus" value= "Check Status" onclick = "openURL(this.name);" /></td>
							</tr>	
						</table>	
		</form>
		<?php
		}
		else
		{
	?>
			<html>
			<head>
			<script language="javascript" type="text/javascript">
				function limitText(limitField, limitCount, limitNum) {
					if (limitField.value.length > limitNum) {
						limitField.value = limitField.value.substring(0, limitNum);
					} else {
						limitCount.value = limitNum - limitField.value.length;
					}
				}
				function validate()
				{
					
					if(document.form.problem.velue.length==0)
						{
							alert("Please enter a problem description");
							fname.focus();
							return false;
						}
					return true;	
				}
			</script>
			<h3>
		Fill in your problem in the box provided below
	</h3>
	<br />
	<br />
	<br />
	<br />
			<form action="index.php?sec=request" method="post" onsubmit="return validate();" >
					<table>
						<tr>
							<td>
								Request : 
							</td>
							<td>
								<textarea name="problem" cols="30" rows="10" onKeyDown="limitText(this.form.problem,this.form.countdown,100);" onKeyUp="limitText(this.form.problem,this.form.countdown,100);">
								</textarea>
								 </td>
								 <td>
									<font size="1">(Maximum characters: 100)<br>
										You have <input readonly type="text" name="countdown" size="3" value="100"> characters left.</font>
								</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" name="SubReq" value="Submit Request" />
							</td>
							<td>
								<input type="reset" name="cancel" value="Cancel" />
							</td>
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
		echo "<p id=msg>Login as a Customer required to view this page</p>";
	}
}
else
{
	echo "<p id=msg>Login required to view this page</p>";
}
?>