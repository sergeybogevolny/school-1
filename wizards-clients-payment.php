<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_clients_payment.class.php');

include_once('classes/listbox.class.php');
$prefixs = $listbox->getPrefixs();
$creditentries = $listbox->getCreditentries();
$paymentmethods = $listbox->getPaymentmethods();
?>
<script type="text/javascript" src="js/jqwidgets/jqxgrid.aggregates.js"></script>
    <script src="js/wizards-clients-payment.js"></script>
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
    									Clients Payment
    								</h3>
    							</div>
    							<div class="box-content">
                               
                                <div id="success" class="hide alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <center>Success</center>
                                </div>                                     
    		                        <form method="post" action="classes/wizards_clients_payment.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
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
    														Step 3
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
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
                                                    <input type="text" name="search-value" id="search-value" class="input-large" style="float:left;margin-right:2px;height:30px;width:157px;" onKeyPress="SearchStatus(event);">
                                                    <button type="button" class="btn btn-success" name="search-simple" id="search-simple" onclick="GoSearch()" style="float:left"><i class="icon-arrow-right"></i> Go</button>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="box-content">
                                                        <div id="search-text" style="display:none;"></div>
                                                        <table id="search-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0" style="display:none;">
                        									<thead>
                        										<tr class='thefilter'>
                        											<th class='with-checkbox'>
           <input type="checkbox" name="check_all_1" class="icheck-me"  data-skin="square" data-color="blue" id="check_all_1" >                  												
                                                           <!-- <input type="checkbox" name="check_all_1" id="check_all_1">-->
                                                                    </th>
                        											<th>Name</th>
                        											<th>Dob</th>
                                                                    <th>SSN</th>
                        										</tr>
                        									</thead>
                        									<tbody>
                                                                <tr>
                            									    <td class="with-checkbox" id="search-checkbox">
<input type="checkbox" name="check" class="icheck-me" value="1" data-skin="square" data-color="blue"  onclick="StepFirstValidate()">                  												
                                                                    </td>
                            										<td></td>
                            										<td></td>
                                                                    <td></td>
                            									</tr>
                                                            </tbody>
                        							    </table>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="stepFirst-validate">
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
    														Step 3
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														1</span>
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
                                                    <div style="width:400px; margin-right: 20px; margin-bottom:20px;float:left;">
                                                        <div id="jqxgrid"></div>
                                                    </div>
                                                    <div class="span6" style="margin-bottom:20px;float:left;">
                                                         <div class="control-group">
                                                              <label for="textfield" class="control-label">Date</label>
                                                              <div class="controls">
                                                                  <input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span8" onclick="StepSecondValidation()" required>
                                                              </div>
                                                          </div>
                                                          <div class="control-group credit-group">
                                                              <label for="textfield" class="control-label">Entry</label>
                                                              <div class="controls">
                                                                   <select name="ledger-creditentry" id="ledger-creditentry" class="select2-me input-large span8" onchange="StepSecondValidation()">
                                                                    <?php echo $creditentries; ?>
                                                                  </select>
                                                              </div>
                                                          </div>
                                                          <div class="control-group">
                                                              <label for="textfield" class="control-label">Amount</label>
                                                              <div class="controls">
                                                                  <input type="text" name="ledger-amount" id="ledger-amount" class="input-large span8"   readonly="readonly"/><span id="amount-add"></span>
                                                              </div>
                                                          </div>
                                                          <div class="control-group credit-group">
                                                              <label for="textfield" class="control-label">Method</label>
                                                              <div class="controls">
                                                                  <select name="ledger-paymentmethod" id="ledger-paymentmethod" class="select2-me input-large span8">
                                                                      <?php echo $paymentmethods; ?>
                                                                  </select>
                                                              </div>
                                                          </div>
                                                          <div class="control-group credit-group">
                                                              <label for="textfield" class="control-label">Memo</label>
                                                              <div class="controls">
                                                                  <textarea name="ledger-memo" id="ledger-memo" class="input-block-level span10"></textarea>
                                                              </div>
                                                          </div>

                                                    </div>



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
    														Step 3
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
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                        </div>
                                        <div class="step" id="fourthStep">
    										<ul class="wizard-steps steps-4">
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
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														3</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 3
    													</span>
    												</div>
    											</li>
                                                <li class="active">
    												<div class="single-step">
    													<span class="title">
    														4</span>
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
                                   

                                            <div class="control-group" id="group-date">
    											<label class="control-label bold">Date</label>
    											<div class="controls">
    												<span id="review_date"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-entry">
    											<label class="control-label bold">Entry</label>
    											<div class="controls">
    												<span id="review_entry"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-method">
    											<label class="control-label bold">Method</label>
    											<div class="controls">
    												<span id="review_method"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-memo">
    											<label class="control-label bold">Memo</label>
    											<div class="controls">
    												<span id="review_memo"></span>
    											</div>
    										</div>
                                            
                                            <div style="margin-bottom:20px;">
                                  <table class="table table-hover table-nomargin table-bordered dataTable-columnfilter">
                                    <thead>
                                        <tr >
                                            <th>Name</th>
                                            <th>Dob</th>
                                            <th>SSN</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="review_table">
                                       
                                    </tbody>
                                </table>
                                            </div>
                                            
                                          </div>  
                                            
                                            <div class="control-group">
											    <label class="control-label" for="confirmation"></label>
											    <div class="controls">

<input type="checkbox" name="confirmation"  value="true" class="icheck-me" data-skin="square" data-color="blue"  id="confirmation" data-rule-required="true">                  												
&nbspYes, I confirm that input is valid.
											    </div>
										    </div>

                                        </div>
                                        <div id="amount-credit"></div>
                                        <div class="form-actions" id="wizard-actions">
                                            <input type="hidden" id="stepTo-validate">
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
