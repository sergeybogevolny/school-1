<?php

// Include our Event Calendar class, used to retrive event data from database
include_once(dirname(__FILE__) . '/classes/calendar.class.php');

// Get parameter passed by fullCalendar plugin
$start = $_GET['start'];
$end = $_GET['end'];
$type = $_GET['type'];

//print_r($start);
// Convert UNIX timestamp into formated date
$start_date = date('Y-m-d', $start);
$end_date = date('Y-m-d', $end);
// Initialiaze Event Calendar object
$eventscalendar = new Events_calendar();
// Get list of event from start_date until end_date
$event_feed = $eventscalendar->getEventList( $start_date, $end_date , $type );
// Convert it into JSON, so it could be consumed by fullCalendar
echo json_encode($event_feed);