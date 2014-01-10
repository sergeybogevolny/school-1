<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function displayinventory($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td><?php echo $row['prefix']; ?></td>
        <?php echo "<td><a href='javascript:LoadInventory(" . $row['id'] . ");'>" . $row['serial'] ."</td>"; ?>
        <td>
            <?php
                 if(!empty($row['value'])){
				    $value = $row['value'];
                    $value = number_format($value, 2, '.', ',');
				 }else{ $value ="";}
                echo $value;
            ?>
        </td>
        <td><?php echo $row['void']; ?></td>
        <td><?php
				if(!empty($row['void_date']) && $row['void_date'] != '0000-00-00' ){
				    $voided = strtotime($row['void_date']);
					$voided = date('m/d/Y', $voided);
				}else{ $voided ="";}
                echo $voided;		
		 ?></td>
        <td><?php echo $row['name']; ?></td>
        <td>
            <?php
			    if(!empty($row['executeddate']) ){
				    $executeddate = strtotime($row['executeddate']);
					$executeddate = date('m/d/Y', $executeddate);
				}else{ $executeddate ="";}
                echo $executeddate;
            ?>
        </td>
        <td>
            <?php
                 if(!empty($row['amount'])){
				    $amount = $row['amount'];
                    $amount = number_format($amount, 2, '.', ',');
				 }else{ $amount ="";}
                echo $amount;
            ?>
        </td>
        <td><?php echo $row['transfer']; ?></td>
	</tr>
	<?php
}

function list_inventory() {

	global $generic;

    $sql = "SELECT
    agency_powers.id,
    agency_powers.prefix,
    agency_powers.serial,
    agency_settings_lists_prefixs.amount AS `value`,
    agency_bonds.power_id,
    agency_powers.void,
	agency_powers.void_date,
    agency_bonds.executeddate,
    agency_bonds.`name`,
    agency_bonds.amount,
    agency_bonds.transfer,
    general_powers.agent_id
    FROM
    agency_powers
    INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
    LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
    INNER JOIN general_powers ON agency_powers.serial = general_powers.serial AND agency_powers.prefix = general_powers.prefix
    WHERE agency_powers.report_id IS NULL AND general_powers.agent_id=1";

	$query = $generic->query($sql);
	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Prefix</th>
                <th>Serial</th>
                <th>Value</th>
                <th>Void</th>
                <th>Voided</th>
                <th>Name</th>
                <th>Executed</th>
                <th>Amount</th>
                <th>Transfer</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayinventory($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

?>