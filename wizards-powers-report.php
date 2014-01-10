<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_report.class.php');

include_once('classes/listbox.class.php');
$sureties = $listbox->getSureties();
$paymentmethods = $listbox->getPaymentmethods();
$agencyfriendly = $listbox->getAgencyFriendly();
$prefixs = $listbox->getPrefixs();

?>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/wizards-powers-report.js"></script>

<style>
.form-wizard .wizard-steps li .single-step {
    padding: 15px 43px;
}
</style>

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
    									<i class="icon-upload-alt"></i>
    									Powers Report
    								</h3>
    							</div>
    							<div class="box-content">
                                
                               <div id="success" class="hide alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <center>Success</center>
                                </div> 
                               
                                <form method="post" action="classes/wizards_powers_report.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                                		<div class="step" id="firstStep">
    										<ul class="wizard-steps steps-6">
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
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>
                                                
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														6</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>
                                            <div class="step-forms">
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Report Date</label>
                                        			<div class="controls">
                                        			    <input type="text" name="report-date" id="report-date" class="input-large span2 datepicker" onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate()">
                                        			</div>
                                        		</div>

                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Surety</label>
                                        			<div class="controls">
                                                        <select name="report-surety" id="report-surety" class="select2-me input-large span2" onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate()">
                								            <?php echo $sureties; ?>
                							            </select>
                                        			</div>
                                                </div>
                                                

    										</div>

    									</div>
    									<div class="step" id="secondStep">
    										<ul class="wizard-steps steps-6">
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
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>
                                                
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														6</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>


                                                                                     
                                            <div class="step-forms">
                                                <!--
                                                <div class="form-actions" id="wizard-actions">
            										<input type="reset" class="btn" value="Back" id="back">
            										<input type="submit" class="btn btn-primary" value="Next" id="next">
            									</div>
                                                -->
                                                <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div style="float:left;margin-right:5px;">
                                                            <select id="executed-filter-prefix" class="select2-me input-large filter-fields" style="width:100px;">
                								                <?php echo $prefixs; ?>
                							                </select>
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="executed-filter-serial" type="text" placeholder="Serial" name="textfield" style="width:100px;">
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="executed-filter-count" type="text" placeholder="#" name="textfield" style="width:100px;">
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <button type="button" class="btn btn-blue" id="executed-filter" style=""><i class="icon-filter"></i></button>
                                                        </div>
                                                    </div>
                                                    <div id="executed-text" style="display:none;"></div>
                                                    <div class="power-loading" style="display: none;">Loading...</div>
                                                    <table id="executed-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    								   <thead>
                        							        <tr class='thefilter'>
                        									    <th class='with-checkbox'><input type="checkbox" name="check_all_1" id="check_all_1"><button type="button" class="btn btn-blue" id="executed-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button></th>
                                                                <th>Prefix</th>
                        										<th>Serial</th>
                                                                <th>Name</th>
                                                                <th>Executed</th>
                                                                <th>Amount</th>
                                                            </tr>
                        							   </thead>
                        							   <tbody>
                                                            <tr>
                            								    <td class="with-checkbox" id="executed-search-checkbox"><input type="checkbox" name="check" value="1"></td>
                            									<td></td>
                            									<td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                       	    </tr>
                                                       </tbody>
                    								</table>

                                                </div>
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div class="span4" id="executed-count"></div>
                                                        <div class="span8" id="executed-amount"></div>
                                                    </div>
                                                    <table id="executed-bin" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    									<thead>
                    										<tr class='thefilter'>
                    											<th class='with-checkbox'><input type="checkbox" name="check_all_2" id="check_all_2"><button type="button" class="btn btn-blue" id="executed-bin-remove" style="margin-left:10px;"><i class="icon-remove"></i></button></th>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Amount</th>
                                                                <th>Net</th>
                                                                <th>BUF</th>
                                                                <th style="display:none;">Name</th>
                                                                <th style="display:none;">Executed</th>
                                                            </tr>
                    									</thead>
                    									<tbody>
                                                        </tbody>
                    								</table>
                                                </div>
                                                </div>
    										</div>
                                         <!-- end of 2nd form  -->
    									</div>


                                        <div class="step" id="thirdStep">
    										<ul class="wizard-steps steps-6">
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
    											<li >
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
                                                <li class='active'>
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
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>


                                                <li>
    												<div class="single-step">
    													<span class="title">
    														6</span>
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
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div style="float:left;margin-right:5px;">
                                                            <select id="filter-prefix" class="select2-me input-large filter-fields" style="width:100px;">
                								                <?php echo $prefixs; ?>
                							                </select>
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="filter-serial" type="text" placeholder="Serial" name="textfield" style="width:100px;">
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="filter-count" type="text" placeholder="#" name="textfield" style="width:100px;">
                                                        </div>
                                                    </div>
                                                    <div id="void-text" style="display:none;"></div>
                                                    <div class="power-loading" style="display: none;">Loading...</div>
                                                    <table id="void-table" class="table table-hover table-nomargin table-bordered dataTable_3 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    								   <thead>
                        							        <tr class='thefilter'>
                        									    <th class='with-checkbox'><input type="checkbox" name="check_all_3" id="check_all_3"><button type="button" class="btn btn-blue" id="voided-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button></th>
                                                                <th>Prefix</th>
                        										<th>Serial</th>
                                                                <th>Value</th>
                                                                <th>Voided</th>
                                                            </tr>
                        							   </thead>
                        							   <tbody>
                                                            <tr style="display:none">
                            								    <td class="with-checkbox" id="search-checkbox"><input type="checkbox" name="check" value="1"></td>
                            									<td></td>
                            									<td></td>
                                                                <td></td>
                                                                <td></td>
                                                       	    </tr>
                                                       </tbody>
                    								</table>

                                                </div>
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div class="span4" id="void-count"></div>
                                                        <div class="span8" id="void-value"></div>
                                                    </div>
                                                    <table id="void-bin" class="table table-hover table-nomargin table-bordered dataTable_4 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    									<thead>
                    										<tr class='thefilter'>
                    											<th class='with-checkbox'><input type="checkbox" name="check_all_4" id="check_all_4"><button type="button" class="btn btn-blue" id="bin-remove" style="margin-left:10px;"><i class="icon-remove"></i></button></th>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Value</th>
                                                                <th style="display:none;">Voided</th>
                    										</tr>
                    									</thead>
                    									<tbody>
                                                        </tbody>
                    								</table>
                                                </div>
                                                </div>
    										</div>
                                         <!-- end of 2nd form  -->



    									</div>


                                        <div class="step" id="fourthStep">
    										<ul class="wizard-steps steps-6">
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
    											<li >
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
                                                <li class='active'>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
                                                        <span class="active"></span>
    													</span>
    													<span class="description">
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>

                                                <li>
    												<div class="single-step">
    													<span class="title">
    														6</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>



                                            <div class="step-forms">
                                                <!--
                                                <div class="form-actions" id="wizard-actions">
            										<input type="reset" class="btn" value="Back" id="back">
            										<input type="submit" class="btn btn-primary" value="Next" id="next">
            									</div>
                                                -->
                                                <div class="row-fluid">
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div style="float:left;margin-right:5px;">
                                                            <select id="transfer-filter-prefix" class="select2-me input-large filter-fields" style="width:100px;">
                								                <?php echo $prefixs; ?>
                							                </select>
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="transfer-filter-serial" type="text" placeholder="Serial" name="textfield" style="width:100px;">
                                                        </div>
                                                        <div style="float:left;margin-right:5px;">
                                                            <input class="input-block-level filter-fields" id="transfer-filter-count" type="text" placeholder="#" name="textfield" style="width:100px;">
                                                        </div>
                                                    </div>
                                                    <div id="transfer-text" style="display:none;"></div>
                                                    <div class="power-loading" style="display: none;">Loading...</div>
                                                    <table id="transfer-table" class="table table-hover table-nomargin table-bordered dataTable_5 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    								   <thead>
                        							        <tr class='thefilter'>
                        									    <th class='with-checkbox'><input type="checkbox" name="check_all_5" id="check_all_5"><button type="button" class="btn btn-blue" id="transfer-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button></th>
                                                                <th>Prefix</th>
                        										<th>Serial</th>
                                                                <th>Name</th>
                                                                <th>Executed</th>
                                                                <th>Amount</th>
                                                            </tr>
                        							   </thead>
                        							   <tbody>
                                                            <tr>
                            								    <td class="with-checkbox" id="executed-search-checkbox"><input type="checkbox" name="check" value="1"></td>
                            									<td></td>
                            									<td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                       	    </tr>
                                                       </tbody>
                    								</table>

                                                </div>
                                                <div class="span6">
                                                    <div class="row-fluid" style="margin-bottom:10px;">
                                                        <div class="span4" id="transfer-count"></div>
                                                        <div class="span8" id="transfer-amount"></div>
                                                    </div>
                                                    <table id="transfer-bin" class="table table-hover table-nomargin table-bordered dataTable_6 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                                                        <thead>
                    										<tr class='thefilter'>
                    											<th class='with-checkbox'><input type="checkbox" name="check_all_6" id="check_all_6"><button type="button" class="btn btn-blue" id="transfer-bin-remove" style="margin-left:10px;"><i class="icon-remove"></i></button></th>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Amount</th>
                                                                <th>Net</th>
                                                                <th>BUF</th>
                                                                <th style="display:none;">Name</th>
                                                                <th style="display:none;">Executed</th>
                                                            </tr>
                    									</thead>
                    									<tbody>
                                                        </tbody>
                    								</table>
                                                </div>
                                                </div>
    										</div>
                                         <!-- end of 3rd form  -->
    									</div>



                                        <div class="step" id="fifthStep">
    										<ul class="wizard-steps steps-6">
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
                                                <li >
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
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li class="active">
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
                                                        <span class="active"></span>
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>

                                                <li>
    												<div class="single-step">
    													<span class="title">
    														6</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                            <div class="step-forms">
                                                <div style="margin-bottom:10px;"><span style="font-weight:bold;">Net</span><span id="netCalculated" style="font-weight:bold;"></span></div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Payment Date</label>
                                        			<div class="controls">
                                        			    <input type="text" name="report-netpaymentdate" id="report-netpaymentdate" class="input-large span2 datep">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Amount</label>
                                        			<div class="controls">
                                        			    <input type="text" name="report-netpaymentamount" id="report-netpaymentname" class="input-large span2">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Method</label>
                                        			<div class="controls">
                                                        <select name="report-netpaymentmethod" id="report-netpaymentmethod" class="select2-me input-large span2">
                								            <?php echo $paymentmethods; ?>
                							            </select>
                                        			</div>
                                                </div>
                                                <div style="margin-bottom:10px;"><span style="font-weight:bold;">BUF</span><span id="bufCalculated" style="font-weight:bold;"></span></div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Payment Date</label>
                                        			<div class="controls">
                                        			    <input type="text" name="report-bufpaymentdate" id="report-bufpaymentdate" class="input-large span2 datepe">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Amount</label>
                                        			<div class="controls">
                                        			    <input type="text" name="report-bufpaymentamount" id="report-bufpaymentname" class="input-large span2">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Method</label>
                                        			<div class="controls">
                                                        <select name="report-bufpaymentmethod" id="report-bufpaymentmethod" class="select2-me input-large span2">
                								            <?php echo $paymentmethods; ?>
                							            </select>
                                        			</div>
                                                </div>
    										</div>
                                        </div>
                                        <div class="step" id="sixthStep">
    										<ul class="wizard-steps steps-6">
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
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														4</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 4
    													</span>
    												</div>
    											</li>
                                                <li>
    												<div class="single-step">
    													<span class="title">
    														5</span>
    													<span class="circle">
    													</span>
    													<span class="description">
    														Step 5
    													</span>
    												</div>
    											</li>

                                                <li class="active">
    												<div class="single-step">
    													<span class="title">
    														6</span>
    													<span class="circle">
                                                        <span class="active"></span>
    													</span>
    													<span class="description">
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>

                                            <div class="control-group" id="group-reportdate">
    											<label class="control-label bold">Report Date</label>
    											<div class="controls">
    												<span id="review_reportdate"></span>
    											</div>
    										</div>


                                            <div class="control-group" id="group-reportnetdate">
    											<label class="control-label bold">Net Date</label>
    											<div class="controls">
    												<span id="review_reportnetdate"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-reportnetamount">
    											<label class="control-label bold">Net Amount</label>
    											<div class="controls">
    												<span id="review_reportnetamount"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-reportnetmethod">
    											<label class="control-label bold">Net Method</label>
    											<div class="controls">
    												<span id="review_reportnetmethod"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-reportbufdate">
    											<label class="control-label bold">BUF Date</label>
    											<div class="controls">
    												<span id="review_reportbufdate"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-reportbufamount">
    											<label class="control-label bold">BUF Amount</label>
    											<div class="controls">
    												<span id="review_reportbufamount"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-reportbufmethod">
    											<label class="control-label bold">BUF Method</label>
    											<div class="controls">
    												<span id="review_reportbufmethod"></span>
    											</div>
    										</div>

                                            <div class="control-group" id="group-executed">
                                                <div class="span12" style="margin-bottom:10px;">
                                                    <div class="span4" id="executed-review-count"></div>
                                                    <div class="span8" id="executed-review-value"></div>
                                                </div>
											    <div id="review_executed" class="span8"></div>
										    </div>


                                            <div class="control-group" id="group-powers">
                                                <div class="span12" style="margin-bottom:10px;">
                                                    <div class="span4" id="review-count"></div>
                                                    <div class="span8" id="review-value"></div>
                                                </div>
											    <div id="review_powers" class="span8"></div>
										    </div>

                                            <div class="control-group" id="group-transfer">
                                                <div class="span12" style="margin-bottom:10px;">
                                                    <div class="span4" id="transfer-review-count"></div>
                                                    <div class="span8" id="transfer-review-value"></div>
                                                </div>
											    <div id="review_transfer" class="span8"></div>
										    </div>


                                            <div class="control-group">
											    <label class="control-label" for="confirmation"></label>
											    <div class="controls">
												    <input type="checkbox" name="confirmation" id="confirmation" class="" data-skin="square" data-color="blue" value="true" data-rule-required="true">
												    &nbspYes, I confirm that input is valid.
											    </div>
										    </div>
                                        </div>

    									<div class="form-actions" id="wizard-actions">
                                            <input type="hidden"  value="" id="executed-net" name="executed-net">
                                            <input type="hidden"  value="" id="executed-net-min" name="executed-net-min">
                                            <input type="hidden"  value="" id="executed-buf" name="executed-buf">
                                            <input type="hidden"  value="" id="executed-buf-min" name="executed-buf-min">

                                            <input type="hidden"  value="<?php echo $level; ?>" id="report-level" name="report-level">
                                            <input type="hidden"  value="<?php echo $agencyfriendly; ?>" id="report-agent-friendly" name="report-agent-friendly">
    										<input type="reset" class="btn" value="Back" id="back">
    										<input type="submit" class="btn btn-primary" value="Create" id="next">
    									</div>

    								</form>
                                    
                                   <div id="report-button" style="display:none" >
                                       </br></br><center><span id="reportbutton"></span></center>
                                   </div>
                                    
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
