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
			if(type[i].value=='request'){
				document.choice.action='http://localhost/call_center/index.php?sec=request';
				}
			else if(type[i].value=='status'){
				 document.choice.action="http://localhost/call_center/index.php?sec=status";
				 }
		
        }
    }
}
</script>
<br />
<br />
<h3 >
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
					<input type="radio" name="operation" value="request">Request</input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="operation" value="status">Status</input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="subChoice" value="Submit" />
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