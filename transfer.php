<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/transfer.class.php');
$id = $transfer->getField('id');
$title = 'transfer';
$label = 'summary';

include("header.php");
$stype = $transfer->getField('type');

$srecorded = $transfer->getField('recorded');
if ($srecorded!=""){
    $srecorded = strtotime($srecorded);
    $srecorded  = date('m/d/Y h:i A', $srecorded);
}
$srequestingagent = $transfer->getField('requestingagent');
$samount = $transfer->getField('amount');
if (strpos($samount, '.') !== TRUE){
    $samount = number_format($samount);
    $samount = $samount . '.00';
} else {
    $samount = number_format($samount);
}
$scounty = $transfer->getField('county');
$sdispatched = $transfer->getField('dispatched');
if ($sdispatched!=""){
    $sdispatched = strtotime($sdispatched);
    $sdispatched  = date('m/d/Y h:i A', $sdispatched);
};
$spostingagent = $transfer->getField('postingagent');
$srejected = $transfer->getField('rejected');
if ($srejected!=""){
    $srejected = strtotime($srejected);
    $srejected  = date('m/d/Y h:i A', $srejected);
};
$srejectedreason = $transfer->getField('rejectedreason');
$sposted = $transfer->getField('posted');
if ($sposted!=""){
    $sposted = strtotime($sposted);
    $sposted  = date('m/d/Y h:i A', $sposted);
};
$spostingfee = $transfer->getField('postingfee');
if (strpos($spostingfee, '.') !== TRUE){
    $spostingfee = number_format($spostingfee);
    $spostingfee = $spostingfee . '.00';
} else {
    $spostingfee = number_format($spostingfee);
}
$spostingreceived = $transfer->getField('postingreceived');
if (strpos($spostingreceived, '.') !== TRUE){
    $spostingreceived = number_format($spostingreceived);
    $spostingreceived = $spostingreceived . '.00';
} else {
    $spostingreceived = number_format($spostingreceived);
}
$sgeneralfee = $transfer->getField('generalfee');
if (strpos($sgeneralfee, '.') !== TRUE){
    $sgeneralfee = number_format($sgeneralfee);
    $sgeneralfee = $sgeneralfee . '.00';
} else {
    $sgeneralfee = number_format($sgeneralfee);
}
$sgeneralreceived = $transfer->getField('generalreceived');
if (strpos($sgeneralreceived, '.') !== TRUE){
    $sgeneralreceived = number_format($sgeneralreceived);
    $sgeneralreceived = $sgeneralreceived . '.00';
} else {
    $sgeneralreceived = number_format($sgeneralreceived);
}
$ssettled = $transfer->getField('settled');
if ($ssettled!=""){
    $ssettled = strtotime($ssettled);
    $ssettled  = date('m/d/Y h:i A', $ssettled);
};
$ssettledreason = $transfer->getField('settledreason');

$sprefix = $transfer->getField('prefix');
$sserial = $transfer->getField('serial');
$spowerid = $transfer->getField('power_id');
if($spowerid != NULL){
	$spowername  =   $transfer->getPowerName($spowerid);
}else{
	$spowername  = '';
}

$scomment = $transfer->getField('comment');
$scomment = str_replace('"', "'", $scomment);

if (isset($_POST['editor']) && !empty($_POST['editor'])) {
	if (isset($_POST['editor'])) {
         $scomment = $_POST['editor'];
	}
}

include_once('classes/listbox.class.php');
$agents = $listbox->getGeneral_Agents();
$counties = $listbox->getCounties();
$transferrejects = $listbox->getTransferrejects();
$transfersettles = $listbox->getTransfersettles();


?>

        <script src="js/plugins/autonumeric/autoNumeric.js"></script>
        <script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/transfer.js"></script>
        <script type="text/javascript">
            var TRANSFER_TYPE = "<?php echo $stype; ?>";
            var TRANSFER_RECORDED = "<?php echo $srecorded; ?>";
            var TRANSFER_REQUESTINGAGENT = "<?php echo $srequestingagent; ?>";
            var TRANSFER_AMOUNT = "<?php echo $samount; ?>";
            var TRANSFER_COUNTY = "<?php echo $scounty; ?>";
            var TRANSFER_DISPATCHED = "<?php echo $sdispatched; ?>";
            var TRANSFER_POSTINGAGENT = "<?php echo $spostingagent; ?>";
            var TRANSFER_REJECTED = "<?php echo $srejected; ?>";
            var TRANSFER_REJECTEDREASON = "<?php echo $srejectedreason; ?>";
            var TRANSFER_POSTED = "<?php echo $sposted; ?>";
            var TRANSFER_POSTINGFEE = "<?php echo $spostingfee; ?>";
            var TRANSFER_POSTINGRECEIVED = "<?php echo $spostingreceived; ?>";
            var TRANSFER_GENERALFEE = "<?php echo $sgeneralfee; ?>";
            var TRANSFER_GENERALRECEIVED = "<?php echo $sgeneralreceived; ?>";
            var TRANSFER_SETTLED = "<?php echo $ssettled; ?>";
            var TRANSFER_SETTLEDREASON = "<?php echo $ssettledreason; ?>";
            var TRANSFER_PREFIX = "<?php echo $sprefix; ?>";
            var TRANSFER_SERIAL = "<?php echo $sserial; ?>";
            var TRANSFER_POWERID = "<?php echo $spowerid; ?>";
            var TRANSFER_POWER = "<?php echo $spowername; ?>";
        </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/transfer-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/transfer-page-header.php'); ?>

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
                                        <?php if ($stype=='recorded') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-dispatch">Dispatch</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-reject">Reject</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-recorded">Delete</a>
    													</li>
    												</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='dispatched') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-post">Post</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-dispatched">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='rejected') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-revert">Revert</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-rejected">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='posted') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-settle">Settle</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-posted">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='settled') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    											        <li>
    														<a href="#" id="actions-delete-settled">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                            <li class='button'>
                                                <div class="btn-group">
                                                	<a href="power.php?id=<?php echo $spowerid; ?>" class="btn btn-primary">
                                                        <i class="icon-barcode"></i>
                    									<div class="details" style="margin-left:60;margin-top:5px;padding-right:5px;">
                                                	        <span class="big"><strong><?php echo $sprefix.'-'.$sserial; ?></strong></span>
            										        <span>Power</span>
                                                        </div>
                                                    </a>
            									</div>
            								</li>

                                        </ul>
                                        <?php
                                        }
                                        ?>
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
                                            <a class="btn btn-mini" href="javascript:LoadDetail(<?php echo $id; ?>)"; class='btn'>
                                                <i class="icon-edit"></i>
                                            </a>
                                        </div>
        							</div>
                                    <div id="detail-list">
                                        <div class="box-content nopadding">
            								<div class='form-horizontal form-bordered'>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Recorded</label>
            										<div class="controls">
                                                        <p><?php echo $srecorded; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Requesting Agent</label>
            										<div class="controls">
                                                        <p><?php echo $srequestingagent; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Amount</label>
            										<div class="controls">
                                                        <p><?php echo $samount; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">County</label>
            										<div class="controls">
                                                        <p><?php echo $scounty; ?></p>
            										</div>
            									</div>
                                                <?php
                                                    if ($sdispatched!=''){
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Dispatched</label>
                    										<div class="controls">
                                                                <p><?php echo $sdispatched; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Posting Agent</label>
                    										<div class="controls">
                                                                <p><?php echo $spostingagent; ?></p>
                    										</div>
                    									</div>
                                                        <?php
                                                    }
                                                ?>
                                                <?php
                                                    if (($srejected!='')) {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Rejected</label>
                    										<div class="controls">
                                                                <p><?php echo $srejected; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Rejected Reason</label>
                    										<div class="controls">
                                                                <p><?php echo $srejectedreason; ?></p>
                    										</div>
                    									</div>
                                                        <?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($sposted!='') {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Posted</label>
                    										<div class="controls">
                                                                <p><?php echo $sposted; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Posting Agent Fee</label>
                    										<div class="controls">
                                                                <p><?php echo $spostingfee; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Posting Agent Received</label>
                    										<div class="controls">
                                                                <p><?php echo $spostingreceived; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">General Agent Fee</label>
                    										<div class="controls">
                                                                <p><?php echo $sgeneralfee; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">General Agent Received</label>
                    										<div class="controls">
                                                                <p><?php echo $sgeneralreceived; ?></p>
                    										</div>
                    									</div>

                                                        <?php if($spowerid!=''){
                                                        ?>
                                                            <div class="control-group">
                            								    <label for="textfield" class="control-label">Power</label>
                            									<div class="controls">
                                                                    <p><?php echo $spowername; ?></p>
                            									</div>
                            								</div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="control-group">
                        										<label for="textfield" class="control-label">Prefix</label>
                        										<div class="controls">
                                                                    <p><?php echo $sprefix; ?></p>
                        										</div>
                        									</div>
                                                            <div class="control-group">
                        										<label for="textfield" class="control-label">Serial</label>
                        										<div class="controls">
                                                                    <p><?php echo $sserial; ?></p>
                        										</div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
														<?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($ssettled!='') {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Settled</label>
                    										<div class="controls">
                                                                <p><?php echo $ssettled; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Settled Reason</label>
                    										<div class="controls">
                                                                <p><?php echo $ssettledreason; ?></p>
                    										</div>
                    									</div>
                                                        <?php
                                                    }
                                                ?>
                                                <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
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
                          										<label for="textfield" class="control-label">Recorded</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-recorded" id="detail-recorded" class="input-large span8" readonly>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Requesting Agent</label>
                          										<div class="controls">
                                                                    <select name="detail-requestingagent-select" id="detail-requestingagent-select" class="select2-me input-large" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()">
                                                                        <?php echo $agents; ?>
                                                                    </select>
                                                                </div>
                            								</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Amount</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-amount" id="detail-amount" class="input-large span8" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='dispatched') || ($stype=='rejected') || ($stype=='posted') || ($stype=='settled')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">County</label>
                          										<div class="controls">
                                                                    <select name="detail-county-select" id="detail-county-select" class="select2-me input-large" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" >
                                                                        <?php echo $counties; ?>
                                                                    </select>
                                                                </div>
                            								</div>
                                                            <?php
                                                            if (($sdispatched!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Dispatched</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-dispatched" id="detail-dispatched" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Posting Agent</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-postingagent" id="detail-postingagent" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($srejected!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Rejected</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-rejected" id="detail-rejected" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Rejected Reason</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-rejectedreason" id="detail-rejectedreason" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($sposted!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Posted</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-posted" id="detail-posted" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Posting Agent Fee</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-postingagent-fee" id="detail-postingagent-fee" class="input-large span8" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='settled')) { echo 'readonly'; }?>>
                            										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Posting Agent Received</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-postingagent-received" id="detail-postingagent-received" class="input-large span8" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='settled')) { echo 'readonly'; }?>>
                            										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">General Agent Fee</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-generalagent-fee" id="detail-generalagent-fee" class="input-large span8" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='settled')) { echo 'readonly'; }?>>
                            										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">General Agent Received</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-generalagent-received" id="detail-generalagent-received" class="input-large span8" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='settled')) { echo 'readonly'; }?>>
                            										</div>
                            									</div>
                                                                <?php if($spowerid!=''){
                                                                ?>
                                                                    <div class="control-group">
                                    								    <label for="textfield" class="control-label">Power</label>
                                    									<div class="controls">
                                                                            <input type="text" name="detail-power" id="detail-power" class="input-large span8" readonly>
                                    									</div>
                                    								</div>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="control-group">
                                  										<label for="textfield" class="control-label">Prefix</label>
                                  										<div class="controls">
                                                                              <input type="text" name="detail-prefix" id="detail-prefix" class="input-large span8">
                                  										</div>
                                  									</div>
                                                                    <div class="control-group">
                                  										<label for="textfield" class="control-label">Serial</label>
                                  										<div class="controls">
                                                                              <input type="text" name="detail-serial" id="detail-serial" class="input-large span8">
                                  										</div>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($ssettled!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Settled</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-settled" id="detail-settled" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Settle Reason</label>
                            										<div class="controls">
                                                                        <input type="text" name="detail-settledreason" id="detail-settledreason" class="input-large span8" readonly>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <input type="hidden" name="detail-type" id="detail-type" value="">
                                        				    <input type="hidden" name="detail-id" id="detail-id" value="">
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

                            <div class="span6" id="comment-view">

                                <div class="box">
        							<div class="box-title">
        								<h3 id="comment-label"></h3>
                                        <div class="actions" id="comment-list-actions">
                                            <a class="btn btn-mini" href="javascript:LoadComment(<?php echo $id; ?>)"; class='btn'>
                                                <i class="icon-edit"></i>
                                            </a>
                                        </div>
                                        <div class="actions" id="comment-box-actions">
                                            <a class="btn btn-mini" href="#"; class='btn' id="comment-cancel">
                                                <i class="icon-remove"></i>
                                            </a>
                                        </div>
        							</div>

                                    <div id="comment-list">
                                        <div class="box-content" id="comment-value">
                                            <?php echo $scomment; ?>
            							</div>
                                    </div>

                                    <!-- id for *-box, insert window body, change class horizontal -->
                                    <div id='comment-box' style="display:none">
                                        <div class="row-fluid">
                                                <div class="box">
                                                    <div class="box-content nopadding">
                                        			    <form method="POST" action="" name="editor_form" id="editor_name">
                        								<textarea cols="80" id="editor" name="editor" rows="10"></textarea>
                        				                <input type="hidden" name="comment-id" id="comment-id" value="<?php echo $id; ?>">
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
        <input type="hidden" name="transfer-action" id="transfer-action" value="">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		<button type="submit" id="confirm-save" class="btn" data-dismiss="modal">Yes</button>
	</div>
</form>
</div>

<div id="modal-dispatch" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="dispatch-form">
    <div class="modal-header">
	    <h3 id="modal-title">Transfer - Dispatch</h3>
	</div>
	<div class="modal-body">
	    <p>Posting Agent</p>
        <select name="transfer-postingagent-select" id="transfer-postingagent-select" class='select2-me input-xlarge'>
		    <?php echo $agents; ?>
    	</select>
        <input type="hidden" name="transfer-postingagent-id" id="transfer-postingagent-id" value="<?php echo $id; ?>">
        <input type="hidden" name="transfer-action" id="transfer-action" value="dispatch">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="dispatch-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-reject" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="reject-form">
    <div class="modal-header">
	    <h3 id="modal-title">Transfer - Reject</h3>
	</div>
	<div class="modal-body">
	    <p>Reason</p>
        <select name="transfer-rejectreason-select" id="transfer-rejectreason-select" class='select2-me input-xlarge' onkeyup="Rejectvalidate()" onblur="Rejectvalidate()" onclick="Rejectvalidate()">
		    <?php echo $transferrejects; ?>
    	</select>
        <input type="hidden" name="transfer-action" id="transfer-action" value="reject">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
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
	    <h3 id="modal-title">Transfer - Revert</h3>
	</div>
	<div class="modal-body">
	    <p>Revert Transfer back to Recorded?</p>
        <input type="hidden" name="transfer-action" id="transfer-action" value="revert">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="revert-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-post" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="post-form">
    <div class="modal-header">
	    <h3 id="modal-title">Transfer - Post</h3>
	</div>
	<div class="modal-body">
        <p>Posting Agent Fee</p>
        <input type="text" name="transfer-posting-amount" id="transfer-posting-amount" class="input-large span2" onkeyup="Postvalidate()" onblur="Postvalidate()" onclick="Postvalidate()">
        <p>General Agent Fee</p>
        <input type="text" name="transfer-general-amount" id="transfer-general-amount" class="input-large span2" onkeyup="Postvalidate()" onblur="Postvalidate()" onclick="Postvalidate()">

        <input type="hidden" name="transfer-action" id="transfer-action" value="post">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="post-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-settle" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="settle-form">
    <div class="modal-header">
	    <h3 id="modal-title">Transfer - Settle</h3>
	</div>
	<div class="modal-body">
        <div id="settle-invalid" style="display:none;">
            <p>Power has not been identified.</p>
        </div>
        <div id="settle-valid" style="display:none;">
            <p>Reason</p>
            <select name="transfer-settlereason-select" id="transfer-settlereason-select" class='select2-me input-xlarge' onkeyup="Settlevalidate()" onblur="Settlevalidate()" onclick="Settlevalidate()">
                <?php echo $transfersettles; ?>
            </select>
        </div>
        <input type="hidden" name="power-id" id="power-id" value="">
        <input type="hidden" name="transfer-action" id="transfer-action" value="settle">
        <input type="hidden" name="transfer-id" id="transfer-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="settle-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<script type="text/javascript">
    CKEDITOR.replace( 'editor',
        {toolbar: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Save', 'NewPage', 'Preview', 'Print' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
          	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
          	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
          	{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
          	{ name: 'tools', items: [ 'Maximize' ] },
          	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
          	{ name: 'others', items: [ '-' ] },
          	'/',
          	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
          	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
          	{ name: 'styles', items: [ 'Styles', 'Format' ] }
        ]}
    );
</script>


<?php
include("footer.php");
?>
