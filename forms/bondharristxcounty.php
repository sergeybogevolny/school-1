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
$forms->getBondharristxcounty($id,$pid);
$txt_casenumber = $forms->getField('casenumber');
$txt_charge = $forms->getField('charge');
$txt_charge = str_replace("&gt;", ">", $txt_charge);
$txt_charge = str_replace("&lt;", "<", $txt_charge);
$txt_charge = str_replace("&amp;", "&", $txt_charge);
$txt_spn = '';
$txt_identifiertype = $forms->getField('identifiertype');
if ($txt_identifiertype=='SPN'){
    $txt_spn = $forms->getField('identifier');
}
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
$txt_surety = 'Allegheny Casualty Company';
$txt_agent = $forms->getField('agent');
$txt_suretyagent_concat = $txt_surety.', ( agent, '.$txt_agent.' )';
$txt_agent_concat = 'agent, '.$txt_agent;
$txt_checkamount = $forms->getField('checkamount');
$txt_bondamount = $forms->getField('amount');
if (strpos($txt_bondamount, '.') !== TRUE){
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
    //$txt_bondamount = $txt_bondamount . '.00';
} else {
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
}
$txt_class = $forms->getField('class');
$txt_court = $forms->getField('court');
$txt_dateexecuted_mdY = date('m/d/Y');
$txt_address = $forms->getField('address');
$txt_city = $forms->getField('city');
$txt_state = $forms->getField('state');
$txt_zip = $forms->getField('zip');
$txt_citystzip="";
$txt_city = $forms->getField('city');
$txt_state = $forms->getField('state');
$txt_zip = $forms->getField('zip');
if ($txt_city!=""){
    $txt_citystatezip = $txt_city;
}
if ($txt_state!=""){
    if ($txt_citystatezip!=""){
        $txt_citystatezip = $txt_citystatezip . ", " . $txt_state;
    } else {
        $txt_citystatezip = $txt_state;
    }
}
if ($txt_zip!=""){
    if ($txt_citystatezip!=""){
        $txt_citystatezip = $txt_citystatezip . " " . $txt_zip;
    } else {
        $txt_citystatezip = $txt_zip;
    }
}
$txt_phone = $forms->getField('phone');
$txt_license = $forms->getField('license');
$txt_empl = 'Home';
$txt_jail = $forms->getField('standingcustodyjail');
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
$resolution= array(216, 400);
$pdf->AddPage('P', $resolution);

$pdf->StartTransform();
// Translate +# to the right, +# to the bottom
$pdf->Translate($translatex, $translatey);
//$pdf->MultiCell(55, 5, 'x'.$translatex, 0, 'L', 0, 1, 10, 10, true);
//$pdf->MultiCell(55, 5, 'y'.$translatey, 0, 'L', 0, 1, 20, 10, true);

$pdf->MultiCell(55, 5, $txt_casenumber, 0, 'L', 0, 1, 159, 20, true);

$pdf->MultiCell(45, 15, $txt_charge, 0, 'L', 0, 1, 157, 30, true);

$pdf->MultiCell(55, 5, $txt_spn, 0, 'L', 0, 1, 147, 49, true);

$pdf->MultiCell(150, 5, $txt_defendant, 0, 'L', 0, 1, 13, 68, true);

$pdf->MultiCell(110, 5, $txt_suretyagent_concat, 0, 'L', 0, 1, 9, 78, true);

$pdf->MultiCell(110, 5, $txt_checkamount, 0, 'L', 0, 1, -2, 89, true);
$pdf->MultiCell(55, 5, $txt_bondamount, 0, 'L', 0, 1, 86, 89, true);

$pdf->MultiCell(55, 5, $txt_class, 0, 'L', 0, 1, 158, 108, true);

$pdf->MultiCell(55, 5, $txt_court, 0, 'L', 0, 1, 162, 117, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_mdY, 0, 'L', 0, 1, 129, 154, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_mdY, 0, 'L', 0, 1, 6, 163, true);

$pdf->MultiCell(55, 5, $txt_surety, 0, 'L', 0, 1, -2, 182, true);

$pdf->MultiCell(55, 5, $txt_agent_concat, 0, 'L', 0, 1, -2, 199, true);

$pdf->MultiCell(55, 5, $txt_address, 0, 'L', 0, 1, -2, 203, true);

$pdf->MultiCell(55, 5, $txt_citystatezip, 0, 'L', 0, 1, -2, 212, true);
$pdf->MultiCell(55, 5, $txt_phone, 0, 'L', 0, 1, 46, 212, true);

$pdf->MultiCell(55, 5, $txt_license, 0, 'L', 0, 1, 4, 224, true);
$pdf->MultiCell(55, 5, $txt_empl, 0, 'L', 0, 1, 46, 224, true);

$pdf->MultiCell(55, 5, $txt_jail, 0, 'L', 0, 1, 122, 233, true);

$pdf->MultiCell(55, 5, $txt_surety, 0, 'L', 0, 1, 58, 295, true);

$pdf->MultiCell(55, 5, $txt_agent_concat, 0, 'L', 0, 1, 28, 337, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_mdY, 0, 'L', 0, 1, 118, 369, true);

// Stop Transformation
$pdf->StopTransform();

$pdf->lastPage();

// ---------------------------------------------------------

// Close and output PDF document
$pdf->Output('bondharristxcounty.pdf', 'I');

