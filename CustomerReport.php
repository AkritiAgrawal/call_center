<?php
//include("graph.php");
require_once('tcpdf/tcpdf.php');

//$_SESSION['dateFrom']=$_POST['dateFrom']; 
//$_SESSION['dateTo'] = $_POST['dateTo'];
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AV Solutions');
$pdf->SetTitle('Customer monthly report');
$pdf->SetSubject('Monthly Report');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

$pdf->SetHeaderData('', '', "Tickets Monthly  ".PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$html = <<<EOD
<h3>A Report on Ticket Count </h3>
EOD;

// Set some content to print
/*$html = <<<EOD
<table>
	<tr>
		<th>
			Customer Id
		</th>
		<th>
			Customer Name
		</th>
		<th>
			&nbsp;&nbsp;Request Id
		</th>
		<th>
			Request Details
		</th>
		<th>
			Request Date
		</th>
		<th>
			Request Status
		</th>
	</tr>
EOD;
*/

// set JPEG quality
$pdf->setJPEGQuality(75);

// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


	#----- Database Connection ------- */
	$con  = mysqli_connect("localhost","root","","call_center");
	
	
	#---- Fetching records from table ----- 
	$totalCount = 0;
	$totalClosed = 0;
	$totalOpen = 0;
	$totalNegative = 0;
	$query = "Select count(*) from request where dateOfSubmission like '%2013/06%'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalCount = $row[0];
	$query = "Select count(*) from request where dateOfSubmission like '%2013/06%'  and status = 'C'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalClosed = $row[0];
	$query = "Select count(*) from request where dateOfSubmission like '%2013/06%'  and status = 'A'";
	$result = mysqli_query($con,$query);
	$row=$result->fetch_row();
	$totalOpen = $row[0];
	
//$key =array('Total Tickets','Total Closed','Total Open');
$values=array('Total Tickets' => $totalCount,'Total Closed' => $totalClosed,'Total Open' =>$totalOpen);
		
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
//	header("Content-type:image/jpeg");
	
	

// Example of Image from data stream ('PHP rules')
//$imgdata = base64_decode(imagejpeg($img));
//$imgsrc = '@'.base64_encode($img);

// The '@' character is used to indicate that follows an image data stream and not an image file name
//$pdf->Image('@'.$imgdata);

/*$html = '<img src="<?php include(graph.php) ?>" width="100" height="100" border="0" />'; */

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
//$pdf->Image('images/graph.jpeg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// test fitbox with all alignment combinations

$horizontal_alignments = array('L', 'C', 'R');
$vertical_alignments = array('T', 'M', 'B');
/*
$x = 15;
$y = 35;
$w = 30;
$h = 30;
// test all combinations of alignments
for ($i = 0; $i < 3; ++$i) {
    $fitbox = $horizontal_alignments[$i].' ';
    $x = 15;
    for ($j = 0; $j < 3; ++$j) {
        $fitbox{1} = $vertical_alignments[$j];
        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));
        $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        $x += 32; // new column
    }
    $y += 32; // new row
}

$x = 115;
$y = 35;
$w = 25;
$h = 50;
for ($i = 0; $i < 3; ++$i) {
    $fitbox = $horizontal_alignments[$i].' ';
    $x = 115;
    for ($j = 0; $j < 3; ++$j) {
        $fitbox{1} = $vertical_alignments[$j];
        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,255));
      //  $pdf->Image('images/image_demo.jpg', $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        $x += 27; // new column
    }
    $y += 52; // new row
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Stretching, position and alignment example
*/
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetXY(110, 200);
$pdf->Image('images/graph.jpeg', '25', '40', 150, 130, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
//$pdf->Image('images/graph.jpeg', '', '', 40, 40, '', '', '', false, 300, '', false, false, 1, false, false, false);


// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
 ob_end_clean();
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

 //echo "<script language=\"javascript\">window.open(\"index.php?sec=adminAction\",\"_blank\");</script>"; 