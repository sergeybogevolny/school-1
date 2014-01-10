<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function list_usertaskscount() {

	global $generic;
    $sql = 'SELECT count(*) AS taskcount FROM agency_users_tasks WHERE flag = 0';
	$query = $generic->query($sql);

	?>
		<?php
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $count = $row['taskcount'];
        if ($count>0){
            echo $count;
        }
		?>

	<?php

}
?>

