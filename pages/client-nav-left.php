            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "summary" ? "active" : "")?>'>
    					    <a href="client.php?id=<?php echo $id; ?>">Summary</a>
    					</li>
                        <li class="<?php echo ($label == "bonds" ? "active" : "")?>">
							<a href="client-bonds.php?id=<?php echo $id; ?>">Bonds</a>
						</li>
                        <li class="<?php echo ($label == "references" ? "active" : "")?>">
							<a href="client-references.php?id=<?php echo $id; ?>">References</a>
						</li>
                        <?php if ($stype=='Client') {
                        ?>
                        <li class="<?php echo ($label == "account" ? "active" : "")?>">
							<a href="client-account.php?id=<?php echo $id; ?>">Account</a>
						</li>
                        <li class="<?php echo ($label == "checkins" ? "active" : "")?>">
							<a href="client-checkins.php?id=<?php echo $id; ?>">Check Ins</a>
						</li>
                        <?php
                        }
                        ?>
                        <li class="<?php echo ($label == "notes" ? "active" : "")?>">
							<a href="client-notes.php?id=<?php echo $id; ?>">Notes</a>
						</li>
                        <?php if ($stype=='Client') {
                        ?>
                        <li class="<?php echo ($label == "tasks" ? "active" : "")?>">
							<a href="client-tasks.php?id=<?php echo $id; ?>">Tasks</a>
						</li>
                        <li class="<?php echo ($label == "geo" ? "active" : "")?>">
							<a href="client-geo.php?id=<?php echo $id; ?>">Geo</a>
						</li>
                        <?php
                        }
                        ?>
					</ul>
				</div>
			</div>
