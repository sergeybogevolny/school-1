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
if (!isset($_GET['pid'])) {
    $pid='';
} else {
    $pid = $_GET['pid'];
}
$id = $_GET['id'];

// get values
$forms->getOtherharristxaoa($id,$pid);
$txt_dateexecuted_mdy = date('m/d/Y');
$txt_amount = $forms->getField('amount');
if (strpos($txt_amount, '.') !== TRUE){
    $nfamount = number_format($txt_amount);
    $txt_amount = $txt_amount . '.00';
} else {
    $txt_amount = number_format($txt_amount);
}
$txt_last = $forms->getField('last');
$txt_first = $forms->getField('first') . " ";
$txt_middle = $forms->getField('middle');
if ($txt_middle!=""){
    $txt_middle = $txt_middle . " ";
}
$txt_defendant = $txt_first . $txt_middle . $txt_last;
$txt_casenumber = $forms->getField('casenumber');
$txt_jail = $forms->getField('jail');
$txt_dateexecuted_d = date('d');
$txt_dateexecuted_month_year = date('F Y');
$translatex =  $forms->getField('translatex');
$translatey =  $forms->getField('translatey');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PrincetonTrust');
$pdf->SetTitle('PrincetonTrust');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setFontSubsetting(true);
//NOTE - Using helvetica instead of arial because form was originally designed using this font and spacing is alreadt set with this
$pdf->SetFont('helvetica', '', 10);
$pdf->SetMargins(0, 0, 0, 0);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->setCellMargins(1, 1, 1, 1);
$resolution= array(216, 280);
$pdf->AddPage('P', $resolution);

$pdf->StartTransform();
// Translate +# to the right, +# to the bottom
$pdf->Translate($translatex, $translatey);

$pdf->MultiCell(55, 5, $txt_dateexecuted_mdy, 0, 'L', 0, 1, 126, 37, true);

$pdf->MultiCell(55, 5, $txt_amount, 0, 'L', 0, 1, 154, 42, true);

$pdf->MultiCell(55, 5, $txt_defendant, 0, 'L', 0, 1, 14, 90, true);

$pdf->MultiCell(55, 5, $txt_casenumber, 0, 'L', 0, 1, 14, 101, true);

$pdf->MultiCell(55, 5, $txt_jail, 0, 'L', 0, 1, 103, 111, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_d, 0, 'L', 0, 1, 144, 190, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_month_year, 0, 'L', 0, 1, 174, 190, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_d, 0, 'L', 0, 1, 144, 252, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_month_year, 0, 'L', 0, 1, 174, 252, true);

// Stop Transformation
$pdf->StopTransform();

$pdf->lastPage();

// ---------------------------------------------------------

// Close and output PDF document
$pdf->Output('otherharristxaoa.pdf', 'I');

