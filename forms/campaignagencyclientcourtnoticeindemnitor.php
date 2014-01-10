<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/check.class.php');
protect("1,2");

include_once('forms.class.php');
include_once('../classes/campaign.class.php');
include_once(dirname(dirname(__FILE__)) . '/integration/tcpdf/tcpdf.php');
include_once('../integration/twilioservices/Twilio.php');
include_once('../integration/twilioservices/config.php');
date_default_timezone_set('America/Indianapolis');

if (!isset($_GET['id'])) {
    die();
}
$id = $_GET['id'];

//SET
$cat = 'PrincetonTrust';

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
$forms->getReportcampaign($id);

$sqlraw = $forms->getField('sqlraw');
$condition = $forms->getField('condition');
$report = $forms->getField('report');
$generator = $forms->getField('generator');
$letters = explode(',', $forms->getField('letters'));
$emails = explode(',', $forms->getField('emails'));
$texts = explode(',', $forms->getField('texts'));
$autocalls = explode(',', $forms->getField('autocalls'));
$lettertemplate = $forms->getField('lettertemplate');
$emailtemplate = $forms->getField('emailtemplate');
$texttemplate = $forms->getField('texttemplate');
$autocalltemplate = $forms->getField('autocalltemplate');
$GLOBALS['title'] = 'Campaign';
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
		$this->Cell(15, 0, 'Letter', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(15, 0, 'Email', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(15, 0, 'Text', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(25, 0, 'AutoCall', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(30, 0, 'Indemnitor', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
        $this->Cell(30, 0, 'Defendant', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(40, 0, 'Setting', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(15, 0, 'Class', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(35, 0, 'Charge', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(20, 0, 'Case #', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(20, 0, 'County', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');
		$this->Cell(20, 0, 'Court', 'B', $ln=0, 'L', 0, '', 0, false, 'T', 'C');

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

$grandtotal1        = 0; // letters
$grandtotal2        = 0; // emails
$grandtotal3        = 0; // texts
$grandtotal4        = 0; // autocalls

$rows = array();
while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
    $rows[] = $row;
    $txt_letter     = 0;
    $txt_email      = 0;
    $txt_text       = 0;
    $txt_autocall   = 0;
    $sqlid = $row['sqlid'];
    if (in_array($sqlid, $letters)) {
        $txt_letter = 1;
    }
    if (in_array($sqlid, $emails)) {
        $txt_email = 1;
    }
    if (in_array($sqlid, $texts)) {
        $txt_text = 1;
    }
    if (in_array($sqlid, $autocalls)) {
        $txt_autocall = 1;
    }
    $txt_indemnitor = $row['indemnitor'];
    $txt_defendant  = $row['defendant'];
	$txt_setting	= $row['setting'];
    $txt_class      = $row['class'];
    $txt_charge     = $row['charge'];
    $txt_casenumber = $row['casenumber'];
    $txt_county     = $row['county'];
    $txt_court      = $row['court'];

    $pdf->SetX(5);
    $pdf->SetFont('helvetica','', 10);
    $pdf->Cell(15, 0, $txt_letter, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(15, 0, $txt_email, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(15, 0, $txt_text, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(25, 0, $txt_autocall, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(30, 0, $txt_indemnitor, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(30, 0, $txt_defendant, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(40, 0, $txt_setting, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(15, 0, $txt_class, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(35, 0, $txt_charge, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(20, 0, $txt_casenumber, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(20, 0, $txt_county, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
    $pdf->Cell(20, 0, $txt_court, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');

    $pdf->Ln();

    $grandtotal1        = $grandtotal1 + $txt_letter;
    $grandtotal2        = $grandtotal2 + $txt_email;
    $grandtotal3        = $grandtotal3 + $txt_text;
    $grandtotal4        = $grandtotal4 + $txt_autocall;

}

$txt_grandtotal1    = $grandtotal1;
$txt_grandtotal2    = $grandtotal2;
$txt_grandtotal3    = $grandtotal3;
$txt_grandtotal4    = $grandtotal4;

//$pdf->Ln();

$gy = $pdf->GetY();
if ($gy>190){
    $pdf->AddPage('L', 'A4');
    $pdf->SetY(55);
    $gy = 55;
}
$pdf->SetX(5);
$pdf->SetFont('helvetica','B',10);
$pdf->Cell(15, 0, $txt_grandtotal1, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Cell(15, 0, $txt_grandtotal2, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Cell(15, 0, $txt_grandtotal3, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Cell(15, 0, $txt_grandtotal4, 0, $ln=0, 'L', 0, '', 0, false, 'T', 'C');
$pdf->Ln();
$pdf->Rect(5, $gy, 60, 0.75, 'DF', $styledouble, array(420, 420, 400));

//---------------------------------------------------------


switch ($lettertemplate){
    case 'message one':
         letter_messageone($rows,$letters,$pdf);
         break;
    case 'message two':
         letter_messagetwo($rows,$letters,$pdf);
         break;
}

switch ($emailtemplate){
    case 'message one':
        email_messageone($rows,$emails,$pdf);
        break;
    case 'message two':
        email_messagetwo($rows,$emails,$pdf);
        break;
    case 'message three':
        email_messagethree($rows,$emails,$pdf);
        break;
}


switch ($texttemplate){
    case 'message one':
        text_messageone($rows,$texts,$pdf);
        break;
    case 'message two':
        text_messagetwo($rows,$texts,$pdf);
        break;
    case 'message three':
        text_messagethree($rows,$texts,$pdf);
        break;
    case 'message four':
        text_messagefour($rows,$texts,$pdf);
        break;
}


switch ($autocalltemplate){

    case 'message one':
        autocall_messageone($rows,$autocalls,$pdf);
        break;
    case 'message two':
        autocall_messagetwo($rows,$autocalls,$pdf);
        break;
    default:
        die();
        break;
}

/////////////////////////////////////////////////////////////LETTERS
function letter_messageone($rows,$letters,$pdf){
    $len = count($rows);
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];
        if (in_array($sqlid, $letters)) {
            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.  Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'RE: '.$txt_casenumber.' - '.$txt_class.' '.$txt_charge, 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Cell(0, 0, 'If you have any questions, please contact our office.', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(0, 0, 'Thank you', 0, 1, 'L');

            $pdf->SetY(269);
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message one', 0, 1, 'L');

            tasktimeline($focus,$txt_indemnitor.' - Letter (Message One)');
        }
    }
}

function letter_messagetwo($rows,$letters,$pdf){
    $len = count($rows);
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];
        if (in_array($sqlid, $letters)) {
            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.  Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'RE: '.$txt_casenumber.' - '.$txt_class.' '.$txt_charge, 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Cell(0, 0, 'If you have any questions, please contact our office.', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(0, 0, 'Thank you', 0, 1, 'L');

            $pdf->SetY(269);
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message two', 0, 1, 'L');

            tasktimeline($focus,$txt_indemnitor.' - Letter (Message Two)');
        }
    }
}

/////////////////////////////////////////////////////////////EMAILS
function email_messageone($rows,$emails,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendemail = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $emails)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.  Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';
            $txt_subject    = 'Campaign Email';
			$txt_email      = 'adam@princetontrust.com';

			$sendemail[]    = array(
		        'subject'   => $txt_subject,
			    'text'      => $txt_body,
				'email'     => $txt_email
			);

            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Email Recipient: <emailaddress>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'SUBJECT: '.$txt_casenumber.' - '.$txt_class.' '.$txt_charge, 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Cell(0, 0, 'If you have any questions, please contact our office.', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'Thank you', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message one', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Email (Message One)');
        }
    }
    $campaign = new Campaign();
	$campaign->send_email($sendemail);
}

function email_messagetwo($rows,$emails,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendemail = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $emails)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.  Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';
            $txt_subject    = 'Campaign Email';
			$txt_email      = 'adam@princetontrust.com';

			$sendemail[]    = array(
			    'subject'   => $txt_subject,
			    'text'      => $txt_body,
				'email'     => $txt_email
			);

			$pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Email Recipient: <emailaddress>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'SUBJECT: '.$txt_casenumber.' - '.$txt_class.' '.$txt_charge, 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Cell(0, 0, 'If you have any questions, please contact our office.', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'Thank you', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message two', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Email (Message Two)');
        }
    }
	$campaign = new Campaign();
	$campaign->send_email($sendemail);

}

function email_messagethree($rows,$emails,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendemail = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $emails)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.  Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';
            $txt_subject    = 'Campaign Email';
			$txt_email      = 'adam@princetontrust.com';

			$sendemail[]    = array(
			    'subject'   => $txt_subject,
			    'text'      => $txt_body,
				'email'     => $txt_email
			);

		    $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Email Recipient: <emailaddress>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'SUBJECT: '.$txt_casenumber.' - '.$txt_class.' '.$txt_charge, 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Cell(0, 0, 'If you have any questions, please contact our office.', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Cell(0, 0, 'Thank you', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message three', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Email (Message Three)');
        }
    }
	$campaign = new Campaign();
	$campaign->send_email($sendemail);

}


/////////////////////////////////////////////////////////////TEXTS

function text_messageone($rows,$texts,$pdf){
    $haspaged = false;
    $len = count($rows);
    $sendtext = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $texts)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.';
			$txt_phone      = '+1 409 960 8884';

            $sendtext[]     = array(
		        'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Text Recipient: <mobilenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message one', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Text (Message One)');
        }
    }
	$campaign = new Campaign();
    $campaign->send_text2($sendtext);
}

function text_messagetwo($rows,$texts,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendtext = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $texts)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.';
			$txt_phone      = '+1 409 960 8884';

            $sendtext[]     = array(
			    'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->SetFont('helvetica','', 10);
            $pdf->Cell(0, 0, 'Text Recipient: <mobilenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message two', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Text (Message Two)');
        }
    }
    $campaign  = new Campaign();
    $campaign->send_text2($sendtext);

}

function text_messagethree($rows,$texts,$pdf){
    $haspaged = false;
    $len = count($rows);
    $sendtext = '';

    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $texts)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.';
			$txt_phone      = '+1 409 960 8884';

            $sendtext[]     = array(
			    'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Text Recipient: <mobilenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message three', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Text (Message Three)');
        }
    }
	$campaign  = new Campaign();
    $campaign->send_text2($sendtext);
}

function text_messagefour($rows,$texts,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendtext = '';

    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $texts)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time.';
			$txt_phone      = '+1 409 960 8884';

            $sendtext[]     = array(
			    'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'Text Recipient: <mobilenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message four', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - Text (Message Four)');
        }
    }
	$campaign = new Campaign();
    $campaign->send_text2($sendtext);
}

/////////////////////////////////////////////////////////////AUTOCALLS
function autocall_messageone($rows,$autocalls,$pdf){
    $haspaged = false;
    $len = count($rows);
	$sendcall = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];

        if (in_array($sqlid, $autocalls)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time. Defendant must be on time. Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';
			$txt_phone      = '+1 409 527 4950';

            $sendcall[]     = array(
			    'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->SetFont('helvetica','', 10);

            $pdf->Cell(0, 0, 'AutoCall Recipient: <phonenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message one', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - AutoCall (Message One)');
        }
    }
	$campaign = new Campaign();
	$campaign->send_autocall($sendcall);
}

function autocall_messagetwo($rows,$autocalls,$pdf){
    $len = count($rows);
	$sendcall = '';
    for($x = 0; $x < $len; $x++) {
        $row = $rows[$x];
        $sqlid = $row['sqlid'];
        if (in_array($sqlid, $autocalls)) {

            if ($haspaged==false){
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->AddPage('P', 'A4');
                $haspaged=true;
            }

            $focus          = $row['focus'];
            $txt_indemnitor = $row['indemnitor'];
            $txt_defendant  = $row['defendant'];
        	$txt_setting	= $row['setting'];
            $txt_class      = $row['class'];
            $txt_charge     = $row['charge'];
            $txt_casenumber = $row['casenumber'];
            $txt_county     = $row['county'];
            $txt_court      = $row['court'];

            $txt_body       = 'The Defendant for whom you signed as Indemnitor has an appearance scheduled for '.$txt_setting. ' in the '.$txt_court.' of '.$txt_county.'.  Defendant must be on time. Defendant must be on time. Failure to make this appearance will result in the bond being forfeited and a suit against you for the bond amount';
			$txt_phone      = '+1 409 527 4950';

			$sendcall[]     = array(
		        'text'      => $txt_body,
				'phone'     => $txt_phone
			);

            $pdf->Cell(0, 0, 'AutoCall Recipient: <phonenumber>', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Write(0, $txt_body, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica','', 8);
            $pdf->Cell(0, 0, 'message two', 0, 1, 'L');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();

            tasktimeline($focus,$txt_indemnitor.' - AutoCall (Message Two)');
        }
    }
	$campaign = new Campaign();
	$campaign->send_autocall($sendcall);
}

function tasktimeline($focus,$template){
    global $generic;
    date_default_timezone_set('America/Indianapolis');

    $assignedby = $_SESSION['nware']['email'];
    $profileid = $_SESSION['nware']['user_id'];
    $date = date('Y-m-d h:i:s');

	$sql1 = "SELECT * FROM tasks WHERE flag_complete=0 AND tasks.assignedby='".$assignedby."' AND CONCAT_WS(':',tasks.type,tasks.focus_id) = '".$focus."'";

	$query1 =  $generic->query($sql1);
    $rcount = $query1->rowCount();
    if( $rcount > 0 ) {
        while($row = $query1->fetch(PDO::FETCH_ASSOC)){
            $taskid = $row['id'];
            $progress = $row['progress'];
            $type = 'new_campaign';
            $activity = 'Campaign for Client Court Notice to Indemnitor '.$template;
            $generated = 'system';

            $sql2 = "INSERT INTO `tasks_timelines` (`task_id`,`type`,`profile_id`,`activity`,`progress`,`generated`,`stamp`)
    	    VALUES ('$taskid','$type','$profileid','$activity','$progress','$generated','$date')";
	        $query2 =  $generic->query($sql2);

		}

    }

}



//Close and output PDF document
$pdf->Output($txt_pdffile, 'I');