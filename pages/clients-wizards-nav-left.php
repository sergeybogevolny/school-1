            <div id="left">
				<div class="subnav">
                    <div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "wizards" ? "active" : "")?>'>
    						<a href="clients-wizards.php">Wizards</a>
    					</li>
                        <li class='dropdown <?php echo ($label == "lists" ? "active" : "")?>'>
    						<a href="#" data-toggle="dropdown">Lists</a>
    						<ul class="dropdown-menu">
    							<li>
    								<a href="clients-lists-alpha.php">Alpha</a>
    							</li>
    						</ul>
    					</li>
					</ul>
				</div>
			</div>
