<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displayprospectbond($row) {

	if(empty($row)) return false;
	?>
	<tr>
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
        <td><?php echo $row['class']; ?></td>
        <td><?php echo $row['charge']; ?></td>
        <td><?php echo $row['casenumber']; ?></td>
        <td><?php echo $row['court']; ?></td>
        <td><?php echo $row['county']; ?></td>
        <td>
        <?php
            echo "<a href='#'><img src='img/printforms.png' alt='Print Forms'></a>";
        ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_prospectbonds($id) {

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
                <th>Forms</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayprospectbond($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displayprospectreference($row) {

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
                echo $sname;
            ?>
        </td>
        <td>
            <?php
                if ($row['dob']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['dob']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_prospectreferences($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_references WHERE client_id=" . $id . " AND flag = 0 ORDER BY indemnify DESC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Indemnify</th>
                <th>Name</th>
                <th>Dob</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayprospectreference($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displayprospectnote($row) {

	if(empty($row)) return false;
	?>
        <li class="left">
    	    <div class="image">
    		    <img src="img/demo/user-1.jpg" alt="">
    		</div>
    		<div class="message">
    		    <span class="caret"></span>
    			<span class="name">
                <?php
                    echo $row['by'];
                ?>
                </span>
    			<p>
                <?php
                    echo $row['comment'];
                ?>
                </p>
    			<span class="time">
                <?php
                    $timestamp = strtotime($row['stamp']);
	                $stamp  = date('m/d/Y  g:i a', $timestamp);
                    echo $stamp;
                ?>
                </span>
    		</div>
    	</li>
	<?php
}
?>

<?php
function list_prospectnotes($id) {

	global $generic;
    $sql = "SELECT * FROM agency_clients_notes WHERE client_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <ul class="messages">
    	<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayprospectnote($row);
		?>
    </ul>
	<?php
}
?>

