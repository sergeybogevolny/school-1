<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-paymentmethods.php');

$title = 'settings';
$label = 'tables';
include_once('header.php');
?>

    <script src="js/settings-paymentmethods.js"></script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
                            <div class="box">
    							<div class="box-title">
    								<h3>
    									<i class="icon-list-alt"></i>
    									Payment Methods
    								</h3>
                                    <div class="actions">
                                        <a class="btn btn-mini" id="settings-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
    							</div>
    							<div class="box-content">
                                    <?php list_settingspaymentmethods(); ?>
    							</div>
  						    </div>

						</div>
					</div>

				</div>
			</div>
		</div>


<div id='jqxWindow-paymentmethods' style="display:none">
<div></div>
<div>
    <div class="row-fluid">
	    <div class="span12">
		    <div class="box-content nopadding">
			    <form method="POST" class='form-vertical form-bordered' id='paymenttype-form'>
				    <div class="control-group">
					    <label for="textfield" class="control-label">Name</label>
						<div class="controls">
						    <input type="text" name="paymenttype-name" id="paymenttype-name" class="input-large">
						</div>
					</div>
                    <div class="controls" id="record-delete" style="margin-left:10px">
					    <label class='checkbox'>
						    <input type="checkbox" name="paymenttype-delete" id="paymenttype-delete"> Delete?
						</label>
					</div>
                    <input type="hidden" name="paymenttype-id" id="paymenttype-id" value="">
                    <div class="form-actions">
					    <button type="submit" class="btn btn-primary" id="paymenttype-save">Save</button>
						<button type="button" class="btn" id="paymenttype-cancel">Cancel</button>
					</div>
				</form>
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
