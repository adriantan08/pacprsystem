<?php
class crud_model extends CI_Model {
	
	function getdb(){
		return $this->load->database('default',true);
	}
	
	function addPaymentRecord($json){
		$arr = json_decode($json, true)[0];
		$status = 0; //status is 0 since it is newly created.
		
		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H:i:s');
		
		$sql = "
			INSERT INTO pac_pr_header(pr_id, pr_status, requestor_id, changed_on)
			VALUES(?,?,?,?);
		";
		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$status,
								0,
								$serverDate
							));
		
		$sql = "
			INSERT INTO pac_pr_details(pr_id, payee, status, payment_form, purpose, dist_class, dist_yield, po_jo_no, rr_no, inv_no, others, details, changed_on)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);
		";
		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$arr['prPayee'],
								$status,
								
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
	
	
}
?>