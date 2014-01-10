<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once('classes/reports_columnar.class.php');
$id = $reportscolumnar->getField('id');

$title = 'reports';
$label = '';
include("header.php");

?>
<style>
.odd1{background:#EFEFEF;}
.even1{background:#DCEBF9;}
</style>

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
                       <div id="logic-data" style="display:none;">
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
            <input type="hidden" value="<?php echo $id; ?>"  id="report-id" />
            <input type="hidden" name="report-conditionraw" id="report-conditionraw" value="">
            <input type="hidden" name="report-conditionrfriendly" id="report-conditionfriendly" value="">

    <!-- js -->
    <script src="js/reports-columnar.js"></script>
    <script src="js/jqueryquery/condition-logic.js"></script>


<?php include("footer.php"); ?>