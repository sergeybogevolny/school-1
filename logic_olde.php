<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");
include_once(dirname(__FILE__) . '/classes/functions-bulletin.php');

$title = 'logic';
$label = 'general';
include_once('header.php');
?>
<style>
.odd1{background:#EFEFEF;}
.even1{background:#DCEBF9;}
</style>
<script src="js/plugins/autonumeric/autoNumeric.js"></script>
<script src="js/logic.js"></script>
        <div class="container-fluid" id="content">

            <?php include_once('pages/search-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid " >

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3>Logic</h3>
    					</div>
                        <div class="span10">
                            <div class="query"></div>
                            <div class="" style="float:left; margin-top:30px;">
                                <button id="gv" class="btn btn-primary"> +G</button>
                                <button id="cv" class="btn btn-primary"> +C</button>
                                <button id="read" class="btn btn-primary" onclick="readInput()"> Read</button>
<!--                                <button id="readquery" class="btn btn-primary" onclick="readQuery()"> Read Query</button>
-->                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid" >
                    <div class="box">
    				    <div class="box-title">
    					    <h3></h3>
    					</div>
                          <div class="loading" style="display: none;">Loading...</div>
                       <div id="logic-data">
                        <table id="logic-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr class='thefilter'>
                              <th>Where</th>
                              <th>AO1</th>
                              <th>AO2</th>
                              <th>G</th>
                              <th>C</th>
                              <th>field</th>
                              <th>><=</th>
                              <th>value</th>
                              <th>Delete</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                       </div>
                    </div>
                </div>

            </div>
			</div>
		</div>

<?php
include("footer.php");
?>
