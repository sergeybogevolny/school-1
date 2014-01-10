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

if (!isset($_GET['oname'])) {
    $oname='';
} else {
    $oname = $_GET['oname'];
}

// get values
$forms->getPowerallegheny($id,$pid);

$type = $forms->getField('type');

$txt_bondamount = $forms->getField('amount');
if (strpos($txt_bondamount, '.') !== TRUE){
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
    //$txt_bondamount = $txt_bondamount . '.00';
} else {
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
}
$txt_dateexecuted_mdY = date('m/d/Y');
if ($oname!=''){
    $txt_defendant = $oname;
} else {
    $txt_last = $forms->getField('last');
    $txt_first = $forms->getField('first') . " ";
    $txt_middle = $forms->getField('middle');
    if ($txt_middle!=""){
        $txt_middle = $txt_middle . " ";
    }
    $txt_defendant = $txt_first . $txt_middle . $txt_last;
}
$txt_dob = $forms->getField('dob');
$txt_dob_mdY = $txt_dob;
if ($txt_dob_mdY!=""){
    $txt_dob_mdY = strtotime($txt_dob_mdY);
    $txt_dob_mdY  = date('m/d/Y', $txt_dob_mdY);
}
$txt_casenumber = $forms->getField('casenumber');
$txt_charge = $forms->getField('charge');
$txt_charge = str_replace("&gt;", ">", $txt_charge);
$txt_charge = str_replace("&lt;", "<", $txt_charge);
$txt_charge = str_replace("&amp;", "&", $txt_charge);
$txt_county = $forms->getField('county');
if ($type=='JP'){
    $precinct = $forms->getField('precinct');
    $position = $forms->getField('position');
    $txt_court = $precinct.'/'.$position;
} else {
    $txt_court = $forms->getField('court');
}
$txt_city = $forms->getField('city');
$txt_state = $forms->getField('state');
$txt_license = $forms->getField('license');
$translatex =  $forms->getField('translatex');
$translatey =  $forms->getField('translatey');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator('PrincetonTrust');
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
$pdf->AddPage();

$pdf->StartTransform();
// Translate +# to the right, +# to the bottom
$pdf->Translate($translatex, $translatey);
//$pdf->MultiCell(55, 5, 'x'.$translatex, 0, 'L', 0, 1, 10, 10, true);
//$pdf->MultiCell(55, 5, 'y'.$translatey, 0, 'L', 0, 1, 20, 10, true);

$pdf->MultiCell(55, 5, $txt_bondamount, 0, 'L', 0, 1, 28, 60, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_mdY, 0, 'L', 0, 1, 119, 60, true);

$pdf->MultiCell(110, 5, $txt_defendant, 0, 'L', 0, 1, 27, 68, true);
$pdf->MultiCell(55, 5, $txt_dob_mdY, 0, 'L', 0, 1, 112, 68, true);

$pdf->MultiCell(55, 5, $txt_casenumber, 0, 'L', 0, 1, 22, 75, true);

$pdf->MultiCell(110, 5, $txt_charge, 0, 'L', 0, 1, 24, 83, true);

$pdf->MultiCell(55, 5, $txt_county, 0, 'L', 0, 1, 30, 91, true);

$pdf->MultiCell(55, 5, $txt_city, 0, 'L', 0, 1, 26, 99, true);
$pdf->MultiCell(55, 5, $txt_state, 0, 'L', 0, 1, 90, 99, true);
$pdf->MultiCell(55, 5, $txt_court, 0, 'L', 0, 1, 114, 99, true);

$pdf->MultiCell(55, 5, $txt_license, 0, 'L', 0, 1, 108, 115, true);

// Stop Transformation
$pdf->StopTransform();

$pdf->lastPage();

// ---------------------------------------------------------

// Close and output PDF document
$pdf->Output('powerallegheny.pdf', 'I');

