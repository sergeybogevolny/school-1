<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function getCampaignmenu($menu,$target) {

    global $generic;

    $sql = "SELECT
    nql_report.id,
    nql_report.`name`,
    nql_report.generator
    FROM
    nql_report
    WHERE nql_report.`menu` LIKE '".$menu.":%' AND nql_report.target = '".$target."' AND nql_report.type = 'campaign' AND nql_report.generator IS NOT NULL ORDER BY `menu` ASC";

	$query = $generic->query($sql);
    $campaignmenu = array();
    if ($query->rowCount() > 0) {
	    while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
		    $id         = $row['id'];
			$name       = $row['name'];
			$campaignmenu[] = array(
			    'id'        => $id,
				'name'      => $name,
			);
		}
	}
    return $campaignmenu;
}

function getIndemnitors($clientid) {

    global $generic;

    $sql = "SELECT * FROM agency_clients_references WHERE indemnify=1 AND flag=0 AND client_id=".$clientid;

	$query = $generic->query($sql);
    $indemnitors = array();
    if ($query->rowCount() > 0) {
	    while( $row = $query->fetch(PDO::FETCH_ASSOC) ) {
		    $id         = $row['id'];
			$last       = $row['last'];
            $first      = $row['first'];
            $middle     = $row['middle'];
			$indemnitors[] = array(
			    'id'        => $id,
				'last'      => $last,
                'first'      => $first,
                'middle'      => $middle,
			);
		}
	}
    return $indemnitors;
}

function displayBondcampaignmenu($menu,$target,$bondid,$clientid) {
    $campaignmenu = getCampaignmenu($menu,$target);
	foreach( $campaignmenu as $data ){
	    if ($target=='client'){
            ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $bondid.':'.$clientid; ?>')"><?php echo $data['name']; ?></a></li><?php
        }
        if ($target=='indemnitor'){
            $indemnitors = getIndemnitors($clientid);
	        foreach( $indemnitors as $indemnitor ){
                $indemnitorid = $indemnitor['id'];
                $sname = '';
                if ($indemnitor['first']!=""){
                    $sname = $indemnitor['first'];
                }
                $sname = trim($sname);
                if ($indemnitor['middle']!=""){
                    $sname = $sname . ' ' . $indemnitor['middle'];
                }
                $sname = trim($sname);
                if ($indemnitor['last']!=""){
                    $sname = $sname . ' ' . $indemnitor['last'];
                }
                $sname = trim($sname);
                ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $bondid.':'.$indemnitorid; ?>')"><?php echo $data['name'].' - '.$sname; ?></a></li><?php
            }
        }

    }
}

function displayClientcampaignmenu($menu,$target,$clientid) {
    $campaignmenu = getCampaignmenu($menu,$target);
	foreach( $campaignmenu as $data ){
	    if ($target=='client'){
            ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $clientid.':'.$clientid; ?>')"><?php echo $data['name']; ?></a></li><?php
        }
        if ($target=='indemnitor'){
            $indemnitors = getIndemnitors($clientid);
	        foreach( $indemnitors as $indemnitor ){
                $indemnitorid = $indemnitor['id'];
                $sname = '';
                if ($indemnitor['first']!=""){
                    $sname = $indemnitor['first'];
                }
                $sname = trim($sname);
                if ($indemnitor['middle']!=""){
                    $sname = $sname . ' ' . $indemnitor['middle'];
                }
                $sname = trim($sname);
                if ($indemnitor['last']!=""){
                    $sname = $sname . ' ' . $indemnitor['last'];
                }
                $sname = trim($sname);
                ?><li><a href="#" onclick="ReportCampaign('<?php echo $data['id'];  ?>','<?php echo $clientid.':'.$indemnitorid; ?>')"><?php echo $data['name'].' - '.$sname; ?></a></li><?php
            }
        }

    }
}


function displayclientbond($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
                $amount = $row['amount'];
                $amount = number_format($amount, 2, '.', ',');
                /*
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $bamount = $famount . '.00';
                } else {
                $bamount = number_format($amount);
                }
                echo $bamount;
                */
                echo $amount;
            ?>
        </td>
        <td><?php echo $row['class']; ?></td>
        <?php echo "<td><a href='javascript:LoadBond(" . $row['id'] . ");'>" . $row['charge'] ."</td>"; ?>
        <td><?php echo $row['casenumber']; ?></td>
        <td><?php echo $row['court']; ?></td>
        <td><?php echo $row['county']; ?></td>
        <td>
            <div class="btn-group">
    		    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bullhorn" style="font-size:18px;"></i></a>
                <ul class="dropdown-menu dropdown-primary pull-right">
                    <?php displayBondcampaignmenu("bond","client",$row['id'],$row['client_id'])?>
                    <?php displayBondcampaignmenu("bond","indemnitor",$row['id'],$row['client_id'])?>
        		</ul>
    		</div>
        </td>
        <td>
            <div class="btn-group">
    		    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><img src='img/tabletools_pdf_white.png'></a>
                <ul class="dropdown-menu dropdown-primary pull-right">
    			    <li>
                        <a href="#" onclick="PrinterLocation('Power - Allegheny',<?php echo $row['id']; ?>)">Power - Allegheny</a>
					</li>
                    <li>
                        <a href="#" onclick="PrinterLocation('Bond - Harris TX, County',<?php echo $row['id']; ?>)">Bond - Harris TX, County</a>
                        <!--<a href="forms/bondharristxcounty.php?id=<?php echo $row['id']; ?>" target="_blank">Bond - Harris TX, County</a>-->
					</li>
                    <li>
                        <a href="#" onclick="PrinterLocation('Bond - Harris TX, JP',<?php echo $row['id']; ?>)">Bond - Harris TX, JP</a>
                        <!--<a href="forms/bondharristxjp.php?id=<?php echo $row['id']; ?>" target="_blank">Bond - Harris TX, JP</a>-->
                    </li>
                    <li>
                        <a href="#" onclick="PrinterLocation('Bond - Houston TX, City',<?php echo $row['id']; ?>)">Bond - Houston TX, City</a>
                        <!--<a href="forms/bondhoustontxcity.php?id=<?php echo $row['id']; ?>" target="_blank">Bond - Houston TX, City</a>-->
					</li>
                    <li>
                        <a href="#" onclick="PrinterLocation('Other - Harris TX, Assignment of Authority',<?php echo $row['id']; ?>)">Other - Harris TX, Assignment of Authority</a>
                        <!--<a href="forms/otherharristxaoa.php?id=<?php echo $row['id']; ?>" target="_blank">Other - Harris TX, Assignment of Authority</a>-->
					</li>
    			</ul>
    		</div>
        </td>

	</tr>
	<?php
}

function list_clientbonds($id) {

	global $generic;
    $sql = "SELECT * FROM agency_bonds WHERE client_id=" . $id . " AND flag = 0 ORDER BY amount DESC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Amount</th>
                <th>Class</th>
                <th>Charge</th>
                <th>Case Number</th>
                <th>Court</th>
                <th>County</th>
                <th>Campaign</th>
                <th>Print</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientbond($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function displayclientreference($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td><?php echo $row['indemnify']; ?></td>
        <td>
            <?php
                $sname = '';
                if ($row['first']!=""){
                    $sname = $row['first'];
                }
                $sname = trim($sname);
                if ($row['middle']!=""){
                    $sname = $sname . ' ' . $row['middle'];
                }
                $sname = trim($sname);
                if ($row['last']!=""){
                    $sname = $sname . ' ' . $row['last'];
                }
                $sname = trim($sname);
                echo "<a href='javascript:LoadReference(" . $row['id'] . ");'>" . $sname;
            ?>
        </td>
        <td><?php echo $row['relation']; ?></td>
        <td><?php echo $row['phone1']; ?></td>
	</tr>
	<?php
}

function list_clientreferences($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_references WHERE client_id=" . $id . " AND flag = 0 ORDER BY indemnify DESC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Indemnitor</th>
                <th>Name</th>
                <th>Relation</th>
                <th>Phone</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientreference($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function list_clientaccount($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_accounts WHERE client_id=" . $id . " AND flag = 0 ORDER BY Date ASC, Debit DESC, Credit DESC";

	$query = $generic->query($sql);

	?>
    <!--
	<table class="table table-hover table-nomargin dataTable table-bordered">
    -->
    <table class="table table-hover table-nomargin table-bordered" style="padding-top:10px">
		<thead>
			<tr>
                <th>Date</th>
                <th>For</th>
                <th>Debit (+)</th>
                <th>Credit (-)</th>
                <th>Balance</th>
                <th>Print</th>
			</tr>
		</thead>
		<tbody>
        <?php
        $balance = 0;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
			$rowid = $row['id'];
            $timestamp = strtotime($row['date']);
	        $date  = date('m/d/Y', $timestamp);
            $printform = '';
            $debit = $row['debit'];
            if ($debit!=''){
                $debit = number_format($debit,2);
                //$balance = $balance + $row['debit'];
                $printform = '<a href="forms/accountinvoice.php?id='.$row['id'].'" class="btn btn-primary" target="_blank" ><img src="img/tabletools_pdf_white.png"></a>';
            }
            $credit = $row['credit'];
            if ($credit!=''){
                $credit = number_format($credit,2);
               // $balance = $balance - $row['credit'];
                $printform = '<a href="forms/accountreceipt.php?id='.$row['id'].'" class="btn btn-primary" target="_blank"><img src="img/tabletools_pdf_white.png"></a>';
            }
            $fbalance = number_format($balance,2);

            ?>
            <tr>
    		    <td><?php echo $date; ?></td>
                <td><?php echo $row['entry']; ?></td>
                <td><a href="#" onclick="editDebitAccount(<?php echo $rowid; ?>,this)" ><?php echo $debit; ?></a></td>
                <td><a href="#" onclick="editCreditAccount(<?php echo $rowid; ?>,this)" ><?php echo $credit; ?></a></td>
                <td><?php echo number_format($row['balance'],2); ?></td>
                <td style="display:none"><?php echo $row['paymentmethod']; ?></td>
                <td style="display:none"><?php echo $row['memo']; ?></td>
                <td>
                    <div class="btn-group">
    		            <?php echo $printform; ?>
                    </div>
                </td>
    		</tr>
            <?php
            }
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function displayclientaccountsschedule($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
            $timestamp = strtotime($row['date']);
	        $stamp  = date('m/d/Y', $timestamp);
            echo $stamp;
            ?>
        </td>
        <td>
            <?php
            $amount = number_format($row['amount'],2);
            echo $amount;
            ?>
        </td>
        <td>
            <?php
            $remaining = number_format($row['remaining'],2);
            echo $remaining;
            ?>
        </td>
	</tr>
	<?php
}

function list_clientaccountsschedules($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_accounts_schedules WHERE client_id=" . $id . " ORDER BY date ASC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin table-bordered" style="padding-top:10px">
		<thead>
			<tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Remaining</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientaccountsschedule($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function displayclientcheckin($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
            $timestamp = strtotime($row['stamp']);
	        $stamp  = date('m/d/Y  g:i a', $timestamp);
            echo $stamp;
            ?>
        </td>
        <?php echo "<td><a href='javascript:LoadCheckin(" . $row['id'] . ");'>" . $row['comment'] ."</td>"; ?>
        <td><?php echo $row['by']; ?></td>
        <td><?php echo $row['location']; ?></td>
	</tr>
	<?php
}

function list_clientcheckins($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_checkins WHERE client_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Created</th>
                <th>Comment</th>
                <th>By</th>
                <th>Physical Location</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientcheckin($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function displayclientnote($row,$i) {

	//echo $_SESSION['nware']['user_id'] ;

	?>
        <li class="left">
    	    <div class="image">
    		    <img src="documents/avatar/<?php echo $row['user_id']?>/<?php echo $row['avatar']?>">
    		</div>
    		<div class="message">
    		    <span class="caret"></span>
    			<span class="name">
                <?php
                    echo $row['email'];
                ?>
                </span>
                <?php
                    if ($row['subject']!=''){
                    ?>
                        <p><i>
                        <?php
                            echo $row['subject'];
                        ?>
                        </i></p>
                    <?php
                    }
                ?>
    			<p>
                <?php if( $i == 0 && $row['user_id'] == $_SESSION['nware']['user_id'] ) {?>
                <a href="#" onclick="clientnoteedit(<?php echo $row['id'] ?>)">
                 <?php
                    echo $row['comment'];
                ?>
                </a>
                <?php }else{ ?>
                <?php
                    echo $row['comment'];
                ?>
                <?php } ?>

                </p>
    			<span class="time">
                <?php
                    $timestamp = strtotime($row['stamp']);
	                $stamp  = date('m/d/Y  g:i a', $timestamp);
                    echo $stamp;
                ?>
                <?php if( $row['edit'] == 1 ){
					echo '<i class="icon-pencil"></i>';

					} ?>
                </span>
    		</div>
    	</li>
	<?php

}

function list_clientnotes($id) {

	global $generic;
    $sql = "SELECT
            agency_clients_notes.*,
            login_users.`email`,
            login_users.`avatar`
            FROM
            agency_clients_notes
            INNER JOIN login_users ON agency_clients_notes.user_id = login_users.user_id
            WHERE client_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <ul class="messages">
    	<?php
		$count = $query->rowCount();
		$i = 0;
		while($row = $query->fetch(PDO::FETCH_ASSOC))
		
		   {
			   
			echo displayclientnote($row,$i);
			
		     $i++;
		   }
		
		?>
    </ul>
	<?php
}

function displayclientdocument($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
            $timestamp = strtotime($row['stamp']);
	        $stamp  = date('m/d/Y  g:i a', $timestamp);
            echo $stamp;
            ?>
        </td>
        <?php echo "<td><a href='#' class='tdoc' data-value='" . $row['id'] . "'>" . $row['file'] ."</td>"; ?>
        <td><?php echo $row['type']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <?php echo "<td><a href='documents/" . $row['client_id'] . "/" . $row['folder'] . "/" . $row['file'] . "'><img src='img/document_blank.png' alt='View Document'></td>"; ?>
	</tr>
	<?php
}

function list_clientdocuments($id, $folder) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_documents WHERE folder='" . $folder . "' AND client_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin table-bordered" style="padding-top:10px">
		<thead>
			<tr>
                <th>Uploaded</th>
                <th>File</th>
                <th>Type</th>
                <th>Comment</th>
                <th>View</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientdocument($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function list_clienttags($id) {

	global $generic;
    $sql = "SELECT tags FROM agency_clients WHERE id=" . $id . " AND flag = 0 ORDER BY tags DESC";

	$query = $generic->query($sql);
    $n = 0;
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if(!empty($row)){
        $tags = explode(", ", $row['tags']);
        $n = count($tags);
        if ($n>0){
        ?>
        <div class="taglist">
            <ul>
        <?php
            for($i = 0; $i < $n;$i++){
        ?>
            <li>
            <span class="tag"><?php echo $tags[$i]; ?></span>
            </li>
        <?php
            }
        ?>
            </ul>
        </div>
        <?php
        }
    }
}

?>