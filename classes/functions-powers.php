<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function list_powers($type,$id){
    switch ($type) {
        case 'agency-summary':
            list_powerssummary('agency',-1);
            break;
        case 'general-summary':
            list_powerssummary('agency',-1);
            break;
        case 'agent-summary':
            list_powerssummary('agent',$id);
            break;
        case 'agency-available':
		    list_powersavailable('agency',-1);
            break;
        case 'general-available':
		    list_powersavailable('general',-1);
            break;
        case 'agent-available':
		    list_powersavailable('agent',$id);
            break;
        case 'agency-executed':
		    list_powersexecuted('agency',-1);
            break;
        case 'general-forfeited':
		    list_powersforfeited('general',-1);
            break;
        case 'agent-forfeited':
		    list_powersforfeited('agent',$id);
            break;
        case 'agency-intaken':
		    list_powersintaken('agency',-1);
            break;
        case 'general-ordered':
		    list_powersordered('general',-1);
            break;
        case 'general-distributed':
		    list_powersdistributed('general',-1);
            break;
        case 'agent-distributed':
		    list_powersdistributed('agent',$id);
            break;
        case 'general-Collected':
		    list_powerscollected('general',-1);
            break;
        case 'agent-collected':
		    list_powerscollected('agent',$id);
            break;
        case 'agency-reported':
		    list_powersreported('agency',-1);
            break;
        case 'general-reported':
		    list_powersreported('general',-1);
            break;
        case 'agent-reported':
		    list_powersreported('agent',$id);
            break;
    }
}

function list_powerssummary($level, $id) {

	global $generic;
    if ($level=='agency'){
        $sql = 'SELECT agency_settings_lists_prefixs.`name`,
				(SELECT count(*)
				FROM
				agency_powers
				LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
				WHERE agency_bonds.power_id IS NULL AND agency_powers.prefix = agency_settings_lists_prefixs.`name`
				) as available,
				(SELECT count(*)
				FROM
				agency_powers
				INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
				WHERE agency_bonds.report_id IS NULL AND agency_powers.prefix = agency_settings_lists_prefixs.`name`
				) as executed
				FROM agency_settings_lists_prefixs;';
    }
    if ($level=='general'){
        $sql = 'SELECT general_settings_lists_prefixs.`name`,
            (SELECT count(*)
            FROM
			general_powers
			LEFT JOIN general_bonds ON general_bonds.power_id = general_powers.id
			WHERE general_bonds.power_id IS NULL AND general_powers.prefix = general_settings_lists_prefixs.`name`
			) as available,
            (SELECT count(*)
            FROM
            general_powers
            INNER JOIN general_bonds ON general_bonds.power_id = general_powers.id
            WHERE general_bonds.report_id IS NULL AND general_powers.prefix = general_settings_lists_prefixs.`name`
			) as forfeited
            FROM general_settings_lists_prefixs;';
    }
    if ($level=='agent'){
        $sql = 'SELECT general_settings_lists_prefixs.`name`,
            (SELECT count(*)
            FROM
			general_powers
			LEFT JOIN general_bonds ON general_bonds.power_id = general_powers.id
			WHERE general_bonds.power_id IS NULL AND general_powers.prefix = general_settings_lists_prefixs.`name` AND general_powers.agent_id = '.$id.'
			) as available,
            (SELECT count(*)
            FROM
            general_powers
            INNER JOIN general_bonds ON general_bonds.power_id = general_powers.id
            WHERE general_bonds.report_id IS NULL AND general_powers.prefix = general_settings_lists_prefixs.`name` AND general_powers.agent_id = '.$id.'
			) as forfeited
            FROM general_settings_lists_prefixs;';
  }
  $query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <?php
                    if ($level=='agency'){
                        ?>
                            <th>Prefix</th>
                            <th>Available</th>
                            <th>Executed</th>
                            <th>Total</th>
                        <?php
                    }
                    if ($level=='general'){
                        ?>
                            <th>Prefix</th>
                            <th>Available</th>
                            <th>Forfeited</th>
                            <th>Total</th>
                        <?php
                    }
                    if ($level=='agent'){
                        ?>
                            <th>Prefix</th>
                            <th>Available</th>
                            <th>Forfeited</th>
                            <th>Total</th>
                        <?php
                    }
                ?>
			</tr>
		</thead>
		<tbody>
		<?php
        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
        ?>
            <tr>
                <?php
                    if ($level=='agency'){
                        ?>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['available']; ?></td>
                            <td><?php echo $row['executed']; ?></td>
                            <td><?php echo $row['available']+$row['executed']; ?></td>
                        <?php
                    }
                    if ($level=='general'){
                        ?>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['available']; ?></td>
                            <td><?php echo $row['forfeited']; ?></td>
                            <td><?php echo $row['available']+$row['forfeited']; ?></td>
                        <?php
                    }
                    if ($level=='agent'){
                        ?>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['available']; ?></td>
                            <td><?php echo $row['forfeited']; ?></td>
                            <td><?php echo $row['available']+$row['forfeited']; ?></td>
                        <?php
                    }
                ?>

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

function displaypoweravailable($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td><?php echo $row['prefix']; ?></td>
        <td><?php echo $row['serial']; ?></td>
        <td>
            <?php
                $amount = $row['amount'];
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $pamount = $famount . '.00';
                } else {
                $pamount = number_format($amount);
                }
                echo $pamount;
            ?>
        </td>
        <td>
            <?php
                if ($row['expiration']=='0000-00-00'){
                    $expiration = '';
                } else {
                    $timestamp = strtotime($row['expiration']);
                    $expiration  = date('m/d/Y', $timestamp);
                }
            echo $expiration;
            ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_powersavailable($level,$id) {

	global $generic;
    if ($level=='agency'){
        $sql = 'SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_settings_lists_prefixs.amount,
            agency_powers_orders_details.expiration,
            agency_bonds.power_id
            FROM
            agency_powers
            INNER JOIN agency_settings_lists_prefixs ON agency_powers.prefix = agency_settings_lists_prefixs.`name`
            LEFT JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_powers_orders_details ON agency_powers.orderdetail_id = agency_powers_orders_details.id
            WHERE agency_bonds.power_id IS NULL';
    }
    if ($level=='general'){
        $sql = 'SELECT
            general_powers.prefix,
            general_powers.serial,
            general_settings_lists_prefixs.amount,
            general_powers_orders_details.expiration,
            general_bonds.power_id
            FROM
            general_powers
            INNER JOIN general_settings_lists_prefixs ON general_powers.prefix = general_settings_lists_prefixs.`name`
            LEFT JOIN general_bonds ON general_bonds.power_id = general_powers.id
            INNER JOIN general_powers_orders_details ON general_powers.orderdetail_id = general_powers_orders_details.id
            WHERE general_bonds.power_id IS NULL';
    }
    if ($level=='agent'){
        $sql = 'SELECT
            general_powers.prefix,
            general_powers.serial,
            general_settings_lists_prefixs.amount,
            general_powers_orders_details.expiration,
            general_bonds.power_id
            FROM
            general_powers
            INNER JOIN general_settings_lists_prefixs ON general_powers.prefix = general_settings_lists_prefixs.`name`
            LEFT JOIN general_bonds ON general_bonds.power_id = general_powers.id
            INNER JOIN general_powers_orders_details ON general_powers.orderdetail_id = general_powers_orders_details.id
            WHERE general_bonds.power_id IS NULL AND general_powers.agent_id = '.$id;
    }

	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Prefix</th>
                <th>Serial</th>
                <th>Amount</th>
                <th>Expiration</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypoweravailable($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowerexecuted($row,$level) {

	if(empty($row)) return false;
	?>
	<tr>
        <td><?php echo $row['prefix']; ?></td>
        <td><?php echo $row['serial']; ?></td>
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
                if ($level=='agency'){
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
                } else {
                    echo $row['name'];
                }
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
function list_powersexecuted($level) {

	global $generic;
    if ($level=='agency'){
        $sql = 'SELECT
            agency_powers.prefix,
            agency_powers.serial,
            agency_clients.last,
            agency_clients.`first`,
            agency_clients.middle,
            agency_bonds.executeddate,
            agency_bonds.amount,
            agency_bonds.power_id,
            agency_bonds.report_id
            FROM
            agency_powers
            INNER JOIN agency_bonds ON agency_bonds.power_id = agency_powers.id
            INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
            WHERE agency_bonds.report_id IS NULL';
    }
	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Prefix</th>
                <th>Serial</th>
                <th>Date</th>
                <th>Name</th>
                <th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerexecuted($row,$level);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowerforfeited($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
                if ($row['date']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['date']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?>
        </td>
        <td><?php echo $row['surety']; ?></td>
        <td><?php echo $row['count']; ?></td>
        <td>
            <?php
                $amount = $row['amount'];
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $oamount = $famount . '.00';
                } else {
                $oamount = number_format($amount);
                }
                echo $oamount;
            ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_powersforfeited($level) {

    global $generic;
    if ($level=='general'){
      $sql = 'SELECT
      general_powers_orders.date,
      general_powers_orders.surety,
      general_powers_orders.count,
      general_powers_orders.amount
      FROM
      general_powers_orders';
    }
    if ($level=='agent'){
      $sql = 'SELECT
      general_powers_orders.date,
      general_powers_orders.surety,
      general_powers_orders.count,
      general_powers_orders.amount
      FROM
      general_powers_orders';
    }

	$query = $generic->query($sql);


	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Date</th>
                <th>Surety</th>
                <th>Count</th>
                <th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerforfeited($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowerintaken($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
                if ($row['date']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['date']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?>
        </td>
        <td><?php echo $row['count']; ?></td>
        <td>
            <?php
                $amount = $row['value'];
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $oamount = $famount . '.00';
                } else {
                $oamount = number_format($amount);
                }
                echo $oamount;
            ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_powersintaken($level) {

    global $generic;
    if ($level=='agency'){
      $sql = 'SELECT
      agency_powers_intakes.date,
      agency_powers_intakes.count,
      agency_powers_intakes.amount
      FROM
      agency_powers_intakes
      WHERE agency_powers_intakes.recorded IS NOT NULL';
    }

	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Date</th>
                <th>Count</th>
                <th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerintaken($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowerordered($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <td>
            <?php
                if ($row['date']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['date']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?>
        </td>
        <td><?php echo $row['surety']; ?></td>
        <td><?php echo $row['count']; ?></td>
        <td>
            <?php
                $amount = $row['amount'];
                if (strpos($amount, '.') !== TRUE){
                    $famount = number_format($amount);
                    $oamount = $famount . '.00';
                } else {
                $oamount = number_format($amount);
                }
                echo $oamount;
            ?>
        </td>
	</tr>
	<?php
}
?>

<?php
function list_powersordered($level) {

    global $generic;
    if ($level=='general'){
      $sql = 'SELECT
      general_powers_orders.date,
      general_powers_orders.surety,
      general_powers_orders.count,
      general_powers_orders.amount
      FROM
      general_powers_orders';
    }

	$query = $generic->query($sql);


	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Date</th>
                <th>Surety</th>
                <th>Count</th>
                <th>Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerordered($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowerdistributed($row) {

	if(empty($row)) return false;
	?>
	<tr>

        <?php
            if ($level=='general'){
            ?>
                <td>
                    <?php
                        if ($row['date']=='0000-00-00'){
                            $date = '';
                        } else {
                            $timestamp = strtotime($row['date']);
                            $date  = date('m/d/Y', $timestamp);
                        }
                    echo $date;
                    ?>
                </td>
                <td><?php echo $row['agent']; ?></td>
                <td><?php echo $row['count']; ?></td>
                <td>
                    <?php
                        $amount = $row['amount'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $oamount = $famount . '.00';
                        } else {
                        $oamount = number_format($amount);
                        }
                        echo $oamount;
                    ?>
                </td>
            <?php
            }
            if ($level=='agent'){
            ?>
                <td>
                    <?php
                        if ($row['date']=='0000-00-00'){
                            $date = '';
                        } else {
                            $timestamp = strtotime($row['date']);
                            $date  = date('m/d/Y', $timestamp);
                        }
                    echo $date;
                    ?>
                </td>
                <td><?php echo $row['count']; ?></td>
                <td>
                    <?php
                        $amount = $row['amount'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $oamount = $famount . '.00';
                        } else {
                        $oamount = number_format($amount);
                        }
                        echo $oamount;
                    ?>
                </td>
            <?php
            }
        ?>
	</tr>
	<?php
}
?>

<?php
function list_powersdistributed($level) {

    global $generic;
    if ($level=='general'){
      $sql = 'SELECT
      general_powers_distributes.date,
      general_powers_distributes.agent,
      general_powers_distributes.count,
      general_powers_distributes.amount
      FROM
      general_powers_distributes';
    }
    if ($level=='agent'){
      $sql = 'SELECT
      general_powers_distributes.date,
      general_powers_distributes.count,
      general_powers_distributes.amount
      FROM
      general_powers_distributes
      WHERE general_powers_distributes.agent_id='.$id;
    }

	$query = $generic->query($sql);


	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <?php
                    if ($level=='general'){
                        ?>
                        <th>Date</th>
                        <th>Agent</th>
                        <th>Count</th>
                        <th>Amount</th>
                        <?php
                    }
                    if ($level=='agent'){
                        ?>
                        <th>Date</th>
                        <th>Count</th>
                        <th>Amount</th>
                        <?php
                    }
                 ?>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerdistributed($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>

<?php
function displaypowercollected($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <?php
        if ($level=='general'){
        ?>
            <td>
                <?php
                    if ($row['date']=='0000-00-00'){
                        $date = '';
                    } else {
                        $timestamp = strtotime($row['date']);
                        $date  = date('m/d/Y', $timestamp);
                    }
                echo $date;
                ?>
            </td>
            <td><?php echo $row['agent']; ?></td>
            <td><?php echo $row['count']; ?></td>
            <td>
                <?php
                    $amount = $row['amount'];
                    if (strpos($amount, '.') !== TRUE){
                        $famount = number_format($amount);
                        $oamount = $famount . '.00';
                    } else {
                    $oamount = number_format($amount);
                    }
                    echo $oamount;
                ?>
            </td>
            <td>
                <?php
                    $net = $row['netcalculated'];
                    if (strpos($net, '.') !== TRUE){
                        $fnet = number_format($net);
                        $onet = $fnet . '.00';
                    } else {
                    $onet = number_format($net);
                    }
                    echo $onet;
                ?>
            </td>
            <td>
                <?php
                    $buf = $row['bufcalculated'];
                    if (strpos($buf, '.') !== TRUE){
                        $fbuf = number_format($buf);
                        $obuf = $fbuf . '.00';
                    } else {
                    $obuf = number_format($buf);
                    }
                    echo $obuf;
                ?>
            </td>
        <?php
        }
        if ($level=='agent'){
        ?>
            <td>
                <?php
                    if ($row['date']=='0000-00-00'){
                        $date = '';
                    } else {
                        $timestamp = strtotime($row['date']);
                        $date  = date('m/d/Y', $timestamp);
                    }
                echo $date;
                ?>
            </td>
            <td><?php echo $row['count']; ?></td>
            <td>
                <?php
                    $amount = $row['amount'];
                    if (strpos($amount, '.') !== TRUE){
                        $famount = number_format($amount);
                        $oamount = $famount . '.00';
                    } else {
                    $oamount = number_format($amount);
                    }
                    echo $oamount;
                ?>
            </td>
            <td>
                <?php
                    $net = $row['netcalculated'];
                    if (strpos($net, '.') !== TRUE){
                        $fnet = number_format($net);
                        $onet = $fnet . '.00';
                    } else {
                    $onet = number_format($net);
                    }
                    echo $onet;
                ?>
            </td>
            <td>
                <?php
                    $buf = $row['bufcalculated'];
                    if (strpos($buf, '.') !== TRUE){
                        $fbuf = number_format($buf);
                        $obuf = $fbuf . '.00';
                    } else {
                    $obuf = number_format($buf);
                    }
                    echo $obuf;
                ?>
            </td>
        <?php
        }
        ?>
	</tr>
	<?php
}
?>

<?php
function list_powerscollected($level) {

    global $generic;
    if ($level=='general'){
      $sql = 'SELECT
      general_powers_collects.date,
      general_powers_collects.agent,
      general_powers_collects.count,
      general_powers_collects.amount,
      general_powers_collects.netcalculated,
      general_powers_collects.bufcalculated
      FROM
      general_powers_collects
      WHERE recorded IS NOT NULL';
    }
    if ($level=='agent'){
      $sql = 'SELECT
      general_powers_collects.date,
      general_powers_collects.count,
      general_powers_collects.amount,
      general_powers_collects.netcalculated,
      general_powers_collects.bufcalculated
      FROM
      general_powers_collects
      WHERE recorded IS NOT NULL AND agent_id='.$id;
    }

	$query = $generic->query($sql);


	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <?php
                    if ($level=='general'){
                    ?>
                        <th>Date</th>
                        <th>Agent</th>
                        <th>Count</th>
                        <th>Amount</th>
                        <th>Net</th>
                        <th>BUF</th>
                    <?php
                    }
                    if ($level=='agent'){
                    ?>
                        <th>Date</th>
                        <th>Count</th>
                        <th>Amount</th>
                        <th>Net</th>
                        <th>BUF</th>
                    <?php
                    }
                 ?>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowercollected($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}
?>


<?php
function displaypowerreported($row) {

	if(empty($row)) return false;
	?>
	<tr>
        <?php
            if ($level=='agency'){
            ?>
                <td>
                    <?php
                        if ($row['date']=='0000-00-00'){
                            $date = '';
                        } else {
                            $timestamp = strtotime($row['date']);
                            $date  = date('m/d/Y', $timestamp);
                        }
                    echo $date;
                    ?>
                </td>
                <td><?php echo $row['surety']; ?></td>
                <td><?php echo $row['count']; ?></td>
                <td>
                    <?php
                        $amount = $row['amount'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $ramount = $famount . '.00';
                        } else {
                        $ramount = number_format($amount);
                        }
                        echo $ramount;
                    ?>
                </td>
                <td>
                    <?php
                        $amount = $row['netcalculated'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $pamount = $famount . '.00';
                        } else {
                        $pamount = number_format($amount);
                        }
                        echo $pamount;
                    ?>
                </td>
                <td>
                    <?php
                        $amount = $row['bufcalculated'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $bamount = $famount . '.00';
                        } else {
                        $bamount = number_format($amount);
                        }
                        echo $bamount;
                    ?>
                </td>
            <?php
            }
            if ($level=='general'){
            ?>
                <td>
                    <?php
                        if ($row['date']=='0000-00-00'){
                            $date = '';
                        } else {
                            $timestamp = strtotime($row['date']);
                            $date  = date('m/d/Y', $timestamp);
                        }
                    echo $date;
                    ?>
                </td>
                <td><?php echo $row['count']; ?></td>
                <td>
                    <?php
                        $amount = $row['amount'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $ramount = $famount . '.00';
                        } else {
                        $ramount = number_format($amount);
                        }
                        echo $ramount;
                    ?>
                </td>
                <td>
                    <?php
                        $amount = $row['netcalculated'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $pamount = $famount . '.00';
                        } else {
                        $pamount = number_format($amount);
                        }
                        echo $pamount;
                    ?>
                </td>
                <td>
                    <?php
                        $amount = $row['bufcalculated'];
                        if (strpos($amount, '.') !== TRUE){
                            $famount = number_format($amount);
                            $bamount = $famount . '.00';
                        } else {
                        $bamount = number_format($amount);
                        }
                        echo $bamount;
                    ?>
                </td>
            <?php
            }
        ?>
	</tr>
	<?php
}
?>

<?php
function list_powersreported($level) {

    global $generic;
    if ($level=='agency'){
      $sql = 'SELECT
      agency_powers_reports.date,
      agency_powers_reports.surety,
      agency_powers_reports.count,
      agency_powers_reports.amount,
      agency_powers_reports.netcalculated,
      agency_powers_reports.bufcalculated
      FROM
      agency_powers_reports';
    }
    if ($level=='general'){
      $sql = 'SELECT
      general_powers_reports.date,
      general_powers_reports.count,
      general_powers_reports.amount,
      general_powers_reports.netcalculated,
      general_powers_reports.bufcalculated
      FROM
      general_powers_reports';
    }

	$query = $generic->query($sql);

	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <?php
                    if ($level=='agency'){
                        ?>
                            <th>Date</th>
                            <th>Surety</th>
                            <th>Count</th>
                            <th>Amount</th>
                            <th>Net</th>
                            <th>BUF</th>
                        <?php
                    }
                    if ($level=='general'){
                        ?>
                            <th>Date</th>
                            <th>Count</th>
                            <th>Amount</th>
                            <th>Net</th>
                            <th>BUF</th>
                        <?php
                    }
                ?>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displaypowerreported($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

?>
<?php

function displaycollectjob($row) {

	if(empty($row)) return false;
	?>          <tr>
                <td class="with-checkbox">
                    <input type="checkbox" name="collect-check" class="icheck-me checkedt" value="<?php echo $row['id'] ?>" data-skin="square" data-color="blue" id="" onclick="StepValidate('firstStep')">
                </td>
                <td><?php echo $row['date'] ?></td>
                <td><?php echo $row['agent_friendly'] ?></td>
                <td><?php echo $row['count'] ?></td>
                <td><?php echo $row['amount'] ?></td>
                <td style="display:none"><?php echo $row['netcalculated'] ?></td>
                <td style="display:none"><?php echo $row['bufcalculated'] ?></td>
                <td style="display:none"><?php echo $row['netdate'] ?></td>
                <td style="display:none"><?php echo $row['netpaid'] ?></td>
                <td style="display:none"><?php echo $row['netmethod'] ?></td>
                <td style="display:none"><?php echo $row['bufdate'] ?></td>
                <td style="display:none"><?php echo $row['bufpaid'] ?></td>
                <td style="display:none"><?php echo $row['bufmethod'] ?></td>
          </tr>
	<?php

}

function list_collectjob() {

	global $generic;
    $sql = 'SELECT * FROM general_powers_collects WHERE recorded IS NULL ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
       <table id="job-list" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
            <thead>
                <tr class='thefilter'>
                    <th class='with-checkbox'></th>
                    <th>Submitted</th>
                    <th>By</th>
                    <th>Count</th>
                    <th>Amount</th>
                    <th style="display:none;">Net Calculated</th>
                    <th style="display:none;">BUF Calculated</th>
                    <th style="display:none;">Net Date</th>
                    <th style="display:none;">Net Paid</th>
                    <th style="display:none;">Net Method</th>
                    <th style="display:none;">BUF Date</th>
                    <th style="display:none;">BUF Paid</th>
                    <th style="display:none;">BUF Method</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC))
                        echo displaycollectjob($row);
                    ?>
            </tbody>
        </table>
	<?php

}
?>

<?php
function displayintakejob($row) {

	if(empty($row)) return false;
	?>          <tr>
                <td class="with-checkbox">
                    <input type="checkbox" name="collect-check" class="icheck-me checkedt" value="<?php echo $row['id'] ?>" data-skin="square" data-color="blue" id="" onclick="StepValidate('firstStep')">
                </td>
                <td><?php echo $row['date'] ?></td>
                <td><?php echo $row['count'] ?></td>
                <td><?php echo $row['value'] ?></td>
          </tr>
	<?php

}

function list_intakejob() {

	global $generic;
    $sql = 'SELECT * FROM agency_powers_intakes WHERE recorded IS NULL ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
       <table id="distribute-list" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
            <thead>
                <tr class='thefilter'>
                    <th class='with-checkbox'></th>
                    <th>Date</th>
                    <th>Count</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC))
                        echo displayintakejob($row);
                    ?>
            </tbody>
        </table>
	<?php

}
?>
