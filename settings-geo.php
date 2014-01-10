<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");
include_once('classes/settings_geo.class.php');
$title = 'settings';
$label = 'geo';
include_once('header.php');

$saddress = $settingsgeo->getField('address');
$scity = $settingsgeo->getField('city');
$sstate = $settingsgeo->getField('state');
$szip = $settingsgeo->getField('zip');
$slatitude = $settingsgeo->getField('latitude');
$slongitude = $settingsgeo->getField('longitude');


?>
    <script src="js/settings-geo.js"></script>

    <script src="js/address.js"></script>

    <script>

        var htmlKey = "4589521321810600054";
        var liveaddress = $.LiveAddress({ key: htmlKey, debug: false, autocomplete: 10, autoVerify: false, geolocate: true, invalidMessage: "That address is not valid" });
        liveaddress.mapFields([{
            street: '#geo-address',
            city: '#geo-city',
            state: '#geo-state',
            zipcode: '#geo-zip'
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

    <script>

		var GEO_ADDRESS = '<?php echo $saddress; ?>';
 		var GEO_CITY =   '<?php echo $scity ?>';
		var	GEO_STATE = '<?php echo $sstate; ?>';
		var	GEO_ZIP =   '<?php echo $szip; ?>';
		var	GEO_LATITUDE = '<?php echo $slatitude ?>';
		var	GEO_LONGITUDE ='<?php echo $slongitude ?>'

	</script>

        <div class="container-fluid" id="content">

            <?php include_once('pages/settings-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/settings-page-header.php'); ?>

					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-global"></i>Geo - Edit</h3>
								</div>
                                <div class="box-content nopadding">
                                    <div class="span8">
                        			    <form method="POST" class='form-horizontal form-bordered' id='settings-geo-form'>

                                            <div class="control-group">
                        					    <label for="textfield" class="control-label">Address</label>
                        						<div class="controls">
                                                    <div class="row-fluid">
                                                        <input type="text" name="geo-address" id="geo-address" class="input-large span12">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="geo-city" id="geo-city" class="input-large span5">
                                                        <input type="text" name="geo-state" id="geo-state" class="input-large span2">
                                                        <input type="text" name="geo-zip" id="geo-zip" class="input-large span4">
                                                        <img class="streets-valid" src="img/streets-address-valid.png" class="span1">
                                                    </div>
                                                </div>
                                                <div class="controls" style="margin-top:-10px">
                                                    <div class="row-fluid">
                                                        <input type="text" name="geo-latitude"  id="geo-latitude" class="input-large span3 latitude" >
                                                        <input type="text" name="geo-longitude" id = "geo-longitude" class="input-large span3 longitude" >
                                                        <img class="streets-valid" src="img/streets-geo-valid.png" class="span1">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="geo-id" id="geo-id" value="">
                                            <div class="form-actions">
                                                <input type="submit" style="display:none">
                        					    <button type="button" class="btn btn-primary" id="geo-save" onclick="GeoSave()">Save</button>
                        						<button type="button" class="btn" id="geo-cancel" onclick="GeoCancel">Cancel</button>
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


<?php
include("footer.php");
?>
