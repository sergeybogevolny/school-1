<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_void.class.php');

include_once('classes/listbox.class.php');
$power = $listbox->getPowers();
$agents = $listbox->getGeneral_Agents();
$prefixs = $listbox->getPrefixs();

?> <script src="js/plugins/select2/select2.min.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/wizards-powers-void.js"></script>


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
    									Powers Void
    								</h3>
    							</div>
    							<div class="box-content">
                                <div id="success" class="hide alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <center>Success</center>
                                </div> 

    							 <form method="post" action="classes/wizards_powers_void.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
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
    														4</span>
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
                                        		    <label for="textfield" class="control-label">Date</label>
                                        			<div class="controls">
                                        			    <input type="text" name="powers-void-date" id="powers-void-date" class="input-large span2 datepicker first-required" onchange="Stepfirstvalidate()">
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
    														Verify
    													</span>
    												</div>
    											</li>
    										</ul>
                                         <!-- 2nd step form -->
                                         
                                         
                                         
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
                                                    <table id="void-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    								   <thead>
                        							        <tr class='thefilter'>
                        									    <th class='with-checkbox'><input type="checkbox" name="check_all_1" id="check_all_1"><button type="button" class="btn btn-blue" id="distribute-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button></th>
                                                                <th>Prefix</th>
                        										<th>Serial</th>
                                                                <th>Value</th>
                                                            </tr>
                        							   </thead>
                        							   <tbody>
                                                            <tr>
                            								    <td class="with-checkbox" id="search-checkbox"><input type="checkbox" name="check" value="1"></td>
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
                                                    <table id="void-bin" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                    									<thead>
                    										<tr class='thefilter'>
                    											<th class='with-checkbox'><input type="checkbox" name="check_all_2" id="check_all_2"><button type="button" class="btn btn-blue" id="bin-remove" style="margin-left:10px;"><i class="icon-remove"></i></button></th>
                    											<th>Prefix</th>
                    											<th>Serial</th>
                                                                <th>Value</th>
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
                                            <div class="step-forms">
                                                <div class="row-fluid">
                                                    <div style="margin-bottom:10px;">
                                                        <!--<div class="span4">Count: 2</div>
                                                        <div class="span8">Value: 3,500.00</div>-->
                                                    </div>
                                                    <label for="textarea" class="control-label" style="margin-left:18px">  Comment</label>
                                             		<div class="controls">
													<textarea name="powers-void-comment" id="powers-void-comment" rows="3" class="input-block-level span5"></textarea>
													</div>
                                                </div>
    										</div>
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
                                            <div class="step-forms">
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Date</label>
                                        			<div class="controls">
                                                    <span id="review_date"></span>
                                        			 </div>
                                        		</div>
                                            </div>
                                            
                                            <div class="control-group" id="group-powers">
                                                <div class="span12" style="margin-bottom:10px;">
                                                    <div class="span4" id="review-count"></div>
                                                    <div class="span8" id="review-value"></div>
                                                </div>
											    <div id="review_powers" class="span8"></div>
										    </div>
                                            
                                            <div class="step-forms">
                                                <div class="row-fluid">
                                                    <div style="margin-bottom:10px;">
                                                        <!--<div class="span4">Count: 2</div>
                                                        <div class="span8">Value: 3,500.00</div>-->
                                                    </div>
                                                    <label for="textarea" class="control-label" style="margin-left:18px">  Comment</label>
                                             		<div class="controls">
                                                    <span id="review_comment" style="margin-left:18px;"></span>
													</div>
                                                </div>
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
                                            <input type="hidden"  value="" id="serial_no" name="serial_no">
    										<input type="reset" class="btn" value="Back" id="back">
    										<input type="submit" class="btn btn-primary" value="Submit" id="next">
    									</div>

    								</form>
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
