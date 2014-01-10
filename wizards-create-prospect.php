<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-prospects.php');

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_create_prospect.class.php');

include_once('classes/listbox.class.php');
include_once('classes/steps.class.php');
$races = $listbox->getRaces();
$phones = $listbox->getPhones();
$sources = $listbox->getSources();
$jails = $listbox->getJails();
$identifiers = $listbox->getIdentifiers();
$counties = $listbox->getCounties();
$sts = $listbox->getSts();
?>
<style>
.form-wizard .wizard-steps li .single-step {
    padding: 16px 35px !important;
}
</style>
    <script src="js/checkamount.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/wizards-create-prospect.js"></script>
    <script src="js/plugins/ajax-autocomplete/jquery.autocomplete.js"></script>
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
    									<i class="icon-plus-sign"></i>
    									Add Student
    								</h3>
    							</div>
    							<div class="box-content">
    		                    <form method="post" action="classes/wizards_create_prospect.class.php" class="form-horizontal form-wizard " id="form-wizard" style="display:none">
                                
                                		<div class="step" id="firstStep">
                                            <?php echo $steps->getSteps(9,1); ?>
    										<div class="step-forms">
        											<div class="control-group">
        												<label for="anotherelem" class="control-label">Initiated By</label>
                                                        <div class="controls">
                                                            <div class="check-col">
                                                                <div class="check-line">
                                                                    <input type="radio" name="prospect-initiated" id="prospect-caller" value="Caller" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline' for="Male">Caller</label>
                                                                </div>
                                                            </div>
                                                            <div class="check-col">
                                                                <div class="check-line">
                                                    			    <input type="radio" name="prospect-initiated" id="prospect-defendant" value="Defendant" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Female">Defendant</label>
                                                                </div>
                                                            </div>
                                                        </div>
        											</div>
                                                 <div id="caller-details" style="display:none">
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Last</label>
        												<div class="controls">
        													<input type="text" name="caller-last" id="caller-last" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        												</div>
        											</div>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">First</label>
        												<div class="controls">
        													<input type="text" name="caller-first" id="caller-first" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="caller-phone1type" id="caller-phone1type" class="select2-me span2" onchange="firstStepValidation()" >
                                                                <?php echo $phones; ?>
                                                            </select>
                                                            <input type="text" name="caller-phone1" id="caller-phone1" class="span2 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Secondary</label>
                                                        <div class="controls">
                                                            <select name="caller-phone2type" id="caller-phone2type" class="select2-me span2" onchange="firstStepValidation()" >
                                                                <?php echo $phones; ?>
                                                            </select>
                                                            <input type="text" name="caller-phone2" id="caller-phone2" class="span2 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Relation</label>
        												<div class="controls">
        													<input type="text" name="caller-relation" id="caller-relation" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                               </div>
                                            </div>
    									</div>
                                        
                                        <div class="step" id="secondStep">
    										<?php echo $steps->getSteps(9,2); ?>
    										<div class="step-forms">
                                                <div class="row-fluid">
                                                    <input type="text" name="search-value" id="search-value" class="input-large" style="float:left;margin-right:2px;height:30px;width:157px;" onKeyPress="SearchStatus(event);">
                                                    <button type="button" class="btn btn-success" name="search-simple" id="search-simple" onclick="GoSearch()" style="float:left"><i class="icon-arrow-right"></i> Go</button>
                                                    <button type="button" class="btn btn-primary" name="add-new" id="add-new" onclick="" style="float:left;margin-left:5px"><i class="icon-plus"></i> Add New</button>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="box-content">
                                                        <div id="search-text" style="display:none;"></div>
                                                        <table id="search-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0" style="display:none;">
                        									<thead>
                        										<tr class='thefilter'>
                        											<th>Name</th>
                        											<th>DOB</th>
                                                                    <th>SSN</th>
                                                                    <th>Type</th>
                                                                    <th>Standing</th>
                                                                    <th>Logged</th>
                        										</tr>
                        									</thead>
                        									<tbody>
                                                                <tr>
                            										<td></td>
                            										<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                            									</tr>
                                                            </tbody>
                        							    </table>
                                                    </div>
                                                </div>
                                            </div>
    									</div>
                                        
                                        <div class="step" id="thirdStep">
                                            <?php echo $steps->getSteps(9,3); ?>
                                            <div class="step-forms">
                                                <div id="no-search-text" style="display:none;"></div>
                                                <div id="prospect-form-group" style="display:none" class="">
        											<div class="control-group">
        												<label for="firstname" class="control-label">Last name</label>
        												<div class="controls">
        													<input type="text" name="personal-last" id="personal-last" class="input-xlarge span4" onclick="thirdStepValidation()" onkeyup="thirdStepValidation()" onblur="thirdStepValidation()" onfocus="thirdStepValidation()">
        												</div>
        											</div>
        											<div class="control-group">
        												<label for="anotherelem" class="control-label">First name</label>
        												<div class="controls">
        													<input type="text" name="personal-first" id="personal-first" class="input-xlarge span4" onclick="thirdStepValidation()" onkeyup="thirdStepValidation()" onblur="thirdStepValidation()" onfocus="thirdStepValidation()">
        												</div>
        											</div>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Middle name</label>
        												<div class="controls">
        													<input type="text" name="personal-middle" id="personal-middle" class="input-xlarge span4">
        												</div>
        											</div>
                                                    <div class="control-group">
                                            		    <label for="textfield" class="control-label">DOB </label>
                                            			<div class="controls">
                                            			    <input type="text" name="personal-dob" id="personal-dob" class="input-large span2 datepicker">
                                            			</div>
                                            		</div>
                                                    <div class="control-group">
                                            		    <label for="textfield" class="control-label">Gender</label>
                                                        <div class="controls">
                                                            <div class="check-col span1" style="border:0px none">
                                                                <div class="check-line ">
                                                                    <input type="radio" name="personal-gender" id="personal-genderMale" value="Male" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline ' for="Male">Male</label>
                                                                </div>
                                                            </div>
                                                            <div class="check-col span2" style="border:0px none">
                                                                <div class="check-line ">
                                                    			    <input type="radio" name="personal-gender" id="personal-genderFemale" value="Female" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Female">Female</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                	</div>
                                                    <div class="control-group">
                                        		        <label for="textfield" class="control-label">Race</label>
                                        			    <div class="controls">
                                                            <select name="personal-race" id="personal-race" class="select2-me input-large span2">
                								                <?php echo $races; ?>
                							                </select>
                                        			    </div>
                                                    </div>
                                                    <div class="control-group">
                                        			    <label for="textfield" class="control-label">Address</label>
                                        				<div class="controls">
                                                            <div class="row-fluid">
                                                                <input type="text" name="personal-address" id="personal-address" class="input-large span6">
                                                            </div>
                                                        </div>
                                                        <div class="controls" style="margin-top:10px">
                                                            <div class="row-fluid">
                                                                <input type="text" name="personal-city" id="personal-city" class="input-large span3">
                                                                <select name="personal-state" id="personal-state" class="select2-me  span5" style="width:80px">
                                                                    <?php echo $sts ; ?>
                                                                </select>
                                                                <input type="text" name="personal-zip" id="personal-zip" class="input-large span2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                        		        <label for="textfield" class="control-label">Phone Primary</label>
                                        			    <div class="controls">
                                                            <select name="personal-phone1type" id="personal-phone1type" class="select2-me input-large span2">
                								                <?php echo $phones; ?>
                							                </select>
                                        				    <input type="text" name="personal-phone1" id="personal-phone1" class="input-large span2 mask_phone"  style="margin-left:5px">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                        		        <label for="textfield" class="control-label">Phone Secondary</label>
                                        			    <div class="controls">
                                                            <select name="personal-phone2type" id="personal-phone2type" class="select2-me input-large span2">
                								                <?php echo $phones; ?>
                							                </select>
                                        				    <input type="text" name="personal-phone2" id="personal-phone2" class="input-large span6 mask_phone span2" style="margin-left:5px">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="personal-id" id="personal-id" value="" />
                                                </div>
                                            </div>
    									</div>
                                        
    									<div class="step" id="fourthStep">
                                            <?php echo $steps->getSteps(9,4); ?>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Source</label>
                                        		<div class="controls">
                                        		    <select name="transaction-source" id="transaction-source" class="select2-me input-large span3">
                								        <?php echo $sources; ?>
                							        </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Standing</label>
                                                <div class="controls">
                                                    <div class="check-col span2">
                                                        <div class="check-line ">
                                                            <input type="radio" name="transaction-standing" id="transaction-standingCustody" value="Custody"  class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline ' for="Custody">Custody</label>
                                                        </div>
                                                    </div>
                                                    <div class="check-col span2">
                                                        <div class="check-line ">
                                                            <input type="radio" name="transaction-standing" id="transaction-standingWarrant" value="Warrant" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Warrant">Warrant</label>
                                                        </div>
                                                    </div>
                                                    <div class="check-col span2">
                                                        <div class="check-line ">
                                                            <input type="radio" name="transaction-standing" id="transaction-standingOther" value="Other" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px"  ><label class='inline' for="Warrant">Other</label>
                                                        </div>
                                                    </div>
                                                </div>
                                        	</div>
                                            <div id="go">
                                            	<div class="control-group" style="display:none" id="standingjail">
                                            	    <label for="textfield" class="control-label">Jail</label>
                                            		<div class="controls">
                                            		    <select name="transaction-standingcustodyjail" id="transaction-standingcustodyjail" class="select2-me input-large span3">
                    								        <?php echo $jails; ?>
                    							        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group" style="display:none" id="standingwarrant">
                                            	    <label for="textfield" class="control-label">Description </label>
                                            		<div class="controls">
                                            		    <input type="text" name="transaction-standingwarrantdescription" id="transaction-standingwarrantdescription" class="input-large span3">
                                            		</div>
                                            	</div>
                                                <div class="control-group" style="display:none" id="standingother">
                                            	    <label for="textfield" class="control-label">Description </label>
                                            		<div class="controls">
                                            		    <input type="text" name="transaction-standingotherdescription" id="transaction-standingotherdescription" class="input-large span3 ">
                                            		</div>
                                            	</div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Identifier</label>
                                        		<div class="controls">
                                                    <select name="transaction-identifiertype" id="transaction-identifiertype" class="select2-me input-large span2">
                								        <?php echo $identifiers; ?>
                							        </select>
                                        			<input type="text" name="transaction-identifier" id="transaction-identifier" class="input-large span2"  style="margin-left:5px">
                                                </div>
                                            </div>
    									</div>
                                        
    									<div class="step" id="fifthStep">
                                            <?php echo $steps->getSteps(9,5); ?>
                                            <div class="row-fluid">
                    	                        <div class="span8" style="margin-bottom:20px">
                                                    <div class="box-title">
            									        <h3 id="bonds-label"></h3>
                                                        <!-- id for list-actions -->
                                                        <div class="actions" id='list-actions'>
                                                            <a class="btn btn-mini" id="bonds-add" href="#">
                                                                <i class="icon-plus"></i>
                                                            </a>
                                                        </div>
                  								    </div>
                								    <div class="box-content nopadding">
                                                        <div id="bonds-list"></div>
                                                        <!--<div id='schedule' style="margin-top:10px"></div>-->
                                                        <!-- id for *-box, insert window body, change class horizontal -->
                                                        <div id='bonds-box' style="display:none">
                                                            <div class='form-horizontal' style="margin-top:20px">
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">Bond Amount </label>
                                            						<div class="controls">
                                            						    <input type="text" name="bond-amount" id="bond-amount" class="input-large mask_currency span5">
                                            						    <input type="hidden" name="bond-checkamount" id="bond-checkamount" class="">
                                            						</div>
                                            					</div>
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">Class </label>
                                                                    <div class="controls">
                                                                        <div class="check-col span2" style="border:0px none">
                                                                            <div class="check-line ">
                                                                                <input type="radio"   name="bond-class" id="bond-classMisdemeanor" value="Misdemeanor" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline ' for="Misdemeanor">M</label>
                                                                            </div>
                                                                         </div>
                                                                         <div class="check-col span3" style="border:0px none">
                                                                            <div class="check-line ">
                                                            			        <input type="radio"  name="bond-class" id="bond-classFelony" value="Felony" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Felony">F</label>
                                                                            </div>
                                                                         </div>
                                                                    </div>
                                            					</div>
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">Charge</label>
                                            						<div class="controls">
                                                                        <input type="text" name="bond-charge" id="bond-charge" style="position: absolute; z-index: 2; background: transparent;" class="span2" onkeyup="fifthStepValidation()"/>
                                                                        <input type="text" name="bond-charge" id="bond-charge-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1;" class="span2"/>
                                                                        <div id="selction-ajax"></div>
                                                                    </div>
                                            					</div>
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">Case Number </label>
                                            						<div class="controls">
                                            						    <input type="text" name="bond-casenumber" id="bond-casenumber" class="input-large span5" style="border: 1px solid #DDDDDD;">
                                            						</div>
                                            					</div>
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">County</label>
                                            						<div class="controls">
                                                                        <select name="bond-county" id="bond-county" class="select2-me input-large" onchange="getCourt()">
                    								                        <?php echo $counties; ?>
                    							                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                            					    <label for="textfield" class="control-label">Court</label>
                                            						<div class="controls ">
                                                                        <select name="bond-court" id="bond-court" class="select2-me input-large">
                    							                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-actions">
                                                                    <div class="controls"  id="bondDelete"  style="display:none">
                                                                        <div class="check-col" style="margin-left:-299px;margin-top:0px;">
                                                                            <div class="check-line">
                                                                                <input type="checkbox" name="bond-delete" class="icheck-me" data-skin="square" data-color="blue" id="bond-delete" ><label class='inline ' for="bond-delete"> Delete? </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="bondId" value="0" />
                                             					    <button type="button" class="btn btn-primary" name="bond-save" id="bond-save">Save</button>
                                            						<button type="button" class="btn" name="bond-cancel" id="bond-cancel">Cancel</button>
                                            					</div>
                                            		        </div>
                                                        </div>
                								    </div>
                                                </div>
                                            </div>
    									</div>
                                        
                                        <div class="step" id="sixthStep">
                                            <?php echo $steps->getSteps(9,6); ?>
                                            <div class="row-fluid">
                        	                    <div class="span8" style="margin-bottom:20px">
                                                    <div class="box-title">
                    									<h3 id="refrences-label">References</h3>
                                                        <!-- id for list-actions -->
                                                        <div class="actions" id='list-actions'>
                                                            <a class="btn btn-mini" id="refrences-add" href="#">
                                                                <i class="icon-plus"></i>
                                                            </a>
                                                        </div>
                    								</div>
                    								<div class="box-content nopadding">
                                                        <div id="refrences-list"></div>
                                                        <!-- id for *-box, insert window body, change class horizontal -->
                                                        <div id='refrences-box' style="display:none">
                                                            <div class='form-horizontal' style="margin-top:20px">
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">Last Name</label>
                                            						<div class="controls">
                                            						    <input type="text" name="refrences-last" id="refrences-last" class="input-large span5" onkeyup="sixthStepValidation()">
                                            						</div>
                                            					</div>
                                            				    <div class="control-group">
                                            					    <label for="textfield" class="control-label">First Name</label>
                                            						<div class="controls">
                                                                        <input type="text" name="refrences-first" id="refrences-first" class="input-large span5" onkeyup="sixthStepValidation()"/>
                                                                    </div>
                                            					</div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Phone Primary</label>
                                                                    <div class="controls">
                                                                        <select name="reference-phone1type" id="reference-phone1type" class="select2-me span6">
                                                                            <?php echo $phones; ?>
                                                                        </select>
                                                                        <input type="text" name="reference-phone1" id="reference-phone1" class="span6 mask_phone">
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Phone Secondary</label>
                                                                    <div class="controls">
                                                                        <select name="reference-phone2type" id="reference-phone2type" class="select2-me span6">
                                                                            <?php echo $phones; ?>
                                                                        </select>
                                                                        <input type="text" name="reference-phone2" id="reference-phone2" class="span6 mask_phone">
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Relation</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="reference-relation" id="reference-relation" class="span12" onkeyup="sixthStepValidation()">

                                                                    </div>
                                                                </div>
                                                                <div class="form-actions">
                                                                    <div class="controls"  id="refrencesDelete"  style="display:none">
                                                                        <div class="check-col" style="margin-left:-299px;margin-top:0px;">
                                                                            <div class="check-line">
                                                                                <input type="checkbox" name="refrences-delete" class="icheck-me" data-skin="square" data-color="blue" id="refrences-delete" ><label class='inline ' for="refrences-delete"> Delete? </label>
                                                                            </div>
                                                                         </div>
                                                                    </div>
                                                                    <input type="hidden" id="refrencesId" value="0" />
                                             					    <button type="button" class="btn btn-primary" name="refrences-save" id="refrences-save">Save</button>
                                            						<button type="button" class="btn" name="refrences-cancel" id="refrences-cancel">Cancel</button>
                                            					</div>
                                                		    </div>
                                                        </div>
                    								</div>
                                                </div>
                                            </div>
    									</div>
                                        
                                        <div class="step" id="seventhStep">
                                            <?php echo $steps->getSteps(9,7); ?>
                                            <div class="row-fluid">
                            	                <div class="span8" style="margin-bottom:20px">
                                                    <div class="box-title">
                        							    <h3>Quote</h3>
                        							</div>
                        						    <div class="box-content">
                                                        <div class="control-group">
                                                    	    <label for="textfield" class="control-label">Fee</label>
                                                    		<div class="controls">
                                        						    <input type="text" name="quote-fee" id="quote-fee" class="input-large span5" style="border: 1px solid #DDDDDD;">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                    	    <label for="textfield" class="control-label">Down</label>
                                                    		<div class="controls">
                                        						    <input type="text" name="quote-down" id="quote-down" class="input-large span5" style="border: 1px solid #DDDDDD;">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                    	    <label for="textfield" class="control-label">Terms</label>
                                                    		<div class="controls">
                                        					    <textarea name="quote-terms" id="quote-terms" class="span5" style="border: 1px solid #DDDDDD;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="step" id="eigthStep">
                                            <?php echo $steps->getSteps(9,8); ?>
                                            <div class="row-fluid">
                            	                <div class="span8" style="margin-bottom:20px">
                                                    <div class="box-title">
                        							    <h3>Note</h3>
                        							</div>
                        						    <div class="box-content">
                                    				    <div class="control-group">
                                    					    <label for="textfield" class="control-label">Subject</label>
                                    						<div class="controls">
                                                                <input type="text" name="note-subject" id="note-subject" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span5" />
                                                                <input type="text" name="note-subject-x" id="note-subject-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span12"/>
                                                                <div id="selction-ajax"></div>
                                                            </div>
                                    					</div>
                                    				    <div class="control-group">
                                    					    <label for="textfield" class="control-label">Comment</label>
                                    						<div class="controls">
                                    						    <textarea name="note-comment" id="note-comment" class="input-block-level span5"></textarea>
                                    						</div>
                                    					</div>
                									</div>
                                                </div>
                                            </div>
                                        </div>
                                        
    									<div class="step" id="ninthStep">
                                            <?php echo $steps->getSteps(9,9); ?>
                                            <div class="control-group" id="group-initiated">
    											<label class="control-label bold">Initiated By</label>
    											<div class="controls">
    												<span id="review-initiated"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-caller-last">
    											<label class="control-label bold">Caller Last</label>
    											<div class="controls">
    												<span id="review-caller-last"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-caller-first">
    											<label class="control-label bold">Caller First</label>
    											<div class="controls">
    												<span id="review-caller-first"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-caller-phone1type">
    											<label class="control-label bold">Caller Primary Phone </label>
    											<div class="controls">
    												<span id="review-caller-phone1type"></span><span id="review-caller-phone1"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-caller-phone2type">
    											<label class="control-label bold">Caller Secondary Phone</label>
    											<div class="controls">
    												<span id="review-caller-phone2type"></span><span id="review-caller-phone2"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-caller-relation">
    											<label class="control-label bold">Caller Relation</label>
    											<div class="controls">
    												<span id="review-caller-relation"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-last">
    											<label class="control-label bold">Last</label>
    											<div class="controls">
    												<span id="review_last"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-first">
    											<label class="control-label">First</label>
    											<div class="controls">
    												<span id="review_first"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-middle">
    											<label class="control-label">Middle</label>
    											<div class="controls">
    												<span id="review_middle"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-dob">
    											<label class="control-label">DOB</label>
    											<div class="controls">
    												<span id="review_dob"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-gender">
    											<label class="control-label">Gender</label>
    											<div class="controls">
    												<span id="review_gender"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-race">
    											<label class="control-label">Race</label>
    											<div class="controls">
    												<span id="review_race"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-address">
                                                <label for="textfield" class="control-label">Address</label>
                                                <div class="controls">
                                                    <div class="row-fluid">
                                                        <span id="review_address"></span>
                                                     </div>
                                                </div>
                                                <div class="controls" style="margin-top:10px">
                                                    <div class="row-fluid">
                                                        <span id="review_city"></span>
                                                        <span id="review_state"></span>
                                                        <span id="review_zip"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group" id="group-phone1">
    											<label class="control-label">Phone Primary</label>
    											<div class="controls">
                                                    <span id="review_phone1type"></span>
    												<span id="review_phone1"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-phone2">
    											<label class="control-label">Phone Secondary</label>
    											<div class="controls">
                                                    <span id="review_phone2type"></span>
    												<span id="review_phone2"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-source">
    											<label class="control-label">Source</label>
    											<div class="controls">
    												<span id="review_source"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-standing">
    											<label class="control-label">Standing</label>
    											<div class="controls">
    												<span id="review_standing"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-jail">
    											<label class="control-label">Jail</label>
    											<div class="controls">
    												<span id="review_jail"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-warrant">
    											<label class="control-label">Description</label>
    											<div class="controls">
    												<span id="review_warrant"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-other">
    											<label class="control-label">Description</label>
    											<div class="controls">
    												<span id="review_other"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-identifier">
    											<label class="control-label">Identifier</label>
    											<div class="controls">
                                                    <span id="review_identifiertype"></span>
    												<span id="review_identifier"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-fee">
    											<label class="control-label">Fee</label>
    											<div class="controls">
    												<span id="review_fee"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-down">
    											<label class="control-label">Down</label>
    											<div class="controls">
    												<span id="review_down"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-terms">
    											<label class="control-label">Terms</label>
    											<div class="controls">
    												<span id="review_terms"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-subject">
    											<label class="control-label">Subject</label>
    											<div class="controls">
    												<span id="review_subject"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-comment">
    											<label class="control-label">Comment</label>
    											<div class="controls">
    												<span id="review_comment"></span>
    											</div>
    										</div>
                                            <div class="control-group" id="group-bonds">
											    <div id="review_bonds" class="span8"></div>
										    </div>
                                            <div class="control-group" id="group-refrences">

											    <div id="review_refrences" class="span8"></div>
										    </div>
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
    										<input type="submit" class="btn btn-primary" value="Create" id="next" name="next" disabled>
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
