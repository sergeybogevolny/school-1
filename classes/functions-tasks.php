<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displayuserstask($row) {
	if(empty($row)) return false;
	?>
    <li class="<?php  echo $row['important'] == 1 ? 'bookmarked' : '' ; ?>">
        <div class="task-type">
           <img src="img/task_<?php echo $row['type'];?>.png">
        </div>
        <span class="task"> <?php echo "<a href='javascript:LoadTask(" . $row['id'] . ");'>".$row['task']."</a>";?></span>
        <span class="task-actions">
            <div class='task-bookmark'><i class="icon-bookmark-empty"></i></div>
        </span>
     </li>
	<?php
}
?>

<?php
function list_userstasks() {

	global $generic;
    $sql = 'SELECT * FROM agency_users_tasks WHERE flag = 0 ORDER BY important DESC';
	$query = $generic->query($sql);

	?>
		<?php
        while($row = $query->fetch(PDO::FETCH_ASSOC)){

			echo displayuserstask($row);
        }
		?>
		
	<?php

}
?>
