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
$forms->compaignLetter($id);
$date  = date('m/d/Y');
$court  = $forms->getField('court');
$last  = $forms->getField('last');
$first  = $forms->getField('first');
$address  = $forms->getField('address');
$city  = $forms->getField('city');
$state  = $forms->getField('state');
$zip  = $forms->getField('zip');
$balance  = number_format($forms->getField('accountbalance'), 2, '.', ',');
$call = $forms->getField('phone');





class MYPDF extends TCPDF {
    // table
   
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
  // Set font
 $arial = $pdf->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
$pdf->SetFont($arial, '', 8, '', true);
  // Add a page
  // This method has several options, check the source code documentation for more information.
  $pdf->AddPage();
 // set page format (read source code documentation for further information)

$pdf->SetFont($arial,'',12);
$pdf->Cell(0, 1, 'Date :'.$date, 0, 2, 'L');
$pdf->Ln();
$pdf->Cell(0, 4, 'Mr/Mrs'.' '.$first.' '.$last, 0, 1, 'L');
$pdf->Cell(0, 4, $address, 0, 1, 'L');
$pdf->Cell(0, 4, $city .' '. $state .' '. $zip, 0, 1, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, 1, 'Subject: '.$date, 0, 2, 'L');
$pdf->Ln();
$pdf->Cell(0, 4, ' Dear Mr/Mrs'.' '.$last, 0, 1, 'L');
$pdf->Ln();
$pdf->Cell(0, 4, 'Your Account balance is'.' '.'$'.$balance.'.'.' '.'Please contact office.', 0, 1, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, 4, 'Thank you', '0', 1, 'L');

// ---------------------------------------------------------

//Close and output PDF document


$pdf->Output('accountreceipt.pdf', 'I');