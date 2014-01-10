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
$forms->getBondharristxjp($id,$pid);
$txt_casenumber = $forms->getField('casenumber');
$txt_spn = '';
$txt_identifiertype = $forms->getField('identifiertype');
if ($txt_identifiertype=='SPN'){
    $txt_spn = $forms->getField('identifier');
}
$txt_precinct = $forms->getField('precinct');;
$txt_dateexecuted_y = date('y');
$txt_last = $forms->getField('last');
$txt_first = $forms->getField('first') . " ";
$txt_middle = $forms->getField('middle');
if ($txt_middle!=""){
    $txt_middle = $txt_middle . " ";
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
$txt_bondamount = $forms->getField('amount');
if (strpos($txt_bondamount, '.') !== TRUE){
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
    //$txt_bondamount = $txt_bondamount . '.00';
} else {
    $txt_bondamount = number_format($txt_bondamount, 2, '.', ',');
}
$txt_checkamount = $forms->getField('checkamount');
$txt_class = $forms->getField('class');
$txt_charge = $forms->getField('charge');
$txt_charge = str_replace("&gt;", ">", $txt_charge);
$txt_charge = str_replace("&lt;", "<", $txt_charge);
$txt_charge = str_replace("&amp;", "&", $txt_charge);
$txt_judge = $forms->getField('court');
$txt_position = $forms->getField('position');
$txt_dateexecuted_month_d = date('F d');
$txt_defendantaddress = $forms->getField('defendantaddress');
$txt_defendantcity = $forms->getField('defendantcity');
$txt_defendantstate = $forms->getField('defendantstate');
$txt_defendantzip = $forms->getField('defendantzip');
$txt_defendantcitystatezip = "";
if ($txt_defendantcity!=""){
    $txt_defendantcitystatezip = $txt_defendantcity;
}
if ($txt_defendantstate!=""){
    if ($txt_defendantcitystatezip!=""){
        $txt_defendantcitystatezip = $txt_defendantcitystatezip . ", " . $txt_defendantstate;
    } else {
        $txt_defendantcitystatezip = $txt_defendantstate;
    }
}
if ($txt_defendantzip!=""){
    if ($txt_defendantcitystatezip!=""){
        $txt_defendantcitystatezip = $txt_defendantcitystatezip . " " . $txt_defendantzip;
    } else {
        $txt_defendantcitystatezip = $txt_defendantzip;
    }
}
$txt_surety = 'Allegheny Casualty Company';
$txt_agencyaddress = $forms->getField('agencyaddress');
$txt_agencycity = $forms->getField('agencycity');
$txt_agencystate = $forms->getField('agencystate');
$txt_agencyzip = $forms->getField('agencyzip');
$txt_agencycitystatezip = "";
if ($txt_agencycity!=""){
    $txt_agencycitystatezip = $txt_agencycity;
}
if ($txt_agencystate!=""){
    if ($txt_agencycitystatezip!=""){
        $txt_agencycitystatezip = $txt_agencycitystatezip . ", " . $txt_agencystate;
    } else {
        $txt_agencycitystatezip = $txt_agencystate;
    }
}
if ($txt_agencyzip!=""){
    if ($txt_agencycitystatezip!=""){
        $txt_agencycitystatezip = $txt_agencycitystatezip . " " . $txt_agencyzip;
    } else {
        $txt_agencycitystatezip = $txt_agencyzip;
    }
}
$txt_jail = $forms->getField('standingcustodyjail');
$txt_dateexecuted_d = date('d');
$txt_dateexecuted_month = date('F');
$translatex =  $forms->getField('translatex');
$translatey =  $forms->getField('translatey');
//$translatey = $translatey - 5; //homestead
$translatey = $translatey; //washington

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

$pdf->MultiCell(55, 5, $txt_casenumber, 0, 'L', 0, 1, 180, 3, true);

$pdf->MultiCell(55, 5, $txt_spn, 0, 'L', 0, 1, 180, 9, true);

$pdf->MultiCell(55, 5, $txt_precinct, 0, 'L', 0, 1, 96, 18, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_y, 0, 'L', 0, 1, 115, 27, true);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(100, 5, $txt_defendant, 0, 'L', 0, 1, 10, 55, true);

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(55, 5, $txt_bondamount, 0, 'L', 0, 1, 175, 60, true);

$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(100, 5, $txt_checkamount, 0, 'L', 0, 1, -1, 64, true);

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(55, 5, $txt_class, 0, 'L', 0, 1, 155, 80, true);
$pdf->MultiCell(110, 5, $txt_charge, 0, 'L', 0, 1, 0, 89, true);

$pdf->MultiCell(55, 5, $txt_judge, 0, 'L', 0, 1, 0, 101, true);
$pdf->MultiCell(55, 5, $txt_precinct, 0, 'L', 0, 1, 62, 101, true);
$pdf->MultiCell(55, 5, $txt_position, 0, 'L', 0, 1, 116, 101, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_month_d, 0, 'L', 0, 1, 85, 134, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_y, 0, 'L', 0, 1, 193, 134, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_month_d, 0, 'L', 0, 1, 27, 150, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_y, 0, 'L', 0, 1, 55, 150, true);

$pdf->MultiCell(55, 5, $txt_defendant, 0, 'L', 0, 1, 112, 151, true);

$pdf->MultiCell(55, 5, $txt_defendantaddress, 0, 'L', 0, 1, 112, 155, true);

$pdf->MultiCell(55, 5, $txt_defendantcitystatezip, 0, 'L', 0, 1, 112, 165, true);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(55, 5, $txt_surety, 0, 'L', 0, 1, 3, 169, true);

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(55, 5, $txt_agencyaddress, 0, 'L', 0, 1, 3, 185, true);

$pdf->MultiCell(55, 5, $txt_agencycitystatezip, 0, 'L', 0, 1, 3, 189, true);

$pdf->MultiCell(55, 5, $txt_jail, 0, 'L', 0, 1, 105, 220, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_d, 0, 'L', 0, 1, 178, 345, true);

$pdf->MultiCell(55, 5, $txt_dateexecuted_month, 0, 'L', 0, 1, 103, 353, true);
$pdf->MultiCell(55, 5, $txt_dateexecuted_y, 0, 'L', 0, 1, 196, 353, true);

// Stop Transformation
$pdf->StopTransform();

$pdf->lastPage();

// ---------------------------------------------------------

// Close and output PDF document
$pdf->Output('bondharristxjp.pdf', 'I');

