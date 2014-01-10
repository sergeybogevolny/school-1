<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

function displaypowernote($row ,$k) {

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

function list_powernotes($id) {

	global $generic;
    $sql = "SELECT
            general_powers_notes.*,
            login_users.`email`,
            login_users.`avatar`
            FROM
            general_powers_notes
            INNER JOIN login_users ON general_powers_notes.user_id = login_users.user_id
            WHERE power_id=" . $id . " AND flag = 0 ORDER BY id DESC";

	$query = $generic->query($sql);

	?>
    <ul class="messages">
    	<?php
		$count = $query->rowCount();
		$k = 0;

		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			echo displaypowernote($row,$k);
		    $k++;
		}
		?>
    </ul>
	<?php
}


?>