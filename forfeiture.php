<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/forfeiture.class.php');
$id = $forfeiture->getField('id');
$title = 'forfeiture';
$label = 'summary';

include("header.php");

$stype = $forfeiture->getField('type');

$srecorded = $forfeiture->getField('recorded');
if ($srecorded!=""){
    $srecorded = strtotime($srecorded);
    $srecorded  = date('m/d/Y h:i A', $srecorded);
}
$sreceived = $forfeiture->getField('received');
if ($sreceived!=""){
    $sreceived = strtotime($sreceived);
    $sreceived  = date('m/d/Y', $sreceived);
}
$scivilcasenumber = $forfeiture->getField('civilcasenumber');
$sforfeited = $forfeiture->getField('forfeited');
if ($sforfeited!=""){
    $sforfeited = strtotime($sforfeited);
    $sforfeited  = date('m/d/Y', $sforfeited);
}
$scounty = $forfeiture->getField('county');
$samount = $forfeiture->getField('amount');
$samount = number_format($samount, 2, '.', ',');
$sdefendant = $forfeiture->getField('defendant');
$sprefix = $forfeiture->getField('prefix');
$sserial = $forfeiture->getField('serial');
$squestioned = $forfeiture->getField('questioned');
if ($squestioned!=""){
    $squestioned = strtotime($squestioned);
    $squestioned  = date('m/d/Y', $squestioned);
}
$squestionedagent = $forfeiture->getField('questionedagent');
$scharged = $forfeiture->getField('charged');
if ($scharged!=""){
    $scharged = strtotime($scharged);
    $scharged  = date('m/d/Y', $scharged);
}
$spostingagent = $forfeiture->getField('postingagent');
$sdocumented= $forfeiture->getField('documented');
if ($sdocumented!=""){
    $sdocumented = strtotime($sdocumented);
    $sdocumented  = date('m/d/Y', $sdocumented);
}
$sdocumentedlevel= $forfeiture->getField('documentedlevel');
$sdocumentedlevel_ufirst = ucwords($sdocumentedlevel);
$shearing = $forfeiture->getField('hearing');
$shearing_mdYhiA = $shearing;
if ($shearing_mdYhiA!=""){
    $shearing_mdYhiA = strtotime($shearing_mdYhiA);
    $shearing_mdYhiA  = date('m/d/Y h:i A', $shearing_mdYhiA);
}
$shearing_meridian = $shearing;
if ($shearing_meridian!=""){
    $shearing_meridian = strtotime($shearing_meridian);
    $shearing_meridian  = date('d F Y - h:i A', $shearing_meridian);
}
$sdisposed = $forfeiture->getField('disposed');
if ($sdisposed!=""){
    $sdisposed = strtotime($sdisposed);
    $sdisposed  = date('m/d/Y', $sdisposed);
}
$sanswered= $forfeiture->getField('answered');
if ($sanswered!=""){
    $sanswered = strtotime($sanswered);
    $sanswered  = date('m/d/Y', $sanswered);
}
$sdisposedreason = $forfeiture->getField('disposedreason');

$spowerid = $forfeiture->getField('power_id');
if($spowerid != NULL){
	$spowername  =   $forfeiture->getPowerName($spowerid);
}else{
	$spowername  = '';
}

$scivilcitationfile = $forfeiture->getField('civilcitation');
if ($scivilcitationfile!=''){
    $scivilcitationfile = 'documents/forfeitures/'.$id.'/'.$scivilcitationfile;
}

$sanswerfile = $forfeiture->getField('answer');
if ($sanswerfile!=''){
    $sanswerfile = 'documents/forfeitures/'.$id.'/'.$sanswerfile;
}
$sdisposefile = $forfeiture->getField('document_disposed');
if ($sdisposefile!=''){
    $sdisposefile = 'documents/forfeitures/'.$id.'/'.$sdisposefile;
}
$scomment = $forfeiture->getField('comment');
$scomment = str_replace('"', "'", $scomment);

if (isset($_REQUEST['editor']) && !empty($_REQUEST['editor'])) {
	if (isset($_REQUEST['comment-update']) && $_REQUEST['comment-update'] == '1') {
         $scomment = $_REQUEST['editor'];
	}
}

$sdocument_hearing = $forfeiture->getField('document_hearing');
$document = array_filter(explode("|", $sdocument_hearing));
$docCount = 1;
//echo '<pre>' ; print_r($document);

include_once('classes/listbox.class.php');
$agents = $listbox->getGeneral_Agents();
$forfeituredisposes = $listbox->getForfeituredisposes();


?>
         <script src="js/ajaxupload.js"></script>
        <script src="js/plugins/autonumeric/autoNumeric.js"></script>
        <script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/forfeiture.js"></script>
        <script type="text/javascript">
            var FORFEITURE_RECORDED = "<?php echo $srecorded; ?>";
            var FORFEITURE_RECEIVED = "<?php echo $sreceived; ?>";
            var FORFEITURE_CIVILCASENUMBER = "<?php echo $scivilcasenumber; ?>";
            var FORFEITURE_FORFEITED = "<?php echo $sforfeited; ?>";
            var FORFEITURE_COUNTY = "<?php echo $scounty; ?>";
            var FORFEITURE_AMOUNT = "<?php echo $samount; ?>";
            var FORFEITURE_DEFENDANT = "<?php echo $sdefendant; ?>";
            var FORFEITURE_PREFIX = "<?php echo $sprefix; ?>";
            var FORFEITURE_SERIAL = "<?php echo $sserial; ?>";
            var FORFEITURE_QUESTIONED = "<?php echo $squestioned; ?>";
            var FORFEITURE_QUESTIONEDAGENT = "<?php echo $squestionedagent; ?>";
            var FORFEITURE_CHARGED = "<?php echo $scharged; ?>";
            var FORFEITURE_POSTINGAGENT = "<?php echo $spostingagent; ?>";
            var FORFEITURE_DOCUMENTED = "<?php echo $sdocumented; ?>";
            var FORFEITURE_DOCUMENTEDLEVEL = "<?php echo $sdocumentedlevel; ?>";
            var FORFEITURE_HEARING = "<?php echo $shearing_meridian; ?>";
            var FORFEITURE_ANSWERED = "<?php echo $sanswered; ?>";
            var FORFEITURE_DISPOSED = "<?php echo $sdisposed; ?>";
            var FORFEITURE_DISPOSEDREASON = "<?php echo $sdisposedreason; ?>";
            var FORFEITURE_POWERID = "<?php echo $spowerid; ?>";
            var FORFEITURE_POWER = "<?php echo $spowername; ?>";
        </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/forfeiture-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/forfeiture-page-header.php'); ?>

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
    														<a href="#" id="actions-question">Question</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-charge">Charge</a>
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
                                        <?php if ($stype=='questioned') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-charge">Charge</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-revert">Revert</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-questioned">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='charged') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-document">Document</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-charged">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                            <li class='button'>
                                                <div class="btn-group">
                                                	<a href="#" class="btn btn-primary">
                                                        <i class="icon-barcode"></i>
                    									<div class="details" style="margin-left:60;padding-right:5px;">
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
                                        <?php if ($stype=='documented') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    													<li>
    														<a href="#" id="actions-dispose">Dispose</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-documented">Delete</a>
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
                                        <?php if ($stype=='disposed') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
    											        <li>
    														<a href="#" id="actions-delete-disposed">Delete</a>
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
            										<label for="textfield" class="control-label">Received</label>
            										<div class="controls">
                                                        <p style="float:left;"><?php echo $sreceived; ?></p>
                                                        <div class="btn-group" style="float:right;">
                                                            <a href="<?php echo $scivilcitationfile; ?>" class="btn btn-primary" id="civilcitation-view" target="_blank"><img src='img/document_buttongroup_white.png'></a>
                                                        </div>
                                                    </div>

            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Civil Case Number</label>
            										<div class="controls">
                                                        <p><?php echo $scivilcasenumber; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Forfeited</label>
            										<div class="controls">
                                                        <p><?php echo $sforfeited; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">County</label>
            										<div class="controls">
                                                        <p><?php echo $scounty; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Amount</label>
            										<div class="controls">
                                                        <p><?php echo $samount; ?></p>
            										</div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Defendant</label>
            										<div class="controls">
                                                        <p><?php echo $sdefendant; ?></p>
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
                                                    if ($squestioned!=''){
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Questioned</label>
                    										<div class="controls">
                                                                <p><?php echo $squestioned; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Questioned Agent</label>
                    										<div class="controls">
                                                                <p><?php echo $squestionedagent; ?></p>
                    										</div>
                    									</div>
                                                        <?php
                                                    }
                                                ?>
                                                <?php
                                                    if (($scharged!='')) {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Charged</label>
                    										<div class="controls">
                                                                <p><?php echo $scharged; ?></p>
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
                                                    if ($sdocumented!='') {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Documented</label>
                    										<div class="controls">
                                                                <p><?php echo $sdocumented; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Level</label>
                    										<div class="controls">
                                                                <p><?php echo $sdocumentedlevel_ufirst; ?></p>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Answered</label>
                    										<div class="controls">
                                                                <p style="float:left;"><?php echo $sanswered; ?></p>
                                                                <div class="btn-group" style="float:right;">
                                                                    <a href="<?php echo $sanswerfile; ?>" class="btn btn-primary" id="answer-view" target="_blank"><img src='img/document_buttongroup_white.png'></a>
                                                                </div>
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Hearing</label>
                    										<div class="controls">
                                                                <p style="float:left;"><?php echo $shearing_mdYhiA; ?></p>
                                                                
                                                                <div class="btn-group"  style="float:right;">
                                                            	    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><img src='img/document_buttongroup_white.png'></a>
                                                                    <ul class="dropdown-menu dropdown-primary pull-right">

                                                                       <?php foreach ($document as $doc) {?>

                                                                            <?php $doc2 =  explode("#",$doc);

																			 ?>
                                                                        <li>
                                                                            <a href="documents/forfeitures/<?php echo $id.'/'.$doc2[0]; ?>" class="document-view" target="_blank"><?php echo $doc2[1]; ?></a>
                                                                        </li>
                                                                       <?php $docCount++;   } ?>

                                                                        <li>
                                                                            <a href="#" onclick="upload()" class="document-upload"><i class="icon-upload"></i> Upload</a>
                                                                        </li>
                                                            		</ul>
                                                            	</div>                                                                
                    										</div>
                    									</div>
                                                        

                                                        <?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($sdisposed!='') {
                                                        ?>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Disposed</label>
                    										<div class="controls">
                                                                <p style="float:left"><?php echo $sdisposed; ?></p>
                                                                <div class="btn-group" style="float:right;">
                                                                    <a href="<?php echo $sdisposefile; ?>" class="btn btn-primary" id="answer-view" target="_blank"><img src='img/document_buttongroup_white.png'></a>
                                                                </div>                                                                
                    										</div>
                    									</div>
                                                        <div class="control-group">
                    										<label for="textfield" class="control-label">Disposed Reason</label>
                    										<div class="controls">
                                                                <p><?php echo $sdisposedreason; ?></p>
                    										</div>
                    									</div>
                                                        <?php
                                                    }
                                                ?>
                                                <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
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
                                                                      <input type="text" name="detail-recorded" id="detail-recorded" class="input-large span12" readonly>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Received</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-received" id="detail-received" class="input-large span12 datepicker" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='charged') || ($stype=='questioned') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Civil Case Number</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-civilcasenumber" id="detail-civilcasenumber" class="input-large span12" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='charged') || ($stype=='questioned') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Forfeited</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-forfeited" id="detail-forfeited" class="input-large span12 datepicker" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='charged') || ($stype=='questioned') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">County</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-county" id="detail-county" class="input-large span12" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='charged') || ($stype=='questioned') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Amount</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-amount" id="detail-amount" class="input-large span12" onkeyup="Detailvalidate()" onblur="Detailvalidate()" onclick="Detailvalidate()" <?php if (($stype=='charged') || ($stype=='questioned') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Defendant</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-defendant" id="detail-defendant" class="input-large span12" <?php if (($stype=='charged') || ($stype=='documented')) { echo 'readonly'; }?>>
                          										</div>
                          									</div>

                                                            <?php if($spowerid!=''){
                                                            ?>
                                                                <div class="control-group">
                                								    <label for="textfield" class="control-label">Power</label>
                                									<div class="controls">
                                                                        <input type="text" name="detail-power" id="detail-power" class="input-large span12" readonly>
                                									</div>
                                								</div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="control-group">
                              										<label for="textfield" class="control-label">Prefix</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-prefix" id="detail-prefix" class="input-large span12">
                              										</div>
                              									</div>
                                                                <div class="control-group">
                              										<label for="textfield" class="control-label">Serial</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-serial" id="detail-serial" class="input-large span12">
                              										</div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($squestioned!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Questioned</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-questioned" id="detail-questioned" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Questioned Agent</label>
                            										<div class="controls">
                                                                          <input type="text" name="detail-questionedagent" id="detail-questionedagent" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($scharged!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Charged</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-charged" id="detail-charged" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                            										<label for="textfield" class="control-label">Posting Agent</label>
                            										<div class="controls">
                                                                          <input type="text" name="detail-postingagent" id="detail-postingagent" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if (($sdocumented!='')) {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Documented</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-documented" id="detail-documented" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Level</label>
                              										<div class="controls">
                                                                          <input type="text" name="detail-documentedlevel" id="detail-documentedlevel" class="input-large span12" readonly>
                              										</div>
                            									</div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Hearing</label>
                              										<div class="controls">
                                                                        <input type="text" value="" class="span12" name="detail-hearing" id="detail-hearing" data-date-format="yyyy-mm-dd HH:ii" <?php if ($stype!='documented') { echo 'readonly'; }?>>
                              										</div>
                            									</div>
                                                                <?php
                                                            }
                                                            ?>
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
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		<button type="submit" id="confirm-save" class="btn" data-dismiss="modal">Yes</button>
	</div>
</form>
</div>

<div id="modal-question" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="question-form">
    <div class="modal-header">
	    <h3 id="modal-title">Forfeiture - Question</h3>
	</div>
	<div class="modal-body">
        <p>Questioned Agent</p>
        <select name="forfeiture-questionedagent-select" id="forfeiture-questionedagent-select" class="select2-me input-large" onkeyup="Questionvalidate()" onblur="Questionvalidate()" onclick="Questionvalidate()">
            <?php echo $agents; ?>
        </select>
        <input type="hidden" name="forfeiture-questionedagent-id" id="forfeiture-questionedagent-id" value="">
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="question">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="question-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-charge" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="charge-form">
    <div class="modal-header">
	    <h3 id="modal-title">Forfeiture - Charge</h3>
	</div>
	<div class="modal-body">
        <div id="charge-status"></div>
        <input type="hidden" name="power-id" id="power-id" value="">
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="charge">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="charge-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-revert" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="revert-form">
    <div class="modal-header">
	    <h3 id="modal-title">Forfeiture - Revert</h3>
	</div>
	<div class="modal-body">
	    <p>Revert Forfeiture back to Recorded?</p>
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="revert">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="revert-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-document" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Forfeiture - Document Answer</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Answered</label>
            <div class="controls">
                <input type="text" name="forfeiture-answerdate" id="forfeiture-answerdate" class="input-large span4 datepicker" onkeyup="Documentvalidate()" onblur="Documentvalidate()" onclick="Documentvalidate()">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
<!--               <input type="file"  name="fileToUpload" id="fileToUpload" onchange="saveFile()"/>
-->                <input type="file" name="forfeiture-answer-file" id="forfeiture-answer-file" onchange="Documentvalidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="document">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="document-save" class="btn btn-primary" data-dismiss="modal" onclick="saveFile(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>

<div id="modal-dispose" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="dispose-form">
    <div class="modal-header">
	    <h3 id="modal-title">Forfeiture - Dispose</h3>
	</div>
	<div class="modal-body">
       <div class="control-group">
            <label for="textfield" class="control-label">Reason</label>
          <div class="controls">
            <select name="forfeiture-disposereason-select" id="forfeiture-disposereason-select" class='select2-me input-xlarge' onkeyup="Disposevalidate()" onblur="Disposevalidate()" onclick="Disposevalidate()">
                    <?php echo $forfeituredisposes; ?>
            </select>
            </div>
       </div> 
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
              <input type="file" name="forfeiture-dispose-file" id="forfeiture-dispose-file" onchange="Disposevalidate()" />
            </div>
        </div> 
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="dispose">
        <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
               
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="dispose-save" class="btn btn-primary" data-dismiss="modal"  onclick="saveDisposeDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>

<div id="modal-upload" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="document-bin-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Hearing</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="bin-name" id="bin-name" class="input-large span4" onkeyup="Binvalidate()" onblur="Binvalidate()" onclick="Binvalidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="bin-upload" id="bin-upload" onchange="Binvalidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="forfeiture-action" id="forfeiture-action" value="bindocument">
        <input type="hidden" name="bin-id" id="bin-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="bin-save" class="btn btn-primary" data-dismiss="modal" onclick="saveBinDoc(<?php echo $id; ?>)">Save</button>
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
