<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/functions-general-transfer.php');

$title = 'transfers';
$label = '';
include_once('header.php');
include_once('classes/listbox.class.php');
$generalagent = $listbox->getGeneral_Agents();


?>
    <!-- Sparkline -->
	<script src="js/plugins/sparklines/jquery.sparklines.min.js"></script>
    <script src="js/plugins/autonumeric/autoNumeric.js"></script>
    <script src="js/general-transfer.js"></script>

    <script>
      

    </script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/agents-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/agents-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title" id="box-title">
								   <h3><i class="icon-list-alt"></i>General Transfer</h3>
<!--                                    <div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="tran-add" href="#"> <i class="icon-plus"></i> </a>
                                    </div>
-->								</div>
                               <div class="box-content" id="transfer-list">
                                    <?php list_generaltransfer(); ?>
								</div>
							</div>
						</div>
					</div>
                    
                    
 <!-- id for *-box, insert window body, change class horizontal -->
        <div id='transfer-box' style="display:none">
            <div class="row-fluid">
            <div class="span6"> 
                    <div class="box">
                        <div class="box-content nopadding">
                            <form method="POST" class='form-horizontal form-bordered' id='transfer-form'>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Date</label>
                                        			<div class="controls">
                                        			    <input type="text" name="transfer-create-date" id="transfer-create-date" class="input-large span5 datepicker first-required" data-rule-required="true">
                                        			</div>
                                        		</div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Amount</label>
                                        			<div class="controls">
                                        			    <input type="text" name="transfer-create-amount" id="transfer-create-amount" class="input-large span5  first-required" data-rule-required="true">
                                        			</div>
                                                </div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Network</label>
                                        			<div class="controls">
                                                        <div class="check-col span2" style="border:0px none">
                                                            <div class="check-line ">
                                                                <input type="radio"  name="transfer-create-network" id="transfer-create-network-in" value="In" class=" icheck-me input-large transfer-create-network" data-skin="square" data-color="blue"  style="margin:0 5px"  data-rule-required="true"><label class='inline ' for="In">In</label>
                                                            </div>
                                                         </div>
                                                         <div class="check-col span2" style="border:0px none">
                                                            <div class="check-line ">
                                            			        <input type="radio"  name="transfer-create-network" id="transfer-create-network-out" value="Out" class=" icheck-me input-large transfer-create-network" data-skin="square" data-color="blue" style="margin:0 5px" data-rule-required="true" ><label class='inline' for="Out">Out</label>
                                                            </div>
                                                          </div>
                                        			</div>
                                                </div>
                                                
                                            
                                             <div id="in-agent-group" style="display:none" class="control-group">
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Requesting Agent</label>
                                        			<div class="controls" id="requesting-agent-select">
                                                        <select name="transfer-create-requesting-agent-select" id="transfer-create-requesting-select" class="select2-me input-large span5" onchange="selectvalidate()">
                								            <?php echo $generalagent; ?>
                							            </select>
                                        			</div>
                                                </div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Posting Agent</label>
                                        			<div class="controls" id="posting-agent-select">
                                                        <select name="transfer-create-posting-agent-select" id="transfer-create-posting-select" class="select2-me input-large span5" onchange="selectvalidate()">
                								            <?php echo $generalagent; ?>
                							            </select>
                                        			</div>
                                                </div> 
                                              </div> 
                                              
                                             <div id="out-agent-group" style="display:none" class="control-group" >
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Requesting Agent</label>
                                        			<div class="controls">
                                        			    <input type="text" name="transfer-create-requesting-agent-text" id="transfer-create-requesting-text" class="input-large span5  first-required" onblur="textvalidate()">
                                        			</div>
                                                </div>
                                                <div class="control-group">
                                        		    <label for="textfield" class="control-label">Posting Agent</label>
                                        			<div class="controls">
                                        			    <input type="text" name="transfer-create-posting-agent-text" id="transfer-create-posting-text" class="input-large span5  first-required" onblur="textvalidate()" >
                                        			</div>
                                                </div> 
                                              </div> 
                                              
                                            <div class="control-group">             
                                                  <label for="textarea" class="control-label" style="margin-left:10px">  Comment</label>
                                                  <div class="controls">
                                                         <textarea name="transfer-create-comment" id="transfer-create-comment" rows="3" class="input-block-level span10"> </textarea>
                                                  </div>
                                             </div>
                                                
                                                
                                <input type="hidden" name="postingagent_id" value="" id="postingagent_id"/>
                                <input type="hidden" name="requestingagent_id" value="" id="requestingagent_id" />
                                <input type="hidden" name="id"  id="transfer-id" />
                                
                                <div class="form-actions">
                                    <input type="submit" style="display:none">
                                    <button type="button" class="btn btn-primary" id="Transfer-save" onclick="TransferSave()">Save</button>
                                    <button type="button" class="btn" id="Transfer-cancel" onclick="TransferCancel()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div></div>
        </div>

    </div>
</div>
                    
                    
                    
                    

				</div>
			</div>
		</div>

<?php
include("footer.php");
?>
