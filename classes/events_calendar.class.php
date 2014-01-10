<?php
/*
	FILE: events_calendar.class.php
	AUTHOR: risanbagja
	DATE: July 27th 2013
*/

// Load generic class to extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// OUR EVENTS_CALENDAR CLASS, USED TO RETRIEVE AGENCY EVENTS FROM DATABASE 
class Events_calendar extends Generic
{
	private $event_list = array();
	private $event_detail = array();

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// getEventList(), function to generate event list for fullCalendar plugin
	// $start = starting date to retrieve
	// $end = ending date to retrieve
	public function getEventList($start, $end) {
		// Query string to retrieve total numbers of each event type in the given date range
		$sql = "
			SELECT COUNT(*) as COUNTS,
			`type` as TYPE,
			`date` as DATE
			FROM agency_events
			WHERE `date` >= '$start'
			AND `date` <= '$end'
			GROUP BY `type`, `date`
		";

		// Execute query string
		$stmt = parent::query($sql);

		// If data is available, fetch it!
		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				// Temporary variable to hold our event detail
				$event_detail =array();
				// Constructiong event's title which displayed on calendar 
				$event_detail['title'] = $row['COUNTS'] . ' ' . $row['TYPE'] . ' Events';
				// Start date of event
				$event_detail['start'] = $row['DATE'];
				// Event's URL
				$event_detail['url'] = 'events-calendar-detail.php?date=' . $row['DATE'] . '&type=';

				// Set CSS classname based on their event type. CSS file located at: 'css/themes.css'
				// Also complete it's event detail page URL
				if ($row['TYPE'] == 'court') {
					$event_detail['className'] = 'event-type-court';
					$event_detail['url'] .= 'court'; 
				} else if ($row['TYPE'] == 'payment') {
					$event_detail['className'] = 'event-type-payment';
					$event_detail['url'] .= 'payment'; 
				}
				
				// Append to our array
				$this->event_list[] = $event_detail;
			}
			// Return a set of event list in the given date
			return $this->event_list;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// displayEventDetail(), function to display detail of each event in the give date
	// $date = date of events
	// $type = type of event, 'court' or 'payement'
	public function displayEventDetail($date, $type) {
		// Retrieve event detail
		$this->getEventDetail($date, $type);

		// Table header
		$table = '<table class="table table-hover table-nomargin dataTable table-bordered">';
		$table .= '<thead><tr><th>Name</th><th>Date</th><th>Type</th></tr></thead>';

		// Table content, displaying each detail
		foreach ($this->event_detail as $detail) {
			$table .= '<tr>';
			$table .= '<td>' . $detail['VALUE'] . '</td>';
			$table .= '<td>' . $detail['DATE'] . '</td>';
			$table .= '<td>' . $detail['TYPE'] . '</td>';
			$table .= '</tr>';
		}

		// Table footer
		$table .= '<tbody>';
		$table .= '</tbody><tfoot></tfoot></table>';

		// Display output!
		echo $table;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// getEventDetail(), function to retrieve detail of each event in the give date
	// $date = date of events
	// $type = type of event, 'court' or 'payement'
	private function getEventDetail($date, $type) {
		// SQL query to retrieve event details
		$sql = "
			SELECT `date`, `type`, `value`
			FROM `agency_events`
			WHERE `date` = '$date'
			AND `type` = '$type'
		";

		// Execute query!
		$stmt = parent::query($sql);

		// If data is available, procceed!
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$detail = array();
				$detail['DATE'] = date('d M Y', strtotime($row['date']));	// Date of event
				$detail['TYPE'] = $row['type'];								// Event type
				$detail['VALUE'] = $row['value'];							// Event value
				$this->event_detail[] = $detail;							// Push to the event_detail!
			}
		}

		// Return back event_detail
		return $this->event_detail;
	}
}
?>