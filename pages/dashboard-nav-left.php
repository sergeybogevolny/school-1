			<div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class="<?php echo ($label == "production" ? "active" : "")?>">
							<a href="dashboard-production.php">Production</a>
						</li>
                        <li class="<?php echo ($label == "geo" ? "active" : "")?>">
							<a href="dashboard-geo.php">Geo</a>
						</li>
					</ul>
				</div>
			</div>
