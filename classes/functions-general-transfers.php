<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function list_transfers($type){
    switch ($type) {
        case 'recorded':
            list_transfersrecorded();
            break;
        case 'dispatched':
            list_transfersdispatched();
            break;
        case 'rejected':
            list_transfersrejected();
            break;
		case 'posted':
		    list_transfersposted();
            break;
        case 'settled':
		    list_transferssettled();
            break;
    }
}

function displaytransferrecorded($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='transfer.php?id=" . $row['id'] . "'>" . $row['recorded'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['requestingagent']; ?></td>
      <td><?php echo '' ?></td>
    </tr>
<?php
}

function list_transfersrecorded() {

	global $generic;
    $sql = "SELECT * FROM general_transfers WHERE type = 'recorded' ORDER BY recorded DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Recorded</th>
          <th>Amount</th>
          <th>Requesting Agent</th>
          <th>Comment</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displaytransferrecorded($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displaytransferdispatched($row) {

	if(empty($row)) return false;
	?>
    <tr>
        <?php echo "<td><a href='transfer.php?id=" . $row['id'] . "'>" . $row['dispatched'] ."</td>"; ?>
        <td><?php echo $row['postingagent']; ?></td>
        <td><?php echo $row['recorded']; ?></td>
        <td><?php echo $row['amount']; ?></td>
        <td><?php echo $row['requestingagent']; ?></td>
    </tr>
<?php
}

function list_transfersdispatched() {

	global $generic;
    $sql = "SELECT * FROM general_transfers WHERE type = 'dispatched' ORDER BY dispatched DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
            <th>Dispatched</th>
            <th>Posting Agent</th>
            <th>Recorded</th>
            <th>Amount</th>
            <th>Requesting Agent</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displaytransferdispatched($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displaytransferrejected($row) {

	if(empty($row)) return false;
	?>
    <tr>
        <?php echo "<td><a href='transfer.php?id=" . $row['id'] . "'>" . $row['rejected'] ."</td>"; ?>
        <td><?php echo $row['rejectedreason']; ?></td>
        <td><?php echo $row['recorded']; ?></td>
        <td><?php echo $row['amount']; ?></td>
        <td><?php echo $row['requestingagent']; ?></td>
    </tr>
<?php
}

function list_transfersrejected() {

	global $generic;
    $sql = "SELECT * FROM general_transfers WHERE type = 'rejected' ORDER BY rejected DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
            <th>Rejected</th>
            <th>Reason</th>
            <th>Recorded</th>
            <th>Amount</th>
            <th>Requesting Agent</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displaytransferrejected($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displaytransferposted($row) {

	if(empty($row)) return false;
	?>
    <tr>
        <?php echo "<td><a href='transfer.php?id=" . $row['id'] . "'>" . $row['posted'] ."</td>"; ?>
        <td><?php echo $row['postingagent']; ?></td>
        <td><?php echo $row['postingfee']; ?></td>
        <td><?php echo $row['requestingagent']; ?></td>
        <td><?php echo $row['requestingfee']; ?></td>
    </tr>
<?php
}

function list_transfersposted() {

	global $generic;
    $sql = "SELECT * FROM general_transfers WHERE type = 'posted' ORDER BY posted DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
            <th>Posted</th>
            <th>Posting Agent</th>
            <th>Posting Fee</th>
            <th>Requesting Agent</th>
            <th>Requesting Fee</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displaytransferposted($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displaytransfersettled($row) {

	if(empty($row)) return false;

    $postingbalance = ($row['postingfee'] - $row['postingreceived']);
    $requestingbalance = ($row['requestingfee'] - $row['requestingreceived']);

	?>
    <tr>
        <?php echo "<td><a href='transfer.php?id=" . $row['id'] . "'>" . $row['settled'] ."</td>"; ?>
        <td><?php echo $row['settledreason']; ?></td>
        <td><?php echo $row['posted']; ?></td>
        <td><?php echo $row['postingagent']; ?></td>
        <td><?php echo $postingbalance; ?></td>
        <td><?php echo $row['requestingagent']; ?></td>
        <td><?php echo $requestingbalance; ?></td>
    </tr>
<?php
}

function list_transferssettled() {

	global $generic;
    $sql = "SELECT * FROM general_transfers WHERE type = 'settled' ORDER BY settled DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
            <th>Settled</th>
            <th>Reason</th>
            <th>Posted</th>
            <th>Posting Agent</th>
            <th>Posting Balance</th>
            <th>Requesting Agent</th>
            <th>Requesting Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displaytransfersettled($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

?>