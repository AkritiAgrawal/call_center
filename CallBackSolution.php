<?php
include('sendMail.class.php');
if(isset($_SESSION['login']))
{
	$db = new dataservice();
	$query = "Select EmpCode from employee_details where UserId='$_SESSION[login]'";
	$result = $db->fetch_query($query);
	if(isset($_POST['CallBackId']))
	{
		$_SESSION['CallBackId'] = $_POST['CallBackId']; 
	}
	if(isset($_POST['SubComment']))
	{
		$query = "Update callback set status = 'C' , comment = '$_POST[comment]' where callbackId = '$_SESSION[CallBackId]'";
		$result = $db->update_data($query);
		header("Location:index.php?sec=actionEngg");
	}
	else
	{
	?>
		<br />
				<br />
				<h3 style="left:100px;  position:relative;">
					CallBack Result
				</h3>
				<br />
				<br />
				<form name="CallBackResult" method="post" action="index.php?sec=CallBackSolution" >
				<table>
					<tr>
						<td>
							Add Comment:
						</td>
						<td>
							<Select name="comment">
								<option value="Contacted">Contacted</option>
								<option value="Wrong Number">Wrong Number</option>
								<option value="Line Busy">Line Busy</option>
								<option value="Reached Answering Machine">Reached Answering Machine</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="SubComment" value="Submit" />
						</td>
						<td>
							<input type="Reset" name="Reset" value="Reset" />
						</td>
					</tr>
				</table>
				</form>
				
	<?php
	}
}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}
?>