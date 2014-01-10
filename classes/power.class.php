<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Power extends Generic {

	function __construct() {
		if(!empty($_GET['id'])) $this->grab();
	}


    private function grab() {

        $this->id = parent::secure($_GET['id']);
		$params = array( ':id' => $this->id );

        $sql = "SELECT
        general_powers.id,
        general_powers.prefix,
        general_powers.serial,
        general_powers_orders.date AS ordered,
        general_powers_distributes.date AS distributed,
        general_powers.agent,
        general_powers_collects.date AS collected,
        general_powers_collects_details.executed,
        general_powers_collects_details.defendant,
        general_powers_collects_details.amount,
        general_powers_collects_details.void,
        general_powers_collects_details.transfer,
        general_powers_reports.date AS reported,
        general_forfeitures.forfeited,
        general_forfeitures.received,
        general_forfeitures.answered,
        general_forfeitures.documentedlevel,
        general_forfeitures.disposed,
        general_transfers.posted AS transfered,
        general_transfers.requestingagent,
        general_transfers.settled,
        general_transfers.id AS transferid,
        general_forfeitures.id AS forfeitureid,
        general_forfeitures.amount AS forfeitureamount,
        general_transfers.amount AS transferamount,
        general_transfers.type AS transfertype,
        general_forfeitures.type AS forfeituretype
        FROM
        general_powers
        LEFT JOIN general_powers_orders ON general_powers_orders.id = general_powers.order_id
        LEFT JOIN general_powers_distributes ON general_powers_distributes.id = general_powers.distribute_id
        LEFT JOIN general_powers_collects ON general_powers.collect_id = general_powers_collects.id
        LEFT JOIN general_powers_collects_details ON general_powers.collectdetail_id = general_powers_collects_details.collect_id
        LEFT JOIN general_powers_reports ON general_powers.report_id = general_powers_reports.id
        LEFT JOIN general_forfeitures ON general_forfeitures.power_id = general_powers.id
        LEFT JOIN general_transfers ON general_transfers.power_id = general_powers.id
        WHERE general_powers.id = :id;";

		$stmt   = parent::query($sql, $params);

        if( $stmt->rowCount() < 1 ) parent::displayMessage("<div class='alert alert-error'>No such record</div>");

	    foreach ($stmt->fetch(PDO::FETCH_ASSOC) as $field => $value)
		    $this->options[$field] = $value;

	}


	public function getField($field) {

		if (!empty($this->options[$field]))
			return $this->options[$field];
	}

}
$power = new Power();
?>