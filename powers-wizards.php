<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'powers';
$label = 'wizards';
include_once('header.php');
?>

        <div class="container-fluid" id="content">

            <?php include_once('pages/powers-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/powers-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
                            <div class="box">
                                <div class="box-title">
    							    <h3>
    								    <i class="icon-magic"></i>
    									<?php echo ucwords($label);?>
    								</h3>
    							</div>
                                <div class="box-content">
            						<ul class="tiles">
            							<li class="darkblue high long">
            								<a href="#"><span><i class="icon-signin"></i></span><span class='name'>Order</span></a>
            							</li>
            							<li class="darkblue high long">
            								<a href="#"><span><i class="icon-signout"></i></span><span class='name'>Distribute</span></a>
            							</li>
            							<li class="darkblue high long">
            								<a href="#"><span class='count'><i class="glyphicon-inbox_in"></i> 1</span><span class='name'>Collect</span></a>
            							</li>
            							<li class="darkblue high long">
            								<a href="#"><span class='count'><i class="glyphicon-inbox_out"></i> 4</span><span class='name'>Report</span></a>
            							</li>
            						</ul>
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
