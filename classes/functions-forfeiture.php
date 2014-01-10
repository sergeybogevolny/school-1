<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function displayforfeiturenote($row) {

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
                <?php
                    echo $row['comment'];
                ?>
                </p>
    			<span class="time">
                <?php
                    $timestamp = strtotime($row['stamp']);
	                $stamp  = date('m/d/Y  g:i a', $timestamp);
                    echo $stamp;
                ?>
                </span>
    		</div>
    	</li>
	<?php
}

function list_forfeiturenotes($id) {

	global $generic;
    $sql = "SELECT
            general_forfeitures_notes.*,
            login_users.`email`,
            login_users.`avatar`
            FROM
            general_forfeitures_notes
            INNER JOIN login_users ON general_forfeitures_notes.user_id = login_users.user_id
            WHERE forfeiture_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <ul class="messages">
    	<?php
		while($row = $query->fetch(PDO::FETCH_ASSOC))
			echo displayforfeiturenote($row);
		?>
    </ul>
	<?php
}


?>