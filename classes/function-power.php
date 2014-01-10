<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function displaycollectjob($row) {

	if(empty($row)) return false;
	?>          <tr>
                <td class="with-checkbox">
                    <input type="checkbox" name="collect-check" class="icheck-me checkedt" value="<?php echo $row['id'] ?>" data-skin="square" data-color="blue" id="" onclick="StepValidate('firstStep')">
                </td>
                <td><?php echo $row['date'] ?></td>
                <td><?php echo $row['agent_friendly'] ?></td>
                <td><?php echo $row['count'] ?></td>
                <td><?php echo $row['netpaid'] ?></td>
                <td><?php echo $row['bufpaid'] ?></td>
                <td style="display:none"><?php echo $row['id1'] ?></td>
                <td style="display:none"><?php echo $row['net'] ?></td>
                <td style="display:none"><?php echo $row['buf'] ?></td>
                <td style="display:none"><?php echo $row['netminimum'] ?></td>
                <td style="display:none"><?php echo $row['bufminimum'] ?></td>
          </tr>
	<?php

}

function list_collectjob() {

	global $generic;
    $sql = 'SELECT general_powers_collects.id as id, general_agents.id as id1 ,general_powers_collects.date,general_powers_collects.agent_friendly,general_powers_collects.count,general_powers_collects.netpaid,general_powers_collects.bufpaid,general_agents_contracts.net,general_agents_contracts.buf,general_agents_contracts.netminimum,general_agents_contracts.bufminimum
	        FROM general_powers_collects
            INNER JOIN general_agents ON general_powers_collects.agent_friendly = general_agents.company
            INNER JOIN general_agents_contracts ON general_agents.id = general_agents_contracts.agent_id
	        WHERE recorded IS NULL ORDER BY id DESC';
	$query = $generic->query($sql);

	?>
       <table id="distribute-list" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
            <thead>
                <tr class='thefilter'>
                    <th class='with-checkbox'></th>
                    <th>Submitted</th>
                    <th>By</th>
                    <th>Count</th>
                    <th>Net</th>
                    <th>BUF</th>
                    <th style="display:none">AgentId</th>
                    <th style="display:none">net</th>
                    <th style="display:none">buf</th>
                    <th style="display:none">netminimum</th>
                    <th style="display:none">bufminimum</th>
                    
                </tr>
            </thead>
            <tbody>
                    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC))
					    //print_r($row);
                        echo displaycollectjob($row);
                    ?>
            </tbody>
        </table>
	<?php

}

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
