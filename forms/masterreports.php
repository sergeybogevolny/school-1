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
   class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
	
	 public function Table($footer) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        //$this->SetTextColor();
        $this->SetDrawColor(255, 255, 255);
        //$this->SetLineWidth(0.0);
        $this->SetFont('', '');
        // Header
        $w = array(40, 35, 40, 45);
        $num_footer = count($footer);
        for($i = 0; $i < $num_footer; ++$i) {
            $this->Cell($w[$i], 7, $footer[$i], 1, 0, 'R', 1);
        }}

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(204, 204, 204);
        $this->SetTextColor();
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 40, 40, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('','');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
			$this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$alignments = array('L' => 'LEFT', 'C' => 'CENTER', 'R' => 'RIGHT', 'J' => 'JUSTIFY');
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

// set font
$arial = $pdf->addTTFfont('../integration/tcpdf/fonts/arial.ttf','TrueTypeUnicode','');
$pdf->SetFont($arial,'',12);

// add a page
$pdf->AddPage();

// column titles
$header = array('Date', 'Payment', 'Cradit', 'Debit');
$footer = array('Total', '', '0000', '0000');
// data loading

   
	global $generic;
    $sql = 'SELECT conditions FROM reports WHERE id='.$id;
	
	$query = $generic->query($sql);
	while($row = $query->fetch(PDO::FETCH_ASSOC))
		 
		 $sqlStmt = $row['conditions'];
			//$sql1 = "'".$sqlStmt."'";
			
			$query1 = $generic->query($sqlStmt);
			//print_r($query1);
			$arr = '';
			while($row1 = $query1->fetch(PDO::FETCH_ASSOC)){
				
				$timestamp = strtotime($row1['date']);
				$dateee = date('m/d/Y', $timestamp);

				
				$credit = $row1['entry']== null ? 0 : $row1['entry'];
				$debit =  $row1['debit']== null ? 0 : $row1['debit'];
				
				$arr[] = array( $dateee, $credit , $debit ,$row1['credit']);
				
				
			}

$data = $arr;
// print colored table
$pdf->ColoredTable($header, $data);
$pdf->Ln();

// ---------------------------------------------------------
//$pdf->array('Total', ' ', '000000', '00000');
//$pdf->Cell(0, 1, 'Total' .'                                                                               '.'0000000'.'                            '.'00000', 0, 2, 'L');

// close and output PDF document
//$pdf->Table($footer);
$html ='
<table style="width:90%;">
        
          <tr>
            <td style="font-size:14px; font-weight:bold; text-align:ledt">Total</td>
            <td style="font-size:14px; text-align:center"></td>
            <td style="font-size:14px; text-align:right">000</td>
            <td style="font-size:14px; text-align:right">000</td>

         </tr>  
         
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('11.pdf', 'I');
