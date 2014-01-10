<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-counties.php');

$title = 'settings';
$label = 'tables';
include_once('header.php');
?>

    <script src="js/settings-counties.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
    							<div class="box-title">
                                    <h3 id="county-label"></h3> 
                                     
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="settings-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
    							</div>
    							<div class="box-content" id='county-list'>
                                    <?php list_settingscounties(); ?>
    							</div>
  						    </div>

						</div>
					</div>


                    <div id='county-box' style="display:none">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="box-content nopadding">
                                    <form method="POST" class='form-horizontal form-bordered' id='county-form'>
                                        <div class="control-group">
                                            <label for="textfield" class="control-label">Name</label>
                                            <div class="controls">
                                                <input type="text" name="county-name" id="county-name" class="input-large span7">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="textfield" class="control-label">Seat</label>
                                            <div class="controls">
                                                <input type="text" name="county-seat" id="county-seat" class="input-large span7">
                                            </div>
                                        </div>
                                        
                                        <div class="check-col" id="record-delete" style="margin-top:10px;" >
                                             <div class="check-line " >
                                                  <input type="checkbox" name="county-delete" id="county-delete" class="icheck-me" data-skin="square" data-color="blue"> 
                                                   <label class='inline ' for="county-delete"> Delete? </label>
                                              </div>
                                         </div>
                                        
                                        <input type="hidden" name="county-id" id="county-id" value="">
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" name="county-save" id="county-save">Save</button>
                                            <button type="button" class="btn" name="county-cancel" id="county-cancel">Cancel</button>
                                        </div>
                                    </form>
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
