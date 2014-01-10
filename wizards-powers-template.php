<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_distribute.class.php');

include_once('classes/listbox.class.php');
//$races = $listbox->getRaces();


?>

    <script src="js/wizards-powers-distribute.js"></script>


        <div class="container-fluid" id="content">

            <?php include_once('pages/wizards-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/wizards-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
    						<div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-signout"></i>
    									Powers Distribute
    								</h3>
    							</div>
    							<div class="box-content">
    		                        <form method="post" action="classes/wizards_powers_distribute.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                                		<div class="step" id="firstStep">
    										<ul class="wizard-steps steps-2">
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Assignment Information
    													</span>
    												</div>
    											</li>
    											<li>
    												<div class="single-step">
    													<span class="title">
    														2</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Power Information
    													</span>
    												</div>
    											</li>
    										</ul>

    									</div>
    									<div class="step" id="secondStep">
    										<ul class="wizard-steps steps-2">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">

    													</span>
    													<span class="description">
    														Assignment Information
    													</span>
    												</div>
    											</li>
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														2</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Power Information
    													</span>
    												</div>
    											</li>
    										</ul>

    									</div>

    									<div class="form-actions" id="wizard-actions">
    										<input type="reset" class="btn" value="Back" id="back">
    										<input type="submit" class="btn btn-primary" value="Create" id="next">
    									</div>

    								</form>
    							</div>
    						</div>
    					</div>
    				</div>

				</div>
			</div>
		</div>


<div id='jqxWindow-status' style="display:none">
<div></div>
<div></div>
</div>

<?php
include("footer.php");
?>
