<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_supplements_create.class.php');

include_once('classes/listbox.class.php');
$sts = $listbox->getSts();

?>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/wizards-supplements-create.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <img src='img/title_supplement.png'> Supplement Create </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_supplements_create.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
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
                        <input type="text" name="search-value" id="search-value" class="input-large" style="float:left;margin-right:2px;height:30px;width:157px;" onKeyPress="SearchStatus(event);">
                        <button type="button" class="btn btn-success" name="search-simple" id="search-simple" onclick="GoSearch()" style="float:left"><i class="icon-arrow-right"></i> Go</button>
                    </div>

                    <div class="row-fluid">
                        <div class="box-content" id="search-results"></div>
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
                    <div class="control-group">
                        <label for="textfield" class="control-label">Transaction Amount </label>
                        <div class="controls">
                            <input type="text" name="transaction-amount" id="transaction-amount" class="input-large mask_currency span5" onblur="stepsecondValidate()" onkeyup="stepsecondValidate()" onchange="stepsecondValidate()">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="textfield" class="control-label">Invoice Amount </label>
                        <div class="controls">
                            <input type="text" name="invoice-amount" id="invoice-amount" class="input-large mask_currency span5" onblur="stepsecondValidate()" onkeyup="stepsecondValidate()" onchange="stepsecondValidate()">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="textfield" class="control-label">Installment Amount </label>
                        <div class="controls">
                            <input type="text" name="installment-amount" id="installment-amount" class="input-large mask_currency span5" onblur="stepsecondValidate()" onkeyup="stepsecondValidate()" onchange="stepsecondValidate()">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="textfield" class="control-label">Installment Interval</label>
                        <div class="controls">
                            <select name="installment-interval" id="installment-interval" class="select2-me input-large" onblur="stepsecondValidate()" onkeyup="stepsecondValidate()" onchange="stepsecondValidate()">
                                <option value=""></option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Biweekly</option>
                                <option value="monthly">Monthly</option>
                		    </select>
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
                  <div class="step-forms">
                    <div class="control-group">
                        <label for="textfield" class="control-label">Method</label>
                        <div class="controls">
                            <select name="draw-method" id="draw-method" class="select2-me input-large" onchange="displayMethod()">
                                <option value=""></option>
                                <option value="check">Check</option>
                                <option value="card">Card</option>
                		    </select>
                        </div>
                    </div>

                    <div id="check-detail" style="display:none;">
                        <div class="control-group">
    					    <label class="control-label">Bank</label>
    					    <div class="controls">
    						    <input type="text" name="draw-bank" id="draw-bank" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
    					    <label class="control-label">Routing</label>
    					    <div class="controls">
    						    <input type="text" name="draw-bankrouting" id="draw-bankrouting" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
    					    <label class="control-label">Account</label>
    					    <div class="controls">
    						    <input type="text" name="draw-bankaccount" id="draw-bankaccount" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>

                    </div>
                    <div id="card-detail" style="display:none;">
                        <div class="control-group">
    					    <label class="control-label">Card</label>
    					    <div class="controls">
    						    <input type="text" name="draw-card" id="draw-card" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
    					    <label class="control-label">Number</label>
    					    <div class="controls">
    						    <input type="text" name="draw-cardnumber" id="draw-cardnumber" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
    					    <label class="control-label">Expiration</label>
    					    <div class="controls">
    						    <input type="text" name="draw-cardexpiration" id="draw-cardexpiration" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
    					    <label class="control-label">CVV</label>
    					    <div class="controls">
    						    <input type="text" name="draw-cardcvv" id="draw-cardcvv" class="input-xlarge span4" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
    						</div>
    					</div>
                        <div class="control-group">
                            <label class="control-label">Address</label>
                            <div class="controls">
                                <div class="row-fluid">
                                    <input type="text" name="draw-cardaddress" id="draw-cardaddress" class="input-large span6" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
                                </div>
                            </div>
                            <div class="controls" style="margin-top:10px">
                                <div class="row-fluid">
                                    <input type="text" name="draw-cardcity" id="draw-cardcity" class="input-large span3" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
                                    <select name="draw-cardstate" id="draw-cardstate" class="select2-me  span5" style="width:80px" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
                                        <?php echo $sts; ?>
                                    </select>
                                    <input type="text" name="draw-cardzip" id="draw-cardzip" class="input-large span2" onblur="stepthirdValidate()" onkeyup="stepthirdValidate()" onchange="stepthirdValidate()">
                                </div>
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
                  <div class="control-group" id="group-indemnitor">
                    <label for="textfield" class="control-label">Indemnitor</label>
                    <div class="controls"> <span id="review-indemnitor"></span> </div>
                  </div>
                  <div class="control-group" id="group-transactionamount">
                    <label for="textfield" class="control-label">Transaction Amount</label>
                    <div class="controls"> <span id="review-transactionamount"></span> </div>
                  </div>
                  <div class="control-group" id="group-invoiceamount">
                    <label for="textfield" class="control-label">Invoice Amount</label>
                    <div class="controls"> <span id="review-invoiceamount"></span> </div>
                  </div>
                  <div class="control-group" id="group-installmentamount">
                    <label for="textfield" class="control-label">Installment Amount</label>
                    <div class="controls"> <span id="review-installmentamount"></span> </div>
                  </div>
                  <div class="control-group" id="group-installmentinterval">
                    <label for="textfield" class="control-label">Installment Interval</label>
                    <div class="controls"> <span id="review-installmentinterval"></span> </div>
                  </div>
                  <div class="control-group" id="group-method">
                    <label for="textfield" class="control-label">Method</label>
                    <div class="controls"> <span id="review-method"></span> </div>
                  </div>
                  <div id="group-method-check" style="display:none;">
                      <div class="control-group" id="group-bank">
                        <label for="textfield" class="control-label">Bank</label>
                        <div class="controls"> <span id="review-bank"></span> </div>
                      </div>
                      <div class="control-group" id="group-bankrouting">
                        <label for="textfield" class="control-label">Routing</label>
                        <div class="controls"> <span id="review-bankrouting"></span> </div>
                      </div>
                      <div class="control-group" id="group-bankaccount">
                        <label for="textfield" class="control-label">Account</label>
                        <div class="controls"> <span id="review-bankaccount"></span> </div>
                      </div>
                  </div>
                  <div id="group-method-card" style="display:none;">
                      <div class="control-group" id="group-card">
                        <label for="textfield" class="control-label">Card</label>
                        <div class="controls"> <span id="review-card"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardnumber">
                        <label for="textfield" class="control-label">Number</label>
                        <div class="controls"> <span id="review-cardnumber"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardexpiration">
                        <label for="textfield" class="control-label">Expiration</label>
                        <div class="controls"> <span id="review-cardexpiration"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardcvv">
                        <label for="textfield" class="control-label">CVV</label>
                        <div class="controls"> <span id="review-cardcvv"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardaddress">
                        <label for="textfield" class="control-label">Address</label>
                        <div class="controls"> <span id="review-cardaddress"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardcity">
                        <label for="textfield" class="control-label">City</label>
                        <div class="controls"> <span id="review-cardcity"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardstate">
                        <label for="textfield" class="control-label">State</label>
                        <div class="controls"> <span id="review-cardstate"></span> </div>
                      </div>
                      <div class="control-group" id="group-cardzip">
                        <label for="textfield" class="control-label">Zip</label>
                        <div class="controls"> <span id="review-cardzip"></span> </div>
                      </div>
                  </div>

                  <input type="text" name="supplement-payer" id="supplement-payer" value=""> <!--set loadindemnitor-->
                  <input type="text" name="supplement-payerid" id="supplement-payerid" value=""> <!--set loadindemnitor-->
                  <input type="text" name="supplement-defendant" id="supplement-defendant" value=""> <!--set loadindemnitor-->
                  <input type="text" name="supplement-defendantid" id="supplement-defendantid" value=""> <!--set loadindemnitor-->

                  <input type="text" name="supplement-transactionamount" id="supplement-transactionamount" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-invoiceamount" id="supplement-invoiceamount" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-installmentamount" id="supplement-installmentamount" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-installmentinterval" id="supplement-installmentinterval" value=""> <!--set before stepshow-->

                  <input type="text" name="supplement-drawmethod" id="supplement-drawmethod" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawbank" id="supplement-drawbank" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawbankrouting" id="supplement-drawbankrouting" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawbankaccount" id="supplement-drawbankaccount" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcard" id="supplement-drawcard" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardnumber" id="supplement-drawcardnumber" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardexpiration" id="supplement-drawcardexpiration" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardcvv" id="supplement-drawcardcvv" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardaddress" id="supplement-drawcardaddress" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardcity" id="supplement-drawcardcity" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardstate" id="supplement-drawcardstate" value=""> <!--set before stepshow-->
                  <input type="text" name="supplement-drawcardzip" id="supplement-drawcardzip" value=""> <!--set before stepshow-->

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
