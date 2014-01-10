<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

include_once(dirname(__FILE__) . '/classes/dashboard.class.php');

$title = 'dashboard';
$label = 'production';
include_once('header.php');
?>
        <!-- [RISAN] Dashboard Production, retrive data from database to be used in chart -->
        <script type="text/javascript">
        </script>
        <!-- [RISAN] Dashboard Production, plotting charts -->
        <script type="text/javascript" src="js/dashboard.js"></script>
    	<script src="js/plugins/ajax-autocomplete/jquery.autocomplete.js"></script>
        
        <div class="container-fluid" id="content">

            <?php include_once('pages/dashboard-nav-left.php'); ?>

			<div id="main">
				<div class="container-fluid">

                    <?php include_once('pages/dashboard-page-header.php'); ?>


				<div class="row-fluid margin-bottom-20">
					<div class="span12">
                        <div class="box margin-bottom-20">
                            <div class="box">
                                <div class="box-title">
                                    <h3>Search </h3>
                                </div>
                            </div>
                        </div>
    
                        <div id="tab_1_5" class="tab-pane">
                            <div class="span8 booking-search">
                              <form action="#" method="post"  >
                                <div class="clearfix margin-bottom-10 dashbord">
                                  <label>Student's Name</label>
                                  <div class="input-icon left">
                                    <input type="text" name="student-name" id="student-name" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span6" />
                                    <input type="text" name="student-name" id="student-name-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span6"/>
                                  </div>
                                </div>
                                <div class="clearfix margin-bottom-10 dashbord">
                                  <label>Label</label>
                                  <div class="input-icon left">
                                    <input type="text" name="label-name" id="label-name" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span6" />
                                    <input type="text" name="label-name" id="label-name-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span6"/>
                                  </div>
                                </div>
                                <div class="clearfix margin-bottom-20 dashbord">
                                  <div class="control-group pull-left margin-right-20">
                                    <label class="control-label">Check-in:</label>
                                    <div class="controls">
                                      <div class="input-append date date-picker" data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                        <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" />
                                        <span class="add-on"><i class="icon-calendar"></i></span> </div>
                                    </div>
                                  </div>
                                  <div class="control-group pull-left">
                                    <label class="control-label">Check-out:</label>
                                    <div class="controls">
                                      <div class="input-append date date-picker" data-date="" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
                                        <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" />
                                        <span class="add-on"><i class="icon-calendar"></i></span> </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="clearfix margin-bottom-10 dashbord">
                                  <label>Father's Name</label>
                                  <div class="input-icon left">
                                    <input type="text" name="father-name" id="father-name" style="z-index: 2; background: #F9F9F9;border: 1px solid #DDDDDD;" class="span6" />
                                    <input type="text" name="father-name" id="father-name-x" disabled="disabled" style="color: #CCC; background: #F9F9F9; z-index: 1;border: 1px solid #DDDDDD;display:none;" class="span6"/>
                                  </div>
                                </div>
                                <a class="btn btn-primary" href="#" onclick="GoSearch()">SEARCH <i class="m-icon-swapright m-icon-white"></i></a>
                              </form>
                            </div>
                          </div>
					</div>
                </div>
                        <div class="portlet-body">
                           <div id="search-text" style="display:none;"></div>
                          <table id="search-table" class="table table-striped table-bordered dataTable_1 table-hover table-full-width">
                            <thead>
                              <tr class="thefilter">
                                <th>Photo</th>
                                <th class="hidden-phone">Full Name</th>
                                <th>Father's Name</th>
                                <th class="hidden-phone">Joined</th>
                                <th class="hidden-phone">Class</th>
                                <th>Section</th>
                                
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td></td>
                                <td class="hidden-phone"></td>
                                <td></td>
                                <td class="hidden-phone"></td>
                                <td class="hidden-phone"></td>
                                <td><span class="label label-success"></span></td>
                                
                              </tr>
                            </tbody>
                          </table>
                          </div>
                        </div>
                </div>
			</div>
		</div>

<?php
include("footer.php");
?>
