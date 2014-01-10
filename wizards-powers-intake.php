<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_intake.class.php');
include_once('classes/functions-powers.php');

?>

    <script src="js/wizards-powers-intake.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/wizards-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

         <!--<a href="wizards-powers-intake.php">wizards-powers-intake.php</a> -->
           <?php include_once('pages/wizards-page-header.php'); ?>

					<div class="row-fluid">
    					<div class="span12">
    						<div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-download-alt"></i>
    									Powers Intake
    								</h3>
    							</div>
    							<div class="box-content">
                              <div id="success" class="hide alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <center>Success</center>
                              </div>

    		                        <form method="post" action="classes/wizards_powers_intake.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                                		<div class="step" id="firstStep">
    										<ul class="wizard-steps steps-3">
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Step 1
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
    														Step 2
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														3</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                            <div class="step-forms">
                                                <div class="row-fluid">
                                                      <?php echo list_intakejob(); ?>
                                                </div>
    										</div>

    									</div>
    									<div class="step" id="secondStep">
    										<ul class="wizard-steps steps-3">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 1
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
    														Step 2
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														3</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                            <div class="step-forms">
                                                <div class="row-fluid">
                                                    <div style="margin-bottom:10px;">
                                                        <div class="span4" id="count"></div>
                                                        <div class="span8" id="sum"></div>
                                                    </div>
                                                   <div class="power-loading" style="display: none;">Loading...</div>
                                                    <table id="detail-list" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    									<thead>
                    										<tr class='thefilter'>
                    											<th class='with-checkbox'>
                                                                    <input type="checkbox" name="check_all" class="icheck-me"  data-skin="square" data-color="blue" id="check_all_2" >
                                                                </th>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Value</th>
                                                                <th>Expiration</th>
                                                                <th style="display:none;">Issued</th>
                    										</tr>
                                                        </thead>
                    									<tbody id="intakedetail">
                                                        </tbody>
                    								</table>

                                                </div>
    										</div>
    									</div>
                                        <div class="step" id="thirdStep">
    										<ul class="wizard-steps steps-3">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 1
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
    														Step 2
    													</span>
    												</div>
    											</li>
                                                <li class="active">
    												<div class="single-step">
    													<span class="title">
    														3</span>
    													<span class="circle">
                                                            <span class="active"></span>
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                            <div class="row-fluid">
                                             <div style="margin-bottom:10px;">
                                                        <div class="span4" id="reviewcount"></div>
                                                        <div class="span8" id="reviewsum"></div>
                                                    </div>
                                                    <table id="review-detail-list" class="table table-hover table-nomargin table-bordered  dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    									<thead>
                    										<tr>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Value</th>
                                                                <th>Expiration</th>
                                                                <th style="display:none;">Issued</th>
                    										</tr>
                    									</thead>
                    									<tbody id="reviewintakesdetail">
                                                        </tbody>
                    								</table>
                                            </div>
                                        <input type="hidden"  name="intake_id" id="intake_id"/>
                                            <div class="control-group">
											    <label class="control-label" for="confirmation"></label>
											    <div class="controls">
												    <input type="checkbox" name="confirmation" id="confirmation" value="true" data-rule-required="true">
												    &nbspYes, I confirm that input is valid.
											    </div>
										    </div>
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
