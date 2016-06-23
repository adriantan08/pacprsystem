<?php
class crud_model extends CI_Model {
	
	function getdb(){
		return $this->load->database('default',true);
	}
	
	function addPaymentRecord($json){
		$arr = json_decode($json, true)[0];
		
		$status = 0; //status is 0 since it is newly created.
		$requestor_id = 0; //will be replaced with logged in user id 
		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H:i:s');
		
		
		
		$sql = "
			INSERT INTO pac_pr_header(pr_id, pr_status, pr_date, requestor_id, changed_on)
			VALUES(?,?,?,?,?);
		";
		
		
		
		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$status,
								$arr['prDate'],
								$requestor_id,
								$serverDate
							));
		
		$sql = "
			INSERT INTO pac_pr_details(pr_id, payee, amount, payment_form, purpose, dist_class, dist_yield, po_jo_no, rr_no, inv_no, others, details, changed_on)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);
		";
		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$arr['prPayee'],
								$arr['prAmount'],
								
								$arr['prForm'],
								$arr['prPurpose'],
								$arr['prDisbClass'],
								$arr['prDisbYield'],
									
								$arr['prPoJoNo'],
								$arr['prRcvReportNo'],
								$arr['prInvoiceNo'],
								$arr['prOthers'],
								$arr['prDetails'],
								
								$serverDate
							));
	}
	
	/*******************************************************************
	*
	*	ALL READ / SELECT
	*
	********************************************************************/
	
	function getPrList(){
		$sql = "
			SELECT 
				a.pr_id AS `pr_id`,
				a.pr_status AS `pr_status`,
				a.changed_on AS `changed_on`,
				a.approver1_id AS `approver1_id`,
				a.approver2_id AS `approver2_id`,
				a.approver3_id AS `approver3_id`,
				b.payee AS `payee`,
				b.details AS `details`
			FROM pac_pr_header a, pac_pr_details b
			WHERE a.pr_id = b.pr_id;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}
	
	function getPrById($id){
		$sql = "
			SELECT
				a.pr_id AS `pr_id`,
				a.pr_date AS `pr_date`,
				a.pr_status AS `pr_status`,
				a.pr_status AS `pr_status`,
				a.changed_on AS `changed_on`,
				a.approver1_id AS `approver1_id`,
				a.approver2_id AS `approver2_id`,
				a.approver3_id AS `approver3_id`,
				b.payee AS `payee`,
				b.amount AS `amount`,
				b.details AS `details`,
				b.payment_form AS `payment_form`,
				b.purpose AS `purpose`,
				b.dist_class AS `dist_class`,
				b.dist_yield AS `dist_yield`,
				b.po_jo_no AS `po_jo_no`,
				b.rr_no AS `rr_no`,
				b.inv_no AS `inv_no`,
				b.others AS `others`
			FROM pac_pr_header a, pac_pr_details b
			WHERE a.pr_id = b.pr_id
			AND a.pr_id = ?
			LIMIT 1;
		";
		
		$q = $this->getdb()->query($sql, array($id));
		if($q->num_rows()>0){
			return $q->first_row('array');
		}
		return null;
	}
	
	
	/*******************************************************************
	*
	*	ALL READ / SELECT
	*
	********************************************************************/
}
?>