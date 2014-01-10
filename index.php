<?php
include_once( dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1, 2");

$title = 'agency';
$label = 'get started';
include_once("header.php");
?>

        <div class="container-fluid" id="content">

            <?php include_once('pages/index-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/index-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3>
										<i class="glyphicon-power"></i>
										Get Started
									</h3>
								</div>
								<div class="box-content">
							        <h4>We are proud to introduce several new features..</h4>
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
