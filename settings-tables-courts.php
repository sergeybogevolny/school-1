<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-courts.php');

$title = 'settings';
$label = 'tables';
include_once('header.php');
?>

    <script src="js/settings-courts.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
    							<div class="box-title">
                                    <h3 id="court-label"></h3>  
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="settings-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
    							</div>
    							<div class="box-content" id='court-list'>
                                    <?php list_settingscourts(); ?>
    							</div>
  						    </div>

						</div>
					</div>

                
                 <div id='court-box' style="display:none">
                        <div class="row-fluid">
                                <div class="span6">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='court-form'>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Name</label>
                                                <div class="controls">
                                                    <input type="text" name="court-name" id="court-name" class="input-large span7">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">County</label>
                                                <div class="controls">
                                                    <div id='jqxDropDownList-court-county'></div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Type</label>
                                                <div class="controls">
                                                    <div id='jqxDropDownList-court-type'></div>
                                                </div>
                                                <div id="type-jp">
                                                    <label for="textfield" class="control-label">Precinct</label>
                                                    <div class="controls">
                                                        <input type="text" name="court-precinct" id="court-precinct" class="input-large">
                                                    </div>
                                                    <label for="textfield" class="control-label">Position</label>
                                                    <div class="controls">
                                                        <input type="text" name="court-position" id="court-position" class="input-large">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Forfeiture Term</label>
                                                <div class="controls">
                                                    <input type="text" name="court-term" id="court-term" class="input-large mask_courtterm span7">
                                                    <span class="help-block">Format: 999</span>
                                                </div>
                                            </div>
                                            <div class="check-col" id="record-delete" style="margin-top:10px;" >
                                                 <div class="check-line " >
                                                        <input type="checkbox"  name="court-delete" id="court-delete" class="icheck-me" data-skin="square" data-color="blue"> <label class='inline ' for="court-delete"> Delete? </label>
                                                  </div>
                                             </div>
                                            <input type="hidden" name="court-id" id="court-id" value="">
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary" id="court-save">Save</button>
                                                <button type="button" class="btn" id="court-cancel">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                
                   </div><!-- End court box --> 
                
                
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
