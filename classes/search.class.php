<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Search extends Generic {

    private $options = array();

	function __construct() {

		if(isset($_POST['search-simple-agency'])) {

            /*
            $target = $_POST['jqxDropDownList-search-target'];
            switch ($target){
                case 'Client':
                    $this->list_simpleclients();
                    break;
                case 'Power':
                    $this->list_simplepowers();
                    break;
                case 'Prospect':
                    $this->list_simpleprospects();
                    break;
            }
            */
            $this->list_simpleclients();

		}
        if(isset($_POST['search-simple-general'])) {
            $this->list_simplegeneral();
		}

	}

    private function list_simpleclients(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        if ($rcount==1){
            $sfirstorlast = $svals[0];
            $sql = $sql = "SELECT * FROM agency_clients WHERE (first LIKE '%" . $sfirstorlast . "%' OR last LIKE '%" . $sfirstorlast . "%') AND flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else if ($rcount==2){
            $sfirst = $svals[0];
            $slast = $svals[1];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND last LIKE '%" . $slast . "%' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else {
            $sfirst = $svals[0];
            $smiddle = $svals[1];
            $slast = $svals[2];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND  middle LIKE '%" . $smiddle . "%' AND last LIKE '%" . $slast . "%' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        }

        //$sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $ . "%' AND  middle LIKE '%" . $ . "%' AND last LIKE '%" . $ . "%' AND  flag = 0";
        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 14 ) {
            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
            echo '<h5>'.$rcount . ' record(s) found.</h5>';
            ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered">
		            <thead>
            			<tr>
                            <th>Name</th>
                            <th>Dob</th>
                            <th>SSN</th>
                            <th>Type</th>
                            <th>Standing</th>
                            <th>Logged</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <?php
                            $id= $row['id'];
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
                            echo "<td><a href='client.php?id=" . $id . "'>" . $sname ."</td>";
                            ?>
                            <td>
                                <?php
                                if ($row['dob']=='0000-00-00'){
                                    $dob = '';
                                } else {
                                    $timestamp = strtotime($row['dob']);
                            	    $dob  = date('m/d/Y', $timestamp);
                                }
                                echo $dob;
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
                            <td>
                                <?php echo $row['type']; ?>
                            </td>
                            <td>
                                <?php echo $row['standing']; ?>
                            </td>
                            <td>
                                <?php
                                if ($row['created']=='0000-00-00'){
                                    $created = '';
                                } else {
                                    $timestamp = strtotime($row['created']);
                            	    $created  = date('m/d/Y h:i A', $timestamp);
                                }
                                echo $created;
                                ?>
                            </td>

	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php

        }

    }

    private function list_simplepowers(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        $sql = "SELECT
                agency_settings_lists_prefix.`name` AS prefixname,
                agency_power_orders_details.serial,
                agency_settings_lists_prefix.amount AS prefixamount
                FROM
                agency_powers
                INNER JOIN agency_power_orders_details ON agency_powers.orderdetail_id = agency_power_orders_details.id
                INNER JOIN agency_settings_lists_prefix ON agency_power_orders_details.prefix_id = agency_settings_lists_prefix.id";

        $swhere = '';
        foreach ($svals as $element) {
            if (is_numeric($element)) {
                if ($swhere==''){
                    $swhere = " agency_power_orders_details.serial LIKE '%" . $element . "%'";
                } else {
                    $swhere = $swhere . " AND agency_power_orders_details.serial LIKE '%" . $element . "%'";
                }
            } else {
                if ($swhere==''){
                    $swhere = " agency_settings_lists_prefix.`name` LIKE '%" . $element . "%'";
                } else {
                    $swhere = $swhere . " AND agency_settings_lists_prefix.`name` LIKE '%" . $element . "%'";
                }
            }
        }

        $sql = $sql . " WHERE " . $swhere;

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 3 ) {
            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
             echo '<h5>'.$rcount . ' record(s) found.</h5>';
            ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered">
		            <thead>
            			<tr>
                            <th>Prefix</th>
                            <th>Serial</th>
                            <th>Amount</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <td><?php echo $row['prefixname']; ?></td>
                            <?php echo "<td><a href='power.php'>" . $row['serial'] ."</td>";?>
                            <td><?php echo $row['prefixamount']; ?></td>
	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php

        }

    }

    private function list_simpleprospects(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        if ($rcount==1){
            $sfirstorlast = $svals[0];
            $sql = $sql = "SELECT * FROM agency_clients WHERE (first LIKE '%" . $sfirstorlast . "%' OR last LIKE '%" . $sfirstorlast . "%') AND type = 'Prospect' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else if ($rcount==2){
            $sfirst = $svals[0];
            $slast = $svals[1];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND last LIKE '%" . $slast . "%' AND type = 'Prospect' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        } else {
            $sfirst = $svals[0];
            $smiddle = $svals[1];
            $slast = $svals[2];
            $sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $sfirst . "%' AND  middle LIKE '%" . $smiddle . "%' AND last LIKE '%" . $slast . "%' AND type = 'Prospect' AND  flag = 0 ORDER BY last DESC, first DESC, middle DESC LIMIT 15";
        }

        //$sql = $sql = "SELECT * FROM agency_clients WHERE first LIKE '%" . $ . "%' AND  middle LIKE '%" . $ . "%' AND last LIKE '%" . $ . "%' AND  flag = 0";
        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 3 ) {
            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
             echo '<h5>'.$rcount . ' record(s) found.</h5>';
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
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <?php
                            $id= $row['id'];
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
                            echo "<td><a href='client.php?id=" . $id . "'>" . $sname ."</td>";
                            ?>
                            <td>
                                <?php
                                if ($row['dob']=='0000-00-00'){
                                    $dob = '';
                                } else {
                                    $timestamp = strtotime($row['dob']);
                            	    $dob  = date('m/d/Y', $timestamp);
                                }
                                echo $dob;
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
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php

        }

    }

    private function list_simplegeneral(){

        global $generic;
        $sval = $_POST['search-value'];
        $sval = ltrim($sval," ");
        $sval = rtrim($sval," ");

        $svals = explode(" ", $sval);
        $rcount = count($svals);

        $sql = "SELECT
        general_powers.id,
        general_powers.serial,
        general_powers.prefix,
        general_powers.agent,
        general_settings_lists_sureties.`name` AS `surety`
        FROM
        general_powers
        INNER JOIN general_settings_lists_prefixs ON general_powers.prefix = general_settings_lists_prefixs.`name`
        INNER JOIN general_settings_lists_sureties ON general_settings_lists_prefixs.surety_id = general_settings_lists_sureties.id";

        $swhere = '';
        foreach ($svals as $element) {
            if (is_numeric($element)) {
                if ($swhere==''){
                    $swhere = " general_powers.serial LIKE '%" . $element . "%'";
                } else {
                    $swhere = $swhere . " AND general_powers.serial LIKE '%" . $element . "%'";
                }
            } else {
                if ($swhere==''){
                    $swhere = " general_powers.prefix LIKE '%" . $element . "%'";
                } else {
                    $swhere = $swhere . " AND general_powers.prefix LIKE '%" . $element . "%'";
                }
            }
        }

        $sql = $sql . " WHERE " . $swhere;

        $query = $generic->query($sql);
        $rcount = $query->rowCount();
        if( $rcount < 1 ) {
            echo '<h5>No records found in search.  Please modify your search.</h5>';
        } else if( $rcount > 10 ) {
            echo '<h5>Records found exceeds limit.  Please narrow your search.</h5>';
        } else {
             echo '<h5>'.$rcount . ' record(s) found.</h5>';
            ?>
	            <table class="table table-hover table-nomargin dataTable table-bordered">
		            <thead>
            			<tr>
                            <th>Prefix</th>
                            <th>Serial</th>
                            <th>Agent</th>
            			</tr>
		            </thead>
    		        <tbody>
          		    <?php
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
	                    if(!empty($row)){
	                    ?>
	                    <tr>
                            <td><?php echo $row['prefix']; ?></td>
                            <?php echo "<td><a href='power.php?id=". $row['id'] ."'>" . $row['serial'] ."</td>";?>
                            <td><?php echo $row['agent']; ?></td>
	                    </tr>
	                    <?php
                       }
                    }
          		    ?>
    		        </tbody>
                    <tfoot>
                    </tfoot>
	            </table>
            <?php

        }

    }


}

$search = new Search();
?>