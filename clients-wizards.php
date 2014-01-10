<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'clients';
$label = 'wizards';
include_once('header.php');
?>

        <div class="container-fluid" id="content">

            <?php include_once('pages/clients-wizards-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/clients-wizards-page-header.php'); ?>

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
            								<a href="./clients-wizards-checkin.php"><span><i class="glyphicon-check"></i></span><span class='name'>Check In</span></a>
            							</li>
            							<li class="darkblue high long">
            								<a href="./clients-wizards-payment.php"><span><i class="glyphicon-usd"></i></span><span class='name'>Payment</span></a>
            							</li>
                                        <li class="darkblue high long">
                                            <a href="./clients-wizards-testpdf.php"><span><i class="glyphicon-file"></i></span><span class='name'>Test PDF</span></a>
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
