<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'documents';
include_once('header.php');

$id = $client->getField('id');
?>

    <script src="js/client-documents.js"></script>

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
										Documents
									</h3>
								</div>
								<div class="box-content">

                                	<div class="plupload">
                                		<p>You browser doesn't have HTML5 support.</p>
                                	</div>

                                    <div id="dir">
	                                    <h4>Bin</h4>
                                        <div id='jqxDropDownList-directory-folder'></div>
                                        <div id="dir-root" style="display:block">
                                            <?php list_clientdocuments($id, 'root'); ?>
                                        </div>
                                        <div id="dir-application" style="display:none">
                                            <?php list_clientdocuments($id, 'application'); ?>
                                        </div>
                                        <div id="dir-legal" style="display:none">
                                            <?php list_clientdocuments($id, 'legal'); ?>
                                        </div>
                                        <div id="dir-premium" style="display:none">
                                            <?php list_clientdocuments($id, 'premium'); ?>
                                        </div>
                                        <div id="dir-trash" style="display:none">
                                            <?php list_clientdocuments($id, 'trash'); ?>
                                        </div>
                                        <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                    </div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

<div id='jqxWindow-document' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
			    <form method="POST" class='form-vertical form-bordered' id='document-form'>
				    <div class="control-group">
					    <label for="textfield" class="control-label">File</label>
						<div class="controls">
						    <p id="document-name"></p>
						</div>
					</div>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Type</label>
						<div class="controls">
						    <p id="document-type"></p>
						</div>
                        <div class="controls" id="modify-mugshot" style="display:none">
					        <label class='checkbox'>
						        <input type="checkbox" name="document-mugshot" id="document-mugshot"> Mugshot?
						    </label>
					    </div>
					</div>
					<div class="control-group">
					    <label for="textfield" class="control-label">Description</label>
						<div class="controls">
						    <textarea name="document-description" id="document-description" class="input-block-level"></textarea>
						</div>
					</div>
                    <div class="control-group">
					    <label for="textfield" class="control-label">Folder</label>
						<div class="controls">
						    <div id='jqxDropDownList-document-folder'></div>
						</div>
					</div>
                    <input type="hidden" name="current-file" id="current-file" value="">
                    <input type="hidden" name="current-folder" id="current-folder" value="">
                    <input type="hidden" name="current-mugshot" id="current-mugshot" value="">
                    <input type="hidden" name="document-id" id="document-id" value="">
                    <input type="hidden" name="client-id" id="client-id" value="">
                    <input type="hidden" name="document_modify" id="document_modify" value="">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="document-save" id="document-save">Save</button>
						<button type="button" class="btn" name="document-cancel" id="document-cancel">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
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
