<?php
if(isset($_SESSION['login']))
{
	$db = new dataservice();
	$query = "Select * from admin where loginId='$_SESSION[login]'";
	$result = $db->does_exist($query);
	if($result==true)
	{
?>
		<br />
		<br />
		<h3 style="left:100px;  position:relative;">
			Pending Assignments
		</h3>
		<br />
		<br />
		<br />
		<br />
		<script language="javascript" type="text/javascript">
	
	function openURL(text)
	{
		var s = text;
		if(s=="SubAddNewEngg")
		{
			document.AdminNav.action="http://localhost/call_center/index.php?sec=NewEngg";
		}
	}
</script>
		<?php
				$query = "Select requestId, DateOfSubmission, Description,EnggId from request where status != 'C'";
				$con  = mysqli_connect("localhost","root","","call_center");
				$result = mysqli_query($con,$query);
				if(mysqli_num_rows($result) == 0)
				{
					echo "<p id=msgSuccess>No more pending requests</p>";
				?>
				
					<form action="" method="post" name="AdminNav" >
					<table>
						<tr>
							<td><input type="submit" name="SubAddNewEngg" value= "Add an Engineer" onclick = "openURL(this.name);" /></td>
						</tr>	
					</table>	
				</form>
				<?php
				}
				else
				{
		?>
					<form name="assignment" method = "post">
						<table border = "1" cellpadding = "2" cellspacing = "2">
							<tr>
								<th>
									Date Of Submission
								</th>
								<th>
									Description
								</th>
								<th>
									Assigned to
								</th>
								<th>
									Assign 
								</th>
							</tr>
							<?php
										while($row=$result->fetch_row())
										{
									?>
							<tr>
								<td>
									
										
										<?php  echo "$row[1]"; ?>
								</td>
								<td>
										<?php  echo "$row[2]";
										
										?>
								</td>
								<td>
										<?php 
										
										$query = "Select FirstName, LastName from employee_details where EmpCode='".$row[3]."'";
										$r = $db->fetch_query($query);
										echo $r['FirstName']." ".$r['LastName'];
										
										?>
								</td>
								<td>
									<a style="color:blue" href="index.php?sec=assign&reqId='<?php echo "$row[0]"; ?>'">assign</a>
								</td>
							</tr>
							<?php
										}
							?>			
							
						</table>
					</form>
				<br />
			click on assign to assign ticket to an Engineer	
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