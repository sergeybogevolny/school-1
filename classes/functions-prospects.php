<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function list_prospects($type){
    switch ($type) {
        case 'current':
            list_prospectscurrent();
            break;
		case 'rejected':
		    list_prospectsrejected();
            break;
		case 'deleted':
		    list_prospectsdeleted();
            break;
    }
}

function displayprospectcurrent($row) {

	if(empty($row)) return false;
	?>

<tr class="color_<?php echo $row['rate']; ?>">
  <td><?php   
              
               
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
            ?></td>
  <td><?php
                if ($row['dob']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['dob']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?></td>
  <td><?php
                if ($row['ssnlast4']==''){
                    $ssn = '';
                } else {
                    $ssn = 'XXX-XX-' . $row['ssnlast4'];
                }
            echo $ssn;
            ?></td>
</tr>
<?php
}

function list_prospectscurrent() {

	global $generic;
    $sql = "SELECT * FROM agency_clients WHERE type = 'Prospect' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC";

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
			echo displayprospectcurrent($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayprospectrejected($row) {

	if(empty($row)) return false;
	?>
<tr>
  <td><?php
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
            ?></td>
  <td><?php
                if ($row['dob']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['dob']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?></td>
  <td><?php
                if ($row['ssnlast4']==''){
                    $ssn = '';
                } else {
                    $ssn = 'XXX-XX-' . $row['ssnlast4'];
                }
            echo $ssn;
            ?></td>
</tr>
<?php
}

function list_prospectsrejected() {

	global $generic;
    $sql = "SELECT * FROM agency_clients WHERE type = 'Reject' AND flag = 0 ORDER BY last DESC, first DESC, middle DESC";

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
			echo displayprospectrejected($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayprospectdeleted($row) {

	if(empty($row)) return false;
	?>
<tr>
  <td><?php
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
            ?></td>
  <td><?php
                if ($row['dob']=='0000-00-00'){
                    $date = '';
                } else {
                    $timestamp = strtotime($row['dob']);
                    $date  = date('m/d/Y', $timestamp);
                }
            echo $date;
            ?></td>
  <td><?php
                if ($row['ssnlast4']==''){
                    $ssn = '';
                } else {
                    $ssn = 'XXX-XX-' . $row['ssnlast4'];
                }
            echo $ssn;
            ?></td>
</tr>
<?php
}

function list_prospectsdeleted() {

	global $generic;
    $sql = "SELECT * FROM agency_clients WHERE type = 'Prospect' AND flag = 1 ORDER BY last DESC, first DESC, middle DESC";

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
			echo displayprospectdeleted($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}
?>
<?php 

function count_prospectsrated(){
	global $generic;
    
	$sql = "SELECT count('rate') AS countup FROM agency_clients WHERE rate ='thumbs-up' AND flag = 0 ";
	$query = $generic->query($sql);
	while($row = $query->fetch(PDO::FETCH_ASSOC))
	$countThumbsup = $row['countup'];
	
    $sql1 = "SELECT count('rate') AS countuncertain FROM agency_clients WHERE rate ='uncertain' AND flag = 0 ";
	$query1 = $generic->query($sql1);
	while($row1 = $query1->fetch(PDO::FETCH_ASSOC))
	$countUncertain = $row1['countuncertain'];

    $sql2 = "SELECT COUNT('rate') AS countdown FROM agency_clients WHERE rate ='thumbs-down' AND flag = 0  ";
	$query2 = $generic->query($sql2);
	while($row2 = $query2->fetch(PDO::FETCH_ASSOC))
	$countThumbsdown = $row2['countdown'];
	
	$total = $countThumbsup + $countUncertain + $countThumbsdown;

?>
            <li> <span class="value"><?php  echo $total; ?></span> <span class="name">Total</span> </li>
            <li> <span class="value"><?php echo $countUncertain; ?></span> <img src='img/rate_list_uncertain.png'> </li>
            <li> <span class="value"><?php echo $countThumbsup; ?></span> <img src='img/rate_list_thumbs-up.png'> </li>
            <li> <span class="value"><?php echo $countThumbsdown; ?></span> <img src='img/rate_list_thumbs-down.png'> </li>
<?php 
} 
?>

<?php 

function prospectChart() {

	 global $generic;
	 $ending_date = date('Y-m-d');		
	 $total_days = 30;	

	$sql = "SELECT DATE(created) AS 'DATE',COUNT(*) AS 'pcount'	FROM agency_clients WHERE type = 'Prospect' AND DATEDIFF('$ending_date', DATE(created)) <= $total_days GROUP BY DATE(created) ORDER BY DATE(created)";

	$query = $generic->query($sql);
	
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		$countProspect[] = $row['pcount'];
	}
	
    $list = json_encode( $countProspect);
    

?>
<script>
   var COUNT_TOTAL_PROSPECTS =  <?php echo $list ?>;
</script>

<span class="prospectBar"></span>

<?php 	
}
?>	
