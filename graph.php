<?php
/*	#----- Finding duplicate values in array ----
	function totalTickets($month,$data) {
	$nb= 0;
	foreach($month as $key => $val)
	{
		if ($val==$data) $nb++;
	}
	return $nb;
	} 

	#----- Database Connection ------- */
	$con  = mysqli_connect("localhost","root","","call_center");
	
	
	#---- Fetching records from table ----- 
	//$i = 0;
	$totalCount = 0;
	$totalClosed = 0;
	$totalOpen = 0;
	$totalNegative = 0;
	$fromDate = $_POST['dateFrom']; 
	$toDate = $_POST['dateTo']; 
	$query = "Select count(*) from request where dateOfSubmission between '$fromDate' and '$toDate'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalCount = $row[0];
	if($totalCount==0)
	{
		header("Location:index.php?sec=ERROR");
	}
	$query = "Select count(*) from request where (dateOfSubmission between '$fromDate' and '$toDate')  and status = 'C'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalClosed = $row[0];
	//echo "Total Count ". $totalClosed[0]; 
	$query = "Select count(*) from request where (dateOfSubmission between '$fromDate' and '$toDate')  and status = 'A'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalOpen = $row[0];
	//echo "Total Count ". $totalOpen[0]; 
//	$query = "Select count(*) from request where dateOfSubmission like % 2013/06  and status = 'C'%";
//	$totalClosed = mysql_query($query);
	
	
	
	#---- Creating array for the past 11 months starting from present month -----
	
/*	for($m=11;$m>=0;$m--)
	{
		$todayDate = date("Y-m-d");
		$date_timestamp = strtotime($todayDate);
		$new_dt = strtotime("-$m months", $date_timestamp);
		$new_mon[$m] = date("Y M",$new_dt);
		$values[$new_mon[$m]] = 0;
	}	*/
	
	#--- Computing no of advisory for each month ------ 
	
	/*for($j=0;$j<sizeOf($month);$j++)
	{
		$count = findDuplicates($month,$month[$j]); 
		$totCount = $totCount + $count;
		$values[$new_month[$j]] = $totCount;
		$j = $totCount - 1 ;
		$key = array_search($new_month[$j],array_keys($values));
		$key = 10 - $key;
		for($k=$key;$k>0;$k--)
			{
				$a = $new_mon[$k];
				$values[$a] = $totCount;
			}
	}*/
	
$key =array('Total Tickets','Total Closed','Total Open');
$values=array('Total Tickets' => $totalCount,'Total Closed' => $totalClosed,'Total Open' =>$totalOpen);
//$key = array_search($total,array_keys($values)); 
//print_r ($key);
//echo count($values);	
		
	#---- Setting width and height of graph image -----	
		
	$img_width=800;
	$img_height=500; 
	$margins=20;

 
	# ---- Find the size of graph by substracting the size of borders----
	$graph_width=$img_width - $margins * 2;
	$graph_height=$img_height - $margins * 2; 
	$img=imagecreate($img_width,$img_height);

 
	$bar_width=20;
	$total_bars=count($values);
	$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

 
	# -------  Define Colors ----------------
	$bar_color=imagecolorallocate($img,0,64,128);
	$background_color=imagecolorallocate($img,255,255,255);
	$border_color=imagecolorallocate($img,200,200,200);
	$line_color=imagecolorallocate($img,220,220,220);
 
	# ------ Create the border around the graph ------

	imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
	imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);

 
	# ------- Max value is required to adjust the scale	-------
	$max_value=max($values);
	$ratio= $graph_height/$max_value;

 
	# -------- Create scale and draw horizontal lines  --------
	$horizontal_lines=20;
	$horizontal_gap=$graph_height/$horizontal_lines;

	for($i=1;$i<=$horizontal_lines;$i++){
		$y=$img_height - $margins - $horizontal_gap * $i ;
		imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
		$v=intval($horizontal_gap * $i /$ratio);
		imagestring($img,0,5,$y-5,$v,$bar_color);

	}
 
 
	# ----------- Draw the bars here ------
	for($i=0;$i< $total_bars; $i++){ 
		# ------ Extract key and value pair from the current pointer position
		list($key,$value)=each($values);
		//echo $value;
		$x1= $margins + $gap + $i * ($gap+$bar_width) ;
		$x2= $x1 + $bar_width; 
		$y1=$margins +$graph_height- intval($value * $ratio) ;
		$y2=$img_height-$margins;
	//	echo $key;
	
		imagestring($img,0,$x1+3,$y1-10,$value,$bar_color);
		imagestring($img,0,$x1+3,$img_height-15,$key,$bar_color);		
		imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
		
	} 
	imagestring($img,0,300,5,"Tickets Submitted",$bar_color);
	//imagestring("ADVISORY PROGRESS GRAPH");
	header("Content-type:image/jpeg");
//	imagejpeg($img);
	imagejpeg($img,'images/graph.jpeg');
	// echo "<script language=\"javascript\">window.open(\"index.php?sec=CustomerReport\",\"_blank\");</script>"; 
	header("Location:index.php?sec=CustomerReport");
	
?>