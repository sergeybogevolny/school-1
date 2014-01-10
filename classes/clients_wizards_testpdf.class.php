<?php
/*
	FILE: clients_wizards_testpdf.class.php
	AUTHOR: risanbagja
	DATE: July 27th 2013
*/

// Load generic class to extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
// Load TCPDF class library
include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// OUR CLIENTS WIZADS TESTPDF CLASS
class Clients_wizards_testpdf extends Generic
{
	private $firstname;
	private $lastname;
	private $email;
	private $gender;
	private $language;
	private $hobbies = array();
	private $age;
	private $url;
	private $aboutme;

	private function getInputData() {
		if (!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email']) ||
			!isset($_POST['gender']) || !isset($_POST['language']) || !isset($_POST['hobbies']) ||
			!isset($_POST['age']) || !isset($_POST['url']) || !isset($_POST['aboutme'])) {
				header('./clients-wizards-testpdf.php');
				die();
		}

		$this->firstname = parent::secure($_POST['firstname']);
		$this->lastname = parent::secure($_POST['lastname']);
		$this->email = parent::secure($_POST['email']);
		$this->gender = parent::secure($_POST['gender']);
		$this->language = parent::secure($_POST['language']);
		$this->hobbies = parent::secure($_POST['hobbies']);
		$this->age = parent::secure($_POST['age']);
		$this->url = parent::secure($_POST['url']);
		$this->aboutme = parent::secure($_POST['aboutme']);
	}

	public function generatePDF() {
		$this->getInputData();

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Dev Porto');
		$pdf->SetTitle('Clients Wizards TestPDF');
		//$pdf->SetSubject('TCPDF Tutorial');
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('dejavusans', '', 14, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

		// Set some content to print
		$hobbies = implode(', ', $this->hobbies);
		$html = <<<EOD
<p>First Name: $this->firstname </p>
<p>Last Name: $this->lastname </p>
<p>Email: $this->email </p>
<p>Gender: $this->gender </p>
<p>Language: $this->language </p>
<p>Hobbies: $hobbies </p>
<p>Age: $this->age </p>
<p>URL: <a href='$this->url'>$this->url</a> </p>
<p>About Me: $this->aboutme </p>
EOD;

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// ---------------------------------------------------------

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('clients_wizards_testpdf.pdf', 'I');

	}
}