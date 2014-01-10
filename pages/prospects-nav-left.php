
            <div id="left">
				<div class="subnav">
                    <div class="subnav-title"><span>Prospects</span>
                    </div>
                </div>
    				<div class="subnav">
                        <div class="subnav-title">
            			    <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Last 30 days</span></a>
            			</div>
            		    <div class="subnav-content">
                            <div style="border-bottom: solid 1px #CCCCCC;">
                                <div class="pagestats">
                                    <?php  prospectChart(); ?>
    					        </div>
                            </div>
				        </div>

            			</div>
                        <div class="subnav">
                        	<div class="subnav-title">
            					<a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Quick Stats</span></a>
            				</div>
            				<div class="subnav-content">
            					<ul class="quickstats">
                                    <?php count_prospectsrated(); ?>
            					</ul>
            				</div>
            			</div>
                    </div>
