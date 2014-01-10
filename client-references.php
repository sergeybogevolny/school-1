<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
include_once('classes/client_reference.class.php');
include_once('classes/listbox.class.php');

$sts = $listbox->getSts();
$phones = $listbox->getPhones();

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'references';
include_once('header.php');

$id = $client->getField('id');
?>
    <script src="js/ajaxupload.js"></script>
    <script src="js/client-references.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
        var REFERENCES_SOURCE = <?php echo $clientreference->getReferences($id); ?>;
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
                                    <h3 id="references-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="references-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='references-list'>
                                    <?php list_clientreferences($id); ?>
                                </div>
							</div>
						</div>
					</div>

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='references-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span6">
                                <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='reference-form'>
                        				    <div class="control-group">
                        					    <label for="textfield" class="control-label">Last</label>
                        						<div class="controls">
                        						    <input type="text" name="reference-last" id="reference-last" class="span12">
                        						</div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">First</label>
                        						<div class="controls">
                        						    <input type="text" name="reference-first" id="reference-first" class="span12">
                        						</div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Middle</label>
                        						<div class="controls">
                        						    <input type="text" name="reference-middle" id="reference-middle" class="span12">
                        						</div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Address</label>
                        						<div class="controls">
                                                    <div class="row-fluid">
                                                        <input type="text" name="reference-address" id="reference-address" class="span12">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="reference-city" id="reference-city" class="input-large span4">
                                                        <select name="reference-state" id="reference-state" class="select2-me" style="width:80px">
                                                            <?php echo $sts; ?>
                                                        </select>
                                                        <input type="text" name="reference-zip" id="reference-zip" class="span3">
                                                        <img class="streets-valid" src="img/streets-address-valid.png" class="span1">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px;display:none;">
                                                    <div class="row-fluid">
                                                        <input type="text" name="reference-latitude" class="input-large span3 latitude" readonly>
                                                        <input type="text" name="reference-longitude" class="input-large span3 longitude" readonly>
                                                        <img class="streets-valid" src="img/streets-geo-valid.png" class="span1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Primary</label>
                        						<div class="controls">
                                                    <select name="reference-phone1type" id="reference-phone1type" class="select2-me span6">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="reference-phone1" id="reference-phone1" class="span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Secondary</label>
                        						<div class="controls">
                                                    <select name="reference-phone2type" id="reference-phone2type" class="select2-me span6">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="reference-phone2" id="reference-phone2" class="span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Other</label>
                        						<div class="controls">
                                                    <select name="reference-phone3type" id="reference-phone3type" class="select2-me span6">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="reference-phone3" id="reference-phone3" class="span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Other</label>
                        						<div class="controls">
                                                    <select name="reference-phone4type" id="reference-phone4type" class="select2-me span6">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="reference-phone4" id="reference-phone4" class="span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Relation</label>
                        						<div class="controls">
                        						    <input type="text" name="reference-relation" id="reference-relation" class="span12">
                                                    <div class="check-line" style="margin-top:10px;">
                        						        <label class='inline' for="reference-caller">Caller </label><input type="checkbox" name="reference-caller" id="reference-caller" class="icheck-me" data-skin="square" data-color="blue">
                                                    </div>
                        						</div>
                        					</div>



                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Indemnitor</label>
                        						<div class="controls">
                                                    <div class="check-col">
                                                       <div class="check-line " >
                        						        <input type="checkbox" name="reference-indemnify" id="reference-indemnify" class="icheck-me" data-skin="square" data-color="blue">
                                                            <div class="btn-group span1" id="supplement-indemnitor"  style="float:right;margin-top:-25;display:none;">
                                                         
                                                                <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getSupplementDoc()" id="supplement-doc"><img src='img/supplement_buttongroup_white.png'></a>
                                                             
                                                                <ul class="dropdown-menu dropdown-primary pull-right" id="supplementDoc">
                                                                    <li>  Loading...  </li>
                                                                </ul>
                                                            </div>
                                                            <div class="btn-group span1" id="document-indemnitor"  style="float:right;margin-top:-25;display:none;">
                                                                <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" onclick="getIndemnifyDoc()" id="indemnify-doc"><img src='img/document_buttongroup_white.png'></a>
                                                                <ul class="dropdown-menu dropdown-primary pull-right" id="indemnifyDoc">
                                                                    <li>  Loading...  </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                     </div>
                                                </div>
                        					</div>

                                            <div class="check-col" id="record-delete" style="margin-top:10px;" >
                                                 <div class="check-line" >
                                                        <input type="checkbox" name="reference-delete" id="reference-delete" class="icheck-me" data-skin="square" data-color="blue"> <label class='inline ' for="reference-delete"> Delete? </label>
                                                  </div>
                                             </div>


                                            <input type="hidden" name="reference-isvalid" class="isvalid">
                                            <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="reference-id" id="reference-id" value="">
                                            <div class="form-actions">
                                                <input type="submit" style="display:none">
                        					    <button type="button" class="btn btn-primary" name="reference-save" id="reference-save" onclick="ReferenceSave()">Save</button>
                        						<button type="button" class="btn" name="reference-cancel" id="reference-cancel" onclick="ReferenceCancel()">Cancel</button>
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

<div id="modal-indemnify" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="indemnify-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Indemnitor</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        <div class="control-group">
            <label for="textfield" class="control-label">Name</label>
            <div class="controls">
                <input type="text" name="indemnify-friendly-name" id="indemnify-friendly-name" class="input-large span4" onkeyup="nameValidate()" onblur="nameValidate()" onclick="nameValidate()" sytle="height:30px;">
            </div>
        </div>
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="indemnify-upload" id="indemnify-upload" onchange="DocValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="indemnify">
        <input type="hidden" name="indemnify-client-id" id="indemnify-client-id" value="">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="indemnify-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="IndemnifyDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>



<div id="modal-supplement" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="supplement-document-form" enctype="multipart/form-data">
    <div class="modal-header">
	    <h3 id="modal-title">Document Supplement</h3>
	</div>
	<div class="modal-body">
        <div class='form-vertical'>
        
        <div class="control-group">
            <label for="textfield" class="control-label">Upload File</label>
            <div class="controls">
                <input type="file" name="supplement-upload" id="supplement-upload" onchange="DocValidate()" />
            </div>
        </div>
        </div>
        <input type="hidden" name="action" id="uplaod-action" value="supplement">
        <input type="hidden" name="supplement-id" id="supplement-id" value="">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="supplement-upload-save" class="btn btn-primary" data-dismiss="modal" onclick="SupplementDoc(<?php echo $id; ?>)">Save</button>
	</div>
</form>
</div>




<?php
include("footer.php");
?>
