<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-events.php');

$title = 'events';
$label = 'lists';
include("header.php");
?>

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
										<i class="icon-list-alt"></i>
										Bonds Made
									</h3>
								</div>
								<div class="box-content">
                                    <?php list_bondsmade(); ?>
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
