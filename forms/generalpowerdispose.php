<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once('forms.class.php');

// Load TCPDF class library
include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');


date_default_timezone_set('America/Indianapolis');

// get values

    class MYPDF extends TCPDF {

    //Page header
    public function Header() {
		include_once('forms.class.php');
		
		$bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(true, 22);
		$style = array('L' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'R' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'B' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0));

		$this->Rect(5, 49, 288, 0, 'DF', $style, array(420, 420, 400));
        $this->SetXY(5, 5);
		$arial = $this->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
		$this->SetFont($arial, 'B', 16);
		$this->setCellHeightRatio(2);
		$this->Cell(59, 0, 'General Agency' , 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->SetFont($arial, 'B', 12);
		$this->Cell(79, 0, 'Disposed Powers Report', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		//$pdf->SetXY(5, 10);
		//print_r($this->getAliasNumPage()); 
			if($this->getPage() == 1){
				$this->Ln();
				$this->SetFont($arial,'', 10);
				$this->Cell(199, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(79, 0,'Created:'.' '.date("m/d/Y H:i a"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
			}else{
				$this->Ln();
				$this->SetFont($arial,'', 10);
				$this->Cell(199, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(79, 0,'Created:'.' '.date("m/d/Y"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
			}
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->SetXY(0, 42);
		$this->SetFont($arial,'B', 10);
		$this->Cell(7, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(51, 0, 'Executed', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(50, 0, 'Power', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(86, 0, 'Defendant', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(45, 0, 'Disposed', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(54, 0, 'Liability', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Ln();
    }

    // Page footer
    public function Footer() {
		 if (2 >= $this->PageNo()) {
        $this->SetMargins(15, 50, 24, true);
    }
        // Position at 15 mm from bottom

		$this->setCellHeightRatio(2);
		$this->SetXY(0, 197);
		$arial = $this->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
		$this->SetFont($arial,'B',10);
		$this->Cell(206, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(87, 0, 'Page '.$this->getAliasNumPage().' '.'of'.' '.$this->getAliasNbPages(), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'R');    }
	
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
$arial = $pdf->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
$pdf->SetFont($arial, '', 8, '', true);
// add a page
$pdf->AddPage('L', 'A4');
$pdf->SetFont($arial, 'B', 8, '', true);
$pdf->SetMargins(0.25, 0.25, 0.25, 0.25);
$pdf->setCellHeightRatio(2);
$style = array('L' => 0,
                'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'R' => 0,
                'B' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0));
$pdf->Ln();
$pdf->SetXY(0, 50);
$pdf->SetFont($arial,'', 10);
		$sqlValue = "SELECT
				general_bonds.executeddate,
				general_bonds.`name`,
				general_bonds.amount,
				general_powers.prefix,
				general_powers.serial,
				general_bonds.disposeddate
				FROM
				general_bonds
				INNER JOIN general_powers ON general_bonds.power_id = general_powers.id
				WHERE general_bonds.disposeddate IS NOT NULL";
		$query1 = $generic->query($sqlValue);
		$h = 0;
		$i = 1;
		$sum = 0;
		$val = 0;
		 while( $row1 = $query1->fetch(PDO::FETCH_ASSOC) ) {
$executed= date('m/d/Y',strtotime($row1['executeddate']));
$power  = $row1['prefix'];
$defendant  = $row1['name'];
$disposed= date('m/d/Y',strtotime($row1['disposeddate']));
$liability  = number_format($row1['amount'], 2, '.', ',');
$liability1  = $row1['amount'];
$serial  = $row1['serial'];
			 	
		$pdf->Cell(6, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(51, 0, $executed, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(50, 0, $serial.'-'.$power, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(87, 0, $defendant, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(44, 0, $disposed, 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(54, 0, $liability, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$pdf->Ln();
$h = $h + 3 ;
		
		$sum += $liability1;
		//print_r($liability)
		
		 }
		$total_sum = number_format($sum, 2, '.', ',') ;
		$i++;		 
$pdf->Ln();

$pdf->SetFont($arial,'B',10);
$pdf->Cell(228, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Cell(69, 0,'Total: '. $total_sum, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Rect(220,65+$h, 50, 0.75, 'DF', $style, array(420, 420, 400));

//$pdf->SetFont($arial,'B',10);


// ---------------------------------------------------------


//Close and output PDF document
$pdf->Output('report.pdf', 'I');