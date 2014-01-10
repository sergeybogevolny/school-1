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
$group = 1;
$groupby = 'prefix';

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

$sqlglobal = "SELECT
general_powers_distributes.date,
general_settings_general.`name` AS general,
general_agents.company AS agency,
general_agents.address,
general_agents.city,
general_agents.state,
general_agents.zip,
SUM(general_powers_distributes_details.`value`) as valuesum,
COUNT(general_powers_distributes_details.`value`) as valuecount
FROM
general_settings_general,
general_powers_distributes
INNER JOIN general_powers_distributes_details ON general_powers_distributes_details.distribute_id = general_powers_distributes.id
INNER JOIN general_agents ON general_powers_distributes.agent_id = general_agents.id
WHERE general_powers_distributes.id =".$id;

$sqlraw = "SELECT
general_powers_distributes.date,
general_powers_distributes_details.prefix,
general_powers_distributes_details.serial,
general_powers_distributes_details.`value`,
general_powers_distributes_details.expiration,
general_settings_general.`name` AS general,
general_agents.company as agency,
general_agents.address,
general_agents.city,
general_agents.state,
general_agents.zip
FROM
general_settings_general,
general_powers_distributes
INNER JOIN general_powers_distributes_details ON general_powers_distributes_details.distribute_id = general_powers_distributes.id
INNER JOIN general_agents ON general_powers_distributes.agent_id = general_agents.id
WHERE general_powers_distributes.id =".$id;

$query1 = $generic->query($sqlglobal);
$global = $query1->fetch(PDO::FETCH_ASSOC);

$title = $global['general'];
$report = "Power Distribution Report";
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
$valuesum = $global['valuesum'];
$valuesum_us = number_format($global['valuesum'], 2, '.', ',');
$valuecount = $global['valuecount'];

$GLOBALS['title'] = $title;
$GLOBALS['report'] = $report;
$GLOBALS['date'] = $date_mdY;
$GLOBALS['agent1'] = $agent1;
$GLOBALS['agent2'] = $agent2;
$GLOBALS['agent3'] = $agent3;
$GLOBALS['valuesum'] = $valuesum_us;
$GLOBALS['valuecount'] = $valuecount;

$txt_pdfcreator = $cat;
$txt_pdfauthor = $cat;
$txt_pdftitle = $cat;
$txt_pdffile = 'generaldistribution1.pdf';

class MYPDF extends TCPDF {

    public function Header() {

        $txt_title = $GLOBALS['title'];
        $txt_report = $GLOBALS['report'];
        $txt_date_mdY = $GLOBALS['date'];
        $txt_agent1 = $GLOBALS['agent1'];
        $txt_agent2 = $GLOBALS['agent2'];
        $txt_agent3 = $GLOBALS['agent3'];
        $txt_valuesum_us = $GLOBALS['valuesum'];
        $txt_valuecount = $GLOBALS['valuecount'];

        $this->SetAutoPageBreak(true, 22);

        //??
        $this->setCellHeightRatio(2);

        $this->SetXY(5, 5);
		$this->SetFont('helvetica', 'B', 16);
		$this->Cell(59, 0, $txt_title, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->SetX(178);
		$this->SetFont('helvetica', '', 12);
		$this->Cell(110, 0, $txt_date_mdY, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        $this->SetX(5);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(59, 0, $txt_report, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');

        if ($txt_agent1!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0,  $txt_agent1, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        }
        $this->SetX(215);
        $this->SetFont('helvetica','B', 10);
    	$this->Cell(38, 0,  'Count', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0,  'Value', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        if ($txt_agent2!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0, $txt_agent2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    	}
        $this->SetX(215);
        $this->SetFont('helvetica','', 10);
    	$this->Cell(38, 0,  '# '.$txt_valuecount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(38, 0,  '$ '.$txt_valuesum_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        if ($txt_agent3!=''){
            $this->SetX(95);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0, $txt_agent3, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
            $this->Ln();
        }

        $this->SetXY(5, 42);
		$this->SetFont('helvetica','B', 10);
		$this->Cell(45, 0, 'Prefix', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Serial', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Value', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Expiration', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
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
    $grandtotal1        = 0; // general_powers_distributes_details.`value`
}

if ($group==1){
    $grouplastvalue     = ''; // prefix
    $groupsubcount      = 0; // count
    $groupsub1          = 0; // general_powers_distributes_details.`value`
}

$query2 = $generic->query($sqlraw);
while( $row = $query2->fetch(PDO::FETCH_ASSOC) ) {

    $txt_prefix             = $row['prefix'];
    $txt_serial             = $row['serial'];
    $txt_value              = $row['value'];
    $txt_value_us           = number_format($row['value'], 2, '.', ',');
    $txt_expiration_mdY     = date('m/d/Y', strtotime($row['expiration']));

    if ($group==1){
        $by = $row[$groupby];
        if ($grouplastvalue==''){
            $grouplastvalue=$by;
        }
        if ($grouplastvalue!=$by){
            //INSERT SUB LINE upon new group WITH $groupsub1 and $groupsub2
            $txt_groupsubcount  = $groupsubcount;
            $txt_groupsub1_us   = number_format($groupsub1, 2, '.', ',') ;

            //$pdf->Ln();

            $gy = $pdf->GetY();
            if ($gy>190){
                $pdf->AddPage('L', 'A4');
                $pdf->SetY(55);
                $gy = 55;
            }
            $pdf->SetX(5);
            $pdf->SetFont('helvetica','B',10);
            $pdf->Cell(55, 0, 'Subtotal Count: '.$txt_groupsubcount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
            $pdf->SetX(95);
            $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
            $pdf->Ln();
            $pdf->Rect(95, $gy, 45, 0.75, 'DF', $stylesingle, array(420, 420, 400));
            $pdf->Ln();

            $groupsubcount  = 0;
            $groupsub1      = 0;
        }
    }


    $pdf->SetX(5);
    $pdf->SetFont('helvetica','', 10);
    $pdf->Cell(45, 0, $txt_prefix, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_serial, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_value_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_expiration_mdY, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();

    if ($group==1){
        $grouplastvalue = $txt_prefix;
        $groupsubcount  = $groupsubcount + 1;
        $groupsub1      = $groupsub1 + $txt_value;
    }

    if ($total==1){
        $grandtotalcount    = $grandtotalcount + 1;
        $grandtotal1        = $grandtotal1 + $txt_value;
    }

}

if ($group==1){
    if ($groupsubcount>0){
        //INSERT SUB LINE if last new group WITH $groupsub1 and $groupsub2
        $txt_groupsubcount  = $groupsubcount;
        $txt_groupsub1_us   = number_format($groupsub1, 2, '.', ',') ;

        //$pdf->Ln();

        $gy = $pdf->GetY();
        if ($gy>190){
            $pdf->AddPage('L', 'A4');
            $pdf->SetY(55);
            $gy = 55;
        }
        $pdf->SetX(5);
        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(55, 0, 'Subtotal Count: '.$txt_groupsubcount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $pdf->SetX(95);
        $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $pdf->Ln();
        $pdf->Rect(95, $gy, 45, 0.75, 'DF', $stylesingle, array(420, 420, 400));
        $pdf->Ln();

    }
}

if ($total==1){
    $txt_grandtotalcount    = $grandtotalcount;
    $txt_grandtotal1_us     = number_format($grandtotal1, 2, '.', ',') ;

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
    $pdf->SetX(95);
    $pdf->Cell(45, 0, $txt_grandtotal1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();
    $pdf->Rect(95, $gy, 45, 0.75, 'DF', $styledouble, array(420, 420, 400));
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($txt_pdffile, 'I');