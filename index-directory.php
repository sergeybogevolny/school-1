<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/functions-directory.php');
include_once('classes/agency_directory.class.php');
include_once('classes/listbox.class.php');

$phones = $listbox->getPhones();

$title = 'agency';
$label = 'directory';
include_once('header.php');
?>

    <script src="js/agency-directory.js"></script>

    <script src="js/address.js"></script>

    <script>

        var htmlKey = "4589521320707542319";
        var liveaddress = $.LiveAddress({ key: htmlKey, debug: false, autocomplete: 10, autoVerify: false, geolocate: true, invalidMessage: "That address is not valid" });
        liveaddress.mapFields([{
            street: '#directory-address',
            city: '#directory-city',
            state: '#directory-state',
            zipcode: '#directory-zip'
          }]);

          $(function() {
            	$('form').submit(function(event) {
            		return suppress(event);
            	});

          });

          function suppress(event) {
          	if (!event) return false;
          	if (event.preventDefault) event.preventDefault();
          	if (event.stopPropagation) event.stopPropagation();
          	if (event.stopImmediatePropagation) event.stopImmediatePropagation();
          	if (event.cancelBubble) event.cancelBubble = true;
          	return false;
          }

    </script>

    <script>var DIRECTORY_SOURCE = <?php echo $agencydirectory->getDirectory(); ?>;</script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/index-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/index-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
    								<h3 id="directory-label"></h3>
    								<div class="actions" id='list-actions'>
                                        <a class="btn btn-mini" id="directory-add" href="#">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </div>
							    </div>
                                <!-- id for list -->
                                <div id='directory-list'>
                                    <?php list_agencydirectory(); ?>
                                </div>
							</div>
						</div>
					</div>

                    <div id='directory-box' style="display:none">
                        <div class="row-fluid">
                    	    <div class="span8">
                                <div class="box">
                        		    <div class="box-content nopadding">
                        			    <form method="POST" class='form-horizontal form-bordered' id='directory-form'>
                        				    <div class="control-group">
                        					    <label for="textfield" class="control-label">Name</label>
                        						<div class="controls">
                        						    <input type="text" name="directory-name" id="directory-name" class="input-large span12">
                        						</div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Type</label>
                        						<div class="controls">
                                                    <select name="directory-type" id="directory-type" class='select2-me input-xlarge'>
													    <option value="person">Person</option>
                                                        <option value="professional">Professional</option>
                                                        <option value="group">Group</option>
                                                        <option value="court">Court</option>
                                                    </select>
                     						    </div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Address</label>
                        						<div class="controls">
                                                    <div class="row-fluid">
                                                        <input type="text" name="directory-address" id="directory-address" class="input-large span12">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="directory-city" id="directory-city" class="input-large span5">
                                                        <input type="text" name="directory-state" id="directory-state" class="input-large span2">
                                                        <input type="text" name="directory-zip" id="directory-zip" class="input-large span4">
                                                        <img class="streets-valid" src="img/streets-address-valid.png" class="span1">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="directory-latitude" class="input-large span3 latitude" readonly>
                                                        <input type="text" name="directory-longitude" class="input-large span3 longitude" readonly>
                                                        <img class="streets-valid" src="img/streets-geo-valid.png" class="span1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Primary</label>
                        						<div class="controls">
                                                    <select name="directory-phone1type" id="directory-phone1type" class="select2-me input-large">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="directory-phone1" id="directory-phone1" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Secondary</label>
                        						<div class="controls">
                        						    <select name="directory-phone2type" id="directory-phone2type" class="select2-me input-large">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="directory-phone2" id="directory-phone2" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Phone Other</label>
                        						<div class="controls">
                        						    <select name="directory-phone3type" id="directory-phone3type" class="select2-me input-large">
								                        <?php echo $phones; ?>
							                        </select>
                        						    <input type="text" name="directory-phone3" id="directory-phone3" class="input-large span6 mask_phone">
                                                </div>
                                            </div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Email</label>
                        						<div class="controls">
                        						    <input type="text" name="directory-email" id="directory-email" class="input-large span12">
                        						</div>
                        					</div>
                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Website</label>
                        						<div class="controls">
                        						    <input type="text" name="directory-website" id="directory-website" class="input-large span12">
                        						</div>
                        					</div>
                                             <div class="controls" id="record-delete" style="margin-left:10px">
                        					    <label class='checkbox'>
                        						    <input type="checkbox" name="directory-delete" id="directory-delete"> Delete?
                        						</label>
                        					</div>
                                            <input type="hidden" name="directory-id" id="directory-id" value="">
                                            <input type="hidden" name="directory-isvalid" class="isvalid">
                                            <div class="form-actions">
                                                <input type="submit" style="display:none">
                        					    <button type="button" class="btn btn-primary" id="directory-save" onclick="DirectorySave()">Save</button>
                        						<button type="button" class="btn" id="directory-cancel" onclick="DirectoryCancel()">Cancel</button>
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
