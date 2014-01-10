<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
include_once('classes/client_note.class.php');

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'notes';
include_once('header.php');

$id = $client->getField('id');
?>
    <script src="js/plugins/ajax-autocomplete/jquery.autocomplete.js"></script>
    <script src="js/client-notes.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
        var NOTES_SOURCE = <?php echo $clientnote->getNotes($id); ?>;
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
                                    <h3 id="notes-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="notes-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='notes-list'>
                                    <?php list_clientnotes($id); ?>
                                </div>
							</div>
						</div>
					</div>

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='notes-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span6">
                                <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='note-form'>
                            				    <div class="control-group">
                            					    <label for="textfield" class="control-label">Subject</label>
                            						<div class="controls">
                                                        <input type="text" name="note-subject" id="note-subject" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span12" />
                                                        <input type="text" name="note-subject" id="note-subject-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span12"/>
                                                        <div id="selction-ajax"></div>
                                                    </div>
                            					</div>
                                        
                        				    <div class="control-group">
                        					    <label for="textfield" class="control-label">Comment</label>
                        						<div class="controls">
                        						    <textarea name="note-comment" id="note-comment" class="input-block-level"></textarea>
                        						</div>
                        					</div>
                                            <div class="controls" id="record-delete" style="margin-left:10px">
                        					    <label class='checkbox'>
                        						    <input type="checkbox" name="note-delete" id="note-delete"> Delete?
                        						</label>
                        					</div>
                                            <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="note-id" id="note-id" value="">
                                            <div class="form-actions">
                        					    <button type="submit" class="btn btn-primary" name="note-save" id="note-save">Save</button>
                        						<button type="button" class="btn" name="note-cancel" id="note-cancel">Cancel</button>
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
