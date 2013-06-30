<?php
	include('sendMail.class.php');
	if(isset($_SESSION['login']))
	{
		$db = new dataservice();
		$query = "Select EmpCode, Grade from employee_details where UserId='$_SESSION[login]'";
		$result = $db->fetch_query($query);
		if(isset($_POST['reqId']))
		{
			$_SESSION['reqId']=$_POST['reqId'];
		}
	?>
	<br />
	<br />
	<h3>
		Frequently Asked Questions
	</h3>
	<br />
	<br />
	
		<form action = "index.php?sec=Solution" method="post">
			<table>
				<tr>
					<td>&nbsp; Category</td>
					<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Question</td>
				</tr>
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
	
	if(isset($_POST['search']))
	{
	?>
		<form name="found" method="post" action="index.php?sec=Solution">				
			<?php
		if($_POST['category']=="" && $_POST['question']=="")
		{
			$query = "Select answer,question,faqid from FAQ ";
			$con  = mysqli_connect("localhost","root","","call_center");
			$result = mysqli_query($con,$query);
			while($row=$result->fetch_row())
			{
				if($result==null)
				{
					echo "No entry found matching the keyword";
				}
				else
				{
				?>
	
					<div width = "70%" height="50%">
					<b><input type="radio" name = "faq" value="<?php echo $row[2]; ?>"/><?php echo $row[1]; ?></b>
					<br />
					<br />
						<?php echo $row[0]; ?> 
					<br />	
					<br />	
					<br />	
					</div>
				<?php
				}
			}	
		}
		elseif($_POST['category']!="" && $_POST['question']=="")
		{
			$ques= mysql_real_escape_string($_POST['question']);
			$query = "Select answer,question,faqid from FAQ where department='$_POST[category]'";
			$con  = mysqli_connect("localhost","root","","call_center");
			$result = mysqli_query($con,$query);
			echo "Category Chosen <b>$_POST[category] </b> <br /> <br />";
			while($row=$result->fetch_row())
			{
				if($result==null)
				{
					echo "No entry found matching the keyword";
				}
				else
				{
				?> 
					<div width = "70%" height="50%">
					<b><input type="radio" name = "faq" value="<?php echo $row[2]; ?>"/><?php echo $row[1]; ?></b>
					<br />
					<br />
						<?php echo $row[0]; ?> 
					<br />	
					<br />	
					<br />	
					</div>
				<?php
				}
			}	
		}
		elseif($_POST['category']=="" && $_POST['question']!="")
		{
			$ques= mysql_real_escape_string($_POST['question']);
			$query = "Select answer,question,faqid from FAQ where question  like '% $ques %' or answer  like '% $ques %'";
			$con  = mysqli_connect("localhost","root","","call_center");
			$result = mysqli_query($con,$query);
			echo "Question submitted <b>$ques </b> <br /> <br />";
			while($row=$result->fetch_row())
			{
				if($result==null)
				{
					echo "No entry found matching the keyword";
				}
				else
				{
				?>
					<div width = "70%" height="50%">
					<b><input type="radio" name = "faq" value="<?php echo $row[2]; ?>"/><?php echo $row[1]; ?></b>
					<br />
					<br />
						<?php echo $row[0]; ?> 
					<br />	
					<br />	
					<br />	
					</div>
				<?php
				}
			}	
		}
		elseif($_POST['category']!="" && $_POST['question']!="")
		{
			$ques= mysql_real_escape_string($_POST['question']);
			$query = "Select answer,question,faqid from FAQ where question  like '% $ques %' or answer like '% $ques % '";
			$con  = mysqli_connect("localhost","root","","call_center");
			$result = mysqli_query($con,$query);
			echo "Category Chosen <b>$_POST[category]</b> <br /> <br /> ";
			echo "Question Submitted <b>$ques </b><br /> <br /> ";
			while($row=$result->fetch_row())
			{
				if($result==null)
				{
					echo "No entry found matching the keyword";
				}
				else
				{
				?>
					<div width = "70%" height="50%">
					<?php  ?>
					
					<b><input type="radio" name = "faq" value="<?php echo $row[2]; ?>"/><?php echo $row[1]; ?></b>
					<br />
					<br />
						<?php echo $row[0]; ?> 
					<br />	
					<br />	
					<br />	
					</div>
				<?php
				}
			}	
		}
		?>
		
			<table>
				<tr>
					<td>
						<input type="submit" name="notFound" value="Not Found" />
					</td>
				
					<td>
						<input type="submit" name="look" value="Submit" /> 
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
	if(isset($_POST['look']))
	{
			$faq = $_POST['faq'];
			$query = "Update request set faqid='$_POST[faq]', status = 'C' where requestId = '$_SESSION[reqId]'";
			//echo $query;
			$result = $db->update_data($query);
			$query = "Select CustId from Request where requestId = '$_SESSION[reqId]'";
			$result = $db->fetch_query($query);
			$query = "Select email from customer where loginId ='$result[CustId]'";
			$result = $db->fetch_query($query);
			$body = "Your request no. '$_SESSION[reqId]' has been resolved by our competent engineer. Your feedback is required to continuously improve our services. Thank You. <br />
			Please <a href = 'http://localhost/call_center/index.php?sec=feedback & reqId=".$_SESSION['reqId']."' > click here </a> to post your feedback";
			$subject = "Call Center Manager ";
			$mail=new sendMail();
			$mail->mailsend($result['email'],$body,$subject);
			header("Location:index.php?sec=actionEngg");
	}
	elseif(isset($_POST['notFound']))
	{
		$query = "Select EmpCode from employee_details where Grade = 'L1' and  ReqCount = ( SELECT MIN( reqCount ) FROM employee_details ) ";
		$result = $db->fetch_query($query);
		$query = "Update Request set EnggId = '$result[EmpCode]',status = 'A' where requestId = '$_SESSION[reqId]' " ;
		$db->update_data($query); 
		$query = "Update employee_details set ReqCount = ReqCount + 1 where EmpCode = '$result[EmpCode]' " ;
		$db->update_data($query); 
		header("Location:index.php?sec=actionEngg");
	}
?>
		
<?php
}
else
{
	echo "<p id=msg>You are not authorised to view this page</p>";
}
?>