<?php
if(isset($_SESSION['login']))
{
?>
<script type="text/javascript" language="javascript">

function openURL()
{
	var type=document.choice.operation;
	for (var i = 0; i < type.length; i++) {       
        if (type[i].checked) {
			if(type[i].value=='manual'){
				document.choice.action='index.php?sec=admin';
			}
			else if(type[i].value=='addEngg'){
				 document.choice.action="index.php?sec=NewEngg";
				 }
			else if(type[i].value=='viewReport'){
				 document.choice.action="index.php?sec=Reports";
				 }	 
			break;
        }
    }
}
</script>
<br />
<br />
<h3>
	Enter your choice of Operation
</h3>
<br />
<br />
<br />
<br />
	<form action="" method="post" onsubmit="openURL();" name="choice">
		<table>
			<tr>
				<td>
					<input type="radio" name="operation" value="manual">Manual Assignment</input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="operation" value="addEngg">Add Engineer</input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="operation" value="viewReport">View Report</input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="subActionAdmin" value="Submit" />
					<input type="reset" name="cancel" value="Cancel" />
				</td>
			</tr>
		</table>
	</form>
<?php
}
else
{
echo "<p id=msg>Login required to view this page</p>";
}

?>