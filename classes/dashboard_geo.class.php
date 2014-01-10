<?php
// Load generic class to extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Dashboard_geo extends Generic
{
	private $location_data;

	// Dashboard geo constructor
	function __construct() {
		$this->location_data = $this->grab();
		echo json_encode($this->location_data);
	}

	// Fetch latitude & logitude data from agency clients
	private function grab() {
		// Get latitude & longitude data
		$stmt = parent::query("SELECT latitude, longitude FROM agency_clients");

		// If no data return, inform error!
		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} 

		else {
			$location_data = array();
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$latitude = (double) $row['latitude'];
				$longitude = (double) $row['longitude'];
				$location_data[] = array($latitude, $longitude);
			}
			return $location_data;
		}
	}
}

$dashboardgeo = new Dashboard_geo();
?>