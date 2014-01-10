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
$forms->getAccountinvoice($id);
$date  = date('m/d/y');
$entry = $forms->getField('entry');
$debit = number_format($forms->getField('debit'), 2, '.', ',');
$paymentmethod = $forms->getField('paymentmethod');
$amount  = number_format($forms->getField('amount'), 2, '.', ',');
$address  = $forms->getField('address');
$casenumber  = $forms->getField('casenumber');
$county  = $forms->getField('county');
$court  = $forms->getField('court');
$charge  = $forms->getField('charge');
$class  = $forms->getField('class');
$last  = $forms->getField('last');
$first  = $forms->getField('first');
$city  = $forms->getField('city');
$state  = $forms->getField('state');
$zip  = $forms->getField('zip');
$balance  = number_format($forms->getField('balance'), 2, '.', ',');
$call = $forms->getField('phone');




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
  $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

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
$pdf->Cell(0, 1, 'Invoice for Account', 0, 1, 'L');
//$pdf->SetFont('Arial','B',16);
$pdf->SetFont($arial,'B',16);
$pdf->Cell(0, 12, 'Call-'.$call, 0, 1, 'R');
$pdf->Ln();
$pdf->SetFont($arial,'',9);
$pdf->Cell(0, 4, $last .' '. $first, 0, 1, 'L');
$pdf->Cell(0, 4, $address, 0, 1, 'L');
$pdf->Cell(0, 4, $city . $state . $zip, 0, 1, 'L');
$pdf->Ln();
$pdf->Cell(0, 1, 'Date :'.$date, 0, 2, 'L');
$pdf->Ln();
$pdf->Cell(0, 1, 'Defendant :'. $last.' '. $first, 0, 2, 'L');
$pdf->Ln();$pdf->Ln();$pdf->Ln();

$pdf->Text(13, 92,'____________________________________________________________________________________________');

$pdf->Text(13, 100,'____________________________________________________________________________________________');

$pdf->Text(15, 97, 'Bond Amount');
$pdf->Text(40, 97, 'Case Number');
$pdf->Text(65, 97, 'Country');
$pdf->Text(95, 97, 'Court');
$pdf->Text(125, 97, 'Class');
$pdf->Text(155, 97, 'Charge');
$pdf->Text(15, 107, $amount);
$pdf->Text(40, 107, $casenumber);
$pdf->Text(65, 107, $county);
$pdf->Text(95, 107, $court);
$pdf->Text(125, 107, $class);
$pdf->Text(155, 107, $charge);

$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$style3 = array('width' => 0.4, 'cap' => 'round', 'join' => 'round', 'dash' => '1,1', 'color' => array(0, 0, 0));

// Print text using writeHTMLCell()
  //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

  // ---------------------------------------------------------
// print table
//$pdf->Table($header,$data);
$pdf->Ln();$pdf->Ln();
$pdf->Cell(0, 1, 'Amount:'.$debit .'     '.    'Method: '.$paymentmethod, 0, 2, 'L');
$pdf->Ln();
$pdf->Cell(0, 1, 'Balance:'.$balance); 
$pdf->Ln();$pdf->Ln();
$pdf->Cell(0, 1, 'Collatrial:', 0, 2, 'L');
$pdf->Ln();$pdf->Ln();
$pdf->Cell(0, 1, 'Deliver:', 0, 2, 'L');
$pdf->Text(55, 158, 'Mail:');
$pdf->Text(49, 167, 'By:______________________');
$pdf->Rect(50, 158, 3, 3, 'D', array('all' => $style3));
$pdf->Text(95, 158, 'Personal:');
$pdf->Text(89, 167, 'By:______________________');
$pdf->Rect(90, 158, 3, 3, 'D', array('all' => $style3));
$pdf->Ln(50);


$pdf->Footer();
  // Close and output PDF document
  // This method has several options, check the source code documentation for more information.
  $pdf->Output('accountinvoice.pdf', 'I');