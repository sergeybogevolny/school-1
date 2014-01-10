<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/agent.class.php');
include_once('classes/functions-agent.php');
include_once('classes/agent_account.class.php');
include_once('classes/listbox.class.php');
$id = $agent->getField('id');

$title = 'agent';
$label = 'account';
include("header.php");

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'net';
}
$paymentmethods = $listbox->getPaymentmethods();

?>

    <script src="js/agent-account.js"></script>

    <script src="js/plugins/autonumeric/autoNumeric.js"></script>

    <script type="text/javascript">
           var TYPE_LIST = '<?php echo $type ?>';
    </script>


        <div class="container-fluid" id="content">

            <?php include_once('pages/agent-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/agent-page-header.php'); ?>

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
                      <!-- ledger-view -->
    				    <div class="span12" id="ledger-view">
    					    <div class="box">
    						    <div class="box-title">
    							    <h3 id="ledger-label"></h3>
                                    <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
									    <option value="net">Net</option>
                                        <option value="buf">BUF</option>
                                    </select>
                                    <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
    							</div>
    							<div class="box-content nopadding">
                                    <?php list_agentaccount($id,$type); ?>
    							</div>
    						</div>
    					</div>
                      <!-- end ledger -->
                      
                      
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
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Amount</label>
                                                <div class="controls">
                                                    <input type="text" name="ledger-amount" id="ledger-amount" class="input-large span7" />
                                                </div>
                                            </div>
                                            <div class="control-group ">
                                                <label for="textfield" class="control-label">Method</label>
                                                <div class="controls">
                                                    <select name="ledger-paymentmethod" id="ledger-paymentmethod" class="select2-me input-large">
                                                        <?php echo $paymentmethods; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="ledger-column" id="ledger-colum" value="">
                                            <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id ?>">
                                            <input type="hidden" name="ledger-id" id="ledger-id" value="">
                                            <input type="hidden" name="ledger-type" id="ledger-type" value="">
                                            
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


<div id='jqxWindow-confirm' style="display:none">
<div></div>
<div>
    <span>Confirm</span>
    <button type="button" class="btn" id="confirm-no">No</button>
	<button type="button" class="btn" id="confirm-yes">Yes</button>
    <input type="hidden" name="confirm-type" id="confirm-type" value="">
</div>
</div>


<?php
include("footer.php");
?>
