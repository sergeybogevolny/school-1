<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displaysettingspaymentmethod($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <?php echo "<td><a href='javascript:LoadPaymentmethods(" . $row['id'] . ");'>" . $row['name'] ."</td>"; ?>
	</tr>
	<?php

}
?>

<?php
function list_settingspaymentmethods() {

	global $generic;
    $sql = 'SELECT * FROM agency_settings_lists_paymentsmethods WHERE flag = 0 ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Name</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaysettingspaymentmethod($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php

}
?>