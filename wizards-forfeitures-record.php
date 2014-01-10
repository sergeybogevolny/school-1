<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_forfeitures_record.class.php');
include_once('classes/listbox.class.php');
$power = $listbox->getGeneral_Powers();

$power = $listbox->getPowers();
$agents = $listbox->getGeneral_Agents();
$prefixs = $listbox->getPrefixs();
$county = $listbox->getCounties();


?>
<script src="js/plugins/select2/select2.min.js"></script>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/wizards-forfeitures-record.js"></script>

<div class="container-fluid" id="content">
<?php include_once('pages/wizards-nav-left.php'); ?>
<div id="main">
<div class="container-fluid">
  <?php include_once('pages/wizards-page-header.php'); ?>
  <div class="row-fluid">
    <div class="span12">
      <div class="box">
        <div class="box-title">
          <h3> <i class="icon-upload-alt"></i> Forfeitures Record </h3>
        </div>
        <div class="box-content">
          <div id="success" class="hide alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <center>
              Success
            </center>
          </div>
          <form method="post" action="classes/wizards_forfeitures_record.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
            <div class="step" id="firstStep">
              <ul class="wizard-steps steps-5">
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
                  <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Step 4 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 5</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                </li>
              </ul>
              <div class="step-forms">
                <div class="control-group">
                  <label for="textfield" class="control-label">Received</label>
                  <div class="controls">
                    <input type="text" name="forfeiture-record-received" id="forfeiture-record-received" class="input-large span2 datepicker first-required" onchange="Stepfirstvalidate()" onblur="Stepfirstvalidate()" onclick="Stepfirstvalidate()">
                  </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Civil Case Number</label>
                  <div class="controls">
                    <input type="text" name="forfeiture-record-caseno" id="forfeiture-record-caseno" class="input-large span2 first-required" onkeyup="Stepfirstvalidate()" onblur="Stepfirstvalidate()" onclick="Stepfirstvalidate()" >
                  </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Forfeited</label>
                  <div class="controls">
                    <input type="text" name="forfeiture-record-forfeited" id="forfeiture-record-forfeited" class="input-large span2 datepicker first-required" onchange="Stepfirstvalidate()" onblur="Stepfirstvalidate()" onclick="Stepfirstvalidate()">
                  </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">County</label>
                  <div class="controls">
                    <input type="text" name="forfeiture-record-county" id="forfeiture-record-county" class="input-large span2  first-required" onkeyup="Stepfirstvalidate()" onblur="Stepfirstvalidate()" onclick="Stepfirstvalidate()">
                  </div>
                </div>
              </div>
            </div>
            <div class="step" id="secondStep">
              <ul class="wizard-steps steps-5">
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
                  <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Step 4 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 5</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                </li>
              </ul>
              <div class="step-forms">
                <div class="row-fluid">
                  <div class="control-group">
                    <label for="textfield" class="control-label">Amount</label>
                    <div class="controls">
                      <input type="text" name="forfeiture-record-amount" id="forfeiture-record-amount" class="input-large span2" onkeyup="Stepsecondvalidate()" onblur="Stepsecondvalidate()" onclick="Stepsecondvalidate()" >
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Defendant</label>
                    <div class="controls">
                      <input type="text" name="forfeiture-record-defendant" id="forfeiture-record-defendant" class="input-large span2" >
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Prefix</label>
                    <div class="controls">
                      <input type="text" name="forfeiture-record-prefix" id="forfeiture-record-prefix" class="input-large span2" >
                    </div>
                  </div>
                  <div class="control-group">
                    <label for="textfield" class="control-label">Serial</label>
                    <div class="controls">
                      <input type="text" name="forfeiture-record-serial" id="forfeiture-record-serial" class="input-large span2" >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="step" id="thirdStep">
              <ul class="wizard-steps steps-5">
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
                  <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Step 4 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 5</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                </li>
              </ul>
              <div class="step-forms">
                <div class="control-group">
                  <label for="textfield" class="control-label">Upload File</label>
                  <div class="controls">
                    <input type="file" name="file" id="forfeiture-record-file"  onchange="Validate(this)"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="step" id="fourthStep">
              <ul class="wizard-steps steps-5">
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
                  <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Step 4 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 5</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                </li>
              </ul>
              <div class="step-forms">
                <div class="control-group">
                  <label for="textfield" class="control-label">Comment</label>
                  <div class="controls">
                    <textarea name="forfeiture-record-comment" id="forfeiture-record-comment" rows="3" class="input-block-level span5"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="step" id="fifthStep">
              <ul class="wizard-steps steps-5">
                <li>
                  <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                </li>
                <li>
                  <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Step 3 </span> </div>
                </li>
                <li >
                  <div class="single-step"> <span class="title"> 4</span> <span class="circle"> </span> <span class="description"> Step 4 </span> </div>
                </li>
                <li class="active">
                  <div class="single-step"> <span class="title"> 5</span> <span class="circle"> <span class="active"></span></span> <span class="description"> Verify </span> </div>
                </li>
              </ul>
              <div class="step-forms">
                <div class="control-group">
                  <label for="textfield" class="control-label">Received</label>
                  <div class="controls"> <span id="review_received"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Civil Case Number</label>
                  <div class="controls"> <span id="review_caseno"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Forfeited</label>
                  <div class="controls"> <span id="review_forfeited"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">County</label>
                  <div class="controls"> <span id="review_county"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Amount</label>
                  <div class="controls"> <span id="review_amount"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Defendant</label>
                  <div class="controls"> <span id="review_defendant"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Prefix</label>
                  <div class="controls"> <span id="review_prefix"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Serial</label>
                  <div class="controls"> <span id="review_serial"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Civil Citation File Name</label>
                  <div class="controls"> <span id="review_civilcitation"></span> </div>
                </div>
                <div class="control-group">
                  <label for="textfield" class="control-label">Comment</label>
                  <div class="controls"> <span id="review_comment"></span> </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="confirmation"></label>
                <div class="controls">
                  <input type="checkbox" name="confirmation" id="confirmation" class="" data-skin="square" data-color="blue" value="true" data-rule-required="true">
                  &nbspYes, I confirm that input is valid. </div>
              </div>
            </div>
            <div class="form-actions" id="wizard-actions">
              <input type="reset"   class="btn" value="Back" id="back">
              <input type="submit"  class="btn btn-primary" value="Submit" id="next">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="modal-error" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
</div>
<?php
include("footer.php");
?>
