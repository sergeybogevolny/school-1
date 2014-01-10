<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');
?>

<?php
function displayagencydirectory($row) {

	if(empty($row)) return false;
	?>
    <tr>
        <td class='img'><img src="img/directory_<?php echo $row['type'];?>.png" alt=""></td>
        <td class='user'><a href='javascript:LoadDirectory("<?php echo $row['id']; ?>");'><?php echo $row['name'];?></a></td>
    </tr>
	<?php
}
?>

<?php
function list_agencydirectory() {

	global $generic;
    $sql = 'SELECT * FROM agency_directory WHERE flag = 0 ORDER BY name ASC';
	$query = $generic->query($sql);

	?>
    <div class="box-content nopadding scrollable" data-height="600" data-visible="true">
    <table class="table table-user table-nohead">
        <tbody>
		<?php
        $salpha = '';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $snamealpha = substr($row['name'], 0, 1);
            $snamealphaupper = strtoupper($snamealpha);
            if ($salpha!=$snamealphaupper){
            ?>
                <tr class="alpha">
    			    <td class="alpha-val">
    				    <span><?php echo trim($snamealphaupper);?></span>
    				</td>
    			    <td colspan="<?php echo ($salpha == "" ? "2" : "3")?>"></td>
    			</tr>
            <?php
            }
            $salpha=$snamealphaupper;
			echo displayagencydirectory($row);
        }
		?>
		</tbody>
	</table>
    </div>
	<?php

}
?>
