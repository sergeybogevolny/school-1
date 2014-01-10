<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displaysettingscounty($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <?php echo "<td><a href='javascript:LoadCounty(" . $row['id'] . ");'>" . $row['name'] ."</td>"; ?>
        <td><?php echo $row['seat']; ?></td>
	</tr>
	<?php

}
?>

<?php
function list_settingscounties() {

	global $generic;
    $sql = 'SELECT * FROM agency_settings_lists_counties WHERE flag = 0 ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Name</th>
                <th>Seat</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaysettingscounty($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php

}
?>
