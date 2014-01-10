<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/reports_campaign.class.php');
include_once('classes/listbox.class.php');
$id = $reportscampaign->getField('id');
$rsqlid = $reportscampaign->getField('rsqlid');
$generator= $reportscampaign->getField('generator');
$title = 'reports';
$label = '';
include("header.php");

$autocall   = $listbox->campaignTemplate('autocall',$generator);
$sms        = $listbox->campaignTemplate('sms',$generator);
$email      = $listbox->campaignTemplate('email',$generator);
$letter     = $listbox->campaignTemplate('letter',$generator);


?>

    <script src="js/plugins/autonumeric/autoNumeric.js"></script>

    <div class="container-fluid" id="content">
        <?php include_once('pages/reports-nav-left.php'); ?>

        <div id="main">
            <div class="container-fluid " >

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3>Conditions</h3>
    					</div>
                        <div class="span10">
                            <div class="span10">
                            <div class="query"></div>
                            <div class="" style="float:left; margin-top:30px;">
                                <button id="gv" class="btn btn-primary"> +G</button>
                                <button id="cv" class="btn btn-primary addCondition"> +C</button>
                                <button id="read" class="btn btn-primary" onclick="readInput()"> Query</button>
                                <button id="btnPrint" class="btn btn-primary" onclick=""> Print</button>
                            </div>
                            </div>
                         </div>
                    </div>
                </div>

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3></h3>
    					</div>
                          <div class="loading" style="display: none;">Loading...</div>
                       <div id="logic-data"  style="display:none;" >
                        <table id="logic-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr class='thefilter'>
                              <th style="display:none">Where</th>
                              <th>Group Operator</th>
                              <th>Condition Operator</th>
                              <th style="display:none">G</th>
                              <th style="display:none">C</th>
                              <th> Field</th>
                              <th>Comparison</th>
                              <th>Value</th>
                              <th> </th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                       </div>
                    </div>
                </div>

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3>Results</h3>
    					</div>
                        <div class="loading" style="display: none;">Loading...</div>
    					<div class="box" id="report-results"></div>
                    </div>
                </div>

            </div>

<div id="modal-campaign" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" id="campaign-form">
    <div class="modal-header">
	    <h3 id="modal-title">Campaign - Send</h3>
	</div>
	<div class="modal-body">
        <p><strong>L</strong>etter</p>
        <select name="campaign-letter-select" id="campaign-letter-select" class="select2-me input-large" onkeyup="" onblur="" onclick="">
         <?php echo $letter; ?>

        </select>
        <br></br>
        <p><strong>E</strong>mail</p>
        <select name="campaign-email-select" id="campaign-email-select" class="select2-me input-large" onkeyup="" onblur="" onclick="">
                <?php echo $email; ?>

        </select>
        <br></br>
        <p><strong>T</strong>ext</p>
        <select name="campaign-text-select" id="campaign-text-select" class="select2-me input-large" onkeyup="" onblur="" onclick="">
             <?php echo $sms; ?>

        </select>
        <br></br>
        <p><strong>A</strong>utomated Call</p>
        <select name="campaign-autocall-select" id="campaign-autocall-select" class="select2-me input-large" onkeyup="" onblur="" onclick="">
        <?php echo $autocall; ?>
        </select>
        <br></br>
        <p>Some blah blah at possible costs.  Check box if you agree.  </p><input type="checkbox" name="check-agree" value="0" id="check-agree">
        <input type="hidden" name="campaign-autocalls" id="campaign-autocalls" value="">
        <input type="hidden" name="campaign-emails" id="campaign-emails" value="">
        <input type="hidden" name="campaign-texts" id="campaign-texts" value="">
        <input type="hidden" name="campaign-letters" id="campaign-letters" value="">
        <input type="hidden" name="campaign-id" id="campaign-id" value="<?php echo $id; ?>">
    </div>
    <div class="modal-footer">
	    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="submit" id="campaign-save" class="btn btn-primary" data-dismiss="modal">Ok</button>
	</div>
        <input type="hidden" name="report-id" id="report-id" value="<?php echo $id; ?>">
        <input type="hidden" name="report-sqlid" id="report-sqlid" value="<?php echo $rsqlid; ?>">
        <input type="hidden" name="report-conditionraw" id="report-conditionraw" value="">
        <input type="hidden" name="report-conditionrfriendly" id="report-conditionfriendly" value="">

</form>
</div>


    <!-- js -->
    <script src="js/reports-campaign.js"></script>
    <script src="js/jqueryquery/condition-logic.js"></script>


<?php include("footer.php"); ?>