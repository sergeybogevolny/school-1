<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
include_once('classes/client_account.class.php');
include_once('classes/listbox.class.php');

$id = $client->getField('id');


$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'account';
include("header.php");

$debitentries = $listbox->getDebitentries();
$creditentries = $listbox->getCreditentries();
$paymentmethods = $listbox->getPaymentmethods();

$accountcount = $clientaccount->getAccountCount($id);
$schedulecount = $clientaccount->getScheduleCount($id);
$schedulebalance = number_format($client->getField('accountschedulebalance'),2);
$accountbalance = number_format($client->getField('accountbalance'),2);
$sfee = number_format($client->getField('quotefee'),2);
$sdown = number_format($client->getField('quotedown'),2);
$sterms = $client->getfield('quoteterms');
//$clientaccount->routine($id);
?>

    <script src="js/client-account.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script type="text/javascript">
        var SCHEDULE_SOURCE = <?php echo $clientaccount->getSchedule($id); ?>;
        var ACCOUNT_COUNT = <?php echo $accountcount; ?>;
    </script>


        <div class="container-fluid" id="content">

            <?php include_once('pages/client-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/client-page-header.php'); ?>

                     <div class="row-fluid">
						<div class="span12">
                            <div class="box">
      							<div class="box-title">
      								<h3>
      									<i class="icon-list-alt"></i>
      									Account
      								</h3>
      							</div>
      							<div class="box-content">
                                    <div class="pull-left">
                                        <div id="ledger-actions">
                                            <ul class="stats">
                                                <li class="button">
                                                    <div class="btn-group">
        												<a href="#" class="btn btn-primary" id="ledger-debit"><img src='img/client_account_debit.png'></a>
        										    </div>
                                                </li>
                                                <li class="button">
                                                    <div class="btn-group">
        												<a href="#" class="btn btn-primary" id="ledger-credit"><img src='img/client_account_credit.png'></a>
        										    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
      							</div>
      						</div>
                        </div>
                    </div>

					<div class="row-fluid">

                        <?php if ($accountcount==0){?>
                        <div class="span6" id="quote-view">
                            <div class="box">
            				    <div class="box-title">
            					    <h3 id="quote-label">Quote</h3>
            					</div>
                                <div id="quote-list">
                                    <div class="box-content nopadding">
                					    <div class='form-horizontal form-bordered'>
                						    <div class="control-group">
                							    <label for="textfield" class="control-label">Fee</label>
                								<div class="controls">
                                                    <p><?php echo $sfee; ?></p>
                								</div>
                							</div>
                                            <div class="control-group">
                							    <label for="textfield" class="control-label">Down</label>
                								<div class="controls">
                                                    <p><?php echo $sdown; ?></p>
                								</div>
                							</div>
                                            <div class="control-group">
                							    <label for="textfield" class="control-label">Terms</label>
                								<div class="controls">
                                                    <p><?php echo $sterms; ?></p>
                								</div>
                							</div>
                						</div>
                					</div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($accountcount!=0){?>
                        <!-- ledger-view -->
    				    <div class="span6" id="ledger-view">
    					    <div class="box">
    						    <div class="box-title">
    							    <h3 id="ledger-label"></h3>
    							</div>
    							<div class="box-content nopadding">
                                    <?php list_clientaccount($id); ?>
    							</div>
    						</div>
    					</div>
                      <!-- end ledger -->

                      <!-- ledger-view -->
                        <div class="span6" id="schedule-view">
                            <div class="box">
								<div class="box-title">
									<h3 id="schedule-label"></h3>
                                    <div class="actions" id="schedule-list-actions">
                                        <?php
                                            if ($schedulecount==0){
                                            ?>
                                                <a class="btn btn-mini" href="#" id="schedule-add">
                                                    <i class="icon-plus"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-mini" href="#" id="schedule-edit">
                                                    <i class="icon-edit"></i>
                                                </a>
                                                <a class="btn btn-mini" href="#" id="schedule-delete">
                                                    <i class="icon-minus"></i>
                                                </a>
                                            <?php
                                            }
                                        ?>
                                    </div>
								</div>

								<div class="box-content nopadding" id="schedule-list">
                                    <?php
                                        if ($schedulecount!=0){
                                        ?>
                                            <div class='form-horizontal form-bordered' style="margin-top:10px;">
                    						    <div class="control-group">
                    							    <label for="textfield" class="control-label">Amount Owed to Schedule</label>
                    								<div class="controls">
                                                        <p><?php echo $schedulebalance; ?></p>
                    								</div>
                    							</div>
                                                <div class="box-content nopadding">
                                                    <?php echo list_clientaccountsschedules($id); ?>
            							        </div>
                    						</div>
                                        <?php
                                        }
                                        ?>
                                </div>


                             <div class="box-content nopadding" id="schedule-form" style="display:none">
                                 <div class="span4" id='jqxCalendar-account' style="margin-top:10px;margin-right:20px;margin-bottom:20px;float:left;"></div>
                                    <div class='form-horizontal form-bordered span7' style="margin-top:10px;float:left;">
                						    <div class="control-group">
                							    <label for="textfield" class="control-label">Amount Owed to Schedule</label>
                								<div class="controls">
                                                    <p id='schedule-owed'><?php echo $schedulebalance; ?></p>
                								</div>
                							</div>
                                            <div class="box-content nopadding">
                                                <div id='schedule' style="margin-top:10px;"></div>
    							            </div>
                                            <div class="">
                                                <input type="hidden" name="schedule-balance" id="schedule-balance" value="">
                                                <input type="hidden" name="account-balance" id="account-balance" value="<?php echo $accountbalance; ?>">
                                				<button type="button" class="btn btn-primary" name="schedule-save" id="schedule-save" style="display:none;">Save</button>
                                                <button type="button" class="btn" name="schedule-cancel" id="schedule-cancel">Cancel</button>
                                			</div>
                                    </div>

								</div>




							</div>
						</div>
                        <?php } ?>
                        <!-- end schedule -->

                        <div class="span6" id="installment-view" style="display:none;">
                            <div class="box">
								<div class="box-title">
									<h3 id="installment-label">Installment - Add</h3>
								</div>

								<div class="box-content nopadding" id="installment-form">

                                    <div class="row-fluid">
                                	    <div class="span12">
                                		    <div class="box-content nopadding">
                                			    <div class='form-horizontal form-bordered'>
                                                    <div class="control-group">
                                					    <label for="textfield" class="control-label">Date</label>
                                						<div class="controls">
                                						    <p id="installment-date"></p>
                                						</div>
                                					</div>
                                                    <div class="control-group">
                                					    <label for="textfield" class="control-label">Amount</label>
                                						<div class="controls">
                                                            <input type="text" name="installment-amount" id="installment-amount" class="input-large">
                                						</div>
                                					</div>
                                                    <div class="control-group recurring-group">
                                                        <label for="textfield" class="control-label">Recurring</label>
                                                        <div class="controls">
                                                            <select id="recurring-type" name="recurring-type" class="select2-me input-large span8">
                                                                <option value=""></option>
                                                                <option value="weekly">Weekly</option>
                                                                <option value="biweekly">Biweekly</option>
                                                                <option value="monthly">Monthly</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="special-date" id="special-date" value="">
                                                    <div class="form-actions">
                                					    <button type="button" class="btn btn-primary" name="installment-save" id="installment-save">Save</button>
                                						<button type="button" class="btn" name="installment-cancel" id="installment-cancel">Cancel</button>
                                					</div>
                                				</div>
                                			</div>
                                		</div>
                                	</div>
                                </div>
                            </div>
                        </div>


                    <!-- start ledger -->
                        <div class="span6" id="creditentry-view" style="display:none">
                            <div class="box">
                              <div class="box-title">
                                <h3 id="creditentry-label"></h3>
                              </div>
                              <div id='debit-box' >
                                <div class="row-fluid">
                                  <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='ledger-form'>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Date</label>
                                                <div class="controls controlLedgerDate" >
                                                    <input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span7 ledgerDate" value=" ">
                                                </div>
                                            </div>
                                            <div class="control-group debit-group">
                                                <label for="textfield" class="control-label">Entry</label>
                                                <div class="controls">
                                                     <select name="ledger-debitentry" id="ledger-debitentry" class="select2-me input-large">
                                                        <?php echo $debitentries; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group credit-group">
                                                <label for="textfield" class="control-label">Entry</label>
                                                <div class="controls">
                                                     <select name="ledger-creditentry" id="ledger-creditentry" class="select2-me input-large">
                                                        <?php echo $creditentries; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Amount</label>
                                                <div class="controls">
                                                    <input type="text" name="ledger-amount" id="ledger-amount" class="input-large span7" />
                                                </div>
                                            </div>
                                            <div class="control-group credit-group">
                                                <label for="textfield" class="control-label">Method</label>
                                                <div class="controls">
                                                    <select name="ledger-paymentmethod" id="ledger-paymentmethod" class="select2-me input-large">
                                                        <?php echo $paymentmethods; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group credit-group">
                                                <label for="textfield" class="control-label">Memo</label>
                                                <div class="controls">
                                                    <textarea name="ledger-memo" id="ledger-memo" class="input-block-level"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ledger-column" id="ledger-colum" value="">
                                            <input type="hidden" name="client-id" id="client-id" value="<?php echo $id ?>">
                                            <input type="hidden" name="ledger-id" id="ledger-id" value="">
                                            <div class="form-actions">
                                            
                                                <div class="check-col" style="margin-top:0px;margin-left:-150px; display:none" id="ledgerDelete">
													<div class="check-line " >
                                					<input type="checkbox" name="ledger-delete" class="icheck-me" data-skin="square" data-color="blue" id="ledger-delete" ><label class='inline ' for="ledger-delete"> Delete? </label>
													</div>
                                                 </div>                                            
                                            
                                                <button type="submit" class="btn btn-primary" name="ledger-save" id="ledger-save">Save</button>
                                                <button type="button" class="btn" name="ledger-cancel" id="ledger-cancel">Cancel</button>
                                            </div>
                                                </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                            <!-- end ledger -->

					</div>
				</div>
			</div>
		</div>


<div id='jqxWindow-status' style="display:none">
<div></div>
<div></div>
</div>

<div id='jqxWindow-confirm' style="display:none">
<div></div>
<div>
    <span>Confirm</span>
    <button type="button" class="btn" id="confirm-no">No</button>
	<button type="button" class="btn" id="confirm-yes">Yes</button>
    <input type="hidden" name="confirm-type" id="confirm-type" value="">
</div>
</div>

<!--<div id='jqxWindow-ledger' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
			    <form method="POST" class='form-vertical form-bordered' id='ledger-form'>
                    <div class="control-group">
                        <label for="textfield" class="control-label">Date</label>
						<div class="controls">
                            <input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker">
                        </div>
                    </div>
                    <div class="control-group debit-group">
                        <label for="textfield" class="control-label">Entry</label>
						<div class="controls">
                             <select name="ledger-debitentry" id="ledger-debitentry" class="select2-me input-large">
                			    <?php echo $debitentries; ?>
                			</select>
                        </div>
                    </div>
                    <div class="control-group credit-group">
                        <label for="textfield" class="control-label">Entry</label>
						<div class="controls">
                             <select name="ledger-creditentry" id="ledger-creditentry" class="select2-me input-large">
                			    <?php echo $creditentries; ?>
                			</select>
                        </div>
                    </div>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Amount</label>
						<div class="controls">
                            <input type="text" name="ledger-amount" id="ledger-amount" class="input-large" />
						</div>
					</div>
                    <div class="control-group credit-group">
					    <label for="textfield" class="control-label">Method</label>
						<div class="controls">
                            <select name="ledger-paymentmethod" id="ledger-paymentmethod" class="select2-me input-large">
                			    <?php echo $paymentmethods; ?>
                			</select>
						</div>
					</div>
                    <div class="control-group credit-group">
                        <label for="textfield" class="control-label">Memo</label>
                        <div class="controls">
                            <textarea name="ledger-memo" id="ledger-memo" class="input-block-level"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="ledger-column" id="ledger-colum" value="">
                    <input type="hidden" name="client-id" id="client-id" value="<?php echo $id ?>">
                    <input type="hidden" name="ledger-id" id="ledger-id" value="">
                    <div class="form-actions">
					    <button type="submit" class="btn btn-primary" name="ledger-save" id="ledger-save">Save</button>
						<button type="button" class="btn" name="ledger-cancel" id="ledger-cancel">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>-->

<!--
<div id='jqxWindow-installment' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
			    <div class='form-vertical form-bordered'>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Date</label>
						<div class="controls">
						    <p id="installment-date"></p>
						</div>
					</div>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Amount</label>
						<div class="controls">
                            <input type="text" name="installment-amount" id="installment-amount" class="input-large">
						</div>
					</div>
                    <div class="control-group recurring-group">
                        <label for="textfield" class="control-label">Recurring</label>
                        <div class="controls">
                            <select id="recurring-type" name="recurring-type" class="select2-me input-large span8">
                                <option value=""></option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Biweekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <input type="text" name="scheduler-balance" id="scheduler-balance" value="">
                    <input type="text" name="schedule-balance" id="schedule-balance" value="">
                    <input type="text" name="special-date" id="special-date" value="">
                    <div class="form-actions">
					    <button type="button" class="btn btn-primary" name="installment-save" id="installment-save">Save</button>
						<button type="button" class="btn" name="installment-cancel" id="installment-cancel">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
-->






<?php
include("footer.php");
?>
