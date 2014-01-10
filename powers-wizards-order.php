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
    									Order Wizard
    								</h3>
    							</div>
    							<div class="box-content">
    								<form action="post.php" method="POST" class='form-horizontal form-wizard-power' id="ss">
    									<div class="step" id="firstStep">
    										<ul class="wizard-steps steps-4">
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Basic information
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
    														Advanced information
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
    														Additional information
    													</span>
    												</div>
    											</li>
    											<li>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Check again
    													</span>
    												</div>
    											</li>
    										</ul>
    										<div class="step-forms">
    											<div class="control-group">
    												<label for="firstname" class="control-label">First name</label>
    												<div class="controls">
    													<input type="text" name="firstname" id="firstname" class="input-xlarge" data-rule-required="true">
    												</div>
    											</div>
    											<div class="control-group">
    												<label for="anotherelem" class="control-label">Last name</label>
    												<div class="controls">
    													<input type="text" name="anotherelem" id="anotherelem" class="input-xlarge" data-rule-required="true">
    												</div>
    											</div>
    											<div class="control-group">
    												<label for="additionalfield" class="control-label">Additional information</label>
    												<div class="controls">
    													<input type="text" name="additionalfield" id="additionalfield" class="input-xlarge" data-rule-required="true" data-rule-minlength="10">
    												</div>
    											</div>
    										</div>
    									</div>
    									<div class="step" id="secondStep">
    										<ul class="wizard-steps steps-4">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">

    													</span>
    													<span class="description">
    														Basic information
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
    														Advanced information
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
    														Additional information
    													</span>
    												</div>
    											</li>
    											<li>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Check again
    													</span>
    												</div>
    											</li>
    										</ul>
    										<div class="control-group">
    											<label for="text" class="control-label">Gender</label>
    											<div class="controls">
    												<select name="gend" id="gend" data-rule-required="true">
    													<option value="">-- Chose one --</option>
    													<option value="1">Male</option>
    													<option value="2">Female</option>
    												</select>
    											</div>
    										</div>
    										<div class="control-group">
    											<label for="text" class="control-label">Accept policy</label>
    											<div class="controls">
    												<label class="checkbox"><input type="checkbox" name="policy" value="agree" data-rule-required="true"> I agree the policy.</label>
    											</div>
    										</div>
    									</div>
    									<div class="step" id="thirdStep">
    										<ul class="wizard-steps steps-4">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">

    													</span>
    													<span class="description">
    														Basic information
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
    														Advanced information
    													</span>
    												</div>
    											</li>
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														3</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Additional information
    													</span>
    												</div>
    											</li>
    											<li>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Check again
    													</span>
    												</div>
    											</li>
    										</ul>
    										<div class="control-group">
    											<label for="text" class="control-label">Additional information</label>
    											<div class="controls">
    												<textarea name="textare" id="tt333" class="span12" rows="7" placeholder="You can provide additional information in here..."></textarea>
    											</div>
    										</div>
    									</div>
    									<div class="step" id="fourthstep">
    										<ul class="wizard-steps steps-4">
    											<li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
    													<span class="circle">

    													</span>
    													<span class="description">
    														Basic information
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
    														Advanced information
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
    														Additional information
    													</span>
    												</div>
    											</li>
    											<li class='active'>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
    														<span class="active"></span>
    													</span>
    													<span class="description">
    														Check again
    													</span>
    												</div>
    											</li>
    										</ul>
    										<div class="control-group">
    											<label for="text" class="control-label">Check again</label>
    											<div class="controls">
    												<label class="checkbox"><input type="checkbox" name="policy" value="agree" data-rule-required="true"> Everything is ok. Submit</label>
    											</div>
    										</div>
    									</div>
    									<div class="form-actions">
    										<input type="reset" class="btn" value="Back" id="back">
    										<input type="submit" class="btn btn-primary" value="Submit" id="next">
    									</div>
    								</form>
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
