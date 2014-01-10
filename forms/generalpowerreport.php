<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once('forms.class.php');

// Load TCPDF class library
include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');


date_default_timezone_set('America/Indianapolis');

if (!isset($_GET['id'])) {
    die();
}

$id = $_GET['id'];
// get values
//$serial = 
$forms->getGeneralPowerReport($id);
$date  = date('m/d/y');
$name = $forms->getField('name');
$address = $forms->getField('address');
$city = $forms->getField('city');
$state = $forms->getField('state');
$zip = $forms->getField('zip');
$defendant = $forms->getField('defendant');
$pnumber = $forms->getField('serial');
$amount = $forms->getField('amount');
$executed = strtotime($forms->getField('executed'));
$year = date('y',$executed);
$month = date('m',$executed);
$day   = date('d',$executed);
//$data =  array($name,$address,$city,$state,$zip,$defendant,$pnumber,$amount,$executed);
$dot = '.';
$pos = strpos($amount, $dot);
if ($pos=== false){
	
	}else{
	
	}
	

class MYPDF extends TCPDF {
    // table
    public function Table($header,$d) {
        $w = array(25, 25, 25, 35,35,35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 0, 0, 'C', 1);
        }
		for($j = 0; $j < count($d); ++$j) {
			$test[$j] = $d[$j];
           $this->Cell('25', 15, $test[$j], 1, 0, 'L',1);
        }

        $this->Ln();
        // Font restoration
         $this->Cell(array_sum($w), 0, '', 'T');
		 
    }
	
}

// create new PDF document
$pdf = new MYPDF($orientation = 'L',
$unit = 'mm',
$format = 'A4',
$unicode = true,
$encoding = 'UTF-8',
$diskcache = false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Emancipation Online');
$pdf->SetTitle('Emancipation Online');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // ---------------------------------------------------------

  // set default font subsetting mode
  $pdf->setFontSubsetting(true);
$arial = $pdf->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');  
$pdf->SetFont($arial, '', 8, '', true);
  // Set font
  // dejavusans is a UTF-8 Unicode font, if you only need to
  // print standard ASCII chars, you can use core fonts like
  // helvetica or times to reduce file size.
  $pdf->SetFont('dejavusans', '', 14, '', true);

  // Add a page
  // This method has several options, check the source code documentation for more information.
  $pdf->AddPage();

  // column titles


  // set text shadow effect
  $pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

  // Set some content to print

 // set page format (read source code documentation for further information)
$page_format = array(
    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
    'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
    'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
    'Dur' => 3,
    'trans' => array(
        'D' => 1.5,
        'S' => 'Split',
        'Dm' => 'V',
        'M' => 'O'
    ),
    'Rotate' => 90,
    'PZ' => 1,
);

// Check the example n. 29 for viewer preferences

// add first page ---
//$pdf->AddPage('P', $page_format, false, false);

$pdf->SetFont('arial','',14);

$html ='
<style>
table
{
border-collapse:collapse;
}
table, td, th
{
}


.table1{
	width:100%;
	}
	
.table2 {
}

.table3{
border:1px solid black;
}

.table3 thead tr td{
border:1px solid black;
}

.table4 tr td{
	border:1px solid #000 ;
	text-align:center;
	height:30px;

}
.table5{
border:1px solid black;
}

.table5 thead tr td{
border:1px solid black;
}


.table2 thead tr th{
	background:#000;
	color:#fff;
	
}

.header td{
	border-right:1px solid #000;
	background-color:#000000;
	color:#fff;
	
}


.clientdetail{
	width:400px;
	float:left;

}
.black{ background:#000000;}
</style>



<table width="125%" class="table1">
  <tr>
   <td>
    <table class="table2">
        <tr>
          <td style="text-align:left" colspan="2"><h1>Power report</h1></td>
		  <td><b>'.$name.'</b><br>'.$address.'<br>'.$city.' '.$state.' '.$zip.'<br></td>
		  <td>'.$date.'</td>
        </tr>
	</table>
   </td>
  </tr>
</table>
	  
<br><br><br>

<table class="table4">
        
          <tr style="font-size:12px; text-align:center">
            <td style="font-size:12px; text-align:center">POWER NUMBER</td>
            <td style="font-size:12px; text-align:center">DATE POSTED</td>
            <td style="font-size:12px; text-align:center">DEFENDANT</td>
            <td style="font-size:12px; text-align:center">BOND AMOUNT</td>

         </tr>  
         <tr >
            <td align="left">'.$pnumber.'</td>
            <td align="left">'.$month.'/'.$day.'/'.$year.' </td>
            <td align="left">'.$defendant.'</td>
            <td align="right">'.$amount.'</td>
           
 		 </tr>
</table>
<br><br><br><br><br><br><br><br><br>
<table class="table4">
  <tr style="font-size:12px; text-align:center">
    <td style="font-size:18px;font-weight:bold; text-align:left" colspan="3"><p>Total</p></td>
    <td style="font-size:18px; font-weight:bold;text-align:right">'.$amount.'</td>
    
  </tr>

</table>
<p></p>
<p>&nbsp;</p>


';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->Footer();
  // Close and output PDF document
  // This method has several options, check the source code documentation for more information.
  $pdf->Output('powerreceipt.pdf', 'I');