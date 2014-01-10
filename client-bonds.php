<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
include_once('classes/client_bond.class.php');
include_once('classes/listbox.class.php');

$counties = $listbox->getCounties();
$courts = $listbox->getCourts();
$setfors = $listbox->getSetfors();
$powers = $listbox->getPowers();
$printers = $listbox->getPrinters();
$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'bonds';
include("header.php");

$id = $client->getField('id');

?>
    <script src="js/ajaxupload.js"></script>
    <script src="js/checkamount.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/client-bonds.js"></script>
    <script src="js/plugins/ajax-autocomplete/jquery.autocomplete.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
	    var IDS = '';
        var BONDS_SOURCE = <?php  echo $clientbond->getBonds($id); ?>;
		var BONDS_POWERS =  '<?php echo $powers; ?>'; 
		var CLIENT_ID =  '<?php echo $id; ?>'; 
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
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="bonds-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="bonds-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='bonds-list'>
                                     <?php list_clientbonds($id); ?>
                                </div>
							</div>
						</div>
					</div>

                <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='bonds-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span12">
                                <div class="box" style="margin-top:-20px;">
                                    <div class="box-content nopadding">
                        			    <form method="POST" class='form-horizontal form-bordered' id='bond-form'>
                                            <div class="span6" style="border-left: 1px solid #DDDDDD;">
                                                <div class="control-group">
                                            	    <label for="textfield" class="control-label">Disposition*</label>
                                            		<div class="controls">
                                                        <div class="check-col">
                                                            <div class="check-line">
                                                                <input type="radio"  name="bond-disposition" id="bond-dispositionExecuted" value="Executed" class=" icheck-me input-large" data-skin="square" data-color="blue"  style="margin:0 5px" ><label class='inline ' for="Executed">Executed</label>
                                                            </div>
                                                         </div>
                                                         <div class="check-col">
                                                            <div class="check-line">
                                            			        <input type="radio"  name="bond-disposition" id="bond-dispositionForfeited" value="Forfeited" class=" icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Forfeited">Forfeited</label>
                                                            </div>
                                                          </div>
                                                         <div class="check-col">
                                                            <div class="check-line">
                                                                <input type="radio"  name="bond-disposition" id="bond-dispositionDisposed" value="Disposed" class="icheck-me input-large" data-skin="square" data-color="blue" style="margin:0 5px" ><label class='inline' for="Disposed">Disposed</label>
                                                            </div>
                                                          </div>
                                                    </div>
                                            	</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Date Executed*</label>
                                        			<div class="controls">
                                        			    <input type="text" name="bond-executeddate" id="bond-executeddate" class="span12">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">Powers</label>
                            						<div class="controls">
                                                       <div id="empty_report" style="width: 257px;">
                                                        <select name="bond-powers" id="bond-powers" class="select2-me input-large" onchange="getPowers()" >
    								                        <?php echo $powers; ?>
    							                        </select>
                                                     <div class="check-line" style="float:right">
                                					<input type="checkbox" name="bond-transfer" class="icheck-me bond-transfer" data-skin="square" data-color="blue" id="bond-transfer" disabled="disabled" ><label class='inline ' for="bond-transfer"> Transfer </label>
													</div>

                                                        </div>
                                                        <div id="powers">
                                                        </div>
                                                     <div class="check-line" style="display:none;float:right;width:108px;margin-top:-21px" id="powers-transfer">
                                					<input type="checkbox" name="bond-transfer" class="icheck-me bond-transfer" data-skin="square" data-color="blue" id="bond-transfer" disabled="disabled" ><label class='inline ' for="bond-transfer"> Transfer </label>
													</div>

                                                    </div>
                                                </div>


                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">Bond Amount*</label>
                            						<div class="controls">
                            						    <input type="text" name="bond-amount" id="bond-amount" class="span12" onkeyup="setCheckAmount()">
                                        			   <input type="hidden" name="bond-checkamount" id="bond-checkamount" class="">
                            						</div>
                            					</div>
                            				    <div class="control-group">
                            					    <label for="textfield" class="control-label">Class*</label>
                                    				<div class="controls">
        												<div class="check-col">
        													<div class="check-line ">
                                    						    <input type="radio" name="bond-class" id="bond-classMisdemeanor" value="Misdemeanor" class="icheck-me" data-skin="square" data-color="blue" style="margin:0 5px;"><label class='inline pull-lef' for="c7">Misdemeanor</label>
        													</div>
                                                         </div>
                                                         <div class="check-col">
        													<div class="check-line ">
                                    						    <input type="radio" name="bond-class" id="bond-classFelony" value="Felony" class=" icheck-me " data-skin="square" data-color="blue" style="margin:0 5px;float:left"><label class='inline' for="c7">Felony</label>
        													</div>
                                                          </div>
                                                    </div>
                            					</div>
                            				    <div class="control-group">
                            					    <label for="textfield" class="control-label">Charge*</label>
                            						<div class="controls">
                                                        <input type="text" name="bond-charge" id="bond-charge" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span12" />
                                                        <input type="text" name="bond-charge" id="bond-charge-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span12"/>
                                                        <div id="selction-ajax"></div>
                                                    </div>
                            					</div>
                            				    <div class="control-group">
                            					    <label for="textfield" class="control-label">Case Number</label>
                            						<div class="controls">
                            						    <input type="text" name="bond-casenumber" id="bond-casenumber" class="input-large span12">
                            						</div>
                            					</div>
                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">County</label>
                            						<div class="controls">
                                                        <select name="bond-county" id="bond-county" class="select2-me span12" onchange="getCourt()">
    								                        <?php echo $counties; ?>
    							                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">Court</label>
                            						<div class="controls ">
                                                        <select name="bond-court" id="bond-court" class="select2-me span12">
    							                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                        						    <label class="control-label">Setting</label>
                        							<div class="controls">
                                                        <input type="text" value="" class="span11" name="bond-setting" id="bond-setting" data-date-format="yyyy-mm-dd HH:ii">
                                                        <div class="btn-group span1"  style="float:right;">
                                                            <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getSettingDoc()" id="setting-doc"><img src='img/document_buttongroup_white.png'></a>
                                                            <ul class="dropdown-menu dropdown-primary pull-right" id="settingDoc">
                                                                <li>  Loading...  </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                        						</div>
                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">Set For</label>
                            						<div class="controls">
                                                        <select name="bond-setfor" id="bond-setfor" class="select2-me input-large" onchange="">
    								                        <?php echo $setfors; ?>
    							                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                            					    <label for="textfield" class="control-label">Attorney</label>
                            						<div class="controls">
                                                        <input type="text" name="bond-attorney" id="bond-attorney" style="z-index: 2; background:#F9F9F9;border: 1px solid #DDDDDD;float:left;" class="span11"/>
                                                        <input type="text" name="bond-attorney" id="bond-attorney-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD; display:none;" class="span11"/>
                                                        <div id="attorney-selection-ajax"></div>


                                                        <div class="btn-group span1"  style="float:right;">
                                                            	    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getAttroneyDoc()" id="attroney-doc"><img src='img/document_buttongroup_white.png'></a>
                                                                    <ul class="dropdown-menu dropdown-primary pull-right" id="attroneyDoc">
                                                                        <li>  Loading...  </li>
                                                                    </ul>
                                                        </div>
                                                    </div>
                            					</div>

                                              </div>
                                            <div class="span6" style="border-left: 1px solid #DDDDDD;">
                                             <!-- forfeited -->
                                                <div id="forfeitedgroup" style="display:none">
                                                    <div class="control-group">
                                            		    <label for="textfield" class="control-label">Date Forfeited*</label>
                                            			<div class="controls">
                                            			    <input type="text" name="bond-forfeiteddate" id="bond-forfeiteddate" class="span12">
                                            			</div>
                                            		</div>
                                                    <div class="control-group">
                                					    <label for="textfield" class="control-label">Forfeited Comment</label>
                                						<div class="controls">
                                						    <textarea name="bond-forfeitedcomment" id="bond-forfeitedcomment" class="input-block-level" rows="23"></textarea>
                                						</div>
                                					</div>
                                                </div>
              							<!-- Disposed -->
                                                <div id="disposedgroup" style="display:none">
                                                    <div class="control-group">
                                            		    <label for="textfield" class="control-label">Date Disposed*</label>
                                            			<div class="controls">
                                            			    <input type="text" name="bond-disposeddate" id="bond-disposeddate" class="span12">
                                            			</div>
                                            		</div>
                                                    <div class="control-group">
                                					    <label for="textfield" class="control-label">Disposed Comment</label>
                                						<div class="controls">
                                						    <textarea name="bond-disposedcomment" id="bond-disposedcomment" class="input-block-level" rows="23"></textarea>
                                						</div>
                            					    </div>
                                                </div>

                                             </div><!-- end span6 -->
                                            <div class="span12">
                                                <input type="hidden" name="powers-id" id="powers-id" value="">
                                                <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                                 <input type="hidden" name="document-setting" id="document-setting" value="">
                                                  <input type="hidden" name="document-name" id="document-name" value="">
                                                  <input type="hidden" name="document-setting-val" id="document-setting-val" value="">


                                                <input type="hidden" name="bond-id" id="bond-id" value="">
                                                <div class="form-actions">
                                                    <div class="controls" >

                                                <div class="check-col" style="margin-left:-299px;margin-top:0px;">
													<div class="check-line " >
                                					<input type="checkbox" name="bond-delete" class="icheck-me" data-skin="square" data-color="blue" id="bond-delete" ><label class='inline ' for="bond-delete"> Delete? </label>
													</div>
                                                 </div>

                                					</div>
                            					    <button type="submit" class="btn btn-primary" name="bond-save" id="bond-save">Save</button>
                            						<button type="button" class="btn" name="bond-cancel" id="bond-cancel">Cancel</button>
                            					</div>
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

<div id="modal-printer" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<h3 id="modal-title-printer"></h3>
		</div>
		<div class="modal-body">
			<p>Printer</p>
            <select name="printer-select" id="printer-select" class='select2-me input-xlarge'>
			    <?php echo $printers; ?>
    		</select>
            <div class="check-line" style="margin-top:10px;">
                <input type="checkbox" name="printer-overwrite" class="icheck-me" data-skin="square" data-color="blue" id="printer-overwrite" ><label class='inline ' for="printer-overwrite"> Overwrite? </label>
            </div>
            <div class="control-group overwrite" style="display:none">
                <label for="textfield" class="control-label">Name</label>
                <div class="controls">
                    <input type="text" name="overwrite-name" id="overwrite-name" class="input-xlarge">
                </div>
            </div>
            <input type="hidden" name="form-id" id="form-id" value="">
        </div>
        <div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button id="button-print" class="btn btn-primary" data-dismiss="modal">Print</button>
		</div>
</div>



<div id="modal-upload" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="setting-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3>Document Setting</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="setting-friendly-name" id="setting-friendly-name" class="input-large span4" onkeyup="nameValidate()" onblur="nameValidate()" onclick="nameValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="setting-upload" id="setting-upload" onchange="DocValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="action" value="setting">
        <input type="hidden" name="setting-bond-id" id="setting-bond-id" value="">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="setting-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="saveDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>


<div id="modal-attrony" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="attrony-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3>Document Attroney</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="attroney-friendly-name" id="attroney-friendly-name" class="input-large span4" onkeyup="nameValidate()" onblur="nameValidate()" onclick="nameValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="attroney-upload" id="attroney-upload" onchange="DocValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="attroney">
        <input type="hidden" name="attrony-bond-id" id="attrony-bond-id" value="">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="attroney-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="AttronyDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>




<?php
include("footer.php");
?>
