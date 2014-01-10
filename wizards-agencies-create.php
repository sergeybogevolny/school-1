<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_agencies_create.class.php');

include_once('classes/listbox.class.php');
$generalagents = $listbox->getGeneral_Agents();
$counties = $listbox->getCounties();
$sts = $listbox->getSts();
$phones = $listbox->getPhones();
?>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/wizards-agencies-create.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <i class="icon-signin"></i> Agencies Create </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_agencies_create.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                <div class="step" id="firstStep">
                  <ul class="wizard-steps steps-4">
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Step 3 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="step-forms">
                    <div class="control-group">
                      <label for="textfield" class="control-label">Type</label>
                      <div class="controls">
                        <select name="agency-type" id="agency-type" class='select2-me span2  input-xlarge' onchange="firstStepValidation()">
                          <option value=""></option>
                          <option value="Candidate">Candidate</option>
                          <option value="Associate">Associate</option>
                        </select>
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Company</label>
                      <div class="controls">
                        <input type="text" name="agency-company" id="agency-company" class="input-large span2 first-required">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Contact</label>
                      <div class="controls">
                        <input type="text" name="agency-contact" id="agency-contact" class="input-large span2 first-required">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="secondStep">
                  <ul class="wizard-steps steps-4">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Step 3 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="row-fluid">
                    <div class="span8" style="margin-bottom:20px">
                      <div class="box-content nopadding">
                        <div class="control-group">
                          <label for="textfield" class="control-label">Address</label>
                          <div class="controls">
                            <div class="row-fluid">
                              <input type="text" name="agency-address" id="agency-address" class="input-large span10">
                            </div>
                          </div>
                          <div class="controls" style="margin-top:10px">
                            <div class="row-fluid">
                              <input type="text" name="agency-city" id="agency-city" class="input-large span5">
                              <select name="agency-state" id="agency-state" class="select2-me  span5" style="width:100px">
                                <?php echo $sts ; ?>
                              </select>
                              <input type="text" name="agency-zip" id="agency-zip" class="input-large span3">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="thirdStep">
                  <ul class="wizard-steps steps-4">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li class="active">
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 3 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Phone Primary</label>
                    <div class="controls">
                      <select name="agency-phone1type" id="agency-phone1type" class="select2-me input-large span2">
                        <?php echo $phones; ?>
                      </select>
                      <input type="text" name="agency-phone1" id="agency-phone1" class="input-large span2 mask_phone"  style="margin-left:5px">
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Phone Secondary</label>
                    <div class="controls">
                      <select name="agency-phone2type" id="agency-phone2type" class="select2-me input-large span2">
                        <?php echo $phones; ?>
                      </select>
                      <input type="text" name="agency-phone2" id="agency-phone2" class="input-large span6 mask_phone span2" style="margin-left:5px">
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Phone Other</label>
                    <div class="controls">
                      <select name="agency-phone3type" id="agency-phone3type" class="select2-me input-large span2">
                        <?php echo $phones; ?>
                      </select>
                      <input type="text" name="agency-phone3" id="agency-phone3" class="input-large span6 mask_phone span2" style="margin-left:5px">
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Email</label>
                    <div class="controls">
                      <input type="text" name="agency-email" id="agency-email" class="input-large span4 first-required" >
                    </div>
                  </div>
                </div>
                <div class="step" id="fourthStep">
                  <ul class="wizard-steps steps-4">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Step 3 </span> </div>
                    </li>
                    <li class="active">
                      <div class="single-step"> <span class="title"> 4</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="control-group" id="group-date">
                    <label class="control-label bold">Type</label>
                    <div class="controls"> <span id="review_type"></span> </div>
                  </div>
                  <div class="control-group" id="group-company">
                    <label class="control-label">Company</label>
                    <div class="controls"> <span id="review_company"></span> </div>
                  </div>
                  <div class="control-group" id="group-contace">
                    <label class="control-label">Contact</label>
                    <div class="controls"> <span id="review_contace"></span> </div>
                  </div>
                  <div class="control-group" id="group-address">
                    <label for="textfield" class="control-label">Address</label>
                    <div class="controls">
                      <div class="row-fluid"> <span id="review_address"></span> </div>
                    </div>
                    <div class="controls" style="margin-top:10px">
                      <div class="row-fluid"> <span id="review_city"></span> <span id="review_state"></span> <span id="review_zip"></span> </div>
                    </div>
                  </div>
                  <div class="control-group" id="group-phone1">
                    <label class="control-label">Phone Primary</label>
                    <div class="controls"> <span id="review_phone1type"></span> <span id="review_phone1"></span> </div>
                  </div>
                  <div class="control-group" id="group-phone2">
                    <label class="control-label">Phone Secondary</label>
                    <div class="controls"> <span id="review_phone2type"></span> <span id="review_phone2"></span> </div>
                  </div>
                  <div class="control-group" id="group-phone3">
                    <label class="control-label">Phone Other</label>
                    <div class="controls"> <span id="review_phone3type"></span> <span id="review_phone3"></span> </div>
                  </div>
                  <div class="control-group" id="group-email">
                    <label class="control-label">Email</label>
                    <div class="controls"> <span id="review_email"></span> </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="confirmation"></label>
                    <div class="controls">
                      <input type="checkbox" name="confirmation" id="confirmation" value="true" data-rule-required="true">
                      &nbspYes, I confirm that input is valid. </div>
                  </div>
                </div>
                <div class="form-actions" id="wizard-actions">
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
<form method="post" id="error-form">
    <div class="modal-header">
	    <h3 id="modal-title-error"></h3>
	</div>
	<div id="modal-body-error">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
	</div>
</form>
<?php
include("footer.php");
?>
