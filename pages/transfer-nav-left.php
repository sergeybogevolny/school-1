<?php
$id = $transfer->getField('id');
?>

            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "summary" ? "active" : "")?>'>
    					    <a href="transfer.php?id=<?php echo $id; ?>">Summary</a>
    					</li>
					</ul>
				</div>
			</div>
