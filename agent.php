<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/agent.class.php');
$id = $agent->getField('id');
$title = 'agent';
$label = 'summary';

$stype = $agent->getField('type');
$scompany = $agent->getField('company');
$scontact = $agent->getField('contact');
$saddress = $agent->getField('address');
$scity = $agent->getField('city');
$sstate = $agent->getField('state');
$szip = $agent->getField('zip');
$scitystatezip = '';
if ($scity!=""){
    $scitystatezip = $scity;
}
if ($sstate!=""){
    if ($scitystatezip!=""){
        $scitystatezip = $scitystatezip . ", " . $sstate;
    }
    $scitystatezip = $sstate;
}
if ($szip!=""){
    if ($scitystatezip!=""){
        $scitystatezip = $scitystatezip . " " . $szip;
    }
    $scitystatezip = $szip;
}
$sphone1type = $agent->getField('phone1type');
$sphone1 = $agent->getField('phone1');
$sphone2type = $agent->getField('phone2type');
$sphone2 = $agent->getField('phone2');
$sphone3type = $agent->getField('phone3type');
$sphone3 = $agent->getField('phone3');
$semail = $agent->getField('email');

if ($stype=='Contracted'){
    $contractsummary = $agent->contractSummary($id);
    if(!empty($contractsummary)){
    	$contractcount =  $contractsummary['Count'];
    	$contractfirst =  $contractsummary['First'];
        $contractfirst_FY = date('F Y',strtotime($contractfirst));
    }
    $netsummary = $agent->netSummary($id);
    if(!empty($netsummary)){
    	$netbalance =  $netsummary['Balance'];
        $netbalance = number_format($netbalance, 2, '.', ',');
        $netdebit =  $netsummary['Debit'];
        $netdebit = number_format($netdebit, 0, '.', ',');
        $netdebit = '$'.$netdebit;
    }
    $bufsummary = $agent->bufSummary($id);
    if(!empty($bufsummary)){
    	$bufbalance =  $bufsummary['Balance'];
        $bufbalance = number_format($bufbalance, 2, '.', ',');
        $bufdebit =  $bufsummary['Debit'];
        $bufdebit = number_format($bufdebit, 0, '.', ',');
        $bufdebit = '$'.$bufdebit;
    }
}


include_once('classes/listbox.class.php');
$agentrejects = $listbox->getAgentrejects();
$sts = $listbox->getSts();
$phones = $listbox->getPhones();

//$s = $power->getField('');

include("header.php");

?>

        <script src="js/plugins/autonumeric/autoNumeric.js"></script>
        <script src="js/agent.js"></script>
        <script type="text/javascript">
            var AGENT_TYPE = "<?php echo $stype; ?>";
            var AGENT_COMPANY = "<?php echo $scompany; ?>";
            var AGENT_CONTACT = "<?php echo $scontact; ?>";
            var AGENT_ADDRESS = "<?php echo $saddress; ?>";
            var AGENT_CITY = "<?php echo $scity; ?>";
            var AGENT_STATE = "<?php echo $sstate; ?>";
            var AGENT_ZIP = "<?php echo $szip; ?>";
            var AGENT_PHONE1TYPE = "<?php echo $sphone1type; ?>";
            var AGENT_PHONE1 = "<?php echo $sphone1; ?>";
            var AGENT_PHONE2TYPE = "<?php echo $sphone2type; ?>";
            var AGENT_PHONE2 = "<?php echo $sphone2; ?>";
            var AGENT_PHONE3TYPE = "<?php echo $sphone3type; ?>";
            var AGENT_PHONE3 = "<?php echo $sphone3; ?>";
            var AGENT_EMAIL = "<?php echo $semail; ?>";
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
      									<i class="icon-th-large"></i>
      									Summary
      								</h3>
      							</div>
      								<div class="box-content">
                                    <div class="pull-left">
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
                                                    <?php if($stype=='Associate'){ ?>
                                                        <ul class="dropdown-menu dropdown-primary">
        													<li>
        														<a href="#" id="actions-delete-associate">Delete</a>
        													</li>
    												    </ul>
                                                    <?php } ?>
                                                    <?php if($stype=='Rejected'){ ?>
                                                        <ul class="dropdown-menu dropdown-primary">
                                                            <li>
        														<a href="#" id="actions-revert">Revert</a>
        													</li>
                                                            <li>
        														<a href="#" id="actions-delete-candidate">Delete</a>
        													</li>
    												    </ul>
                                                    <?php } ?>
                                                    <?php if($stype=='Candidate'){ ?>
                                                        <ul class="dropdown-menu dropdown-primary">
                                                            <li>
        														<a href="#" id="actions-contract">Contract</a>
        													</li>
                                                            <li>
        														<a href="#" id="actions-reject">Reject</a>
        													</li>
                                                            <li>
        														<a href="#" id="actions-delete-candidate">Delete</a>
        													</li>
    												    </ul>
                                                    <?php } ?>
                                                    <?php if($stype=='Contracted'){ ?>
                                                        <ul class="dropdown-menu dropdown-primary">
        													<li>
        														<a href="#" id="actions-delete-contracted">Delete</a>
        													</li>
    												    </ul>
                                                    <?php } ?>
    										    </div>
                                            </li>


                                            <?php if($stype=='Contracted'){ ?>

                                                <?php if($contractsummary!=''): ?>
                                                <li class='darkblue'>
            										<span class="count"><?php echo $contractcount; ?></span>
                    								<div class="details">
                    								    <span class="big">Contract(s)</span>
                    									<span>since <?php echo $contractfirst_FY; ?></span>
                    								</div>
            									</li>
                                                <?php endif ?>

                                                <?php if($netsummary!=''): ?>
                                                <li class='darkblue'>
            										<i class="icon-money"></i>
                    								<div class="details">
                    								    <span class="big"><?php echo $netbalance; ?> Net Balance</span>
                    									<span>Sum from <?php echo $netdebit; ?></span>
                    								</div>
            									</li>
                                                <?php endif ?>

                                                <?php if($bufsummary!=''): ?>
                                                <li class='darkblue'>
            										<i class="icon-money"></i>
                    								<div class="details">
                    								    <span class="big"><?php echo $bufbalance; ?> Buf Balance</span>
                    									<span>Sum from <?php echo $bufdebit; ?></span>
                    								</div>
            									</li>
                                                <?php endif ?>

                                            <?php } ?>

                                        </ul>
                                    </div>
      							</div>
      						</div>
                        </div>
                    </div>


                    <div class="row-fluid">
                        <div class="span6" id="detail-view">

                                <div class="box">
        							<div class="box-title">
        								<h3 id="detail-label"></h3>
                                        <div class="actions" id="detail-list-actions">
                                            <a class="btn btn-mini" href="javascript:LoadDetail(<?php echo $id; ?>)"; >
                                                <i class="icon-edit"></i>
                                            </a>
                                        </div>
        							</div>
                                    <div id="detail-list">
                                        <div class="box-content nopadding">
            								<div class='form-horizontal form-bordered'>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Company</label>
            										<div class="controls">
                                                        <p><?php echo $scompany; ?></p>
            										</div>
            									</div>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Contact</label>
            										<div class="controls">
                                                        <p><?php echo $scontact; ?></p>
            										</div>
            									</div>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Address</label>
            										<div class="controls">
                                                        <p><?php echo $saddress; ?></p>
            										</div>
                                                    <div class="controls">
                                                        <p><?php echo $scitystatezip; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Primary</label>
            										<div class="controls">
                                                        <p style="float:left;" class="phone"><?php echo $sphone1type; ?><?php echo $sphone1; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Secondry</label>
            										<div class="controls">
                                                        <p style="float:left;" class="phone"><?php echo $sphone2type; ?><?php echo $sphone2; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Phone Other</label>
            										<div class="controls">
                                                        <p style="float:left;" class="phone"><?php echo $sphone3type; ?><?php echo $sphone3; ?></p>
            										</div>
            									</div>

                                                 <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
            								</div>
            							</div>
                                    </div>

                                    <!-- id for *-box, insert window body, change class horizontal -->
                                    <div id='detail-box' style="display:none">
                                        <div class="row-fluid">
                                                <div class="box">
                                                    <div class="box-content nopadding">
                                        			    <form method="POST" class='form-horizontal form-bordered' id='detail-form'>
                                                           
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Company</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-company" id="detail-company" class="input-large span8" readonly>
                          										</div>
                          									</div>
                                                            
                                                      
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Contact</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-contact" id="detail-contact" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label"> Address</label>
                            										                                        						<div class="controls">
                                                                    <div class="row-fluid">
                                                                        <input type="text" name="detail-address" id="detail-address" class="input-large span11">
                                                                    </div>
                                                                </div>
                                                                <div class="controls" style="margin-top:-10px">
                                                                    <div class="row-fluid">
                                                                        <input type="text" name="detail-city" id="detail-city" class="input-large span4">
                                                                        <select name="detail-state" id="detail-state" class="select2-me" style="width:80px">
                                                                            <?php echo $sts; ?>
                                                                        </select>
                                                                        <input type="text" name="detail-zip" id="detail-zip" class="span3">
                                                                    </div>
                                                                </div>
                            								</div>
                                                                
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Primary</label>
                                        						<div class="controls">
                                                                    <select name="detail-phone1type" id="detail-phone1type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="detail-phone1" id="detail-phone1" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Secondary</label>
                                        						<div class="controls">
                                                                    <select name="detail-phone2type" id="detail-phone2type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="detail-phone2" id="detail-phone2" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                                
                                                            <div class="control-group">
                                        					    <label for="textfield" class="control-label">Phone Other</label>
                                        						<div class="controls">
                                                                    <select name="detail-phone3type" id="detail-phone3type" class="select2-me span6">
                								                        <?php echo $phones; ?>
                							                        </select>
                                        						    <input type="text" name="detail-phone3" id="detail-phone3" class="span6 mask_phone">
                                                                </div>
                                                            </div>
                                                                
                                                                                                                           
                                                            <input type="hidden" name="detail-type" id="detail-type" value="">
                                                            <input type="hidden" name="detail-id" id="detail-id" value="<?php echo $id; ?>">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-primary" id="detail-save">Save</button>
                        						                <button type="button" class="btn" id="detail-cancel">Cancel</button>
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

<div id="modal-confirm" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="confirm-form">
    <div class="modal-header">
	    <h3 id="modal-title"></h3>
	</div>
	<div class="modal-body">
        <p><strong>Confirm</strong></p>
        <p>Are you certain you want to continue?</p>
        <input type="hidden" name="agent-action" id="agent-action" value="">
        <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		<button type="submit" id="confirm-save" class="btn" data-dismiss="modal">Yes</button>
	</div>
</form>
</div>

<div id="modal-reject" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="reject-form">
    <div class="modal-header">
	    <h3 id="modal-title">Agent - Reject</h3>
	</div>
	<div class="modal-body">
        <p>Reason</p>
        <select name="agent-rejectreason-select" id="agent-rejectreason-select" class='select2-me input-xlarge' onkeyup="Rejectvalidate()" onblur="Rejectvalidate()" onclick="Rejectvalidate()">
                <?php echo $agentrejects; ?>
        </select>
        <input type="hidden" name="agent-action" id="agent-action" value="reject">
        <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="reject-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>


<div id="modal-revert" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="revert-form">
    <div class="modal-header">
	    <h3 id="modal-title">Agent - Revert</h3>
	</div>
	<div class="modal-body">
	    <p>Revert Transfer back to Candidate?</p>
        <input type="hidden" name="agent-action" id="agent-action" value="revert">
        <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="revert-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-contract" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="contract-form">
    <div class="modal-header">
	    <h3 id="modal-title">Agent - Contract</h3>
	</div>
	<div class="modal-body">
        <p>Net ($ on 1k)</p>
        <input type="text" name="agent-net" id="agent-net" class="input-large mask-rate" onkeyup="Contractvalidate()" onblur="Contractvalidate()" onclick="Contractvalidate()">
        <p>Net Minimum</p>
        <input type="text" name="agent-netminimum" id="agent-netminimum" class="input-large" onkeyup="Contractvalidate()" onblur="Contractvalidate()" onclick="Contractvalidate()">
        <p>BUF ($ on 1k)</p>
        <input type="text" name="agent-buf" id="agent-buf" class="input-large mask-rate" onkeyup="Contractvalidate()" onblur="Contractvalidate()" onclick="Contractvalidate()">
        <p>BUF Minimum</p>
        <input type="text" name="agent-bufminimum" id="agent-bufminimum" class="input-large" onkeyup="Contractvalidate()" onblur="Contractvalidate()" onclick="Contractvalidate()">

        <input type="hidden" name="agent-action" id="agent-action" value="contract">
        <input type="hidden" name="agent-id" id="agent-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="contract-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
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
