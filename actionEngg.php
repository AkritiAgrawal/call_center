<?php
if(isset($_SESSION['login']))
	{
		$db = new dataservice();
		$query = "Select EmpCode from employee_details where UserId='$_SESSION[login]'";
		$result = $db->fetch_query($query);
		if($result!=null)
		{
?>
			<br />
			<br />
			<h3 style="left:100px;  position:relative;">
				Pending Assignments
			</h3>
			<br />
			<br />
			<h4 style="left:100px;  position:relative;">
				Tickets
			</h4>
			<br />
			<br />
			<?php
				$query = "Select requestId, DateOfSubmission, Description from request where enggId = '$result[EmpCode]' and status != 'C'";
				$con  = mysqli_connect("localhost","root","","call_center");
				$r = mysqli_query($con,$query);
				if(mysqli_num_rows($r) == 0)
				{
					echo "<p id=msgSuccess>No more pending requests</p>";
				}
				else
				{
				?>
					<form name="assignment"  method = "post" action="index.php?sec=Solution">
						<table border = "1" cellpadding = "2" cellspacing = "2">
							<tr>
								<th>
									Date Of Submission
								</th>
								<th>
									Description
								</th>
							</tr>
							<?php
								while($row=$r->fetch_row())
								{
							?>
							<tr>
								<td>
									<input type="radio" name="reqId" value="<?php echo $row[0];?>">	<?php  echo "$row[1]"; ?>
								</td>
								<td>
									<?php  echo "$row[2]";	?>
								</td>
							</tr>
								<?php
								}
								?>			
							<tr>
								<td colspan = "3" align ="center">
									<input type="submit" value="Submit" name="SubActionEngg"/>
								</td>
							</tr>
						</table>
					</form>
					<?php
				}
				?>
				<br />
				<br />
				<h4 style="left:100px;  position:relative;">
					CallBack Requests
				</h4>
				<br />
				<br />
				<?php
					$query = "Select CallBackId, DateOfSubmission, PhoneNo, TimeToContact,CustId from callback where enggId = '$result[EmpCode]' and status != 'C'";
					$con  = mysqli_connect("localhost","root","","call_center");
					$result = mysqli_query($con,$query);
					if(mysqli_num_rows($result) == 0)
					{
						echo "<p id=msgSuccess>No more pending callback requests</p>";
					}
					else
					{
					?>
						<form name="callBackReq"  method = "post" action="index.php?sec=CallBackSolution">
							<table border = "1" cellpadding = "2" cellspacing = "2">
								<tr>
									<th>
										Date Of Submission
									</th>
									<th>
										Customer Name
									</th>
									<th>
										Contact No.
									</th>
									<th>
										Time to Contact
									</th>
								</tr>
								<?php
									while($row=$result->fetch_row())
									{
								?>
								<tr>
									<td>
										<input type="radio" name="CallBackId" value="<?php echo $row[0];?>">	<?php  echo "$row[1]"; ?>
									</td>
									<td>
								<?php
									$q = "Select FirstName, LastName from customer where LoginId = '$row[4]'";
									//echo $q;
									$s = $db->fetch_query($q);
									echo $s['FirstName']." ".$s['LastName'];
								?>
								
									</td>
									<td>
										<?php  echo "$row[2]";	?>
									</td>
									<td>
										<?php  echo "$row[3]";	?>
									</td>
								</tr>
									<?php
									}
									?>			
								<tr>
									<td colspan = "4" align ="center">
										<input type="submit" value="Submit" name="SubActionCallBack"/>
									</td>
								</tr>
							</table>
						</form>
						<?php
					}
		}
		else
		{
			echo "You are not authorised to view this page";
		}
		if(isset($_POST['SubActionEngg']))
		{
			$_SESSION['reqId'] = $_POST['reqId'];
			header("Location:index.php?sec=Solution");
		}
}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}
?>