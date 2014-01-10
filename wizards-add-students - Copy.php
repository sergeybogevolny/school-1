<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-prospects.php');

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_add_students.class.php');

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
    <script src="js/wizards-add-students.js"></script>
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
                                            <?php echo $steps->getSteps(5,1); ?>
    										<div class="step-forms">
                                            <h4>Provide Personal details</h4>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Name</label>
        												<div class="controls">
        													<input type="text" name="student_firstname" id="student_firstname" placeholder="First Name" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="student_middlename" id="student_middlename" class="input-xlarge span3" onclick="firstStepValidation()" placeholder="Middle Name" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="student_lastname" id="student_lastname" class="input-xlarge span3" onclick="firstStepValidation()" placeholder="Last Name" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Father's Name</label>
        												<div class="controls">
        													<input type="text" name="father_firstname" id="father_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="father_middlename" id="father_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="father_lastname" id="father_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
        											<div class="control-group">
        												<label for="anotherelem" class="control-label">Gender</label>
                                                        <div class="controls">
                                                            <div class="check-col">
                                                                <div class="check-line">
                                                                    <input type="radio" name="student_sex" id="student_sex" value="Caller" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline' for="Male">Male</label>
                                                                </div>
                                                                <div class="check-line">
                                                    			    <input type="radio" name="student_sex" id="student_sex" value="Defendant" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Female">Female</label>
                                                                </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="student_current_street" id="student_current_street" placeholder="Address" class="input-xlarge span8" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<div class="controls">
        													<input type="text" name="student_current_city" id="student_current_city" placeholder="City" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="student_current_state" id="student_current_state" placeholder="State" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="student_current_zip" id="student_current_zip" placeholder="Zip" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                               </div>
                                            </div>
    									
                                        
                                        <div class="step" id="secondStep">
    										<?php echo $steps->getSteps(5,2); ?>
    										<div class="step-forms">
                                            <h4>Parent's Detail</h4><br/>
                                            <h5>Father's Detail</h5>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Father's Name</label>
        												<div class="controls">
        													<input type="text" name="father_firstname" id="father_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="father_middlename" id="father_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="father_lastname" id="father_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="father_phone1_type" id="father_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="father_phone1" id="father_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Secondary Primary</label>
                                                        <div class="controls">
                                                            <select name="father_phone2_type" id="father_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="father_phone1" id="father_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="father_qualification" id="father_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="father_occupation" id="father_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                            <h5>Mother's Detail</h5>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Mothers's Name</label>
        												<div class="controls">
        													<input type="text" name="mother_firstname" id="mother_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="mother_middlename" id="mother_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="mother_lastname" id="mother_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="mother_phone1_type" id="mother_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="mother_phone1" id="mother_phone1_type" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Secondary</label>
                                                        <div class="controls">
                                                            <select name="mother_phone2_type" id="mother_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="mother_phone2" id="mother_phone2" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="mother_qualification" id="mother_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="mother_occupation" id="mother_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                            <h5>Address Detail</h5>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_street" id="student_parmanent_street" placeholder="Address" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">City</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_city" id="student_parmanent_city" placeholder="City" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">State</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_state" id="student_parmanent_state" placeholder="State" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country</label>
                                                        <div class="controls">
                                                            <select name="student_parmanent_country" id="student_parmanent_country" placeholder="Country" class="select2-me span4" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Zip</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_zip" id="student_parmanent_zip" placeholder="Zip" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Remark</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_remarl" id="student_parmanent_remark" placeholder="Remark" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                               </div>
                                            </div>
                                        
                                        <div class="step" id="thirdStep">
                                            <?php echo $steps->getSteps(5,3); ?>
                                            <div class="step-forms">
                                            <h4>Gardian's Detail</h4><br/>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Guardian's Name</label>
        												<div class="controls">
        													<input type="text" name="guardian_firstname" id="guardian_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="guardian_middlename" id="guardian_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="guardian_lastname" id="guardian_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="guardian_phone1_type" id="guardian_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="guardian_phone1" id="guardian_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="guardian_phone2_type" id="guardian_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="guardian_phone2_type" id="guardian_phone2_type" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="guardian_qualification" id="guardian_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="guardian_occupation" id="guardian_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                            <h5>Address Detail</h5>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_street" id="student_guardian_street" placeholder="Address" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">City</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_city" id="student_guardian_city" placeholder="City" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">State</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_state" id="student_guardian_state" placeholder="State" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country</label>
                                                        <div class="controls">
                                                            <select name="student_guardian_country" id="student_guardian_country" placeholder="Country" class="select2-me span4" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Zip</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_zip" id="student_guardian_zip" placeholder="Zip" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Remark</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_remark" id="student_guardian_remark" placeholder="Remark" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                               </div>
                                            </div>
                                        
    									<div class="step" id="fourthStep">
                                            <?php echo $steps->getSteps(5,4); ?>
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
                                            <?php echo $steps->getSteps(5,5); ?>
<!--                                        <div class="control-group" id="group-terms">
    											<label class="control-label">Terms</label>
    											<div class="controls">
    												<span id="review_student_firstname"></span>
    											</div>
    										   </div>
--> 
                                            <h4>Provide Personal details</h4>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Name</label>
        												<div class="controls">
        													<input type="text" name="student_firstname" id="review_student_firstname" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="student_middlename" id="review_student_middlename" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="student_lastname" id="review_student_lastname" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Father's Name</label>
        												<div class="controls">
        													<input type="text" name="father_firstname" id="review_father_firstname" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="father_middlename" id="review_father_middlename" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="father_lastname" id="review_father_lastname" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
        											<div class="control-group">
        												<label for="anotherelem" class="control-label">Gender</label>
                                                        <div class="controls">
                                                            <div class="check-col">
                                                                <div class="check-line">
                                                                    <input type="radio" name="student_sex" id="rexiew_student_sex" value="Caller" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline' for="Male">Male</label>
                                                                </div>
                                                                <div class="check-line">
                                                    			    <input type="radio" name="student_sex" id="review_student_sex" value="Defendant" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Female">Female</label>
                                                                </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="review_student_current_street" id="student_current_street" class="input-xlarge span8" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<div class="controls">
        													<input type="text" name="student_current_city" id="review_student_current_city" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="student_current_state" id="review_student_current_state" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="student_current_zip" id="review_student_current_zip" class="input-xlarge span3" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                            <h4>Parent's Detail</h4><br/>
                                            <h5>Father's Detail</h5>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Father's Name</label>
        												<div class="controls">
        													<input type="text" name="father_firstname" id="father_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="father_middlename" id="father_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="father_lastname" id="father_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="father_phone1_type" id="father_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="father_phone1" id="father_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Secondary Primary</label>
                                                        <div class="controls">
                                                            <select name="father_phone2_type" id="father_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="father_phone1" id="father_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="father_qualification" id="father_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="father_occupation" id="father_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                            <h5>Mother's Detail</h5>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Mothers's Name</label>
        												<div class="controls">
        													<input type="text" name="mother_firstname" id="mother_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="mother_middlename" id="mother_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="mother_lastname" id="mother_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="mother_phone1_type" id="mother_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="mother_phone1" id="mother_phone1_type" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Secondary</label>
                                                        <div class="controls">
                                                            <select name="mother_phone2_type" id="mother_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="mother_phone2" id="mother_phone2" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="mother_qualification" id="mother_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="mother_occupation" id="mother_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                            <h5>Address Detail</h5>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_street" id="student_parmanent_street" placeholder="Address" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">City</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_city" id="student_parmanent_city" placeholder="City" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">State</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_state" id="student_parmanent_state" placeholder="State" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country</label>
                                                        <div class="controls">
                                                            <select name="student_parmanent_country" id="student_parmanent_country" placeholder="Country" class="select2-me span4" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Zip</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_zip" id="student_parmanent_zip" placeholder="Zip" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Remark</label>
        												<div class="controls">
        													<input type="text" name="student_parmanent_remarl" id="student_parmanent_remark" placeholder="Remark" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>

                                            <h4>Gardian's Detail</h4><br/>
                                            <br/>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Guardian's Name</label>
        												<div class="controls">
        													<input type="text" name="guardian_firstname" id="guardian_firstname" class="input-xlarge span3" placeholder="First Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        													<input type="text" name="guardian_middlename" id="guardian_middlename" class="input-xlarge span3" placeholder="Middle Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
        													<input type="text" name="guardian_lastname" id="guardian_lastname" class="input-xlarge span3" placeholder="Last Name" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()">
                                                        </div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="guardian_phone1_type" id="guardian_phone1_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="guardian_phone1" id="guardian_phone1" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone Primary</label>
                                                        <div class="controls">
                                                            <select name="guardian_phone2_type" id="guardian_phone2_type" class="select2-me span2" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                            <input type="text" name="guardian_phone2_type" id="guardian_phone2_type" class="span4 mask_phone" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Qualification</label>
        												<div class="controls">
                                                            <select name="guardian_qualification" id="guardian_qualification" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Ocupation</label>
        												<div class="controls">
                                                            <select name="guardian_occupation" id="guardian_occupation" class="select2-me span6" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
        												</div>
        											</div>
                                                    
                                            <h5>Address Detail</h5>
                                            <br/>
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Address</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_street" id="student_guardian_street" placeholder="Address" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">City</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_city" id="student_guardian_city" placeholder="City" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">State</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_state" id="student_guardian_state" placeholder="State" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Country</label>
                                                        <div class="controls">
                                                            <select name="student_guardian_country" id="student_guardian_country" placeholder="Country" class="select2-me span4" onchange="firstStepValidation()" ><?php echo $phones; ?>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Zip</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_zip" id="student_guardian_zip" placeholder="Zip" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
        											</div>
                                                    
                                                    <div class="control-group">
        												<label for="anotherelem" class="control-label">Remark</label>
        												<div class="controls">
        													<input type="text" name="student_guardian_remark" id="student_guardian_remark" placeholder="Remark" class="input-xlarge span4" onclick="firstStepValidation()" onkeyup="firstStepValidation()" onblur="firstStepValidation()" >
        												</div>
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
