<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_transfers_create.class.php');

include_once('classes/listbox.class.php');
$generalagents = $listbox->getGeneral_Agents();
$counties = $listbox->getCounties();
?>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/wizards-transfers-create.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <i class="icon-signin"></i> Transfers Create </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_transfers_create.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
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
                      <label for="textfield" class="control-label">Date</label>
                      <div class="controls">
                        <input type="text" name="transfer-create-date" id="transfer-create-date" class="input-large span2 datepicker first-required">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Amount</label>
                      <div class="controls">
                        <input type="text" name="transfer-create-amount" id="transfer-create-amount" class="input-large span2 first-required">
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
                          <label for="textfield" class="control-label">Requesting Agent</label>
                          <div class="controls">
                            <select name="transfer-create-requesting-agent-select" id="transfer-create-requesting-select" class="select2-me input-large span4 second-required">
                              <?php echo $generalagents; ?>
                            </select>
                          </div>
                        </div>
                        <div class="control-group">
                          <label for="textfield" class="control-label">County</label>
                          <div class="controls">
                            <select name="transfer-create-county-select" id="transfer-create-county-select" class="select2-me input-large span4 second-required">
                              <?php echo $counties; ?>
                            </select>
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
                    <label for="textarea" class="control-label" style="margin-left:18px">Comment</label>
                    <div class="controls">
                      <textarea name="transfer-create-comment" id="transfer-create-comment" rows="3" class="input-block-level span5"> </textarea>
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
                    <label class="control-label bold">Date</label>
                    <div class="controls"> <span id="review_date"></span> </div>
                  </div>
                  <div class="control-group" id="group-amount">
                    <label class="control-label">Amount</label>
                    <div class="controls"> <span id="review_amount"></span> </div>
                  </div>
                  <div class="control-group" id="group-requesting">
                    <label class="control-label">Requesting Agent</label>
                    <div class="controls"> <span id="review_requesting"></span> </div>
                  </div>
                  <div class="control-group" id="group-county">
                    <label class="control-label">County</label>
                    <div class="controls"> <span id="review_county"></span> </div>
                  </div>
                  <div class="control-group" id="group-comments">
                    <label class="control-label">Comment</label>
                    <div class="controls"> <span id="review_comment"></span> </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="confirmation"></label>
                    <div class="controls">
                      <input type="hidden" name="requestingagent_id" val="" id="requestingagent_id" />
                      <input type="checkbox" name="confirmation" id="confirmation" value="true" data-rule-required="true">
                      &nbspYes, I confirm that input is valid. </div>
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
