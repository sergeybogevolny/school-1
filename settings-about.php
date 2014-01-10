<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'settings';
$label = 'about';
include_once('header.php');

$version='1028';
$major='20';
$minor= round(abs(strtotime('2011-10-28  00:00:00')-strtotime(date('Y-m-d h:i:s')))/86400);
$revision = '3';

?>

        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3>
										<i class="icon-quote-right"></i>
										<?php echo ucwords($label);?>
									</h3>
								</div>
								<div class="box-content">
									<p>Version <?php echo $version;?>.<?php echo $major;?>.<?php echo $minor;?>.<?php echo $revision;?></p>
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
