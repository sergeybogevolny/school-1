<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function list_forfeitures($type){
    switch ($type) {
        case 'recorded':
            list_forfeituresrecorded();
            break;
        case 'questioned':
            list_forfeituresquestioned();
            break;
        case 'charged':
            list_forfeiturescharged();
            break;
        case 'documented':
            list_forfeituresdocumented();
            break;
        case 'disposed':
            list_forfeituresdisposed();
            break;

    }
}

function displayforfeiturerecorded($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='forfeiture.php?id=" . $row['id'] . "'>" . $row['recorded'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['prefix']; ?></td>
      <td><?php echo $row['serial']; ?></td>
      <td><?php echo $row['county']; ?></td>
    </tr>
<?php
}

function list_forfeituresrecorded() {

	global $generic;
    $sql = "SELECT * FROM general_forfeitures WHERE type = 'recorded' ORDER BY recorded DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Recorded</th>
          <th>Amount</th>
          <th>Prefix</th>
          <th>Serial</th>
          <th>County</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displayforfeiturerecorded($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displayforfeiturequestioned($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='forfeiture.php?id=" . $row['id'] . "'>" . $row['questioned'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['prefix']; ?></td>
      <td><?php echo $row['serial']; ?></td>
      <td><?php echo $row['county']; ?></td>
    </tr>
<?php
}

function list_forfeituresquestioned() {

	global $generic;
    $sql = "SELECT * FROM general_forfeitures WHERE type = 'questioned' ORDER BY questioned DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Questioned</th>
          <th>Amount</th>
          <th>Prefix</th>
          <th>Serial</th>
          <th>County</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displayforfeiturequestioned($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displayforfeiturecharged($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='forfeiture.php?id=" . $row['id'] . "'>" . $row['charged'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['prefix']; ?></td>
      <td><?php echo $row['serial']; ?></td>
      <td><?php echo $row['county']; ?></td>
    </tr>
<?php
}

function list_forfeiturescharged() {

	global $generic;
    $sql = "SELECT * FROM general_forfeitures WHERE type = 'charged' ORDER BY charged DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Charged</th>
          <th>Amount</th>
          <th>Prefix</th>
          <th>Serial</th>
          <th>County</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displayforfeiturecharged($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displayforfeituredocumented($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='forfeiture.php?id=" . $row['id'] . "'>" . $row['documented'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['prefix']; ?></td>
      <td><?php echo $row['serial']; ?></td>
      <td><?php echo $row['county']; ?></td>
    </tr>
<?php
}

function list_forfeituresdocumented() {

	global $generic;
    $sql = "SELECT * FROM general_forfeitures WHERE type = 'documented' ORDER BY documented DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Documented</th>
          <th>Amount</th>
          <th>Prefix</th>
          <th>Serial</th>
          <th>County</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displayforfeituredocumented($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

function displayforfeituredisposed($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='forfeiture.php?id=" . $row['id'] . "'>" . $row['disposed'] ."</td>"; ?>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['prefix']; ?></td>
      <td><?php echo $row['serial']; ?></td>
      <td><?php echo $row['county']; ?></td>
    </tr>
<?php
}

function list_forfeituresdisposed() {

	global $generic;
    $sql = "SELECT * FROM general_forfeitures WHERE type = 'disposed' ORDER BY disposed DESC";
	$query = $generic->query($sql);

	?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
      <thead>
        <tr>
          <th>Disposed</th>
          <th>Amount</th>
          <th>Prefix</th>
          <th>Serial</th>
          <th>County</th>
        </tr>
      </thead>
      <tbody>
        <?php
    		while($row = $query->fetch(PDO::FETCH_ASSOC))
    			echo displayforfeituredisposed($row);
    	?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php
}

?>