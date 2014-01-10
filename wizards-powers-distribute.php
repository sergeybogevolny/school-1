<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

$title = 'wizards';
$label = '';
include_once('header.php');
include_once('classes/wizards_powers_distribute.class.php');

include_once('classes/listbox.class.php');
$agents = $listbox->getGeneral_Agents();
$prefixs = $listbox->getPrefixs();

?>
<script src="js/wizards-powers-distribute.js"></script>

<div class="container-fluid" id="content">
  <?php include_once('pages/wizards-nav-left.php'); ?>
  <div id="main">
    <div class="container-fluid">
      <?php include_once('pages/wizards-page-header.php'); ?>
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <div class="box-title">
              <h3> <i class="icon-signout"></i> Powers Distribute </h3>
            </div>
            <div class="box-content">
              <div id="success" class="hide alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <center>
                  Success
                </center>
              </div>
              <form method="post" action="classes/wizards_powers_distribute.class.php" class="form-horizontal form-wizard" id="form-wizard" style="display:none">
                <div class="step" id="firstStep">
                  <ul class="wizard-steps steps-3">
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="step-forms">
                    <div class="control-group">
                      <label for="textfield" class="control-label">Distribute Date</label>
                      <div class="controls">
                        <input type="text" name="distribute-date" id="distribute-date" class="input-large span2 datepicker " onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate()">
                      </div>
                    </div>
                    <div class="control-group">
                      <label for="textfield" class="control-label">Agent</label>
                      <div class="controls">
                        <select name="distribute-agent" id="distribute-agent" class="select2-me input-large span2" onblur="Stepfirstvalidate()" onkeyup="Stepfirstvalidate()" onchange="Stepfirstvalidate()">
                          <?php echo $agents; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="secondStep">
                  <ul class="wizard-steps steps-3">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li class='active'>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="step-forms">
                    <div class="row-fluid">
                      <div class="span6">
                        <div class="row-fluid" style="margin-bottom:10px;">
                            <div style="float:left;margin-right:5px;">
                                <select id="filter-prefix" class="select2-me input-large filter-fields" style="width:100px;">
                                    <?php echo $prefixs; ?>
                                </select>
                            </div>
                            <div style="float:left;margin-right:5px;">
                                <input class="input-block-level filter-fields" id="filter-serial" type="text" placeholder="Serial" name="textfield" style="width:100px;">
                            </div>
                            <div style="float:left;margin-right:5px;">
                                <input class="input-block-level filter-fields" id="filter-count" type="text" placeholder="#" name="textfield" style="width:100px;">
                            </div>
                            <div style="float:left;margin-right:5px;">
                                <button type="button" class="btn btn-blue" id="distribute-filter" style=""><i class="icon-filter"></i></button>
                            </div>
                        </div>
                        <div id="distribute-text" style="display:none;"></div>
                        <div class="power-loading" style="display: none;">Loading...</div>
                        <table id="distribute-table" class="table table-hover table-nomargin table-bordered dataTable_1 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr class='thefilter'>
                              <th class='with-checkbox'><input type="checkbox" name="check_all_1" id="check_all_1">
                                <button type="button" class="btn btn-blue" id="distribute-add" style="margin-left:10px;"><i class="icon-chevron-right"></i></button>
                              </th>
                              <th>Prefix</th>
                              <th>Serial</th>
                              <th>Value</th>
                              <th>Issued</th>
                              <th>Expiration</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="with-checkbox" id="search-checkbox"><input type="checkbox" name="check" value="1"></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="span6">
                        <div class="row-fluid" style="margin-bottom:10px;">
                          <div class="span4" id="distribute-count"></div>
                          <div class="span8" id="distribute-value"></div>
                        </div>
                        <table id="distribute-bin" class="table table-hover table-nomargin table-bordered dataTable_2 dataTable-nosort dataTable-noheader dataTable-nofooter" data-nosort="0">
                          <thead>
                            <tr class='thefilter'>
                              <th class='with-checkbox'><input type="checkbox" name="check_all_2" id="check_all_2">
                                <button type="button" class="btn btn-blue" id="bin-remove" style="margin-left:10px;"><i class="icon-remove"></i></button></th>
                              <th>Prefix</th>
                              <th>Serial</th>
                              <th>Value</th>
                              <th style="display:none;">Issued</th>
                              <th style="display:none;">Expiration</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="step" id="thirdStep">
                  <ul class="wizard-steps steps-3">
                    <li>
                      <div class="single-step"> <span class="title"> 1</span> <span class="circle"> </span> <span class="description"> Step 1 </span> </div>
                    </li>
                    <li>
                      <div class="single-step"> <span class="title"> 2</span> <span class="circle"> </span> <span class="description"> Step 2 </span> </div>
                    </li>
                    <li class="active">
                      <div class="single-step"> <span class="title"> 3</span> <span class="circle"> <span class="active"></span> </span> <span class="description"> Verify </span> </div>
                    </li>
                  </ul>
                  <div class="control-group" id="group-distributedate">
                    <label class="control-label bold">Distribute Date</label>
                    <div class="controls"> <span id="review_distributedate"></span> </div>
                  </div>
                  <div class="control-group" id="group-agent">
                    <label class="control-label">Agent</label>
                    <div class="controls"> <span id="review_agent"></span> </div>
                  </div>
                  <div class="control-group" id="group-powers">
                    <div class="span12" style="margin-bottom:10px;">
                      <div class="span4" id="review-count"></div>
                      <div class="span8" id="review-value"></div>
                    </div>
                    <div id="review_powers" class="span8"></div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="confirmation"></label>
                    <div class="controls">
                      <input type="hidden" name="distribute-agent-id" id="distribute-agent-id" value="" />
                      <input type="checkbox" name="confirmation" id="confirmation" value="true" data-rule-required="true">
                      &nbspYes, I confirm that input is valid. </div>
                  </div>
                </div>
                <div class="form-actions" id="wizard-actions">
                  <input type="reset" class="btn" value="Back" id="back">
                  <input type="submit" class="btn btn-primary" value="Create" id="next">
                </div>
              </form>
              <div id="report-button" style="display:none" > </br>
                </br>
                <center>
                  <span id="reportbutton"></span>
                </center>
              </div>
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
