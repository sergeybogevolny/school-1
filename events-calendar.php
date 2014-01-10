<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/events_calendar.class.php');

$title = 'events';
$label = 'calendar';
include_once('header.php');
?>
		<!-- [ADDED BY RISAN] Load our event calendar JS library -->
		<script type="text/javascript" src="./js/events-calendar.js"></script>
        <div class="container-fluid" id="content">

            <?php include_once('pages/events-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/events-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3>
										<i class="icon-calendar"></i>
										Calendar
									</h3>
								</div>
								<div class="box-content">
								    <div class="calendar"></div>
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
