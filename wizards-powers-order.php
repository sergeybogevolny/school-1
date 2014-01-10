<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_order.class.php');

include_once('classes/listbox.class.php');
$couriers = $listbox->getCouriers();
$sureties = $listbox->getSureties();
$prefixs = $listbox->getPrefixs();
?>
<script src="js/wizards-powers-order.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <i class="icon-signin"></i> Powers Order </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_powers_order.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                <div class="step" id="firstStep">
                  <ul class="wizard-steps steps-3">
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="step-forms">
                    <div class="control-group">
                      <label for="textfield" class="control-label">Order Date</label>
                      <div class="controls">
                        <input type="text" name="order-date" id="order-date" class="input-large span2 datepicker" onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Courier</label>
                      <div class="controls">
                        <select name="order-courier" id="order-courier" class="select2-me input-large span2">
                          <?php echo $couriers; ?>
                        </select>
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Surety</label>
                      <div class="controls">
                        <select name="order-surety" id="order-surety" class="select2-me input-large span2 " onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate()">
                          <?php echo $sureties; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="secondStep">
                  <ul class="wizard-steps steps-3">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="row-fluid">
                    <div class="span8" style="margin-bottom:20px">
                      <div class="box-title">
                        <h3 id="powers-label"></h3>
                        <div class="actions" id='list-actions'> <a class="btn btn-mini" id="powers-add" href="#"> <i class="icon-plus"></i> </a> </div>
                      </div>
                      <div class="box-content nopadding">
                        <div id="powers-list"></div>
                        <div id='powers-box' style="display:none">
                          <div class='form-horizontal' style="margin-top:20px">
                            <div class="control-group">
                              <label for="textfield" class="control-label">Prefix</label>
                              <div class="controls">
                                <select name="power-prefix" id="power-prefix" class="select2-me input-large power-required" onblur="Powerlistvalidate()" onkeyup="Powerlistvalidate()" onchange="Powerlistvalidate()">
                                  <?php echo $prefixs; ?>
                                </select>
                              </div>
                            </div>
                            <div class="control-group">
                              <label for="textfield" class="control-label">Serial Begin</label>
                              <div class="controls">
                                <input type="text" name="power-serialbegin" id="power-serialbegin" class="input-large power-required span4" onblur="Powerlistvalidate()" onkeyup="Powerlistvalidate()" onchange="Powerlistvalidate()">
                              </div>
                            </div>
                            <div class="control-group">
                              <label for="textfield" class="control-label">Serial End</label>
                              <div class="controls">
                                <input type="text" name="power-serialend" id="power-serialend" class="input-large power-required span4" onblur="Powerlistvalidate()" onkeyup="Powerlistvalidate()" onchange="Powerlistvalidate()">
                              </div>
                            </div>
                            <div class="control-group">
                              <label for="textfield" class="control-label">Issue Date</label>
                              <div class="controls">
                                <input type="text" name="power-issued" id="power-issued" class="input-large span2 datepicker power-required" onblur="Powerlistvalidate()" onkeyup="Powerlistvalidate()" onchange="Powerlistvalidate()">
                              </div>
                            </div>
                            <div class="control-group">
                              <label for="textfield" class="control-label">Expiration Date</label>
                              <div class="controls">
                                <input type="text" name="power-expiration" id="power-expiration" class="input-large span2 datepicker power-required" onblur="Powerlistvalidate()" onkeyup="Powerlistvalidate()" onchange="Powerlistvalidate()">
                              </div>
                            </div>
                            <div class="form-actions">
                              <div class="controls"  id="powerDelete"  style="display:none">
                                <div class="check-col" style="margin-left:-299px;margin-top:0px;">
                                  <div class="check-line " >
                                    <input type="checkbox" name="power-delete" class="icheck-me" data-skin="square" data-color="blue" id="power-delete" >
                                    <label class='inline ' for="power-delete"> Delete? </label>
                                  </div>
                                </div>
                              </div>
                              <input type="hidden" id="powerId" value="0" />
                              <button type="button" class="btn btn-primary" name="power-save" id="power-save">Save</button>
                              <button type="button" class="btn" name="power-cancel" id="power-cancel">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="thirdStep">
                  <ul class="wizard-steps steps-3">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li class="active">
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="control-group" id="group-orderdate">
                    <label class="control-label bold">Order Date</label>
                    <div class="controls">
                      <span id="review_orderdate"></span>
                     </div>
                  </div>
                  <div class="control-group" id="group-courier">
                    <label class="control-label">Courier</label>
                    <div class="controls">
                      <span id="review_courier"></span>
                     </div>
                  </div>
                  <div class="control-group" id="group-surety">
                    <label class="control-label">Surety</label>
                    <div class="controls">
                      <span id="review_surety"></span>
                    </div>
                  </div>
                  <div class="control-group" id="group-powers">
                    <div id="review_powers" class="span8"></div>
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
    <div id="modal-body-error"> </div>
    <div class="modal-footer">
      <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
    </div>
  </form>
</div>
<?php
include("footer.php");
?>
