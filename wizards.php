<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
?>

        <div class="container-fluid" id="content">

            <?php include_once('pages/wizards-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/wizards-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
                            <?php
                            if ($level=="agent"){
                            ?>
    						    <ul class="tiles">
            					    <li class="darkblue high long">
            						    <a href="wizards-powers-intake.php"><span><i class="icon-signin"></i></span><span class='name'>Powers - Intake</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-powers-report.php"><span class='count'><i class="icon-upload-alt"></i></span><span class='name'>Powers - Report</span></a>
            						</li>
                                </ul>
        					<?php
                            }
                            ?>
                            <?php
                            if ($level=="agency"){
                            ?>
    						    <ul class="tiles">
            					    <li class="darkblue high long">
            						    <a href="wizards-powers-intake.php"><span><i class="icon-signin"></i></span><span class='name'>Powers - Intake</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-powers-void.php"><span></span><span class='name'>Powers - Void</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-powers-report.php"><span class='count'><i class="icon-upload-alt"></i></span><span class='name'>Powers - Report</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-create-prospect.php"><span><i class="icon-plus-sign"></i></span><span class='name'>Prospect - Create</span></a>
            						</li>
                                    <li class="darkblue high long extend">
            						    <a href="wizards-clients-payment.php"><span><img src='img/wizard_payment.png'></span><span class='name'>Client - Payment</span></a>
            						</li>
            					    <li class="darkblue high long extend">
            						    <a href="wizards-tasks-create.php"><span></span><span class='name'>Task - Create</span></a>
            						</li>
                                    <li class="darkblue high long extend">
            						    <a href="wizards-supplements-create.php"><span><img src='img/wizard_supplement.png'></span><span class='name'>Supplement - Create</span></a>
            						</li>
                                </ul>
        					<?php
                            }
                            ?>
                            <?php
                            if ($level=="general"){
                            ?>
    						    <ul class="tiles">
            					    <li class="darkblue high long">
            						    <a href="wizards-powers-order.php"><span><i class="icon-signin"></i></span><span class='name'>Powers - Order</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-powers-distribute.php"><span><i class="icon-signout"></i></span><span class='name'>Powers - Distribute</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-transfers-create.php"><span></span><span class='name'>Transfers - Create</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-forfeitures-record.php"><span></span><span class='name'>Forfeitures - Record</span></a>
            						</li>
                                    <li class="darkblue high long">
            						    <a href="wizards-powers-collect.php"><span class='count'><i class="icon-download-alt"></i></span><span class='name'>Powers - Collect & Report</span></a>
            						</li>
                                    
                                    <li class="darkblue high long">
            						    <a href="wizards-agencies-create.php"><span></span><span class='name'>Agencies - Create</span></a>
            						</li>
            					</ul>
        					<?php
                            }
                            ?>
    					</div>
    				</div>

				</div>
			</div>
		</div>


<?php
include("footer.php");
?>
