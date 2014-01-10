<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once('forms.class.php');
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

$forms = new Forms();
$forms->getReportcolumnar($id);

$sqlraw = $forms->getField('sqlraw');
$condition = $forms->getField('condition');
$report = $forms->getField('report');
$generator = $forms->getField('generator');
$title = $forms->getField('title');

$GLOBALS['title'] = $title;
$GLOBALS['report'] = $report;
$GLOBALS['condition'] = $condition;

$query = $generic->query($sqlraw);

$txt_pdfcreator = $cat;
$txt_pdfauthor = $cat;
$txt_pdftitle = $cat;
$txt_pdffile = $generator.'.pdf';

class MYPDF extends TCPDF {

    public function Header() {

        $txt_title = $GLOBALS['title'];
        $txt_report = $GLOBALS['report'];
        $txt_condition = $GLOBALS['condition'];

        $this->SetAutoPageBreak(true, 22);

        //??
        $this->setCellHeightRatio(2);

        $this->SetXY(5, 5);
		$this->SetFont('helvetica', 'B', 16);
		$this->Cell(59, 0, $txt_title, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->SetX(178);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(110, 0, $txt_report, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
        $this->Ln();

        $this->SetX(199);
        $this->SetFont('helvetica','', 10);
		$this->Cell(89, 0,'Created: '.date("m/d/Y H:i a"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Ln();

        if ($txt_condition!=''){
            $this->SetX(99);
            $this->SetFont('helvetica','', 10);
    		$this->Cell(189, 0,'Condition(s): '.$txt_condition, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
    		$this->Ln();
        }

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
    $grandtotal1        = 0; // general_powers.`value`
}

if ($group==1){
    $grouplastvalue     = ''; // prefix
    $groupsubcount      = 0; // count
    $groupsub1          = 0; // general_powers.`value`
}

while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {

    $txt_prefix     = $row['prefix'];
    $txt_serial     = $row['serial'];
    $txt_value      = $row['value'];
    $txt_value_us   = number_format($row['value'], 2, '.', ',');
    $txt_date       = $row['date'];
    $txt_date_mdY   = date('m/d/Y',strtotime($row['date']));
    $txt_agent      = $row['agent'];

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
            $pdf->SetX(106);
            $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
            $pdf->Ln();
            $pdf->Rect(106, $gy, 45, 0.75, 'DF', $stylesingle, array(420, 420, 400));
            $pdf->Ln();

            $groupsubcount  = 0;
            $groupsub1      = 0;
        }
    }

    $pdf->SetX(5);
    $pdf->SetFont('helvetica','', 10);
    $pdf->Cell(51, 0, $txt_prefix, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(50, 0, $txt_serial, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(45, 0, $txt_value_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(56, 0, $txt_date_mdY, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(84, 0, $txt_agent, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
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
        $pdf->SetX(106);
        $pdf->Cell(45, 0, $txt_groupsub1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $pdf->Ln();
        $pdf->Rect(106, $gy, 45, 0.75, 'DF', $stylesingle, array(420, 420, 400));
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
    $pdf->SetX(106);
    $pdf->Cell(45, 0, $txt_grandtotal1_us, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Ln();
    $pdf->Rect(106, $gy, 45, 0.75, 'DF', $styledouble, array(420, 420, 400));
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($txt_pdffile, 'I');