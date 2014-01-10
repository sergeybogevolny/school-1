<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once('forms.class.php');
include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');
date_default_timezone_set('America/Indianapolis');

class MYPDF extends TCPDF {

    public function Header() {

		include_once('forms.class.php');
		$forms = new Forms();

        $this->SetAutoPageBreak(true, 22);

        //??
        $this->setCellHeightRatio(2);

        $this->SetXY(5, 5);
		$this->SetFont('helvetica', 'B', 16);
		$this->Cell(59, 0, 'Agency Name', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->SetX(178);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(110, 0, 'Available Powers by Prefix Report', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        $this->SetX(199);
        $this->SetFont('helvetica','', 10);
		$this->Cell(89, 0,'Created: '.date("m/d/Y H:i a"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Ln();

        $this->SetXY(5, 42);
		$this->SetFont('helvetica','B', 10);
		$this->Cell(51, 0, 'Prefix', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(50, 0, 'Serial', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Value', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(56, 0, 'Received', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(84, 0, 'Agent', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
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

$sql = "SELECT
    general_powers_orders.date,
	general_powers.serial,
	general_powers.prefix,
	general_powers.`value`,
	general_powers.agent
	FROM
	general_powers
	INNER JOIN general_powers_orders ON general_powers.order_id = general_powers_orders.id
	WHERE general_powers.report_id IS NULL
    ORDER BY general_powers.prefix ASC";

$query = $generic->query($sql);


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator('PrincetonTrust');
$pdf->SetAuthor('PrincetonTrust');
$pdf->SetTitle('PrincetonTrust');


$pdf->AddPage('L', 'A4');

$style = array('L' => 0,
                'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'R' => 0,
                'B' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0));

//??
$pdf->setCellHeightRatio(2);
$pdf->SetXY(0, 50);

$grandtotal1 = 0; // general_powers.`value`
$grandtotal2 = 0; // count

$grouplastvalue = '';
$groupsub1 = 0; // general_powers.`value`
$groupsub2 = 0; // count

while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {

    $txt_prefix     = $row['prefix'];
    $txt_serial     = $row['serial'];
    $txt_value      = $row['value'];
    $txt_value_us   = number_format($row['value'], 2, '.', ',');
    $txt_date       = $row['date'];
    $txt_date_mdY   = date('m/d/Y',strtotime($row['date']));
    $txt_agent      = $row['agent'];

    if ($grouplastvalue==''){
        $grouplastvalue = $txt_prefix;
    }

    if ($grouplastvalue!=$txt_prefix){
        //INSERT SUB LINE upon new group WITH $groupsub1 and $groupsub2

        $txt_groupsub1_us = number_format($groupsub1, 2, '.', ',') ;
        $txt_groupsub2 = $groupsub2;

        //$pdf->Ln();

        $gy = $pdf->GetY();
        $pdf->SetX(5);
        $pdf->SetFont('helvetica','B',10);
        $pdf->Cell(55, 0, 'Subtotal Count: '.$txt_groupsub2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $pdf->SetX(106);
        $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $pdf->Ln();
        $pdf->Rect(106, $gy, 45, 0.75, 'DF', $style, array(420, 420, 400));
        $pdf->Ln();

        $groupsub1 = 0;
        $groupsub2 = 0;
    }

    $pdf->SetX(5);
    $pdf->SetFont('helvetica','', 10);
    $pdf->Cell(51, 0, $txt_prefix, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(50, 0, $txt_serial, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_value_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(56, 0, $txt_date_mdY, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(84, 0, $txt_agent, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();

    $grouplastvalue = $txt_prefix;
    $groupsub1 = $groupsub1 + $txt_value;
    $groupsub2 = $groupsub2 + 1;

    $grandtotal1 = $grandtotal1 + $txt_value;
    $grandtotal2 = $grandtotal2 + 1;

}

if ($groupsub2>0){
    //INSERT SUB LINE if last new group WITH $groupsub1 and $groupsub2

    $txt_groupsub1_us = number_format($groupsub1, 2, '.', ',') ;
    $txt_groupsub2 = $groupsub2;

    //$pdf->Ln();

    $gy = $pdf->GetY();
    $pdf->SetX(5);
    $pdf->SetFont('helvetica','B',10);
    $pdf->Cell(55, 0, 'Subtotal Count: '.$txt_groupsub2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->SetX(106);
    $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();
    $pdf->Rect(106, $gy, 45, 0.75, 'DF', $style, array(420, 420, 400));
    $pdf->Ln();

}

$txt_grandtotal1_us = number_format($grandtotal1, 2, '.', ',') ;
$txt_grandtotal2 = $grandtotal2;

//$pdf->Ln();

$gy = $pdf->GetY();
$pdf->SetX(5);
$pdf->SetFont('helvetica','B',10);
$pdf->Cell(55, 0, 'Total Count: '.$txt_grandtotal2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->SetX(106);
$pdf->Cell(45, 0, $txt_grandtotal1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Ln();
$pdf->Rect(106, $gy, 45, 0.75, 'DF', $style, array(420, 420, 400));

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('report.pdf', 'I');