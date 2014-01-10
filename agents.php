<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'agents';
$label = '';

include("header.php");

include_once(dirname(__FILE__) . '/classes/functions-agents.php');
include_once('classes/listbox.class.php');
$phones = $listbox->getPhones();

if(isset($_GET['type'])){
    $type = $_GET['type'];
} else {
    $type = 'contracted';
}
?>
    <!-- Sparkline -->
	<script src="js/plugins/sparklines/jquery.sparklines.min.js"></script>
    <script src="js/agents.js"></script>
    <script src="js/address.js"></script>


    <script>
       var TYPE_LIST = '<?php echo $type ?>';
    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/agents-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/agents-page-header.php'); ?>

                    <div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
                                    <!-- id for list-label, remove nested -->
                                    <h3 id="agents-label"></h3>
                                    <!-- id for list-actions -->
                                    <div id='list-actions'>
                                        <select name="list-type" id="list-type" class='select2-me input-xlarge' onchange="getList()">
									        <option value="contracted">Contracted</option>
                                            <option value="candidate">Candidate</option>
                                            <option value="associate">Associate</option>
                                            <option value="rejected">Rejected</option>
                                             <option value="deleted">Deleted</option> 
                                        </select>
                                        <div class="actions">
                                            <a class="btn btn-mini" id="agents-add" href="#">
                                                <i class="icon-plus"></i>
                                            </a>
                                        </div>
                                    </div>
								</div>
                                <!-- id for *-list, remove content div -->
                                <div id='agents-list'>
                                    <?php list_agents($type); ?>
                                </div>
							</div>
						</div>
					</div>

                    <!-- id for *-box, insert window body, change class horizontal -->
                    <div id='agents-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span6">
                                <div class="box">
                                    <div class="box-content nopadding">
                                        <form method="POST" class='form-horizontal form-bordered' id='agent-form'>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Type</label>
                                        		<div class="controls">
                                        		    <select name="personal-type" id="personal-type" class='select2-me input-xlarge' >
            									        <option value=""></option>
            									        <option value="Candidate">Candidate</option>
                                                        <option value="Associate">Associate</option>
                                                    </select>
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Company</label>
                                        		<div class="controls">
                                        		    <input type="text" name="personal-company" id="personal-company" class="input-large span8" >
                                        		</div>
                                        	</div>
                                        	<div class="control-group">
                                        	    <label for="textfield" class="control-label">Contact</label>
                                        		<div class="controls">
                                        		    <input type="text" name="personal-contact" id="personal-contact" class="input-large span8" >
                                        		</div>
                                        	</div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Address</label>
                                        		<div class="controls">
                                                    <div class="row-fluid">
                                                        <input type="text" name="personal-address" id="personal-address" class="input-large span12">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="personal-city" id="personal-city" class="input-large span5">
                                                        <input type="text" name="personal-state" id="personal-state" class="input-large span2">
                                                        <input type="text" name="personal-zip" id="personal-zip" class="input-large span4">
                                                        <img class="streets-valid" src="img/streets-address-valid.png" class="span1">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="personal-latitude" class="input-large span3 latitude" readonly>
                                                        <input type="text" name="personal-longitude" class="input-large span3 longitude" readonly>
                                                        <img class="streets-valid" src="img/streets-geo-valid.png" class="span1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Phone Primary</label>
                                        		<div class="controls">
                                                    <select name="personal-phone1type" id="personal-phone1type" class="select2-me input-large">
                								        <?php echo $phones; ?>
                							        </select>
                                        			<input type="text" name="personal-phone1" id="personal-phone1" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Phone Secondary</label>
                                        		<div class="controls">
                                                    <select name="personal-phone2type" id="personal-phone2type" class="select2-me input-large">
                								        <?php echo $phones; ?>
                							        </select>
                                        			<input type="text" name="personal-phone2" id="personal-phone2" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Phone Other</label>
                                        		<div class="controls">
                                                    <select name="personal-phone3type" id="personal-phone3type" class="select2-me input-large">
                								        <?php echo $phones; ?>
                							        </select>
                                        		    <input type="text" name="personal-phone3" id="personal-phone3" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                        	    <label for="textfield" class="control-label">Email</label>
                                        		<div class="controls">
                                        		    <input type="text"  name="personal-email" id="personal-email" class="input-large span8"  data-rule-email="true">
                                        		</div>
                                        	</div>
                                            <input type="hidden" name="personal-isvalid" class="isvalid">
                                            <input type="hidden" name="personal-id" id="personal-id" value="">
                                            <div class="form-actions">
                        					    <button type="submit" class="btn btn-primary" name="agent-save" id="agent-save">Save</button>
                        						<button type="button" class="btn" name="agent-cancel" id="agent-cancel">Cancel</button>
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
    <input type="hidden" name="confirm-type" id="confirm-type" value="">
</div>
</div>



<?php
include("footer.php");
?>
