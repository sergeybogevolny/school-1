<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displaysettingscourt($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <?php echo "<td><a href='javascript:LoadCourt(" . $row['id'] . ");'>" . $row['name'] ."</td>"; ?>
        <td><?php echo $row['county']; ?></td>
        <td><?php echo $row['type']; ?></td>
	</tr>
	<?php

}
?>

<?php
function list_settingscourts() {

	global $generic;
    $sql = 'SELECT * FROM agency_settings_lists_courts WHERE flag = 0 ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Name</th>
                <th>County</th>
                <th>Type</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaysettingscourt($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php

}
?>
