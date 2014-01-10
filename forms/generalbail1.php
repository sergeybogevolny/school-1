<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');
date_default_timezone_set('America/Indianapolis');

if (!isset($_GET['id'])) {
    die();
}
$id = $_GET['id'];

//SET
$cat = 'PrincetonTrust';
$total = 1;
$group = 0;
$groupby = '';

//Style for Single Line
$stylesingle = array('L' => 0,
            'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
            'R' => 0,
            'B' => 0);

//Style for Double Line
$styledouble = array('L' => 0,
            'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
            'R' => 0,
            'B' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0));

$sqlraw = "SELECT
general_settings_general.`name` as agency,
general_settings_general.address,
general_settings_general.city,
general_settings_general.state,
general_settings_general.zip,
general_powers_reports.date as `date`,
general_powers_reports.net,
general_powers_reports.buf,
general_powers_reports.netcalculated as netsum,
general_powers_reports.bufcalculated as bufsum,
CONCAT_WS('-',general_powers_reports_details.prefix,general_powers_reports_details.serial) as `power`,
general_powers_reports_details.executed,
general_powers_reports_details.defendant,
general_powers_reports_details.amount,
general_powers_reports_details.netcalculated,
general_powers_reports_details.bufcalculated
FROM
general_settings_general,
general_powers_reports
INNER JOIN general_powers_reports_details ON general_powers_reports_details.report_id = general_powers_reports.id
WHERE general_powers_reports.id=".$id;

$query1 = $generic->query($sqlraw);
$global = $query1->fetch(PDO::FETCH_ASSOC);

$report = "Agent's Bail Report";
$date_mdY = date('m/d/Y',strtotime($global['date']));
$agent1 = $global['agency'];
$agent2 = $global['address'];
$agent3 = "";
$city = $global['city'];
$state = $global['state'];
$zip = $global['zip'];
if ($city!=""){
    $agent3 = $city;
}
if ($state!=""){
    if ($agent3!=""){
        $agent3 = $agent3 . ", " . $state;
    } else {
        $agent3 = $state;
    }
}
if ($zip!=""){
    if ($agent3!=""){
        $agent3 = $agent3 . " " . $zip;
    } else {
        $agent3 = $zip;
    }
}
$net = $global['net'];
$buf = $global['buf'];
$netsum = $global['netsum'];
$netsum_us = number_format($global['netsum'], 2, '.', ',');
$bufsum = $global['bufsum'];
$bufsum_us = number_format($global['bufsum'], 2, '.', ',');


$GLOBALS['report'] = $report;
$GLOBALS['date'] = $date_mdY;
$GLOBALS['agent1'] = $agent1;
$GLOBALS['agent2'] = $agent2;
$GLOBALS['agent3'] = $agent3;
$GLOBALS['net'] = $net;
$GLOBALS['buf'] = $buf;
$GLOBALS['netsum'] = $netsum_us;
$GLOBALS['bufsum'] = $bufsum_us;

$txt_pdfcreator = $cat;
$txt_pdfauthor = $cat;
$txt_pdftitle = $cat;
$txt_pdffile = 'generalbail1.pdf';

class MYPDF extends TCPDF {

    public function Header() {

        $txt_report = $GLOBALS['report'];
        $txt_date_mdY = $GLOBALS['date'];
        $txt_agent1 = $GLOBALS['agent1'];
        $txt_agent2 = $GLOBALS['agent2'];
        $txt_agent3 = $GLOBALS['agent3'];
        $txt_net = $GLOBALS['net'];
        $txt_buf = $GLOBALS['buf'];
        $txt_netsum_us = $GLOBALS['netsum'];
        $txt_bufsum_us = $GLOBALS['bufsum'];

        $this->SetAutoPageBreak(true, 22);

        //??
        $this->setCellHeightRatio(2);

        $this->SetXY(5, 5);
		$this->SetFont('helvetica', 'B', 16);
		$this->Cell(59, 0, $txt_report, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->SetX(178);
		$this->SetFont('helvetica', '', 12);
		$this->Cell(110, 0, $txt_date_mdY, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        if ($txt_agent1!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0,  $txt_agent1, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        }
        $this->SetX(215);
        $this->SetFont('helvetica','B', 10);
    	$this->Cell(38, 0,  'Net', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0,  'BUF', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        if ($txt_agent2!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0, $txt_agent2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    	}
        $this->SetX(215);
        $this->SetFont('helvetica','', 10);
    	$this->Cell(38, 0,  '% '.$txt_net, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0,  '% '.$txt_buf, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        if ($txt_agent3!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0, $txt_agent3, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        }
        $this->SetX(215);
        $this->SetFont('helvetica','', 10);
    	$this->Cell(38, 0,  '$ '.$txt_netsum_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0,  '$ '.$txt_bufsum_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        $this->SetXY(5, 42);
		$this->SetFont('helvetica','B', 10);
		$this->Cell(45, 0, 'Power #', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Posted', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(70, 0, 'Defendant', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(50, 0, 'Bond Amount', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(38, 0, 'Net', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0, 'BUF', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Ln();
        $this->Ln();

    }

    public function Footer() {

        $this->SetTopMargin(50);

        //??
		$this->setCellHeightRatio(2);

		$this->SetXY(206, 197);
		$this->SetFont('helvetica','B',10);

        //TODO - using alias creates a string buffer that does not align left correctly
        $txt_page = 'Page '. $this->getAliasNumPage() . ' of '. $this->getAliasNbPages();

		$this->Cell(82, 0, $this->PageNo(), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
        $this->Ln();

    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator($txt_pdfcreator);
$pdf->SetAuthor($txt_pdfauthor);
$pdf->SetTitle($txt_pdftitle);

$pdf->AddPage('L', 'A4');

//??
$pdf->setCellHeightRatio(2);
$pdf->SetXY(0, 50);

if ($total==1){
    $grandtotalcount    = 0; // count
    $grandtotal1        = 0; // agency_powers_reports_details.amount
    $grandtotal2        = 0; // agency_powers_reports_details.netcalculated
    $grandtotal3        = 0; // agency_powers_reports_details.bufcalculated
}

$query2 = $generic->query($sqlraw);
while( $row = $query2->fetch(PDO::FETCH_ASSOC) ) {

    $txt_power              = $row['power'];
    $txt_executed_mdY       = date('m/d/Y', strtotime($row['executed']));
    $txt_defendant          = $row['defendant'];
    $txt_amount             = $row['amount'];
    $txt_amount_us          = number_format($row['amount'], 2, '.', ',');
    $txt_netcalculated      = $row['netcalculated'];
    $txt_netcalculated_us   = number_format($row['netcalculated'], 2, '.', ',');
    $txt_bufcalculated      = $row['bufcalculated'];
    $txt_bufcalculated_us   = number_format($row['bufcalculated'], 2, '.', ',');

    $pdf->SetX(5);
    $pdf->SetFont('helvetica','', 10);
    $pdf->Cell(45, 0, $txt_power, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_executed_mdY, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(70, 0, $txt_defendant, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(50, 0, $txt_amount_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(38, 0, $txt_netcalculated_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(38, 0, $txt_bufcalculated_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();

    if ($total==1){
        $grandtotalcount    = $grandtotalcount + 1;
        $grandtotal1        = $grandtotal1 + $txt_amount;
        $grandtotal2        = $grandtotal2 + $txt_netcalculated;
        $grandtotal3        = $grandtotal3 + $txt_bufcalculated;
    }

}

if ($total==1){
    $txt_grandtotalcount    = $grandtotalcount;
    $txt_grandtotal1_us     = number_format($grandtotal1, 2, '.', ',') ;
    $txt_grandtotal2_us     = number_format($grandtotal2, 2, '.', ',') ;
    $txt_grandtotal3_us     = number_format($grandtotal3, 2, '.', ',') ;

    //$pdf->Ln();

    $gy = $pdf->GetY();
    if ($gy>190){
        $pdf->AddPage('L', 'A4');
        $pdf->SetY(55);
        $gy = 55;
    }
    $pdf->SetX(5);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(55, 0, 'Total Count: '.$txt_grandtotalcount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->SetX(165);
    $pdf->Cell(50, 0, $txt_grandtotal1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(38, 0, $txt_grandtotal2_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(38, 0, $txt_grandtotal3_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();
    $pdf->Rect(165, $gy, 125, 0.75, 'DF', $styledouble, array(420, 420, 400));
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($txt_pdffile, 'I');