<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/supplement.class.php');
$id = $supplement->getField('id');
$title = 'supplement';
$label = 'summary';

include("header.php");

$stype = $supplement->getField('type');
$srecorded = $supplement->getField('recorded');
if ($srecorded!=""){
    $srecorded = strtotime($srecorded);
    $srecorded  = date('m/d/Y h:i A', $srecorded);
}
$sdocumentrecorded = $supplement->getField('document_recorded');
if ($sdocumentrecorded!=''){
    $sdocumentrecorded = 'documents/supplements/'.$id.'/'.$sdocumentrecorded;
}
$spayer = $supplement->getField('payer');
$sdefendant = $supplement->getField('defendant');
$samount = $supplement->getField('amount');
$samount = number_format($samount, 2, '.', ',');
$scontracted = $supplement->getField('contracted');
if ($scontracted!=""){
    $scontracted = strtotime($scontracted);
    $scontracted  = date('m/d/Y h:i A', $scontracted);
}
$sdocumentcontracted = $supplement->getField('document_contracted');
if ($sdocumentcontracted!=''){
    $sdocumentcontracted = 'documents/supplements/'.$id.'/'.$sdocumentcontracted;
}
$sbilled = $supplement->getField('billed');
if ($sbilled!=""){
    $sbilled = strtotime($sbilled);
    $sbilled  = date('m/d/Y h:i A', $sbilled);
}

$scomment = $supplement->getField('comment');
$scomment = str_replace('"', "'", $scomment);

if (isset($_REQUEST['editor']) && !empty($_REQUEST['editor'])) {
	if (isset($_REQUEST['comment-update']) && $_REQUEST['comment-update'] == '1') {
         $scomment = $_REQUEST['editor'];
	}
}


?>
        <script src="js/ajaxupload.js"></script>
        <script src="js/plugins/autonumeric/autoNumeric.js"></script>
        <script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>
        <script src="js/supplement.js"></script>
        <script type="text/javascript">
            var SUPPLEMENT_TYPE = "<?php echo $stype; ?>";
            var SUPPLEMENT_RECORDED = "<?php echo $srecorded; ?>";
            var SUPPLEMENT_PAYER = "<?php echo $spayer; ?>";
            var SUPPLEMENT_DEFENDANT = "<?php echo $sdefendant; ?>";
            var SUPPLEMENT_AMOUNT = "<?php echo $samount; ?>";
            var SUPPLEMENT_CHARGED = "<?php echo $scontracted; ?>";
            var SUPPLEMENT_BILLED = "<?php echo $sbilled; ?>";
        </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/supplement-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/supplement-page-header.php'); ?>

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
    														<a href="#" id="actions-delete-recorded">Delete</a>
    													</li>
    												</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='contracted') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
                                                        <li>
    														<a href="#" id="actions-bill">Bill</a>
    													</li>
                                                        <li>
    														<a href="#" id="actions-delete-contracted">Delete</a>
    													</li>
                        							</ul>
    										    </div>
                                            </li>
                                        </ul>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($stype=='billed') {
                                        ?>
                                        <ul class="stats">
                                            <li class="button client-menu">
                                                <div class="btn-group">
    												<a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="icon-bolt"></i></a>
    												<ul class="dropdown-menu dropdown-primary">
                                                        <li>
    														<a href="#" id="actions-delete-charged">Delete</a>
    													</li>
                        							</ul>
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
                                                        <p style="float:left;"><?php echo $srecorded; ?></p>
                                                        <div class="btn-group" style="float:right;">
                                                            <a href="<?php echo $sdocumentrecorded; ?>" class="btn btn-primary" id="recorded-view" target="_blank"><img src='img/document_buttongroup_white.png'></a>
                                                        </div>
                                                    </div>
            									</div>
                                                <div class="control-group">
            										<label for="textfield" class="control-label">Payer</label>
            										<div class="controls">
                                                        <p><?php echo $spayer; ?></p>
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
            									<?php if ($scontracted!=''){
                                                ?>
                                                    <div class="control-group">
                    								    <label for="textfield" class="control-label">Contracted</label>
                    									<div class="controls">
                                                            <p style="float:left;"><?php echo $scontracted; ?></p>
                                                            <div class="btn-group" style="float:right;">
                                                                <a href="<?php echo $sdocumentcontracted; ?>" class="btn btn-primary" id="contracted-view" target="_blank"><img src='img/document_buttongroup_white.png'></a>
                                                            </div>
                                                        </div>
                    								</div>
                                                <?php
                                                }
                                                ?>
            									<?php if ($sbilled!=''){
                                                ?>
                                                    <div class="control-group">
                    								    <label for="textfield" class="control-label">Billed</label>
                    									<div class="controls">
                                                            <p><?php echo $sbilled; ?></p>
                                                        </div>
                    								</div>
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="supplement-id" id="supplement-id" value="<?php echo $id; ?>">
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
                          										<label for="textfield" class="control-label">Payer</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-payer" id="detail-payer" class="input-large span12" readonly>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Defendant</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-defendant" id="detail-defendant" class="input-large span12" readonly>
                          										</div>
                          									</div>
                                                            <div class="control-group">
                          										<label for="textfield" class="control-label">Amount</label>
                          										<div class="controls">
                                                                      <input type="text" name="detail-amount" id="detail-amount" class="input-large span12" readonly>
                          										</div>
                          									</div>
                                                            <?php if (($scontracted!='')) { ?>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Contracted</label>
                              									<div class="controls">
                                                                    <input type="text" name="detail-contracted" id="detail-contracted" class="input-large span12" readonly>
                              									</div>
                            								</div>
                                                            <?php } ?>
                                                            <?php if (($sbilled!='')) { ?>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Billed</label>
                              									<div class="controls">
                                                                    <input type="text" name="detail-billed" id="detail-billed" class="input-large span12" readonly>
                              									</div>
                            								</div>
                                                            <?php } ?>
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
        <input type="hidden" name="supplement-action" id="supplement-action" value="">
        <input type="hidden" name="supplement-id" id="supplement-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		<button type="submit" id="confirm-save" class="btn" data-dismiss="modal">Yes</button>
	</div>
</form>
</div>

<div id="modal-bill" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="bill-form">
    <div class="modal-header">
	    <h3 id="modal-title">Supplement - Bill</h3>
	</div>
	<div class="modal-body">
        <div id="charge-status"></div>
        <input type="hidden" name="power-id" id="power-id" value="">
        <input type="hidden" name="supplement-action" id="supplement-action" value="bill">
        <input type="hidden" name="supplement-id" id="supplement-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="bill-save" class="btn btn-primary" data-dismiss="modal">Save</button>
	</div>
</form>
</div>

<div id="modal-revert" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="revert-form">
    <div class="modal-header">
	    <h3 id="modal-title">Supplement - Revert</h3>
	</div>
	<div class="modal-body">
	    <p>Revert Supplement back to Recorded?</p>
        <input type="hidden" name="supplement-action" id="supplement-action" value="revert">
        <input type="hidden" name="supplement-id" id="supplement-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="revert-save" class="btn btn-primary" data-dismiss="modal">Save</button>
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
