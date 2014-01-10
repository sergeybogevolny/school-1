<?php
$id = $agent->getField('id');
$stype = $agent->getField('type');
?>

            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "summary" ? "active" : "")?>'>
    					    <a href="agent.php?id=<?php echo $id; ?>">Summary</a>
    					</li>
                        <?php if($stype=='Contracted'){ ?>
                            <li class="<?php echo ($label == "contracts" ? "active" : "")?>">
    							<a href="agent-contracts.php?id=<?php echo $id; ?>">Contracts</a>
    						</li>
                            <li class="<?php echo ($label == "powers" ? "active" : "")?>">
    							<a href="agent-powers.php?id=<?php echo $id; ?>">Powers</a>
    						</li>
                            <li class="<?php echo ($label == "account" ? "active" : "")?>">
    							<a href="agent-account.php?id=<?php echo $id; ?>">Account</a>
    						</li>
                        <?php } ?>
                        <li class="<?php echo ($label == "notes" ? "active" : "")?>">
							<a href="agent-notes.php?id=<?php echo $id; ?>">Notes</a>
						</li>
					</ul>
				</div>
			</div>
