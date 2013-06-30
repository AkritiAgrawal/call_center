<?php
if(isset($_SESSION['login']))
{
	$db = new dataservice();
	$query = "Select * from admin where loginId='$_SESSION[login]'";
	$result = $db->does_exist($query);
	if($result==true)
	{
	?>	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
	$(function(){
	
	$('#dateFrom').datepicker({
	  dateFormat: 'yy/mm/dd',
	  onSelect: function(dateText, inst) {
	       $('#dateTo').datepicker('option','minDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
          }
	});
	$('#dateTo').datepicker({
	  dateFormat: 'yy/mm/dd',
	  onSelect: function(dateText, inst) {
	       $('#dateFrom').datepicker('option','maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
	  }					
	});

});
</script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
			<br />
			<br />
			<h3 style="left:20px;  position:relative;">
				Select Dates for which you want report
			</h3>
			<br />
			<br />

	<form method="post" action = "graph.php">
		<table>
			<tr>
				<td>	
					From :
				</td>
				<td>
					<input id="dateFrom" type="text" name="dateFrom" class="datepicker" />
				</td>
			
				<td>	
					To :
				</td>
				<td>
					<input id="dateTo" type="text" name="dateTo" class="datepicker" />
				</td>
				<td>
					<input type="submit" name="submit" value="Submit" />
				</td>
			</tr>
		</table>
	</form>	
<?php
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