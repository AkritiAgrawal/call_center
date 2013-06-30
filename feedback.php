<?php
include('sendMail.class.php');
if(isset($_GET['reqId']))
	{
		$db = new dataservice();
		$query = "Select FAQId, description from request where requestId='$_GET[reqId]'";
		$result = $db->fetch_query($query);
		$query = "Select answer from FAQ where FAQId = '$result[FAQId]'";
		$result_FAQ = $db->fetch_query($query);
	?>
<br />
<br />
<h3 style="left:100px;  position:relative;">
	FEEDBACK
</h3>
<br />
<br />
<br />
<br />	
		<form action = "index.php?sec=feedback" method="post">
			<table>
			<input type="hidden" name = "requestID" value = "<?php echo $_GET['reqId']; ?>" >
				<tr>
					<td>
						Problem Statement :
					</td>
					<td>
						<?php echo $result['description']; ?>
					</td>
				</tr>
				<tr>
					<td>
						Solution Provided :
					</td>
					<td>
						<?php echo $result_FAQ['answer']; ?>
					</td>
				</tr>
				<tr>
					<td>
						Satisfaction Level :
					</td>
					<td>
						<input type="radio" name = "rating" value = "5" /> Completely Satisfied 
						<input type="radio" name = "rating" value = "4" /> Very Satisfied 
						<input type="radio" name = "rating" value = "3" /> Somewhat Satisfied 
						<input type="radio" name = "rating" value = "2" /> Slightly Satisfied 
						<input type="radio" name = "rating" value = "1" /> Not at all Satisfied 
					</td>
				</tr>
				<tr>
					<td>
						Comments :
					</td>
					<td>
						<textarea name = "comment" rows = "10" cols = "17" ></textarea> 
					</td>
				</tr>
				<tr>
					<td>
						<input type="Submit" name= "subFeedBack" value = "POST" />
					</td>
					<td>
						<input type="reset" name = "reset" value = "CANCEL" />
					</td>
				</tr>
			</table>
		</form>	
<?php
}
elseif(isset($_POST['subFeedBack']))
{
	$db = new dataservice();
	$comment = mysql_real_escape_string($_POST['comment']);
	$query = "Insert into feedback (requestId, satLevel,comment) values ('$_POST[requestID]','$_POST[rating]','$comment')";
	$result = $db->insert_data($query);
	echo "Thank you for providing feedback";
	if($_POST['rating']<3)
	{
		$query="Select EnggId from request where requestId='".$_POST['requestID']."'";
		$result=$db->fetch_query($query);
		$query = "Select FirstName, LastName from employee_details where EmpCode='".$row[3]."'";
		$r = $db->fetch_query($query);
		$body = "$_POST[requestID] that was handled by $r[FirstName] $r[LastName] has received $_POST[rating] as rating.";
		$subject = "Negative Feedback ALERT!! ";
		$mail=new sendMail();
		$mail->mailsend("agrawalakriti05@gmail.com",$body,$subject);
	}
}
else
{
	echo "<p id=msg>You are not authorisied to view this page</p>";
}
?>