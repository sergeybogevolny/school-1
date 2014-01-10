<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'clients';
$label = 'wizards';
// Include our header file (showing main navigation at top)
include_once('header.php');
?>
<!-- Load JS file to set form wizard plugin -->
<script type="text/javascript" src="js/clients-wizards-testpdf.js"></script>
<div class="container-fluid" id="content">
	<!-- SHOWING LEFT NAVIGATION =========================================================================-->
	<?php include_once('./pages/clients-wizards-nav-left.php'); ?>

	<!-- MAIN CONTENT CONTAINER ==========================================================================-->
	<div id="main">
		<div class="container-fluid">

			<!-- SHOWING MAIN TITLE AND CURRENT DATE TIME ================================================-->
			<?php include_once('./pages/clients-wizards-page-header.php'); ?>

			<!-- SHOWING SUB TITLE & FORM WIZARD =========================================================-->
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<!-- SUB TITLE ===================================================================-->
						<div class="box-title">
							<h3>
								<i class="glyphicon-file"></i>
								Test PDF
							</h3>
						</div> <!-- [END] box-title class -->

						<!-- MAIN CONTENT: FORM WIZARD ===================================================-->
						<div class="box-content">
							<form method="post" action="clients-wizards-testpdf-post.php" class="form-horizontal form-wizard" id="form-wizard">
								<!-- FIRST STEP ==========================================================-->
								<div class="step" id="firstStep">
									<!-- WIZARD HEADER ***************************************************-->
									<ul class="wizard-steps steps-4">
										<!-- Step1 header -->
										<li class="active">
											<div class="single-step">
												<span class="title">1</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Basic Information</span>
											</div>
										</li>

										<!-- Step2 header -->
										<li>
											<div class="single-step">
												<span class="title">2</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Advanced Information</span>
											</div>
										</li>

										<!-- Step3 header -->
										<li>
											<div class="single-step">
												<span class="title">3</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Aditional Information</span>
											</div>
										</li>

										<!-- Step4 header-->
										<li>
											<div class="single-step">
												<span class="title">4</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Check Again</span>
											</div>
										</li>
									</ul> <!-- [END] wizard-steps class -->

									<!-- WIZARD FORM *****************************************************-->
									<div class="step-forms">
										<!-- First Name -->
										<div class="control-group">
											<label class="control-label" for="firstname">First Name</label>
											<div class="controls">
												<input type="text" name="firstname" id="firstname" class="input-xlarge" data-rule-required="true">
											</div>
										</div>
										<!-- Last Name -->
										<div class="control-group">
											<label class="control-label" for="lastname">Last Name</label>
											<div class="controls">
												<input type="text" name="lastname" id="lastname" class="input-xlarge" data-rule-required="true">
											</div>
										</div>
										<!-- Email -->
										<div class="control-group">
											<label class="control-label" for="lastname">Email</label>
											<div class="controls">
												<input type="text" name="email" id="email" class="input-xlarge" data-rule-required="true" data-rule-email="true">
											</div>
										</div>
									</div>
								</div> <!-- [END] firstStep -->

								<!-- SECOND STEP =========================================================-->
								<div class="step" id="secondStep">
									<!-- WIZARD HEADER ***************************************************-->
									<ul class="wizard-steps steps-4">
										<!-- Step1 header -->
										<li>
											<div class="single-step">
												<span class="title">1</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Basic Information</span>
											</div>
										</li>

										<!-- Step2 header -->
										<li class="active">
											<div class="single-step">
												<span class="title">2</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Advanced Information</span>
											</div>
										</li>

										<!-- Step3 header -->
										<li>
											<div class="single-step">
												<span class="title">3</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Aditional Information</span>
											</div>
										</li>

										<!-- Step4 header-->
										<li>
											<div class="single-step">
												<span class="title">4</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Check Again</span>
											</div>
										</li>
									</ul> <!-- [END] wizard-steps class -->

									<!-- WIZARD FORM *****************************************************-->
									<div class="step-forms">
										<!-- Gender -->
										<div class="control-group">
											<label class="control-label" for="gender">Gender</label>
											<div class="controls">
												<input type="radio" name="gender" value="male" data-rule-required="true"> Male
												<input type="radio" name="gender" value="female"> Female
											</div>
										</div>
										<!-- Language -->
										<div class="control-group">
											<label class="control-label" for="language">Language</label>
											<div class="controls">
												<select name="language" id="language" data-rule-required="true">
													<option value="">-- Choose One ---</option>
													<option value="english">English</option>
													<option value="french">French</option>
													<option value="spanish">Spanish</option>
													<option value="german">German</option>
													<option value="greek">Greek</option>
												</select>
											</div>
										</div>
										<!-- Hobbies -->
										<div class="control-group">
											<label class="control-label" for="hobbies[]">Hobbies</label>
											<div class="controls">
												<input type="checkbox" name="hobbies[]" value="football" data-rule-required="true"> Football
												<input type="checkbox" name="hobbies[]" value="basket ball" data-rule-required="true"> Basket Ball
												<input type="checkbox" name="hobbies[]" value="swimming" data-rule-required="true"> Swimming
											</div>
										</div>
									</div>
								</div> <!-- [END] secondStep -->

								<!-- THIRD STEP ==========================================================-->
								<div class="step" id="thirdStep">
									<!-- WIZARD HEADER ***************************************************-->
									<ul class="wizard-steps steps-4">
										<!-- Step1 header -->
										<li>
											<div class="single-step">
												<span class="title">1</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Basic Information</span>
											</div>
										</li>

										<!-- Step2 header -->
										<li>
											<div class="single-step">
												<span class="title">2</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Advanced Information</span>
											</div>
										</li>

										<!-- Step3 header -->
										<li class="active">
											<div class="single-step">
												<span class="title">3</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Aditional Information</span>
											</div>
										</li>

										<!-- Step4 header-->
										<li>
											<div class="single-step">
												<span class="title">4</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Check Again</span>
											</div>
										</li>
									</ul> <!-- [END] wizard-steps class -->

									<!-- WIZARD FORM *****************************************************-->
									<div class="step-forms">
										<!-- Age -->
										<div class="control-group">
											<label class="control-label" for="age">Age</label>
											<div class="controls">
												<input type="text" name="age" id="age" class="input-xlarge" data-rule-required="true" data-rule-range="[18,60]">
											</div>
										</div>
										<!-- Website URL -->
										<div class="control-group">
											<label class="control-label" for="url">Website URL</label>
											<div class="controls">
												<input type="text" name="url" id="url" class="input-xlarge" data-rule-required="true" data-rule-url="true">
											</div>
										</div>
										<!-- About Me -->
										<div class="control-group">
											<label class="control-label" for="aboutme">About Me</label>
											<div class="controls">
												<textarea name="aboutme" id="aboutme" class="span12" rows="7" data-rule-required="true" data-rule-rangelength="[20,140]"></textarea>
											</div>
										</div>
									</div>
								</div> <!-- [END] thirdStep -->

								<!-- FORTH STEP ==========================================================-->
								<div class="step" id="forthStep">
									<!-- WIZARD HEADER ***************************************************-->
									<ul class="wizard-steps steps-4">
										<!-- Step1 header -->
										<li>
											<div class="single-step">
												<span class="title">1</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Basic Information</span>
											</div>
										</li>

										<!-- Step2 header -->
										<li>
											<div class="single-step">
												<span class="title">2</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Advanced Information</span>
											</div>
										</li>

										<!-- Step3 header -->
										<li>
											<div class="single-step">
												<span class="title">3</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Aditional Information</span>
											</div>
										</li>

										<!-- Step4 header-->
										<li class="active">
											<div class="single-step">
												<span class="title">4</span>
												<span class="circle"> <span class="active"></span> </span>
												<span class="description">Check Again</span>
											</div>
										</li>
									</ul> <!-- [END] wizard-steps class -->

									<!-- WIZARD FORM *****************************************************-->
									<div class="step-forms">
										<!-- First name -->
										<div class="control-group">
											<label class="control-label">First Name</label>
											<div class="controls">
												<span id="review_firstname"></span>
											</div>
										</div>

										<!-- Last name -->
										<div class="control-group">
											<label class="control-label">Last Name</label>
											<div class="controls">
												<span id="review_lastname"></span>
											</div>
										</div>

										<!-- Email -->
										<div class="control-group">
											<label class="control-label">Email</label>
											<div class="controls">
												<span id="review_email"></span>
											</div>
										</div>

										<!-- Gender -->
										<div class="control-group">
											<label class="control-label">Gender</label>
											<div class="controls">
												<span id="review_gender"></span>
											</div>
										</div>

										<!-- Language -->
										<div class="control-group">
											<label class="control-label">Language</label>
											<div class="controls">
												<span id="review_language"></span>
											</div>
										</div>

										<!-- Hobbies -->
										<div class="control-group">
											<label class="control-label">Hobbies</label>
											<div class="controls">
												<span id="review_hobbies"></span>
											</div>
										</div>

										<!-- Age -->
										<div class="control-group">
											<label class="control-label">Age</label>
											<div class="controls">
												<span id="review_age"></span>
											</div>
										</div>

										<!-- URL -->
										<div class="control-group">
											<label class="control-label">Website URL</label>
											<div class="controls">
												<span id="review_url"></span>
											</div>
										</div>

										<!-- About Me -->
										<div class="control-group">
											<label class="control-label">About Me</label>
											<div class="controls">
												<span id="review_aboutme"></span>
											</div>
										</div>

										<!-- Confirmation -->
										<div class="control-group">
											<label class="control-label" for="confirmation"></label>
											<div class="controls">
												<input type="checkbox" name="confirmation" id="confirmation" value="true" data-rule-required="true">
												Yes, I confirm that all data are valid
											</div>
										</div>

										<!-- Secret Token, to prevent exploit attempt -->
									</div>
								</div> <!-- [END] forthStep -->

								<div class="form-actions">
									<input type="reset" class="btn" value="Back" id="back">
									<input type="submit" class="btn btn-primary" value="Generate PDF" id="next">
								</div>
							</form> <!-- [END] form -->
						</div> <!-- [END] box-content class -->

					</div> <!-- [END] boc class -->
				</div> <!-- [END] span12 class -->
			</div> <!-- [END] row-fluid class -->

		</div> <!-- [END] container-fluid class --> 
	</div> <!-- [END] main id -->

</div> <!-- [END] container-fluid class -->