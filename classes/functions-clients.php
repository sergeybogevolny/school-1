<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displayclientalpha($row) {

	if(empty($row)) return false;
	?>
	<tr>
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
                echo "<a href='client.php?id=" . $row['id'] . "'>" . $sname;
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
	</tr>
	<?php
}
?>

<?php
function list_clientsalpha($alpha) {

	global $generic;
    if ($alpha=='recent'){
        $sql = "SELECT * FROM agency_clients WHERE type = 'Client' AND flag = 0 ORDER BY created DESC LIMIT 100";
    } else {
        $sql = "SELECT * FROM agency_clients WHERE last LIKE '" . $alpha . "%' AND type = 'Client' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC";
    }

	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Name</th>
                <th>Dob</th>
                <th>SSN</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayclientalpha($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>
