<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Wizards_supplements_create extends Generic {

	private $options = array();

    function __construct() {

		if(!empty($_POST)) {

            if(isset($_POST['search-indemnitors'])) {
                $this->list_indemnitors();
    		} else {

                foreach ($_POST as $key => $value)
    				$this->options[$key] = parent::secure($value);
    				$this->add();
    				if(!empty($this->error)){
    					echo $this->error;
    				}else {
    					echo $this->result;
    				}
            }
        }
    }

    private function add() {

        $stamp  = date('Y-m-d H:i:s');

        if(isset($this->options['supplement-transactionamount'])){
            $transactionamount = $this->options['supplement-transactionamount'];
            $transactionamount = str_replace(",", "", $transactionamount);
		}else{$transactionamount = '0';}
        if(isset($this->options['supplement-invoiceamount'])){
            $invoiceamount = $this->options['supplement-invoiceamount'];
            $invoiceamount = str_replace(",", "", $invoiceamount);
		}else{$invoiceamount = '0';}
        if(isset($this->options['supplement-installmentamount'])){
            $installmentamount = $this->options['supplement-installmentamount'];
            $installmentamount = str_replace(",", "", $installmentamount);
		}else{$installmentamount = '0';}
        $poolamount = ($transactionamount*.15)-$invoiceamount;

        $recorded               = $stamp;
        $payer	                = $this->options['supplement-payer'];
        $payerid                = $this->options['supplement-payerid'];
        $defendant              = $this->options['supplement-defendant'];
        $defendantid            = $this->options['supplement-defendantid'];
        $transactionamount      = $transactionamount;
        $documentrecorded       = 'supplementapplication'.$payerid.'.pdf';
        $invoiceamount          = $invoiceamount;
        $poolamount             = $poolamount;
        $drawinstallmentamount  = $installmentamount;
        $drawinterval           = $this->options['supplement-installmentinterval'];
        $drawtype               = $this->options['supplement-drawmethod'];
        $drawbank               = $this->options['supplement-drawbank'];
        $drawbankrouting        = $this->options['supplement-drawbankrouting'];
        $drawbankaccount        = $this->options['supplement-drawbankaccount'];
        $drawcard               = $this->options['supplement-drawcard'];
        $drawcardnumber         = $this->options['supplement-drawcardnumber'];
        $drawcardexpiration     = $this->options['supplement-drawcardexpiration'];
        $drawcardcvv            = $this->options['supplement-drawcardcvv'];
        $drawcardaddress        = $this->options['supplement-drawcardaddress'];
        $drawcardcity           = $this->options['supplement-drawcardcity'];
        $drawcardstate          = $this->options['supplement-drawcardstate'];
        $drawcardzip            = $this->options['supplement-drawcardzip'];

		$sql = "INSERT INTO suite_supplements(`type`,`recorded`,`payer`,`defendant`,`amount`,`document_recorded`,`invoiceamount`,`poolamount`,`drawinstallment`,`drawinterval`,`drawtype`,`drawbank`,`drawbankrouting`,`drawbankaccount`,`drawcard`,`drawcardnumber`,`drawcardexpiration`,`drawcardcvv`,`drawcardaddress`,`drawcardcity`,`drawcardst`,`drawcardzip`,`payer_id`) VALUES('recorded','$stamp','$payer','$defendant','$transactionamount','$documentrecorded','$invoiceamount','$poolamount','$drawinstallmentamount','$drawinterval','$drawtype','$drawbank','$drawbankrouting','$drawbankaccount','$drawcard','$drawcardnumber','$drawcardexpiration','$drawcardcvv','$drawcardaddress','$drawcardcity','$drawcardstate','$drawcardzip','$payerid')";
        $stmt = parent::query($sql);

        $sql = "UPDATE agency_clients_references SET `document_application`='$documentrecorded',`document_contract`='' WHERE id=".$payerid;
        $stmt = parent::query($sql);

        include_once(dirname(dirname(__FILE__)).'/integration/tcpdf/tcpdf.php');

        date_default_timezone_set('America/Indianapolis');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator('PrincetonTrust');
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
        $pdf->AddPage();

        $pdf->StartTransform();

        $pdf->MultiCell(55, 5, 'Recorded: '.$recorded, 0, 'L', 0, 1, 20, 20, true);
        $pdf->MultiCell(55, 5, 'Payer: '.$payer, 0, 'L', 0, 1, 20, 30, true);
        $pdf->MultiCell(55, 5, 'Defendant: '.$defendant, 0, 'L', 0, 1, 20, 40, true);
        $pdf->MultiCell(55, 5, 'Transaction Amount: '.$transactionamount, 0, 'L', 0, 1, 20, 50, true);
        $pdf->MultiCell(55, 5, 'Invoice Amount: '.$invoiceamount, 0, 'L', 0, 1, 20, 60, true);
        $pdf->MultiCell(55, 5, 'Pool Amount: '.$poolamount, 0, 'L', 0, 1, 20, 70, true);
        $pdf->MultiCell(55, 5, 'Installment Amount: '.$drawinstallmentamount, 0, 'L', 0, 1, 20, 80, true);
        $pdf->MultiCell(55, 5, 'Installment Interval: '.$drawinterval, 0, 'L', 0, 1, 20, 90, true);
        $pdf->MultiCell(55, 5, 'Draw Method: '.$drawtype, 0, 'L', 0, 1, 20, 100, true);

        $pdf->StopTransform();

        $pdf->lastPage();

        $pdf->Output(dirname(dirname(__FILE__)).'/documents/'.$defendantid.'/'.$documentrecorded, 'F');

		echo "<div class='alert alert-success' id='status'>".$id."</div>";

	}

    private function list_indemnitors(){

        global $generic;
        $sql = "SELECT
        agency_clients.id as clientid,
        agency_clients.last,
        agency_clients.`first`,
        agency_clients.middle,
        agency_clients.dob,
        agency_clients.ssnlast4,
        agency_clients_references.last as indemnitorlast,
        agency_clients_references.`first` as indemnitorfirst,
        agency_clients_references.`middle` as indemnitormiddle,
        agency_clients_references.id
        FROM
        agency_clients
        INNER JOIN agency_clients_references ON agency_clients_references.client_id = agency_clients.id
        WHERE agency_clients.flag = 0 AND agency_clients_references.flag = 0 AND agency_clients_references.indemnify=1";

        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);
        if ($rcount==1){
            $sfirstorlast = $svals[0];
             $sql = $sql." AND (agency_clients.first LIKE '%" . $sfirstorlast . "%' OR agency_clients.last LIKE '%" . $sfirstorlast . "%') ORDER BY agency_clients.last DESC, agency_clients.first DESC, agency_clients.middle DESC LIMIT 30";
	    } else if ($rcount==2){
            $sfirst = $svals[0];
            $slast = $svals[1];
            $sql = $sql." AND agency_clients.first LIKE '%" . $sfirst . "%' AND agency_clients.last LIKE '%" . $slast . "%' ORDER BY agency_clients.last DESC, agency_clients.first DESC, agency_clients.middle DESC LIMIT 30";
        } else {
            $sfirst = $svals[0];
            $smiddle = $svals[1];
            $slast = $svals[2];
            $sql = $sql." AND agency_clients.first LIKE '%" . $sfirst . "%' AND  agency_clients.middle LIKE '%" . $smiddle . "%' AND agency_clients.last LIKE '%" . $slast . "%' ORDER BY agency_clients.last DESC, agency_clients.first DESC, agency_clients.middle DESC LIMIT 30";
        }

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5 id="error">No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 29 ) {
            echo '<h5 id="error">Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
            echo '<h5>'.$rcount . ' record(s) found.</h5>';
            ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered">
		            <thead>
            			<tr>
                            <th>Defendant</th>
                            <th>Dob</th>
                            <th>SSN</th>
                            <th>Indemnitor</th>
                            <th style="display:none;">Defendantid</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
                        echo '<tr id="'.$row['id'].'">';
                        ?>
                            <?php
                            $sdefendant = '';
                            if ($row['first']!=""){
                                $sdefendant = $row['first'];
                            }
                            $sdefendant = trim($sdefendant);
                            if ($row['middle']!=""){
                                $sdefendant = $sdefendant . ' ' . $row['middle'];
                            }
                            $sdefendant = trim($sdefendant);
                            if ($row['last']!=""){
                                $sdefendant = $sdefendant . ' ' . $row['last'];
                            }
                            echo "<td>".$sdefendant."</td>";
                            ?>
                            <td>
                                <?php
                                if ($row['dob']=='0000-00-00'){
                                    $dob = '';
                                } else {
                                    $timestamp = strtotime($row['dob']);
                            	    $dob  = date('m/d/Y', $timestamp);
                                }
                                echo $dob;
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($row['ssnlast4']==''){
                                    $ssn = '';
                                } else {
                                    $ssn = 'XXX-XX-' . $row['ssnlast4'];
                                }
                                echo $ssn;
                                ?>
                            </td>
                            <?php
                            $id= $row['id'];
                            $sindemnitor = '';
                            if ($row['indemnitorfirst']!=""){
                                $sindemnitor = $row['indemnitorfirst'];
                            }
                            $sindemnitor = trim($sindemnitor);
                            if ($row['indemnitormiddle']!=""){
                                $sindemnitor = $sindemnitor . ' ' . $row['indemnitormiddle'];
                            }
                            $sindemnitor = trim($sindemnitor);
                            if ($row['indemnitorlast']!=""){
                                $sindemnitor = $sindemnitor . ' ' . $row['indemnitorlast'];
                            }
                            echo '<td><a href="#" onclick="loadIndemnitor('.$row['id'].')">'.$sindemnitor.'</td>';
                            ?>
                            <td style="display:none;">
                                <?php echo $row['clientid']; ?>
                            </td>
	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php

        }
    }

 }

$wizardssupplementscreate = new Wizards_supplements_create();
?>