<?php
/*
	FILE: events_calendar.class.php
	AUTHOR: risanbagja
	DATE: July 27th 2013
*/

// Include our Event Calendar class, used to retrive event data from database
include_once(dirname(__FILE__) . '/classes/events_calendar.class.php');

// Get parameter passed by fullCalendar plugin
$start = $_GET['start'];
$end = $_GET['end'];

// Convert UNIX timestamp into formated date
$start_date = date('Y-m-d', $start);
$end_date = date('Y-m-d', $end);

// Initialiaze Event Calendar object
$eventscalendar = new Events_calendar();
// Get list of event from start_date until end_date
$event_feed = $eventscalendar->getEventList($start_date, $end_date);
// Convert it into JSON, so it could be consumed by fullCalendar
echo json_encode($event_feed);