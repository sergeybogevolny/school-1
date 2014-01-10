<?php
/*
	FILE: dashboard-production.js
	AUTHOR: risanbagja
	DATE: July 24th 2013
*/

// Include Generic class, which will be extended
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

// Our Dashboard-production class, to retrieve sales data from agency_clients table
class Dashboard_production extends Generic
{
	private $ending_date;		// Latest date to plot the data
	private $total_days = 7;	// Numbers days to plot before the ending date

	private $close_ratio;		// Helper variable to hold first chart value
	private $sales_source;		// Helper variable to hold second chart value

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Class constructor
	function __construct() {
		// Initialize ending_date, in this case today's date
		$this->ending_date = date('Y-m-d');
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Function to retrieve total numbers of 'Clients and Prospects'
	// $type = 'Client' or 'Prospect'
	public function getCloseRatio($type) {
		// SQL query to fetch numbers of 'Client'/'Prospect' type
		$sql = "
			SELECT DATE(created) AS 'DATE', 
			COUNT(*) AS 'COUNTS' 
			FROM agency_clients
			WHERE type = '$type' AND 
			DATEDIFF('$this->ending_date', DATE(created)) <= $this->total_days
			GROUP BY DATE(created)
			ORDER BY DATE(created)
		";

		// Execute our query
		$stmt = parent::query($sql);

		// If no data return, inform error!
		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} 

		// If data is exsist 
		else {
			// Prepare our helper variable
			$this->prepareCloseRatio($this->close_ratio);
			// Fetch each row, get total numbers of current type
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$this->close_ratio[$row['DATE']] = $row['COUNTS'];
			}
		}

		// Reverse array content, so the oldest date came first
		$this->close_ratio = array_reverse($this->close_ratio);

		// Modify our helper variable, so it is easier to be used in Javascript
		$close_ratio_res = array();
		foreach ($this->close_ratio as $key => $val) {
			$close_ratio_res[] = array('date' => $key, 'counts' => $val);
		}
		// Format result to JSON type
		return json_encode($close_ratio_res);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Function to retrieve total amount grouped by it's source
	public function getSalesSource() {
		// SQL query to retrieve total amount based on it's source
		$sql = "
			SELECT SUM(amount) as 'AMOUNT', 
			source as 'SOURCE', 
			DATE(created) as 'DATE'
			FROM agency_clients
			WHERE type = 'Client'
			GROUP BY source, DATE(created)
			ORDER BY DATE(created)
		";

		// Execute our query
		$stmt = parent::query($sql);

		// If no data return, inform error!
		if ( $stmt->rowCount() < 1 ) {
		    echo "<div class='alert alert-error' id='status'>FAIL</div>";
		    return false;
		} 

		// If data is exists 
		else {
			// Prepare our helper variable
			$this->prepareSalesSource($this->sales_source);
			// Fetch each row, get total amount spent based on it's source
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				$this->sales_source[$row['DATE']][$row['SOURCE']] = $row['AMOUNT'];
			}
		}

		// Reverse our array content, so the oldest date came first
		$this->sales_source =array_reverse($this->sales_source);

		// Modify our helper variable, so it is easier to be used in Javascript
		$sales_source_res = array();
		foreach ($this->sales_source as $key => $val) {
			// Array with 'detail' key would hold total amount of each source type
			$sales_source_res[] = array('date' => $key, 'detail' => $val);
		}
		// Format our result in JSON
		return json_encode($sales_source_res);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Function to prepare our helper variable for Close Ratio chart
	private function prepareCloseRatio(&$chart_data) {
		$chart_data = array();
		$date = $this->ending_date;

		// Create an empty array variable with key 'date'
		for ($i = 0; $i < $this->total_days; $i++) {
			$chart_data[$date] = 0;
			// Move date 1 day backward
			$date = date('Y-m-d', strtotime($date) - (60 * 60 * 24));
		}
		return $chart_data;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Function to prepare our helper variable for Sales Source chart
	private function prepareSalesSource(&$chart_data) {
		$chart_data = array();
		$date = $this->ending_date;

		// Create an empty array variable with key 'date'
		for ($i = 0; $i < $this->total_days; $i++) {
			$chart_data[$date] = array(
				'Attorney' => 0,
				'Coupon' => 0,
				'Friend' => 0,
				'Internet' => 0,
				'Television' => 0,
				'Radio' => 0
			);

			// Move date 1 day backward
			$date = date('Y-m-d', strtotime($date) - (60 * 60 * 24));
		}
		return $chart_data;
	}
}

// Initialize Dashboard_production class
$dashboardproduction = new Dashboard_production();
?>