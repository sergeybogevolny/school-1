<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/dashboard_production.class.php');

$title = 'dashboard';
$label = 'production';
include_once('header.php');
?>
        <!-- [RISAN] Dashboard Production, retrive data from database to be used in chart -->
        <script type="text/javascript">
            var CLOSE_RATIO_CLIENT = <?php echo $dashboardproduction->getCloseRatio('Client'); ?>;
            var CLOSE_RATIO_PROSPECT = <?php echo $dashboardproduction->getCloseRatio('Prospect'); ?>;
            var SALES_SOURCE = <?php echo $dashboardproduction->getSalesSource(); ?>;
        </script>
        <!-- [RISAN] Dashboard Production, plotting charts -->
        <script type="text/javascript" src="js/dashboard-production.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/dashboard-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/dashboard-page-header.php'); ?>

					<div class="row-fluid">
                        <div class="span12">
    						<div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-bar-chart"></i>
    									Close Ratio
    								</h3>
    							</div>
    							<div class="box-content">
    								<div id="flot-4-sales" class='flot'></div>
    							</div>
    						</div>
					    </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
    						<div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-bar-chart"></i>
    									Sales Source
    								</h3>
    							</div>
    							<div class="box-content">
    								<div id="flot-4-source" class='flot'></div>
    							</div>
    						</div>
					    </div>





					</div>

				</div>
			</div>
		</div>

<?php
include("footer.php");
?>
