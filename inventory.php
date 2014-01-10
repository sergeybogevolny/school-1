<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/inventory.class.php');
include_once('classes/functions-inventory.php');

$title = 'inventory';
$label = '';

include("header.php");

?>

    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/inventory.js"></script>

    <!--SET SOURCE -->
    <script type="text/javascript">
        var INVENTORY_SOURCE = <?php echo $inventory->getUnreported(); ?>;
    </script>


        <div class="container-fluid" id="content">

            <?php include_once('pages/inventory-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/inventory-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="inventory-label"></h3>
                                    <!-- id for list-actions -->
                                    <div class="actions" id='list-actions'></div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='inventory-list'>
                                     <?php list_inventory();   ?>
                                </div>
							</div>
						</div>
					</div>

                    <div id='inventory-box' style="display:none">
                        <div class="row-fluid">
                            <div class="box">
                                <div class="box-content nopadding span6">

                                        <form method="POST" class='form-horizontal form-bordered' id='inventory-form'>

                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Void</label>
                                                        <div class="controls">
                                                              <input type="checkbox" name="detail-void"  id="detail-void" >
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Voided*</label>
                                                        <div class="controls">
                                                            <input type="text" name="detail-voided" id="detail-voided" class="input-large span12" data-date-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                        
                                        
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Name*</label>
                                                        <div class="controls">
                                                              <input type="text" name="detail-name" id="detail-name" class="input-large span12">
                                                        </div>
                                                    </div>

                                                
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Executed*</label>
                                                        <div class="controls">
                                                            <input type="text" name="detail-executeddate" id="detail-executeddate" class="input-large span12" data-date-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                              
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Amount*</label>
                                                        <div class="controls">
                                                              <input type="text" name="detail-amount" id="detail-amount" class="input-large span12">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Transfer</label>
                                                        <div class="controls" id="transfercheck">
                        						            <input type="checkbox" name="detail-transfer" id="detail-transfer" >
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                  <div style="display:none"> <span id="name-review"></span><span id="executeddate-review"></span><span id="amount-review"></span><span id="transfer-review"></span></div>
                                                
                                              
                                                <input type="hidden" name="bond-id" id="bond-id" value="">
                                                <input type="hidden" name="power-id" id="power-id" value="">
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

<?php
include("footer.php");
?>
