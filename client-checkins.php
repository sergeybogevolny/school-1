<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/client.class.php');
include_once('classes/functions-client.php');
include_once('classes/client_checkin.class.php');

$stype = $client->getField('type');
if ($stype=='Prospect'){
    $title = 'prospect';
} else {
    $title = 'client';
}
$label = 'checkins';
include_once('header.php');

$id = $client->getField('id');
?>

    <script src="js/client-checkins.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
        var CHECKINS_SOURCE = <?php echo $clientcheckin->getCheckins($id); ?>;
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
                                    <h3 id="checkins-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="checkins-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='checkins-list'>
                                    <?php list_clientcheckins($id); ?>
                                </div>
							</div>
						</div>
					</div>

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='checkins-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span6">
                                <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='checkin-form'>
                        				    <div class="control-group">
                        					    <label for="textfield" class="control-label">Comment</label>
                        						<div class="controls">
                        						    <textarea name="checkin-comment" id="checkin-comment" class="input-block-level"></textarea>
                        						</div>
                        					</div>
                                            
                                            <div class="check-col" id="record-delete" style="margin-top:10px;" >
                                                 <div class="check-line " >
                        						    <input type="checkbox" name="checkin-delete" id="checkin-delete" class="icheck-me" data-skin="square" data-color="blue"><label class='inline ' for="reference-delete"> Delete? </label>
                                                  </div>
                        					</div>
                                            
                                            <input type="hidden" name="client-id" id="client-id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="checkin-id" id="checkin-id" value="">
                                            <div class="form-actions">
                        					    <button type="submit" class="btn btn-primary" name="checkin-save" id="checkin-save">Save</button>
                        						<button type="button" class="btn" name="checkin-cancel" id="checkin-cancel">Cancel</button>
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
