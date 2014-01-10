<?php
ob_start();
if (!isset($_SESSION)) session_start();

include_once('classes/agency_user_history.class.php');

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
if (curPageName()=='settings-profile.php'){
    $title = 'settings';
    $label = 'profile';
}

if(!isset($_SESSION['level'])) {
    $_SESSION['level'] = 'agency';
}
$level = $_SESSION['level'];

include_once('classes/header.class.php');
$header = new Header();


?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<title>BailSuite | Web Application</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
     <!-- dataTables -->
	<link rel="stylesheet" href="css/plugins/datatable/TableTools.css">
    <!-- chosen -->
	<link rel="stylesheet" href="css/plugins/chosen/chosen.css">

    <!-- PageGuide -->
	<link rel="stylesheet" href="css/plugins/pageguide/pageguide.css">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.css">
	<link rel="stylesheet" href="css/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<!-- select2 -->
	<link rel="stylesheet" href="css/plugins/select2/select2.css">
	<!-- icheck -->
	<link rel="stylesheet" href="css/plugins/icheck/all.css">
    <!-- Plupload -->
	<link rel="stylesheet" href="css/plugins/plupload/jquery.plupload.queue.css">
    <!--AXUpload -->
    <link rel="stylesheet" href="css/plugins/axupload/axupload.css" rel="stylesheet">
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="css/plugins/datepicker/datepicker.css">

    <link rel="stylesheet" href="css/plugins/basttags/tags.css">
    <link rel="stylesheet" href="css/plugins/timepicker/bootstrap-timepicker.min.css">

    <link rel="stylesheet" href="js/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />


	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/style__not-minified.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="css/themes.css">

    <link rel="stylesheet" href="js/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="js/jqwidgets/styles/jqx.metro.css" type="text/css" />

    <link rel="stylesheet" href="css/custom.css">

    <!-- jQuery -->
	<script src="js/jquery.min.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxpanel.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdropdownlist.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxtooltip.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxdata.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.selection.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxnumberinput.js"></script>

    <script type="text/javascript" src="js/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="js/jqwidgets/globalization/globalize.js"></script>



	<!-- Nice Scroll -->
	<script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>

	<!-- jQuery UI -->
	<script src="js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.draggable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
	<!-- Touch enable for jquery UI -->
	<script src="js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
	<!-- slimScroll -->
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Bootbox -->
	<script src="js/plugins/bootbox/jquery.bootbox.js"></script>

<?php
if ($title=='dashboard' && $label=='production'){
?>
    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.bar.order.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.stack.js"></script>
<?php
} else if ($title=='dashboard' && $label=='geo'){
?>
    <!-- gmap -->
	<script src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script>
	<script src="js/plugins/gmap/gmap3.min.js"></script>
	<script src="js/plugins/gmap/gmap3-menu.js"></script>
<?php
} else if ($title=='client' && $label=='geo'){
?>
    <!-- gmap -->
	<script src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script>
	<script src="js/plugins/gmap/gmap3.min.js"></script>
	<script src="js/plugins/gmap/gmap3-menu.js"></script>
<?php
} else if ($title=='client' && $label=='documents'){
?>
    <!-- PLUpload -->
	<script src="js/plugins/plupload/plupload.full.js"></script>
	<script src="js/plugins/plupload/jquery.plupload.queue.js"></script>
<?php
}
?>

	<!-- imagesLoaded -->
	<script src="js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
	<!-- PageGuide -->
	<script src="js/plugins/pageguide/jquery.pageguide.js"></script>
	<!-- FullCalendar -->
	<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
	<!-- Chosen -->
	<script src="js/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- select2 -->
	<script src="js/plugins/select2/select2.min.js"></script>
	<!-- icheck -->
	<script src="js/plugins/icheck/jquery.icheck.min.js"></script>
    <!-- Validation -->
	<script src="js/plugins/validation/jquery.validate.min.js"></script>
	<script src="js/plugins/validation/additional-methods.min.js"></script>
    <!-- Form -->
	<script src="js/plugins/form/jquery.form.min.js"></script>
	<!-- Wizard -->
	<script src="js/plugins/wizard/jquery.form.wizard.min.js"></script>
	<script src="js/plugins/mockjax/jquery.mockjax.js"></script>
    <!-- dataTables -->
	<script src="js/plugins/datatable/jquery.dataTables.min.js"></script>
	<script src="js/plugins/datatable/TableTools.min.js"></script>
	<script src="js/plugins/datatable/ColReorder.min.js"></script>
	<script src="js/plugins/datatable/ColVis.min.js"></script>
	<script src="js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
    <!-- Masked inputs -->
	<script src="js/plugins/maskedinput/jquery.maskedinput.min.js"></script>

    <script src="js/plugins/inputmask/jquery.inputmask.bundle.min.js"></script>
    <script src="js/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>


	<!-- Datepicker plugin -->
	<script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Notify -->
	<script src="js/plugins/gritter/jquery.gritter.min.js"></script>


    <script src="js/plugins/basttags/tags.js"></script>

    <script src="js/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    
    
    <!-- X Editable -->
	<link rel="stylesheet" type="text/css" href="plugin/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
	<link rel="stylesheet" type="text/css" href="plugin/plugins/bootstrap-editable/inputs-ext/address/address.css"/>

	<script type="text/javascript" src="plugin/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js"></script>
	<script type="text/javascript" src="plugin/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
	<script type="text/javascript" src="plugin/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js"></script>   

	<!-- Theme framework -->
	<script src="js/eakroko.js"></script>
	<!-- Theme scripts -->
	<script src="js/application.js"></script>
	<!-- Just for demonstration -->
	<script src="js/demonstration.js"></script>

    <script>
	    function setLevel(level){
		    $.post("classes/header.class.php", { level: level})
			    .done(function(data) {
				window.location = "index.php";
			});
		}
	</script>

	<!--[if lte IE 9]>
		<script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicono.ico" />

</head>

<body class="theme-blue">

	<div id="navigation">
		<div class="container-fluid">
            <?php if ($level=="agent"){ ?>
                <a href="#" id="brand-less">BailSuite</a>
            <?php } else { ?>
                <a href="search.php" id="brand">BailSuite</a>
            <?php } ?>
            <a class="toggle-mobile" href="#"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>
                <?php
                if ($level=="agent"){
                ?>
                <li class="<?php echo ($title == "agency" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "agency" ? " active" : "")?>">
						<span>Agent</span>
                        <span class="caret"></span>
					</a>
				    <ul class="dropdown-menu">
						<li>
							<a href="index.php">Get Started</a>
						</li>
                        <li>
							<a href="#" onClick="setLevel('agency')">Agency</a>
						</li>
                        <li>
							<a href="#" onClick="setLevel('general')">General</a>
						</li>
					</ul>
				</li>
                <li class="<?php echo ($title == "wizards" ? "active" : "")?>">
					<a href="wizards.php">Wizards</a>
                </li>
                <li class="<?php echo ($title == "inventory" ? "active" : "")?>">
					<a href="inventory.php">Inventory</a>
                </li>
                <?php
                }
                ?>
                <?php
                if ($level=="agency"){
                ?>
                <li class="<?php echo ($title == "agency" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "agency" ? " active" : "")?>">
						<span>Agency</span>
                        <span class="caret"></span>
					</a>
				    <ul class="dropdown-menu">
						<li>
							<a href="index.php">Get Started</a>
						</li>
						<li>
							<a href="index-bulletin.php">Bulletin</a>
						</li>
						<li>
							<a href="index-directory.php">Directory</a>
						</li>
                        <li>
							<a href="index-feeds.php">Feeds</a>
						</li>
                        <!--
                        <li>
							<a href="#" onClick="setLevel('agent')">Agent</a>
						</li>
                        <li>
							<a href="#" onClick="setLevel('general')">General</a>
						</li>
                        -->
					</ul>
				</li>

                <li class="<?php echo ($title == "dashboard" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "dashboard" ? " active" : "")?>">
						<span>Dashboard</span>
                        <span class="caret"></span>
					</a>
				    <ul class="dropdown-menu">
						<li>
							<a href="dashboard-production.php">Production</a>
						</li>
						<li>
							<a href="dashboard-geo.php">Geo</a>
						</li>
					</ul>
				</li>

                <li class="<?php echo ($title == "wizards" ? "active" : "")?>">
					<a href="wizards.php">Wizards</a>
                </li>

                <li class="<?php echo ($title == "powers" ? "active" : "")?>">
					<a href="powers.php">Powers</a>
                </li>

                <li class="<?php echo ($title == "prospects" ? "active" : "")?>">
					<a href="prospects.php">Prospects</a>
                </li>

                <li class="<?php echo ($title == "clients" ? "active" : "")?>">
					<a href="clients.php">Clients</a>
                </li>

                <li class="<?php echo ($title == "calendar" ? "active" : "")?>">
					<a href="calendar.php">Calendar</a>
                </li>

                <li class="<?php echo ($title == "reports" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "reports" ? " active" : "")?>">
						<span>Reports</span>
                        <span class="caret"></span>
					</a>
                    <ul class="dropdown-menu">
                        <li class='dropdown-submenu'>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Campaign</a>
							<ul class="dropdown-menu">
                                <?php echo	$header->displayCampaignmenu($level); ?>
							</ul>
						</li>
                        <li class='dropdown-submenu'>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Columnar</a>
							<ul class="dropdown-menu">
                                <?php echo	$header->displayColumnarmenu($level); ?>
							</ul>
						</li>
                    </ul>

				</li>

                <li class="<?php echo ($title == "history" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "history" ? " active" : "")?>">
						<span>History</span>
                        <span class="caret"></span>
					</a>
                    <ul class="dropdown-menu">
			            <?php echo	$agencyuserhistory->displayhistorymenu(); ?>
                    </ul>
				</li>

                <?php
                }
                ?>
                <?php
                if ($level=="general"){
                ?>
                <li class="<?php echo ($title == "agency" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "agency" ? " active" : "")?>">
						<span>General</span>
                        <span class="caret"></span>
					</a>
				    <ul class="dropdown-menu">
						<li>
							<a href="index.php">Get Started</a>
						</li>
						<li>
							<a href="index-bulletin.php">Bulletin</a>
						</li>
						<li>
							<a href="index-directory.php">Directory</a>
						</li>
                        <li>
							<a href="#" onClick="setLevel('agent')">Agent</a>
						</li>
                        <li>
							<a href="#" onClick="setLevel('agency')">Agency</a>
						</li>
					</ul>
				</li>

                <li class="<?php echo ($title == "wizards" ? "active" : "")?>">
					<a href="wizards.php">Wizards</a>
                </li>

                <li class="<?php echo ($title == "powers" ? "active" : "")?>">
					<a href="powers.php">Powers</a>
                </li>

                <li class="<?php echo ($title == "agents" ? "active" : "")?>">
					<a href="agents.php">Agents</a>
                </li>

                <li class="<?php echo ($title == "forfeitures" ? "active" : "")?>">
                                    <a href="general-forfeitures.php">Forfeitures</a>
                </li>
                 <li class="<?php echo ($title == "transfers" ? "active" : "")?>">
					<a href="general-transfers.php">Transfers</a>
                </li>

                <li class="<?php echo ($title == "reports" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "reports" ? " active" : "")?>">
						<span>Reports</span>
                        <span class="caret"></span>
					</a>
                    <ul class="dropdown-menu">
                        <li class='dropdown-submenu'>
							<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Columnar</a>
							<ul class="dropdown-menu">
                                <?php echo	$header->displayColumnarmenu($level); ?>
							</ul>
						</li>
                    </ul>

				</li>

                <li class="<?php echo ($title == "history" ? "active" : "")?>">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle<?php echo ($title == "history" ? " active" : "")?>">
						<span>History</span>
                        <span class="caret"></span>
					</a>
                    <ul class="dropdown-menu">
			            <?php echo	$agencyuserhistory->displayhistorymenu(); ?>
                    </ul>
				</li>

                <?php
                }
                ?>


			</ul>

<!-- User Nav -->
			<div class="user">
				<ul class="icon-nav">
                     <?php
                     if ($level=="agent"){
                     ?>
                        <li>
        					<a href="agency-messages.php">
            					<i class="icon-envelope-alt"></i>
                                <?php if( $header->getUnreadMessageCount() > 0 ) { ?>
            					<span class="label label-lightred" id="unreadmessagecount"><?php echo $header->getUnreadMessageCount(); ?></span>
            					<?php } ?>
                            </a>
    				    </li>
                        <li class="dropdown">
    						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-cog"></i></a>
    						<ul class="dropdown-menu pull-right">
                                <li>
    							    <a href="settings-about.php">About</a>
    							</li>
    						</ul>
    					</li>
                     <?php
                     }
                     ?>

                     <?php
                     if ($level=="agency"){
                     ?>
                        <li>
    					    <a href="tasks.php"><i class="icon-tasks"></i><span class="label label-lightred" ><?php echo $header->getTasksCount(); ?></span></a>
    					</li>
                        <li class="dropdown">
    						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-cog"></i></a>
    						<ul class="dropdown-menu pull-right">
    							<li>
    							    <a href="settings-profile.php">Profile</a>
    							</li>
                                <li>
    							    <a href="settings-communications.php">Communications</a>
    							</li>
                                <li>
    							    <a href="settings-bulletin.php">Bulletin</a>
    							</li>
                                <li>
    							    <a href="settings-geo.php">Geo</a>
    							</li>

                                <li class='dropdown-submenu'>
        							<a href="#">Tables</a>
        							<ul class="dropdown-menu">
                                        <li>
        									<a href="settings-tables-attorneys.php">Attorneys</a>
        								</li>
                                        <li>
        									<a href="settings-tables-charges.php">Charges</a>
        								</li>
                                        <li>
        									<a href="settings-tables-counties.php">Counties</a>
        								</li>
                                        <li>
        									<a href="settings-tables-couriers.php">Couriers</a>
        								</li>
        								<li>
        									<a href="settings-tables-courts.php">Courts</a>
        								</li>
                                        <li>
        									<a href="settings-tables-jails.php">Jails</a>
        								</li>
                                        <li>
        									<a href="settings-tables-offices.php">Offices</a>
        								</li>
                                        <li>
        									<a href="settings-tables-paymentmethods.php">Payment Methods</a>
        								</li>
                                        <li>
        									<a href="settings-tables-prefixs.php">Prefixs</a>
        								</li>
                                        <li>
        									<a href="settings-tables-setfors.php">Set Fors</a>
        								</li>
                                        <li>
        									<a href="settings-tables-sources.php">Sources</a>
        								</li>
                                        <li>
        									<a href="settings-tables-sureties.php">Sureties</a>
        								</li>
        							</ul>
        						</li>
                                <li>
    							    <a href="settings-about.php">About</a>
    							</li>
    						</ul>
    					</li>
                     <?php
                     }
                     ?>

                     <?php
                     if ($level=="general"){
                     ?>
                        <li>
        					<a href="agency-messages.php">
            					<i class="icon-envelope-alt"></i>
                                <?php if( $header->getUnreadMessageCount() > 0 ) { ?>
            					<span class="label label-lightred" id="unreadmessagecount"><?php echo $header->getUnreadMessageCount(); ?></span>
            					<?php } ?>
                            </a>
    				    </li>
                        <li class="dropdown">
    						<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-cog"></i></a>
    						<ul class="dropdown-menu pull-right">
    							<li>
    							    <a href="settings-profile.php">Profile</a>
    							</li>
                                <li>
    							    <a href="settings-bulletin.php">Bulletin</a>
    							</li>
                                <li class='dropdown-submenu'>
        							<a href="#">Tables</a>
        							<ul class="dropdown-menu">
                                        <li>
        									<a href="settings-tables-attorneys.php">Attorneys</a>
        								</li>
                                        <li>
        									<a href="settings-tables-charges.php">Charges</a>
        								</li>
                                        <li>
        									<a href="settings-tables-counties.php">Counties</a>
        								</li>
                                        <li>
        									<a href="settings-tables-couriers.php">Couriers</a>
        								</li>
        								<li>
        									<a href="settings-tables-courts.php">Courts</a>
        								</li>
                                        <li>
        									<a href="settings-tables-jails.php">Jails</a>
        								</li>
                                        <li>
        									<a href="settings-tables-offices.php">Offices</a>
        								</li>
                                        <li>
        									<a href="settings-tables-paymentmethods.php">Payment Methods</a>
        								</li>
                                        <li>
        									<a href="settings-tables-prefixs.php">Prefixs</a>
        								</li>
                                        <li>
        									<a href="settings-tables-setfors.php">Set Fors</a>
        								</li>
                                        <li>
        									<a href="settings-tables-sources.php">Sources</a>
        								</li>
                                        <li>
        									<a href="settings-tables-sureties.php">Sureties</a>
        								</li>
        							</ul>
        						</li>
                                <li>
    							    <a href="settings-about.php">About</a>
    							</li>
    						</ul>
    					</li>
                     <?php
                     }
                     ?>


				</ul>
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo $_SESSION['nware']['username']; ?> <img src="documents/avatar/<?php echo $_SESSION['nware']['user_id']; ?>/<?php echo $_SESSION['nware']['avatar']; ?>" alt="" width="25" height="25" style="width:25px; height:25px;"></a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="#" onClick="goLiveHelp()">Live Help</a>
						</li>
						<li>
							<a href="../logout.php">Sign out</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<!--<div class="container-fluid" id="content">-->

<script>
function goLiveHelp() {

        // Set height and width
        var NewWinHeight=600;
        var NewWinWidth=600;

        // Place the window
        var NewWinPutX=10;
        var NewWinPutY=10;

        //Get what is below onto one line

        TheNewWin = window.open("http://www.princetontrust.com/livehelp",'LiveHelp','fullscreen=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');

        //Get what is above onto one line

        TheNewWin.resizeTo(NewWinHeight,NewWinWidth);
        TheNewWin.moveTo(NewWinPutX,NewWinPutY);

        }
</script>