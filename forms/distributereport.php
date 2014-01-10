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
$value = $forms->getDistributeReport($id);
//echo '<pre>';
//print_r($value); die();

$date  = date('m/d/Y');
$name  = $value[0]['name'];
$address  = $value[0]['address'];
$city  = $value[0]['city'];
$state  = $value[0]['state'];
$zip  = $value[0]['zip'];


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
$pdf = new MYPDF($orientation = 'P',
$unit = 'mm',
$format = 'A4',
$unicode = true,
$encoding = 'UTF-8',
$diskcache = false);
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Emancipation Online');
$pdf->SetTitle('Emancipation Online');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

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

  // Set font
 
 $arial = $pdf->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
$pdf->SetFont($arial, '', 8, '', true);
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
    'Rotate' => 0,
    'PZ' => 1,
);
// Check the example n. 29 for viewer preferences
$pdf->SetFont($arial, '', 8, '', true);
// add first page ---
//$pdf->AddPage('P', $page_format, false, false);
$pdf->SetFont($arial,'I',14);
$pdf->Text(13, 19, 'Distribution Report');
//$pdf->SetFont('Arial','B',16);
$pdf->Ln();
$pdf->SetFont($arial,'',9);
$pdf->Cell(0, 4, $name , 0, 1, 'R');
$pdf->Cell(0, 4, $address, 0, 1, 'R');
$pdf->Cell(0, 4, $city . $state . $zip, 0, 1, 'R');
$pdf->Ln();
$pdf->Cell(0, 1, 'Date :'.$date, 0, 2, 'L');

$pdf->Text(13, 65,'______________________________________________________________________________________________');

$pdf->Text(13, 73,'______________________________________________________________________________________________');


$pdf->Text(15, 70, 'Value');
$pdf->Text(62, 70, 'Prefix');
$pdf->Text(105, 70, 'Serial');
$pdf->Text(155, 70, 'Expiration Date');
$h = 80;
$i = 1;
$sum = 0;
$count = count($value);
foreach( $value as $val ){
	$h = $h + 10 ;
	//echo '<pre>';print_r($h);
	$pdf->Text(15, $h, number_format($val['value'], 2, '.', ','));
	$pdf->Text(62, $h, $val['prefix']);
	$pdf->Text(105, $h, $val['serial']);
	$pdf->Text(155, $h, date('m/d/Y', strtotime($val['expiration'])));
	//echo '<pre>';print_r($i+1);
	//print_r($count);
	if($i == $count){
		$pdf->Text(13, $h+10,'______________________________________________________________________________________________');
		$pdf->Ln();$pdf->Ln();
		$pdf->Text(13, $h+20,'Total:');$pdf->Text(25, $h+20,number_format($sum, 2, '.', ','));
		$pdf->Text(155, $h+20,'Count:');$pdf->Text(167,$h+20,$count);
		$pdf->Ln();
		
	}
	
	$sum += $val['value']; 
	$i++;
}

$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$style3 = array('width' => 0.4, 'cap' => 'round', 'join' => 'round', 'dash' => '1,1', 'color' => array(0, 0, 0));

// Print text using writeHTMLCell()
  //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

  // ---------------------------------------------------------
// print table
//$pdf->Table($header,$data);
//$pdf->Cell(0, 1, 'Total:'.$debit .'                     '.    'COUNT: '.$paymentmethod, 0, 2, 'L'); 
$pdf->Ln();$pdf->Ln();

$pdf->Ln();$pdf->Ln();

//$pdf->GetPage(1, true);
//$pdf->GetY(50);

$pdf->Footer();
  // Close and output PDF document
  // This method has several options, check the source code documentation for more information.
  $pdf->Output('distributionreport.pdf', 'I');