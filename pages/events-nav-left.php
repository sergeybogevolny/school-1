            <div id="left">
				<div class="subnav">
					<div class="subnav-title"><span><?php echo ucwords($title);?></span></div>
					<ul class="subnav-menu">
                        <li class='<?php echo ($label == "calendar" ? "active" : "")?>'>
    						<a href="events-calendar.php">Calendar</a>
    					</li>
                        <li class='dropdown <?php echo ($label == "lists" ? "active" : "")?>'>
    						<a href="#" data-toggle="dropdown">Lists</a>
    						<ul class="dropdown-menu">
                                <li>
    								<a href="events-lists-bondsmade.php">Bonds Made</a>
    							</li>
    						</ul>
    					</li>
					</ul>
				</div>
			</div>
