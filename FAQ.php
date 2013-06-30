<?php
	include('sendMail.class.php');
	if(isset($_SESSION['login']))
	{
		$db = new dataservice();
		$query = "Select EmpCode from employee_details where UserId='$_SESSION[login]' and Grade = 'L1'";
		$result = $db->fetch_query($query);
		if($result!=null)
		{
			
?>
		<script language = "javascript" type="text/javascript">
			function ChooseAction(ch)
			{
				if(ch=="add")
				{
					document.getElementById("divAddFAQ").style.display = "block";
					document.getElementById("divUpdateFAQ").style.display = "none";
				}
				else if(ch=="update")
				{
					document.getElementById("divUpdateFAQ").style.display = "block";
					document.getElementById("divAddFAQ").style.display = "none";
				}
			}
		</script>
		<form action = "index.php?sec=Solution" method="post" >
			<table>
				<tr>
					<td>
						<select name="category">
							<option value=""></option>
					<?php
						$query = "Select distinct (department) from faq ";
						$con  = mysqli_connect("localhost","root","","call_center");
						$result = mysqli_query($con,$query);
						while($row=$result->fetch_row())
						{
					?>
						
							<option value = "<?php echo $row[0];  ?>"><?php echo $row[0];  ?></option>
						
						<?php
						}
						?>
						</select>
					</td>
					<td>
						<input type = "text" name = "question" />
					</td>
					<td>
						<input type = "submit" name = "search" value = "Search" />
					</td>
				</tr>
			</table>
		</form>
<?php
						$query = "Select description from request where requestId = '$_SESSION[reqId]' ";
						$result = $db->fetch_query($query);
						echo "Providing solution for <b> $result[description] </b> <br />";
	}
	else
	{
		echo "<p id=msg>You are not authorised to view this page</p>";
	}
	
?>
	<form name = "choice" >
		<table>
			<tr>
				<td>
					<input type="radio" name="act" value="add" onChange = "ChooseAction(this.value);"> ADD FAQ </input>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="act" value="update" onChange = "ChooseAction(this.value);"> UPDATE FAQ </input>
				</td>
			</tr>
		</table>
	</form>
	<br />
	<br />
	<br />
	<br />
	<div id = "divAddFAQ" style ="display:none" >
		<form name="addFAQ" action = "index.php?sec=FAQ"  method = "post">
			<center>ADD FAQ</center>
			<table>
				<tr>
					<td>
						Category :
					</td>
					<td>
						<input type="Text" name="category" />
					</td>
				</tr>
				<tr>
					<td>
						Question :
					</td>
					<td>
						<input type="Text" name="ques" />
					</td>
				</tr>
				<tr>
					<td>
						Answer :
					</td>
					<td>
						<Textarea name="ans" rows = "5" cols = "17" >
						</Textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="ADD" name="SubAdd" />
					</td>
					<td>
						<input type="reset" value="CANCEL" name = "reset" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id = "divUpdateFAQ" style ="display:none" >
		<form name="updateFAQ" action = "index.php?sec=FAQ"  method = "post">
			<center>UPDATE FAQ</center>
			<table>
				<tr>
					<td>
						Category :
					</td>
					<td>
						<input type="Text" name="category" />
					</td>
				</tr>
				<tr>
					<td>
						Question :
					</td>
					<td>
						<input type="Text" name="ques" />
					</td>
				</tr>
				<tr>
					<td>
						Answer :
					</td>
					<td>
						<Textarea name="ans" rows = "5" cols = "17" >
						</Textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="UPDATE" name="SubUpdate" />
					</td>
					<td>
						<input type="reset" value="CANCEL" name = "reset" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	</body>
</html>	
<?php
	if(isset($_POST['SubAdd']))
	{
		$category = mysql_real_escape_string($_POST['category']);
		$ques = mysql_real_escape_string($_POST['ques']);
		$ans = mysql_real_escape_string($_POST['ans']);
		$query = "Insert into FAQ (question,answer,department) values('".$ques."','".$ans."','".$category."')";
		$result=$db->insertdata_with_pkreturn($query);
		$query = "Update request set faqid='$result', status = 'C' where requestId = '$_SESSION[reqId]'";
		$result = $db->update_data($query);
		$query = "Select CustId from Request where requestId = '$_SESSION[reqId]'";
		$result = $db->fetch_query($query);
		$query = "Select email from customer where loginId ='$result[CustId]'";
		$result = $db->fetch_query($query);
		$body = "Your request no. '$_SESSION[reqId]' has been resolved by our competent engineer. Your feedback is required to continuously improve our services. Thank You. <br />
		Please <a href = 'http://localhost/call_center/index.php?sec=feedback&reqId=".$_SESSION['reqId']."' > click here </a> to post your feedback";
		$subject = "Call Center Manager ";
		$mail=new sendMail();
		$mail->mailsend($result['email'],$body,$subject);
		echo "Record added successfully";
	}
}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}

?>