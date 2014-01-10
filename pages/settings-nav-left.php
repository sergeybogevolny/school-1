            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "profile" ? "active" : "")?>'>
    					    <a href="settings-profile.php">Profile</a>
    					</li>
                        <li class='<?php echo ($label == "communications" ? "active" : "")?>'>
    					    <a href="settings-communications.php">Communications</a>
    					</li>
                        <li class='<?php echo ($label == "bulletin" ? "active" : "")?>'>
    					    <a href="settings-bulletin.php">Bulletin</a>
    					</li>
                        <li class='<?php echo ($label == "geo" ? "active" : "")?>'>
    					    <a href="settings-geo.php">Geo</a>
    					</li>
                        <li class='dropdown <?php echo ($label == "tables" ? "active" : "")?>'>
    						<a href="#" data-toggle="dropdown">Tables</a>
    						<ul class="dropdown-menu">
    							<li>
    							    <a href="settings-tables-attorneys.php">Attorneys</a>
    							</li>
                                <li>
    							    <a href="settings-tables-charges.php">Charges</a>
    							</li>
                                <li>
    							    <a href="settings-tables-counties.php">Counties</a>
    							</li>
                                <li>
    							    <a href="settings-tables-couriers.php">Couriers</a>
    							</li>
    							<li>
    							    <a href="settings-tables-courts.php">Courts</a>
    							</li>
                                <li>
    							    <a href="settings-tables-jails.php">Jails</a>
    							</li>
                                <li>
    							    <a href="settings-tables-offices.php">Offices</a>
    							</li>
                                <li>
    							    <a href="settings-tables-paymentmethods.php">Payment Methods</a>
    							</li>
                                <li>
    							    <a href="settings-tables-prefixs.php">Prefixs</a>
    							</li>
                                <li>
    							    <a href="settings-tables-setfors.php">Set Fors</a>
    							</li>
                                <li>
    							    <a href="settings-tables-sources.php">Sources</a>
    							</li>
                                <li>
    							    <a href="settings-tables-sureties.php">Sureties</a>
    							</li>
    						</ul>
    					</li>
                        <li class="<?php echo ($label == "about" ? "active" : "")?>">
							<a href="settings-about.php">About</a>
						</li>
					</ul>
				</div>
			</div>
