<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displaybondmade($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
                if ($row['executeddate']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['executeddate']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?>
        </td>
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
                echo $sname;
            ?>
        </td>
        <td>
            <?php
                $amount = $row['amount'];
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $bamount = $famount . '.00';
                } else {
                $bamount = number_format($amount);
                }
                echo $bamount;
            ?>
        </td>

	</tr>
	<?php
}
?>

<?php
function list_bondsmade() {

	global $generic;
    $sql = "SELECT
            agency_clients.last,
            agency_clients.`first`,
            agency_clients.middle,
            agency_bonds.executeddate,
            agency_bonds.amount
            FROM
            agency_clients
            INNER JOIN agency_bonds ON agency_clients.id = agency_bonds.client_id
            WHERE agency_clients.type = 'Client' AND agency_bonds.executeddate > 0000-00-00
            ORDER BY agency_bonds.executeddate DESC";

	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered dataTable-tools">
		<thead>
			<tr>
                <th>Date</th>
                <th>Name</th>
                <th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaybondmade($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

