<?php
class crud_model extends CI_Model {

	function getdb(){
		return $this->load->database('default',true);
	}

/*******************************************************************
*
*	INSERTS
*
********************************************************************/


	function addPaymentRecord($json){
		$arr = json_decode($json, true)[0];
		$requestor_id = $this->getCurrentRequestor();

		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H:i:s');


		//INSERT TO pac_pr_header
		$sql = "
			INSERT INTO pac_pr_header(pr_id, pr_status, pr_date, requestor_id, changed_on)
			VALUES(?,?,?,?,?);
		";



		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$arr['prStatus'],
								$arr['prDate'],
								$requestor_id,
								$serverDate
							));

		//INSERT TO pac_pr_details
		$sql = "
			INSERT INTO pac_pr_details(pr_id, payee, amount, payment_form, purpose, dist_class, dist_yield, po_jo_no, rr_no, inv_no, others, details, changed_on, receipt_img)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);
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

								$serverDate,
								
								$arr['prReceiptImg']
							));
		$this->logHistory($json,"CREATE");

	}

/*******************************************************************
*
*	INSERTS
*
********************************************************************/


/*******************************************************************
*
*	SELECT
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
			WHERE a.pr_id = b.pr_id
			ORDER BY changed_on desc;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	function getPrListForAsh($status){
		$sql = "
			SELECT
				a.pr_id AS `pr_id`,
				a.pr_status AS `pr_status`,
				a.pr_date AS `pr_date`,
				c.emp_firstname AS `emp_firstname`,
				c.emp_lastname AS `emp_lastname`,
				b.payee AS `payee`,
				b.amount AS `amount`,
				a.approver1_id AS `approver1_id`,
				a.approver2_id AS `approver2_id`,
				a.approver3_id AS `approver3_id`
			FROM pac_pr_header a, pac_pr_details b, pac_employees c
			WHERE a.pr_id = b.pr_id
			AND a.pr_status = ?
			AND a.requestor_id = c.emp_id
			ORDER BY a.pr_date desc;
		";
		$q = $this->getdb()->query($sql, array($status));
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	function getPrListForWfc($status){
		$sql = "
			SELECT
				a.pr_id AS `pr_id`,
				a.pr_status AS `pr_status`,
				a.pr_date AS `pr_date`,
				c.emp_firstname AS `emp_firstname`,
				c.emp_lastname AS `emp_lastname`,
				b.payee AS `payee`,
				b.amount AS `amount`,
				a.approver1_id AS `approver1_id`,
				a.approver2_id AS `approver2_id`,
				a.approver3_id AS `approver3_id`
			FROM pac_pr_header a, pac_pr_details b, pac_employees c
			WHERE a.pr_id = b.pr_id
			AND a.pr_status = ?
			AND a.requestor_id = c.emp_id
			AND c.emp_id = ?
			ORDER BY a.pr_date desc;

		";
		$uid = $this->getCurrentRequestor();
		$q = $this->getdb()->query($sql, array($status,$uid));
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
				b.others AS `others`,
				b.receipt_img as `receipt_img`
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
*	SELECT
*
********************************************************************/


/*******************************************************************
*
*	UPDATE
*
********************************************************************/
	function updatePaymentRecord($json){
		$arr = json_decode($json, true)[0];
		$requestor_id = $this->getCurrentRequestor();

		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H:i:s');


		//UPDATE TO pac_pr_header
		$sql = "
			UPDATE pac_pr_header
			SET
				pr_status = ?,
				pr_date = ?,
				requestor_id = ?,
				changed_on = ?
			WHERE pr_id = ?;
		";



		$this->getdb()->query($sql, array(
								$arr['prStatus'],
								$arr['prDate'],
								$requestor_id,
								$serverDate,
								$arr['prNum']
							));

		//UPDATE TO pac_pr_details
		$sql = "
			UPDATE pac_pr_details
			SET
				payee = ?,
				amount = ?,
				payment_form = ?,
				purpose = ?,
				dist_class = ?,
				dist_yield = ?,
				po_jo_no = ?,
				rr_no = ?,
				inv_no = ?,
				others = ?,
				details = ?,
				changed_on = ?,
				receipt_img = ?
			WHERE
				pr_id = ?;
		";
		$this->getdb()->query($sql, array(
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
								$serverDate,
								$arr['prReceiptImg'],
								
								$arr['prNum']
							));


		$this->logHistory($json, "UPDATE");
		//ADRIAN: SEND EMAIL IF $arr['prStatus'] == 1; send to Admin Sec Head

	}

	function updatePrStatus($prNum, $prStatus, $approvalType){
		$userId = $this->getCurrentRequestor();
		$userRole = $this->getCurrentUserRole();
		
		if($userRole == 'ASH'){
			$column = 'approver1_id';
		}
		else if($userRole == 'VERIFIER'){
			$column = 'approver2_id';
		}
		else if($userRole == 'APPROVER'){
			$column = 'approver3_id';
		}
		else
			exit(); //problem with getting current user role. If role doesn't match anything, do nothing.
		
		$sql = "
			UPDATE pac_pr_header
			SET
				pr_status = ?,
				".$column." = ?
			WHERE
				pr_id = ?;
		";
		$this->getdb()->query($sql, array(
								$prStatus,
								$userId,
								$prNum
							));

		$this->logHistoryApproval($prNum, $prStatus, $approvalType);
	}

/*******************************************************************
*
*	UPDATE
*
********************************************************************/



/*******************************************************************
*
*	REUSABLES
*
********************************************************************/
	/*
	*	This is the default history tracking for WCF users that creates and updates their PR form
	*	INSERT TO pac_pr_history + the json_encoded value of the pr_details for logging purposes
	*/
	function logHistory($json, $msg){
		$arr = json_decode($json, true)[0];
		$requestor_id = $this->getCurrentRequestor();

		$sql  = "
			INSERT INTO pac_pr_history(pr_id, status, remarks, user_id, pr_data)
			VALUES(?,?,?,?,?);

		";
		$this->getdb()->query($sql, array(
								$arr['prNum'],
								$arr['prStatus'],
								$msg,
								$requestor_id,
								$json
		));
	}


	/*
	*	This is another version/function to track PR history.
	*	This is catered for simple tracking of a PR's approval status so no JSON data are needed
	*
	*/
	function logHistoryApproval($prNum, $prStatus,$approvalType){

		$requestor_id = $this->getCurrentRequestor();

		$sql  = "
			INSERT INTO pac_pr_history(pr_id, status, remarks, user_id)
			VALUES(?,?,?,?);

		";
		$this->getdb()->query($sql, array(
								$prNum,
								$prStatus,
								'APPROVAL STATUS CHANGE BY: '.$approvalType,
								$requestor_id
		));
	}

	function getCurrentRequestor(){
		return $this->session->userdata('userId');
	}
	
	function getCurrentUserRole(){
		return $this->session->userdata('userRole');
	}
/*******************************************************************
*
*	REUSABLES
*
********************************************************************/

}
?>
