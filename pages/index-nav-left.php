			<div id="left">
				<div class="subnav">
                    <?php
                    if ($level=="agent"){
                    ?>
                        <div class="subnav-title"><span>Agent</span></div>
					<?php
                    }
                    ?>
                    <?php
                    if ($level=="agency"){
                    ?>
                        <div class="subnav-title"><span>Agency</span></div>
					<?php
                    }
                    ?>
                    <?php
                    if ($level=="general"){
                    ?>
                        <div class="subnav-title"><span>General</span></div>
					<?php
                    }
                    ?>
                    <?php if ($level=="agent"){ ?>
    					<ul class="subnav-menu">
                            <li class="<?php echo ($label == "get started" ? "active" : "")?>">
    							<a href="index.php">Get Started</a>
    						</li>
    					</ul>
					<?php } else { ?>
                        <ul class="subnav-menu">
                            <li class="<?php echo ($label == "get started" ? "active" : "")?>">
    							<a href="index.php">Get Started</a>
    						</li>
                            <li class="<?php echo ($label == "bulletin" ? "active" : "")?>">
    							<a href="index-bulletin.php">Bulletin</a>
    						</li>
                            <li class="<?php echo ($label == "directory" ? "active" : "")?>">
    							<a href="index-directory.php">Directory</a>
    						</li>
                            <li class="<?php echo ($label == "feeds" ? "active" : "")?>">
    							<a href="index-feeds.php">Feeds</a>
    						</li>
    					</ul>
					<?php } ?>
				</div>
			</div>
