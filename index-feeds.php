<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/agency_feeds.class.php');

$title = 'agency';
$label = 'feeds';
include_once('header.php');
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
    								<h3><i class="icon-bullhorn"></i>Feeds</h3>
            						<div class="actions">
            						    <a href="#" class="btn btn-mini custom-checkbox checkbox-active" id="feeds-refresh">Automatic refresh<i class="icon-check-empty"></i></a>
            						</div>
    							</div>
    							<div class="box-content nopadding">
            					  		<table class="table table-nohead" id="feeds-container">
                                            <tbody>
                                                <?php $feeds->display(); ?>
                                            </tbody>
                                        </table>
                                        <script type="text/javascript" src="js/agency-feeds.js" language="javascript"></script>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                refreshFeed(<?php echo $feeds->latest_feed_id; ?>);
                                            });
                                        </script>
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
