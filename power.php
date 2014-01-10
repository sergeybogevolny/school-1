<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/power.class.php');
$id = $power->getField('id');
$title = 'power';
$label = 'summary';

$stype = '';

$sprefix = $power->getField('prefix');
$sserial = $power->getField('serial');

$sordered = $power->getField('ordered');
if ($sordered!=""){
    $sordered = strtotime($sordered);
    $sordered  = date('m/d/Y', $sordered);
}
$sdistributed = $power->getField('distributed');
if ($sdistributed!=""){
    $sdistributed = strtotime($sdistributed);
    $sdistributed  = date('m/d/Y', $sdistributed);
}
$sagent = $power->getField('agent');
$scollected = $power->getField('collected');
if ($scollected!=""){
    $scollected = strtotime($scollected);
    $scollected  = date('m/d/Y', $scollected);
}
$sexecuted = $power->getField('executed');
if ($sexecuted!=""){
    $sexecuted = strtotime($sexecuted);
    $sexecuted  = date('m/d/Y', $sexecuted);
}
$sdefendant = $power->getField('defendant');
$samount = $power->getField('amount');
if ($samount!=''){
    if (strpos($samount, '.') !== TRUE){
        $samount = number_format($samount);
        $samount = $samount . '.00';
    } else {
        $samount = number_format($samount);
    }
    $samount = '$'.$samount;
}
$svoid = $power->getField('void');
$stransfer = $power->getField('transfer');
$sreported = $power->getField('reported');
if ($sreported!=""){
    $sreported = strtotime($sreported);
    $sreported  = date('m/d/Y', $sreported);
}
$sforfeitureid = $power->getField('forfeitureid');
$sforfeited = $power->getField('forfeited');
if ($sforfeited!=""){
    $sforfeited = strtotime($sforfeited);
    $sforfeited  = date('m/d/Y', $sforfeited);
}
$sreceived = $power->getField('received');
if ($sreceived!=""){
    $sreceived = strtotime($sreceived);
    $sreceived  = date('m/d/Y', $sreceived);
}
$sanswered = $power->getField('answered');
if ($sanswered!=""){
    $sanswered = strtotime($sanswered);
    $sanswered  = date('m/d/Y', $sanswered);
}
$sdocumentedlevel = $power->getField('documentedlevel');
$sdisposed = $power->getField('disposed');
if ($sdisposed!=""){
    $sdisposed = strtotime($sdisposed);
    $sdisposed  = date('m/d/Y', $sdisposed);
}
$stransferid = $power->getField('transferid');
$stransfered = $power->getField('transfered');
if ($stransfered!=""){
    $stransfered = strtotime($stransfered);
    $stransfered  = date('m/d/Y', $stransfered);
}
$srequestingagent = $power->getField('requestingagent');
$ssettled = $power->getField('settled');
if ($ssettled!=""){
    $ssettled = strtotime($ssettled);
    $ssettled  = date('m/d/Y', $ssettled);
}

$stransferamount = $power->getField('transferamount');
if ($stransferamount!=''){
    if (strpos($stransferamount, '.') !== TRUE){
        $stransferamount = number_format($stransferamount);
        $stransferamount = $stransferamount . '.00';
    } else {
        $stransferamount = number_format($stransferamount);
    }
    $stransferamount = '$'.$stransferamount;
}
$stransfertype = $power->getField('transfertype');
$stransferdate_FjY = $power->getField('forfeited');
if ($stransferdate_FjY!=""){
    $stransferdate_FjY = strtotime($stransferdate_FjY);
    $stransferdate_FjY  = date('F j, Y', $stransferdate_FjY);
}

$sforfeitureamount = $power->getField('forfeitureamount');
if ($sforfeitureamount!=''){
    if (strpos($sforfeitureamount, '.') !== TRUE){
        $sforfeitureamount = number_format($sforfeitureamount);
        $sforfeitureamount = $sforfeitureamount . '.00';
    } else {
        $sforfeitureamount = number_format($sforfeitureamount);
    }
    $sforfeitureamount = '$'.$sforfeitureamount;
}
$sforfeituretype = $power->getField('forfeituretype');
$sforfeituredate_FjY = $power->getField('forfeited');
if ($sforfeituredate_FjY!=""){
    $sforfeituredate_FjY = strtotime($sforfeituredate_FjY);
    $sforfeituredate_FjY  = date('F j, Y', $sforfeituredate_FjY);
}

//$s = $power->getField('');


include("header.php");

?>

        <script src="js/power.js"></script>
        <script type="text/javascript">
            var POWER_PREFIX = "<?php echo $sprefix; ?>";
            var POWER_SERIAL = "<?php echo $sserial; ?>";
            var POWER_ORDERED = "<?php echo $sordered; ?>";
            var POWER_DISTRIBUTED = "<?php echo $sdistributed; ?>";
            var POWER_AGENT = "<?php echo $sagent; ?>";
            var POWER_COLLECTED = "<?php echo $scollected; ?>";
            var POWER_EXECUTED = "<?php echo $sexecuted; ?>";
            var POWER_DEFENDANT = "<?php echo $sdefendant; ?>";
            var POWER_AMOUNT = "<?php echo $samount; ?>";
            var POWER_VOID = "<?php echo $svoid; ?>";
            var POWER_TRANSFER = "<?php echo $stransfer; ?>";
            var POWER_REPORTED = "<?php echo $sreported; ?>";
            var POWER_FORFEITED = "<?php echo $sforfeited; ?>";
            var POWER_RECEIVED = "<?php echo $sreceived; ?>";
            var POWER_ANSWERED = "<?php echo $sanswered; ?>";
            var POWER_DOCUMENTEDLEVEL = "<?php echo $sdocumentedlevel; ?>";
            var POWER_DISPOSED = "<?php echo $sdisposed; ?>";
            var POWER_TRANSFERED = "<?php echo $stransfered; ?>";
            var POWER_REQUESTINGAGENT = "<?php echo $srequestingagent; ?>";
            var POWER_SETTLED = "<?php echo $ssettled; ?>";
        </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/power-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/power-page-header.php'); ?>

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
                                                    <!--
                                                    <ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-dispatch">Dispatch</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-reject">Reject</a>
    													</li>
    												</ul>
                                                    -->
    										    </div>
                                            </li>
                                            <li class='button'>
                                                <div class="btn-group">
    												<a href="transfer.php?id=<?php echo $stransferid?>" class="btn btn-primary">
                                                        <i class="icon-random"></i>
              									        <div class="details">
              										        <span class="big"><strong><?php echo $stransferamount; ?> Transfer</strong></span>
              										        <span><?php echo ucwords($stransfertype).' - '.$stransferdate_FjY; ?></span>
              									        </div>
                                                    </a>
                                                </div>
              								</li>

                                            <li class='button'>
                                                <div class="btn-group">
    												<a href="forfeiture.php?id=<?php echo $sforfeitureid?>" class="btn btn-primary" style="padding-bottom:15px;">
                                                        <i class="glyphicon-bomb" style="margin-top:10px;"></i>
                    									<div class="details">
                    										<span class="big"><strong><?php echo $sforfeitureamount; ?> Forfeiture</strong></span>
                    										<span><?php echo ucwords($sforfeituretype).' - '.$sforfeituredate_FjY; ?></span>
                    									</div>
                                                    </a>
                                                </div>
              								</li>

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
                                            <a class="btn btn-mini" href="javascript:LoadDetail(<?php echo $id; ?>)"; class='btn'>
                                                <i class="icon-edit"></i>
                                            </a>
                                        </div>
        							</div>
                                    <div id="detail-list">
                                        <div class="box-content nopadding">
            								<div class='form-horizontal form-bordered'>
            									<div class="control-group">
            										<label for="textfield" class="control-label">Ordered</label>
            										<div class="controls">
                                                        <p><?php echo $sordered; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Distributed</label>
            										<div class="controls">
                                                        <p><?php echo $sdistributed; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Agent</label>
            										<div class="controls">
                                                        <p><?php echo $sagent; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Collected</label>
            										<div class="controls">
                                                        <p><?php echo $scollected; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Voided</label>
            										<div class="controls">
                                                        <p><?php echo $scollected; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Executed</label>
            										<div class="controls">
                                                        <p><?php echo $sexecuted; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Defendant</label>
            										<div class="controls">
                                                        <p><?php echo $sdefendant; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Amount</label>
            										<div class="controls">
                                                        <p><?php echo $samount; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Transfered</label>
            										<div class="controls">
                                                        <p><?php echo $stransfered; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Requesting Agent</label>
            										<div class="controls">
                                                        <p><?php echo $srequestingagent; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Settled</label>
            										<div class="controls">
                                                        <p><?php echo $ssettled; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Reported</label>
            										<div class="controls">
                                                        <p><?php echo $sreported; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Forfeited</label>
            										<div class="controls">
                                                        <p><?php echo $sforfeited; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Received</label>
            										<div class="controls">
                                                        <p><?php echo $sreceived; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Answered</label>
            										<div class="controls">
                                                        <p><?php echo $sanswered; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Documented</label>
            										<div class="controls">
                                                        <p><?php echo $sdocumentedlevel; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Disposed</label>
            										<div class="controls">
                                                        <p><?php echo $sdisposed; ?></p>
            										</div>
            									</div>

                                                <!--
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
                                                -->


                                                <input type="hidden" name="power-id" id="power-id" value="<?php echo $id; ?>">
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
                          										<label for="textfield" class="control-label">Ordered</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-ordered" id="detail-ordered" class="input-large span8" readonly>
                          										</div>
                          									</div>
                                                            <!--
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
                                                            -->

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



                    </div>
				</div>

			</div>
		</div>


<?php
include("footer.php");
?>
