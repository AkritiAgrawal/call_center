<?php
//session_start();
//header("Content-type:image/jpeg");
		$_SESSION['dateFrom']=$_POST['dateFrom']; 
		$_SESSION['dateTo'] = $_POST['dateTo'];
	include("CustomerReport.php");
	
	?>
		
	<?php
?>