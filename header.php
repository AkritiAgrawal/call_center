<?php
session_start();
include('dataservice.php');
?>
<title>
CALL CENTER MANAGER
</title>
<table width="100%">
<tr>
<td width="60%"><h4>AV Solutions. </h4></td>
<td width="500px;" align="right">
<?php
if(isset($_SESSION['login']))
		{
			$query="Select FirstName from employee_details where UserId = '$_SESSION[login]'";
			$db = new dataservice();
			$result = $db->fetch_query($query);
			$user=$result['FirstName'];
			$flag=0;
			if($result==null)
			{
				$query="Select FirstName from customer where LoginId = '$_SESSION[login]'";
				$result = $db->fetch_query($query);
				$user=$result['FirstName'];
				$flag=1;
			}
			if($result==null)
			{
				$user="Administrator";
				$flag=0;
			}
			
			?>
			Welcome <?php echo $user ?>
			<a href='index.php?sec=logout'>Logout</a>
			<?php	
			if($flag==1)
			{
				echo "<br /><br /><a href=index.php?sec=ClickToCallBack>Request Call Back </a>";
			}
		}
		else
		{
			echo "<h4><a href='index.php?sec=login'>Sign In</a> &nbsp; &nbsp; &nbsp; &nbsp;";
			echo "<a href='index.php?sec=Customer'>Sign Up</a> </h4> ";
		}
?></td>
</tr>
</table>