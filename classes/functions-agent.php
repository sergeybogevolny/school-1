<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function displayagentcontract($row) {

	if(empty($row)) return false;
	?>
	<tr>

            <?php
            $timestamp = strtotime($row['date']);
	        $date  = date('m/d/Y', $timestamp);
            echo "<td><a href='javascript:LoadContract(" . $row['id'] . ");'>" . $date ."</td>";
            ?>

        <td><?php echo $row['net']; ?></td>
        <td><?php echo $row['buf']; ?></td>
	</tr>
	<?php
}

function list_agentcontracts($id) {

	global $generic;
    $sql = "SELECT * FROM general_agents_contracts WHERE agent_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>

	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Date</th>
                <th>Net</th>
                <th>BUF</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentcontract($row);
		?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php
}

function list_agentaccount($id,$type) {

	global $generic;
    $sql = "SELECT * FROM general_agents_accounts WHERE type = '".$type."' AND agent_id=" . $id . " AND flag = 0 ORDER BY Date ASC, Debit DESC, Credit DESC";

	$query = $generic->query($sql);

	?>
    <!--
	<table class="table table-hover table-nomargin dataTable table-bordered">
    -->
    <table class="table table-hover table-nomargin table-bordered" style="padding-top:10px">
		<thead>
			<tr>
                <th>Date</th>
                <th>For</th>
                <th>Debit (+)</th>
                <th>Credit (-)</th>
                <th>Balance</th>
			</tr>
		</thead>
		<tbody>
        <?php
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $date = strtotime($row['date']);
	        $date  = date('m/d/Y', $date);
            $debit = $row['debit'];
			$rowid = $row['id'];
			$collectid = $row['collect_id'];
            if ($debit!=''){
                $debit = number_format($debit,2);
            }
            $credit = $row['credit'];
            if ($credit!=''){
                $credit = number_format($credit,2);
            }
            $balance = $row['balance'];
            if ($balance!=''){
                $balance = number_format($balance,2);
            }

            ?>
            <tr>
    		    <td><?php echo $date; ?></td>
                
                <td><?php echo $row['entry']; ?></td>
                <?php if($collectid == -1 ){ ?>
                        <td><?php echo $debit; ?></td>
                        <td><?php echo $credit; ?></td>
                <?php }else{ ?>
                        <td><a href="#" onclick="editDebitAccount(<?php echo $rowid; ?>,this)" ><?php echo $debit; ?></a></td>
                        <td><a href="#" onclick="editCreditAccount(<?php echo $rowid; ?>,this)" ><?php echo $credit; ?></a></td>
                <?php } ?>
                
                <td><?php echo $balance ?></td>
                <td style="display:none"><?php echo $row['paymentmethod']; ?></td>
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


function displayagentnote($row,$k) {

	if(empty($row)) return false;
	
	?>
        <li class="left">
    	    <div class="image">
    		    <img src="documents/avatar/<?php echo $row['user_id']?>/<?php echo $row['avatar']?>">
    		</div>
    		<div class="message">
    		    <span class="caret"></span>
    			<span class="name">
                <?php
                    echo $row['email'];
					
                ?>
                </span>
    			<p>
                <?php if( $k == 0 && $row['user_id'] == $_SESSION['nware']['user_id'] ) {?>
                <a href="#" onclick="agentnoteedit(<?php echo $row['id'] ?>)">
                 <?php
                    echo $row['comment'];
                ?>
                </a>
                <?php }else{ ?>
                <?php
                    echo $row['comment'];
                ?>
                <?php } ?>
               
                </p>
    			<span class="time">
                <?php
                    $timestamp = strtotime($row['stamp']);
	                $stamp  = date('m/d/Y  g:i a', $timestamp);
                    echo $stamp;
                ?>
                <?php if( $row['edit'] == 1 ){
					echo '<i class="icon-pencil"></i>';
					
					} ?>
                </span>
    		</div>
    	</li>
	<?php   
}

function list_agentnotes($id) {

	global $generic;
    $sql = "SELECT
            general_agents_notes.*,
            login_users.`email`,
            login_users.`avatar`
            FROM
            general_agents_notes
            INNER JOIN login_users ON general_agents_notes.user_id = login_users.user_id
            WHERE agent_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <ul class="messages">
    	<?php
		$count = $query->rowCount();
		$k = 0;
		
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			
			{
				echo displayagentnote($row,$k);
			    $k++;
			}
		?>
    </ul>
	<?php
}


?>