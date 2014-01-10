<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function fullcalendar($month=NULL, $year=NULL) {
	
	global $generic;
	$sql = "SELECT
    count(*) AS count, type, date
    FROM
    agency_events    
    WHERE
    month(date) = '" . $month . "' and year(date)='" . $year . "' GROUP BY type, date ORDER BY date ASC";

	$query = $generic->query($sql);
	$rows = array();
	while($row = $query->fetch(PDO::FETCH_ASSOC)) :
		$info['id'] = $row['count'];
		$info['title'] = $row['count'] . " " . $row['type'] . " Events";
		$info['start'] = $row['date'];
		$info['url'] = 'events-calendar-detail.php?date=' . $row['date'] . '&type=' . $row['type'];
		if($row['type'] == 'payment') $info['color'] = 'yellow'; else $info['color'] = 'pink';
		$info['textColor'] = 'black';
		$rows[] = $info;
		unset($info);
	endwhile;
	return json_encode($rows);
}


function list_events($date=NULL, $type='paymment') {

	global $generic;
    $sql = "SELECT * FROM agency_events WHERE date='".$date."' and type='".$type."' ORDER BY id DESC";
	$query = $generic->query($sql);
	?>
	<table class="table table-hover table-nomargin dataTable table-bordered">
		<thead>
			<tr>
                <th>Name</th>
                <th>Date</th>
                <th>Type</th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
		<tr>
			<td><?=$row['value']?></td>
			<td><?=date('d M Y', strtotime($row['date']))?></td>
			<td><?=$row['type']?></td>
		</tr>
		<?php endwhile; ?>
		</tbody>
        <tfoot>
        </tfoot>
	</table>
	<?php

}
?>
