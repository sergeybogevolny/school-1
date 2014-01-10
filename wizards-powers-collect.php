<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_collect.class.php');
include_once('classes/functions-powers.php');
include_once('classes/listbox.class.php');
$prefixs = $listbox->getPrefixs();
$paymentmethods  =  $listbox->getPaymentmethods();

?>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/wizards-powers-collect.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <i class="icon-download-alt"></i> Powers Collect & Report </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_powers_collect.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
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
                    <div class="row-fluid">
                      <?php list_collectjob() ?>
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
                  <div class="step-forms">
                    <div class="row-fluid">
                      <div style="margin-bottom:10px;">
                        <div class="span4" id="count"></div>
                        <div class="span8" id="sum"></div>
                      </div>
                      <div class="power-loading" style="display: none;">Loading...</div>
                      <table id="detail-list" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                        <thead>
                          <tr class='thefilter'>
                            <th class='with-checkbox'> <input type="checkbox" name="check_all" class="icheck-me"  data-skin="square" data-color="blue" id="check_all_2" ></th>
                            <th>Prefix</th>
                            <th>Serial</th>
                            <th>Executed</th>
                            <th>Defendant</th>
                            <th>Amount</th>
                            <th>Transfer</th>
                            <th>Net Contracted</th>
                            <th>BUF Contracted</th>
                            <th>Net Calculated</th>
                            <th>BUF Calculated</th>
                            <th style="display:none;">Void</th>
                          </tr>
                        </thead>
                        <tbody id="collectdetail">
                        </tbody>
                      </table>
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
                  <div class="step-forms">
                    <div class="span6">
                      <div style="margin-bottom:15px;"><span style="font-size:14px;font-weight:bold;">Collect</span></div>
                      <div style="margin-bottom:10px;"><span style="font-weight:bold;">Net</span><span id="collected-netcontracted" style="font-weight:bold;"></span></div>
                      <div class="control-group" id="collected-netpaymentdate-group">
                        <label for="textfield" class="control-label">Payment Date</label>
                        <div class="controls"> <span id="collected-netpaymentdate"></span> </div>
                      </div>
                      <div class="control-group" id="collected-netpaymentamount-group">
                        <label for="textfield" class="control-label">Amount</label>
                        <div class="controls"> <span id="collected-netpaymentamount"></span> </div>
                      </div>
                      <div class="control-group" id="collected-netpaymentmethod-group">
                        <label for="textfield" class="control-label">Method</label>
                        <div class="controls"> <span id="collected-netpaymentmethod"></span> </div>
                      </div>
                      <div style="margin-bottom:10px;"><span style="font-weight:bold;">Buf</span><span id="collected-bufcontracted" style="font-weight:bold;"></span></div>
                      <div class="control-group" id="collected-bufpaymentdate-group">
                        <label for="textfield" class="control-label">Payment Date</label>
                        <div class="controls"> <span id="collected-bufpaymentdate"></span> </div>
                      </div>
                      <div class="control-group" id="collected-bufpaymentamount-group">
                        <label for="textfield" class="control-label">Amount</label>
                        <div class="controls"> <span id="collected-bufpaymentamount"></span> </div>
                      </div>
                      <div class="control-group" id="collected-bufpaymentmethod-group">
                        <label for="textfield" class="control-label">Method</label>
                        <div class="controls"> <span id="collected-bufpaymentmethod"></span> </div>
                      </div>
                    </div>
                    <div class="span6">
                      <div style="margin-bottom:15px;"><span style="font-size:14px;font-weight:bold;">Report</span></div>
                      <div style="margin-bottom:10px;"><span style="font-weight:bold;">Net</span><span id="reporting-netcalculated" style="font-weight:bold;"></span></div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Payment Date</label>
                        <div class="controls">
                          <input type="text" name="report-netpaymentdate-general" id="report-netpaymentdate-general" class="input-large span6 datepicker">
                        </div>
                      </div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Amount</label>
                        <div class="controls">
                          <input type="text" name="report-netpaymentamount-general" id="report-netpaymentamount-general" class="input-large span6">
                        </div>
                      </div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Method</label>
                        <div class="controls">
                          <select name="report-netpaymentmethod-general" id="report-netpaymentmethod-general" class="select2-me input-large span6">
                            <?php echo $paymentmethods; ?>
                          </select>
                        </div>
                      </div>
                      <div style="margin-bottom:10px;"><span style="font-weight:bold;">Buf</span><span id="reporting-bufcalculated" style="font-weight:bold;"></span></div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Payment Date</label>
                        <div class="controls">
                          <input type="text" name="report-bufpaymentdate-general" id="report-bufpaymentdate-general" class="input-large span6 datepicker">
                        </div>
                      </div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Amount</label>
                        <div class="controls">
                          <input type="text" name="report-bufpaymentamount-general" id="report-bufpaymentamount-general" class="input-large span6">
                        </div>
                      </div>
                      <div class="control-group">
                        <label for="textfield" class="control-label">Method</label>
                        <div class="controls">
                          <select name="report-bufpaymentmethod-general" id="report-bufpaymentmethod-general" class="select2-me input-large span6">
                            <?php echo $paymentmethods; ?>
                          </select>
                        </div>
                      </div>
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
                  <div class="row-fluid">
                    <div style="margin-bottom:10px;">
                      <div class="span4" id="reviewcount"></div>
                      <div class="span8" id="reviewsum"></div>
                    </div>
                    <div id="report-review">
                      <div style="margin-bottom:15px;"><span style="font-size:14px;font-weight:bold;">Report</span></div>
                      <div style="margin-bottom:10px;"><span style="font-weight:bold;">Net</span><span id="review-netcalculated" style="font-weight:bold;"></span></div>
                      <div id="group-net">
                          <div class="control-group" id="group-netpaymentdate">
                            <label for="textfield" class="control-label">Payment Date</label>
                            <div class="controls"> <span id="review-netpaymentdate-general"></span> </div>
                          </div>
                          <div class="control-group" id="group-netpaymentamount">
                            <label for="textfield" class="control-label">Amount</label>
                            <div class="controls"> <span id="review-netpaymentamount-general"></span> </div>
                          </div>
                          <div class="control-group" id="group-netpaymentmethod">
                            <label for="textfield" class="control-label">Method</label>
                            <div class="controls"> <span id="review-netpaymentmethod-general"></span> </div>
                          </div>
                      </div>
                      <div id="group-buf">
                          <div style="margin-bottom:10px;"><span style="font-weight:bold;">BUF</span><span id="review-bufcalculated" style="font-weight:bold;"></span></div>
                          <div class="control-group" id="group-bufpaymentdate">
                            <label for="textfield" class="control-label">Payment Date</label>
                            <div class="controls"> <span id="review-bufpaymentdate-general"></span> </div>
                          </div>
                          <div class="control-group" id="group-bufpaymentamount">
                            <label for="textfield" class="control-label">Amount</label>
                            <div class="controls"> <span id="review-bufpaymentamount-general"></span> </div>
                          </div>
                          <div class="control-group" id="group-bufpaymentmethod">
                            <label for="textfield" class="control-label">Method</label>
                            <div class="controls"> <span id="review-bufpaymentmethod-general"></span> </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row-fluid">
                    <table id="review-detail-list" class="table table-hover table-nomargin table-bordered  dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                      <thead>
                        <tr>
                          <th>Prefix</th>
                          <th>Serial</th>
                          <th>Executed</th>
                          <th>Defendant</th>
                          <th>Amount</th>
                          <th>Transfer</th>
                          <th>Net Contracted</th>
                          <th>Buf Contracted</th>
                          <th>Net Calculated</th>
                          <th>Buf Calculated</th>
                          <th style="display:none;">Void</th>
                          <th style="display:none;">ID</th>
                        </tr>
                      </thead>
                      <tbody id="reviewcollectdetail">
                      </tbody>
                    </table>
                  </div>

                  <input type="hidden" name="report-agency" id="report-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-agencyid" id="report-agencyid" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-net-agency" id="report-net-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-netminimum-agency" id="report-netminimum-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-buf-agency" id="report-buf-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-bufminimum-agency" id="report-bufminimum-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-netcontracted-agency" id="report-netcontracted-agency" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-bufcontracted-agency" id="report-bufcontracted-agency" value=""> <!--set f cjd-->

                  <input type="hidden" name="report-netpaymentamount-agency" id="report-netpaymentamount-agency" value="">
                  <input type="hidden" name="report-bufpaymentamount-agency" id="report-bufpaymentamount-agency" value="">

                  <input type="hidden" name="report-surety" id="report-surety" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-count" id="report-count" value="">  <!--set fw before step-->
                  <input type="hidden" name="report-amount" id="report-amount" value="">  <!--set fw before step-->
                  <input type="hidden" name="report-netcalculated-general" id="report-netcalculated-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-bufcalculated-general" id="report-bufcalculated-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-net-general" id="report-net-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-netminimum-general" id="report-netminimum-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-buf-general" id="report-buf-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-bufminimum-general" id="report-bufminimum-general" value=""> <!--set f cjd-->
                  <input type="hidden" name="report-collectid" id="report-collectid" value=""> <!--set fw before step-->

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
              <div id="report-button" style="display:none" > </br>
                </br>
                <center>
                  <span id="reportbutton"></span>
                </center>
              </div>
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
