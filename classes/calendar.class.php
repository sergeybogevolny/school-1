<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Events_calendar extends Generic
{
	private $event_list = array();
	private $event_detail = array();

	public function getEventList($start, $end , $type) {
		
		if ($type == 'task'){
			$sql = "SELECT agency_users_tasks.deadline,count(*)  as COUNTS
					FROM agency_users_tasks
					WHERE agency_users_tasks.flag_complete = 0 AND
					 agency_users_tasks.deadline >= '$start'
					 AND agency_users_tasks.deadline <= '$end'
					GROUP BY agency_users_tasks.deadline";
			}
		if ($type == 'payment'){
			$sql = "SELECT agency_clients_accounts_schedules.date,
					count(*) as COUNTS
					FROM
					agency_clients_accounts_schedules
					INNER JOIN agency_clients ON agency_clients_accounts_schedules.client_id = agency_clients.id
					WHERE agency_clients.accountbalance > 0 and agency_clients_accounts_schedules.date>='$start' and agency_clients_accounts_schedules.date<='$end'
					GROUP BY agency_clients_accounts_schedules.date";
		
		    }
		if ($type == 'court'){
			$sql = "SELECT
					DATE(agency_bonds.setting),
					count(*) as COUNTS
					FROM
					agency_bonds
					INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
					WHERE agency_clients.type = 'Client' AND agency_bonds.setting>='$start' AND agency_bonds.setting<='$end'
					GROUP BY
					DATE(agency_bonds.setting)";
		
		    }
		
		
		$stmt = parent::query($sql);

		if ($stmt->rowCount() > 0) {
			while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
				//print_r($row);
				if ($type == 'task'){
				   $date =  $row['deadline'];
				}
				if ($type == 'payment'){
				   $date =  $row['date'];
				}
				if ($type == 'court'){
				   $date = $row['DATE(agency_bonds.setting)'];
				}
				
				$event_detail =array();
				$event_detail['title'] = $row['COUNTS'] . 'Events';
				$event_detail['start'] = $date;
				$event_detail['url'] = 'calendar-detail.php?date=' . $date . '&type=';

				if ($type == 'task') {
					$event_detail['className'] = 'calender-type-court';
					$event_detail['url'] .= 'task'; 
				} else if ($type == 'payment') {
					$event_detail['className'] = 'calender-type-payment';
					$event_detail['url'] .= 'payment'; 
				} else if ($type == 'court') {
					$event_detail['className'] = 'calender-type-court';
					$event_detail['url'] .= 'court'; 
				}
				
				$this->event_list[] = $event_detail;
			}
			
			return $this->event_list;

	}
	
	}
	public function displayEventDetail($date, $type) {
		$this->getEventDetail($date, $type);

		$table = '<table class="table table-hover table-nomargin dataTable table-bordered">';
		
		if($type == 'task'){
			$table .= '<thead><tr><th>Deadline</th><th>Task</th><th>Type</th></tr></thead>';
	
			foreach ($this->event_detail as $detail) {
				$table .= '<tr>';
				$table .= '<td>' . $detail['DATE'] . '</td>';
				$table .= '<td><a href="task.php?id='.$detail['TASKID'].'" >' . $detail['TASK'] . '</a></td>';
				$table .= '<td>' . $detail['TYPE'] . '</td>';
				$table .= '</tr>';
			}
		}
		
		if($type == 'payment'){
			$table .= '<thead><tr><th>Date</th><th>Name</th><th>Amount</th></tr></thead>';
	
			foreach ($this->event_detail as $detail) {
            $ndate = date('m/d/Y',strtotime($detail['DATE']));
				
				$table .= '<tr>';
				$table .= '<td>' . $ndate . '</td>';
				$table .= '<td><a href="client.php?id='.$detail['CLIENTID'].'" >' . $detail['NAME'] . '</a></td>';
				$table .= '<td>' . $detail['AMOUNT'] . '</td>';
				$table .= '</tr>';
			}
		}
		
		
		if($type == 'court'){
			$table .= '<thead><tr><th>Satting</th><th>Court</th><th>Name</th></tr></thead>';
	
			foreach ($this->event_detail as $detail) {
				
        $ndate = date('m/d/Y',strtotime($detail['SETTING']));
				
				$table .= '<tr>';
				$table .= '<td><a href="client.php?id='.$detail['CLIENTID'].'"  >' . $ndate . '</a></td>';
				$table .= '<td>' . $detail['COURT'] . '</td>';
				$table .= '<td>' . $detail['NAME'] . '</td>';
				$table .= '</tr>';
			}
		}
		$table .= '<tbody>';
		$table .= '</tbody><tfoot></tfoot></table>';

		// Display output!
		echo $table;
	}

	private function getEventDetail($date, $type) {
		
		if($type == 'task'){
			$this->getTaskEventDetail($date, $type);
		}
		if($type == 'payment'){
			$this->getPaymentEventDetail($date, $type);
		}
		if($type == 'court'){
			$this->getCourtEventDetail($date, $type);
		}
 	}
	
	
	private function getTaskEventDetail($date, $type) {
		
			$sql = "SELECT
					agency_users_tasks.id,
					agency_users_tasks.task,
					agency_users_tasks.type,
					agency_users_tasks.deadline,
					agency_users_tasks.flag_complete,
					agency_users_tasks.user_id
					FROM
					agency_users_tasks
					WHERE agency_users_tasks.flag_complete = 0 AND agency_users_tasks.deadline ='$date'
					";
		
					$stmt = parent::query($sql);
			
					if ($stmt->rowCount() > 0) {
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							if($type == 'task'){
							$detail = array();
							$detail['DATE'] = date('d M Y', strtotime($row['deadline']));	
							$detail['TASK'] = $row['task'];								
							$detail['TYPE'] = $row['type'];
							$detail['TASKID'] = $row['id'];
							
							
														
							$this->event_detail[] = $detail;							
						}
					}}
			
					return $this->event_detail;
	
	}
	
	private function getPaymentEventDetail($date, $type) {
		
			$sql = "SELECT
			        agency_clients_accounts_schedules.client_id,
					agency_clients_accounts_schedules.date,
					agency_clients.last,
					agency_clients.`first`,
					agency_clients.middle,
					agency_clients_accounts_schedules.amount
					FROM
					agency_clients_accounts_schedules
					INNER JOIN agency_clients ON agency_clients_accounts_schedules.client_id = agency_clients.id
					WHERE
					agency_clients.accountbalance > 0 AND agency_clients_accounts_schedules.date ='$date'
					";
		
					$stmt = parent::query($sql);
			
					if ($stmt->rowCount() > 0) {
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							//print_r($row);
							if($type == 'payment'){
							$detail = array();
							$detail['DATE'] = date('d M Y', strtotime($row['date']));	
							$detail['NAME'] = $row['first'].' '.$row['middle'] .' '. $row['last'];								
							$detail['AMOUNT'] = $row['amount'];
							$detail['CLIENTID'] = $row['client_id'];
							
							
														
							$this->event_detail[] = $detail;							
						}
					}}
			
					return $this->event_detail;
	
	}
		private function getCourtEventDetail($date, $type) {
        
		
			$sql = "SELECT
			        agency_bonds.client_id,
					agency_clients.last,
					agency_clients.`first`,
					agency_clients.middle,
					agency_bonds.setting,
					agency_bonds.court
					FROM
					agency_bonds
					INNER JOIN agency_clients ON agency_bonds.client_id = agency_clients.id
					WHERE agency_clients.type = 'Client' AND agency_bonds.setting like '%" . $date . "%'
					";
					$stmt = parent::query($sql);
					if ($stmt->rowCount() > 0) {
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							
							if($type == 'court'){
							$detail = array();
							$detail['SETTING'] = $row['setting'];	
							$detail['COURT'] = $row['court'];
							$detail['NAME'] = $row['first'].' '.$row['middle'] .' '. $row['last'];								
							$detail['CLIENTID'] = $row['client_id'];
							
														
							$this->event_detail[] = $detail;							
						}
					}}
			
					return $this->event_detail;
	
	}

}
?>