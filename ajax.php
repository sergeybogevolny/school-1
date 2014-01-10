<?php
if (!isset($_SESSION)) session_start();

$action = $_GET['action'];

switch ($action) {
    case 'refresh_feed':
        include_once(dirname(__FILE__) . '/classes/agency_feeds.class.php');
        $after_feed = intval($_GET['after_feed']);
        $output['feeds'] = $feeds->getLatest($after_feed);
        $output['latest_feed_id'] = $feeds->latest_feed_id;
        echo json_encode($output);
        break;
}