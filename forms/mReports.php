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
// get values
    class MYPDF extends TCPDF {

    //Page header
    public function Header() {
		include_once('forms.class.php');
		$id = $_GET['id'];
		$forms = new Forms();
		$forms->getMasterReport($id);
		$name  = $forms->getField('name');
		$condition = $forms->getField('condition');
		$id  = $forms->getField('id');
		//print_r($condition);
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
		$this->Cell(59, 0, $name , 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(30, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->SetFont($arial, 'B', 12);
		$this->Cell(79, 0, 'Test Report', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		//$pdf->SetXY(5, 10);
		//print_r($this->getAliasNumPage()); 
			if($this->getPage() == 1){
				$this->Ln();
				$this->SetFont($arial,'', 10);
				$this->Cell(199, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(79, 0,'Date:'.' '.date("m/d/Y"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
				$this->Ln();
				$this->SetFont($arial,'B', 10);
				$this->Cell(121, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(157, 0,'Condition:'.' '.$condition, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
			}else{
				$this->Ln();
				$this->SetFont($arial,'', 10);
				$this->Cell(199, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(79, 0,'Date:'.' '.date("m/d/Y"), 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
				$this->Ln();
				$this->SetFont($arial,'B', 10);
				$this->Cell(121, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
				$this->Cell(157, 0,'Condition:'.' '.$condition, 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
			}
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->SetXY(0, 42);
		$this->SetFont($arial,'B', 10);
		$this->Cell(7, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(51, 0, 'Date', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(25, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$this->Cell(53, 0, 'Credit', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(53, 0, 'Debit', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$this->Cell(54, 0, 'Amount', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
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
$style = array('L' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'T' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'R' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0),
                'B' => array('width' => 0.10, 'cap' => 'round', 'join' => 'miter', 'dash' => 0));
$pdf->Rect(5, 49, 288, 0, 'DF', $style, array(420, 420, 400));
//$pdf->Rect(5, 59, 288, 0, 'DF', $style, array(420, 420, 400));
//$pdf->Rect(220, 92, 70, 0, 'DF', $style, array(420, 420, 400));
$pdf->SetFont($arial,'B', 10);
//$pdf->SetXY(0, 50);
//$pdf->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
//$pdf->Cell(77, 0, 'Group Label: Value', 1, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
$pdf->Ln();
$pdf->SetXY(0, 50);
$pdf->SetFont($arial,'', 10);
$pdf->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');

global $generic;
    $sql = 'SELECT* FROM nql_report WHERE id='.$id;
	
		$query = $generic->query($sql);
	//$stmt = parent::query($sql);
	 if ($query->rowCount() > 0) {
		 
		 
		 while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
			 
			 
			 
			 $sqlValue = $row['sqlraw'];
			 $cond = $row['condition'];
			// print_r( $row );
			 
	     
		$query1 = $generic->query($sqlValue);
       // print_r($query1);
	 	//$arr = '';
		
		 while( $row1 = $query1->fetch(PDO::FETCH_ASSOC) ) {
			 //print_r($i);
			 	$date  = date('m/d/y');
				$amount = number_format($row1['balance'], 2, '.', ',');
				$last  = number_format($row1['credit'], 2, '.', ',');;
				$first  = number_format($row1['debit'], 2, '.', ',');;
				
				$date1= date('m/d/Y',strtotime($row1['date']));
				
				
if($pdf->getPage() >= 100){
$pdf->SetFont($arial,'', 10);


}

		$pdf->Cell(53, 0, $date1, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(53, 0, $last, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(53, 0, $first, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(54, 0, $amount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Ln();
		$pdf->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(53, 0, $date1, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(53, 0, $last, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(53, 0, $first, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(25, 0, '', 0, $ln=0, 'C', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(54, 0, $amount, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$pdf->Cell(5, 0, '', 0, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
		
			   }
		 
		 }
		
	 }
//$pdf->SetFont($arial,'B',10);
//$pdf->Cell(206, 0, '', 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
//$pdf->Cell(87, 0, 'Group Level: Total', 1, $ln=0, 'R', 0, '', 0, false, 'T', 'C');
//$pdf->SetFont($arial,'B',10);


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('report.pdf', 'I');