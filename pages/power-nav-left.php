<?php
$id = $power->getField('id');
?>

            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "summary" ? "active" : "")?>'>
    					    <a href="power.php?id=<?php echo $id; ?>">Summary</a>
    					</li>
                        <li class="<?php echo ($label == "notes" ? "active" : "")?>">
                            <a href="power-notes.php?id=<?php echo $id; ?>">Notes</a>
                        </li>
					</ul>
				</div>
			</div>
