<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/agent.class.php');
include_once('classes/functions-agent.php');
include_once('classes/agent_contract.class.php');

$title = 'agent';
$label = 'contracts';
include_once('header.php');

$id = $agent->getField('id');
?>

    <script src="js/agent-contracts.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
	 <script type="text/javascript" src="js/jqwidgets/jqxnumberinput.js"></script>
 
    <!--SET SOURCE -->
    <script type="text/javascript">
        var CONTRACTS_SOURCE = <?php echo $agentcontract->getContracts($id); ?>;
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
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="contracts-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="contracts-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='contracts-list'>
                                    <?php list_agentcontracts($id); ?>
                                </div>
							</div>
						</div>
					</div>

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='contracts-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span6">
                                <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='contract-form'>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Date</label>
                                        		<div class="controls">
                                        		    <input type="text" name="contract-date" id="contract-date" class="input-large span12 datepicker">
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Net ($ on 1k)</label>
                                        		<div class="controls">
                                        		    <input type="text" name="contract-net" id="contract-net" class="input-large span12 mask-rate">
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Net Minimum</label>
                                        		<div class="controls">
                                        		    <input type="text" name="contract-netminimum" id="contract-netminimum" class="input-large span12">
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Buf ($ on 1k)</label>
                                        		<div class="controls">
                                        		    <input type="text" name="contract-buf" id="contract-buf" class="input-large span12 mask-rate">
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Buf Minimum</label>
                                        		<div class="controls">
                                        		    <input type="text" name="contract-bufminimum" id="contract-bufminimum" class="input-large span12">
                                        		</div>
                                        	</div>
                                            <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="contract-id" id="contract-id" value="">
                                            <div class="form-actions">
                        					    <button type="submit" class="btn btn-primary" name="contract-save" id="contract-save">Save</button>
                        						<button type="button" class="btn" name="contract-cancel" id="contract-cancel">Cancel</button>
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
</div>
</div>

<?php
include("footer.php");
?>
