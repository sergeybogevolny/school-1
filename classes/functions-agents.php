<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function list_agents($type){
    switch ($type) {
        case 'contracted':
            list_agentscontracted();
            break;
        case 'candidate':
            list_agentscandidate();
            break;
        case 'associate':
            list_agentsassociate();
            break;
		case 'rejected':
		    list_agentsrejected();
            break;
		case 'deleted':
		    list_agentsdeleted();
            break;
    }
}

function displayagentcontracted($row) {

	if(empty($row)) return false;
	?>
    <tr>
      <?php echo "<td><a href='agent.php?id=" . $row['id'] . "'>" . $row['company'] ."</td>"; ?>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['city']; ?></td>
    </tr>
<?php
}

function list_agentscontracted() {

	global $generic;
    $sql = "SELECT * FROM general_agents WHERE type = 'Contracted' AND flag = 0 ORDER BY company DESC, contact DESC, city DESC";

	$query = $generic->query($sql);

	?>
<table class="table table-hover table-nomargin dataTable table-bordered">
  <thead>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentcontracted($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayagentcandidate($row) {

	if(empty($row)) return false;
	?>
    <tr>
       <?php echo "<td><a href='agent.php?id=" . $row['id'] . "'>" . $row['company']."</td>"; ?>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['city']; ?></td>
    </tr>
<?php
}

function list_agentscandidate() {

	global $generic;
    $sql = "SELECT * FROM general_agents WHERE type = 'Candidate' AND flag = 0 ORDER BY company DESC, contact DESC, city DESC";

	$query = $generic->query($sql);

	?>
<table class="table table-hover table-nomargin dataTable table-bordered">
  <thead>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentcandidate($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayagentassociate($row) {

	if(empty($row)) return false;
	?>
    <tr>
       <?php echo "<td><a href='agent.php?id=" . $row['id'] . "'>" . $row['company']."</td>"; ?>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['city']; ?></td>
    </tr>
<?php
}

function list_agentsassociate() {

	global $generic;
    $sql = "SELECT * FROM general_agents WHERE type = 'Associate' AND flag = 0 ORDER BY company DESC, contact DESC, city DESC";

	$query = $generic->query($sql);

	?>
<table class="table table-hover table-nomargin dataTable table-bordered">
  <thead>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentassociate($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayagentrejected($row) {

	if(empty($row)) return false;
	?>
    <tr>
       <?php echo "<td><a href='agent.php?id=" . $row['id'] . "'>" . $row['company']."</td>"; ?>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['city']; ?></td>
    </tr>
<?php
}

function list_agentsrejected() {

	global $generic;
    $sql = "SELECT * FROM general_agents WHERE type = 'Rejected' AND flag = 0 ORDER BY company DESC, contact DESC, city DESC";

	$query = $generic->query($sql);

	?>
<table class="table table-hover table-nomargin dataTable table-bordered">
  <thead>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentrejected($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}

function displayagentdeleted($row) {

	if(empty($row)) return false;
	?>
    <tr>
       <td><?php echo $row['company'] ?></td>
      <td><?php echo $row['contact']; ?></td>
      <td><?php echo $row['city']; ?></td>
    </tr>
<?php
}

function list_agentsdeleted() {

	global $generic;
    $sql = "SELECT * FROM general_agents WHERE flag = 1 ORDER BY company DESC, contact DESC, city DESC";

	$query = $generic->query($sql);

	?>
<table class="table table-hover table-nomargin dataTable table-bordered">
  <thead>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayagentdeleted($row);
		?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php
}
?>