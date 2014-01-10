<?php
include_once(dirname(dirname(__FILE__)) . '/classes/check.class.php');
protect("1,2");

// Include our Events Calendar class
include_once(dirname(__FILE__) . '/classes/calendar.class.php');

$title = 'events';
$label = 'calendar';
include_once('header.php');

// Get event 'date' and 'type' to be displayed
if (isset($_REQUEST['date'])) { $date = $_REQUEST['date']; } else { $date = date('Y-m-d'); }
if (isset($_REQUEST['type'])) { $type = $_REQUEST['type']; } else { $type = 'payment'; }
if (isset($_REQUEST['type'])) { $type = $_REQUEST['type']; } else { $type = 'court'; }

if ($type == 'task') $table_title =  date('jS F Y', strtotime($date)) . ' Task Events';
elseif ($type == 'payment') $table_title = date('jS F Y', strtotime($date)) . ' Payment Events';
elseif ($type == 'court') $table_title = date('jS F Y', strtotime($date)) . ' Court Events';
$eventscalendar = new Events_calendar();
?>

<div class="container-fluid" id="content">

	<?php include_once('pages/events-nav-left.php'); ?>

	<div id="main">
		<div class="container-fluid">

			<?php include_once('pages/events-page-header.php'); ?>

			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<div class="box-title">
							<h3>
								<i class="icon-list-alt"></i>
								<?php echo $table_title; ?>
							</h3>
							<div class="actions">
								<a class="btn btn-mini" id="settings-add" href="#">
									<i class="icon-plus"></i>
								</a>
							</div>
						</div>
						<div class="box-content">
							<?php $eventscalendar->displayEventDetail($date, $type); ?>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>
<?php
include("footer.php");
?>