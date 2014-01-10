<?php
$scompany = $agent->getField('company');
$stype = $agent->getField('type');
?>

                    <div class="page-header">
						<div class="pull-left">
							<ul class="stats">
								<li class='lightgrey extend'>
                                    <img src='img/agent.png'>
									<div class="details">
										<span class="big"><strong><?php echo $scompany; ?></strong></span>
										<span>Agent - <?php echo ucwords($stype);?></span>
									</div>
								</li>
							</ul>

						</div>
						<div class="pull-right">
							<ul class="stats">
								<li class='grey'>
									<i class="icon-calendar"></i>
									<div class="details">
										<span class="big">February 22, 2013</span>
										<span>Wednesday, 13:56</span>
									</div>
								</li>
							</ul>
						</div>
					</div>