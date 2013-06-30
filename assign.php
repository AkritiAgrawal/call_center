<?php
if(isset($_SESSION['login']))
{
	$reqId =$_GET['reqId'];
	$db = new dataservice();
	$query = "Select * from admin where loginId='$_SESSION[login]'";
	$result = $db->does_exist($query);
	?>
	<br />
<br />
<h3>
	Select Engineer to Assign Tickets
</h3>
<br />
<br />
<br />
<br />
		<form name="assign" method="post" action="index.php?sec=assigned">
			<table border="1" cellspacing="2" cellpadding="2">
				<tr>
					<th>
						Name
					</th>
					<th>
						Grade
					</th>
					<th>
						Designation
					</th>
				</tr>
<?php
	if($result==true)
	{
		$query = "Select FirstName, LastName,EmpCode,Grade,Designation from employee_details";
		$con  = mysqli_connect("localhost","root","","call_center");
		$result = mysqli_query($con,$query);
		while($row=$result->fetch_row())
		{
			
?>
			<tr>
				<td>
					<input type="radio" name="EmpCode" value ="<?php echo $row[2] ?>"/><?php echo "$row[0] $row[1]";  ?>
					<input type="hidden" name="reqId" value="<?php echo $reqId; ?>" />
				</td>
				<td>
					<?php echo "$row[3]"; ?>
				</td>
				<td>
					<?php echo "$row[4]"; ?>
				</td>
			</tr>	
			
<?php		
			}
		}
		?>
		<tr>
			<td>
				<input type="submit" name="subAssign" value="Assign" />
			</td>
			<td>
				<input type="reset" name="reset" value="Cancel" />
			</td>
		</tr>	
		
		</table>
		</form>
	</body>
</html>	
<?php
}
else
{
	echo "<p id=msg>You are not authorised to view this page<p>";
}

?>