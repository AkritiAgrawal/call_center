<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<script language="javascript" type="text/javascript">
	
	function openURL(text)
	{
		var s = text;
		if(s=="SubRequest")
		{
			window.location="http://localhost/call_center/index.php?sec=request";
		}
		else if(s=="SubStatus")
		{
			window.location="http://localhost/call_center/index.php?sec=status";
		}
	}
</script>
<?php
if(isset($_SESSION['login']))
{
	if(isset($_POST['CheckStatus']))
	{
		$db= new dataservice();
		$reqId = mysql_real_escape_string($_POST['ReqId']);
		if(isset($reqId))
		{
			$query = "Select Status from request where requestId='$reqId' and custId = '$_SESSION[login]' ";
			$result = $db->fetch_query($query);
			if($result==null)
			{	
				echo "<p id=msg>Please enter a valid Request Id</p>";
			}
			else
			{
				if($result['Status']!='C')
				{
					echo "<p id=msgSuccess>Our engineers are still processing your request</p>";
				}
				else
				{
					echo "<p id=msgSuccess>Your request has been processed. Hope you are satisfied with our solution
					<br />
					<a href=index.php?sec=feedback>Click here</a> to provide feedback. If already filled ignore the message.</p>";
				}
			}
			?>
				<form action="" method="post" name="StatusNav" >
					<table>
						<tr>
							<td><input type="button" name="SubRequest" value= "Submit Request" onclick = "openURL(this.name);" /></td>
							<td><input type="submit" name="SubStatus" value= "Check Another Status" onclick = "openURL(this.name);" /></td>
						</tr>	
					</table>	
				</form>
				
			<?php
			
		}
		
	}
	else
	{
		?>
	<body>
		<form name="status" action="index.php?sec=status" method="post" >
			<table>
				<tr>
					<td>Request Id :</td>
					<td><input type="text" name="ReqId" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="CheckStatus" value="Check Status" /></td>
				</tr>
			</table>
		</form>
<?php

	}
}	
else
{
	echo "<p id=msg>Login required to view this page</p>";
}
?>