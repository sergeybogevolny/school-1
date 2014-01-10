<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/forfeiture.class.php');
include_once('classes/functions-forfeiture.php');
include_once('classes/forfeiture_note.class.php');

$title = 'forfeiture';
$label = 'notes';

include_once('header.php');

$id = $forfeiture->getField('id');
?>

    <script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>
    <script src="js/forfeiture-notes.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
        var NOTES_SOURCE = <?php echo $forfeiturenote->getNotes($id); ?>;
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
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="notes-label"></h3>
                                    <!-- id for list-actions -->

								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='notes-list'>

                                <div class="box-content nopadding">
								<form method="POST" action="" name="editor_form" id="editor_name">
								<textarea cols="80" id="editor" name="editor" rows="10"></textarea>
								<script type="text/javascript">CKEDITOR.replace( 'editor',{toolbar : 'default'});</script>
								<input type="hidden" name="do_add" value="do_add" />
								</form>
								</div>

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
                                            <input type="hidden" name="forfeiture-id" id="forfeiture-id" value="<?php echo $id; ?>">
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
