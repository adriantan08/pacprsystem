<?php
class Crud_model extends CI_Model {

	function getdb(){
		if(ENVIRONMENT !== 'production')
			return $this->load->database('default',true);
		else
			return $this->load->database('production',true);
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
			INSERT INTO pac_pr_details(pr_id, payee, amount, payment_form, purpose, dist_class, dist_yield, po_jo_no, rr_no, inv_no, others, details, changed_on, receipt_img, exp_code)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
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

								$arr['prReceiptImg'],
								$arr['prExpCode']
							));
		$this->logHistory($json,"CREATE");

	}
	
	function addComment($prId, $comment){
		$userId = $this->session->userdata('userId');
		$sql = "
			INSERT INTO pac_pr_comments(pr_id, comment_text, comment_by)
			VALUES(?,?,?);
		";
		
		$this->getdb()->query($sql, array(
			$prId, $comment, $userId
		));
		
		
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
				a.request_read_flag AS `request_read_flag`,
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
	
	//USED IN PRINT
	function getBulkPr($ids){
		$ids = explode(' ', $ids);
		
		//prepare the question marks for the prepared statement later where the $ids will be binded
		$questionmarks = array();
		if(count($ids)>0){
			foreach($ids as $i){
				//To be safe on our question, we check if we got all IDs are integer. 
				if(!is_numeric($i)) exit("Malfromed parameter");
				$questionmarks[] = '?';
			}
		}
		else
			exit("Nothing to print.");
		
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
				b.receipt_img as `receipt_img`,
				CONCAT(c.exp_code_id,'|',c.exp_desc) as `exp_code`
			FROM pac_pr_header a, pac_pr_details b, pac_exp_codes c
			WHERE a.pr_id = b.pr_id
			AND b.exp_code = c.exp_code_id
			AND a.pr_id IN (
			
		";
		$sql .= implode(',', $questionmarks);
		$sql .= ")
				ORDER BY a.pr_id ASC;
		;";
		
		$q = $this->getdb()->query($sql, $ids);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}
	

//WFC
	function getDraftedPRs($status){
		$empId = $this->session->userdata('userId');
		$empRole = $this->session->userdata('userRole');
		$roleQuery = "AND a.requestor_id = ".$empId;
		$sql = "
			SELECT
				a.pr_id AS `pr_id`,
				a.pr_status AS `pr_status`,
				a.pr_date AS `pr_date`,
				a.request_read_flag AS `request_read_flag`,
				c.emp_firstname AS `emp_firstname`,
				c.emp_lastname AS `emp_lastname`,
				b.payment_form AS `pr_paymentForm`,
				b.payee AS `payee`,
				b.amount AS `amount`
			FROM pac_pr_header a, pac_pr_details b, pac_employees c
			WHERE a.pr_id = b.pr_id
			AND a.pr_status = ?
			".$roleQuery."
			AND a.requestor_id = c.id
			ORDER BY a.pr_date desc;
		";
		$q = $this->getdb()->query($sql, array($status));
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

//WFC
	function getSubPRs($status){

		$empId = $this->session->userdata('userId');
		$empRole = $this->session->userdata('userRole');
		$roleQuery = "";
		if($empRole=='WFC') {
			$roleQuery = " AND a.requestor_id = ".$empId;
		}
		if($empRole=='ASH') {
			$roleQuery = " AND (a.approver1_id = ".$empId." or a.approver1_id = 999) ";
		}
		if($empRole=='VERIFIER') {
			$roleQuery = " AND (a.approver2_id = ".$empId." or a.approver2_id = 999) ";
		}
		if($empRole=='APPROVER') {
			$roleQuery = " AND (a.approver3_id = ".$empId." or a.approver3_id = 999) ";
		}
		$sql = "
			SELECT
				a.pr_id AS `pr_id`,
				d.status_name AS `pr_status`,
				a.pr_date AS `pr_date`,
				a.request_read_flag AS `request_read_flag`,
				a.approver1_read_flag AS `approver1_read_flag`,
				a.approver2_read_flag AS `approver2_read_flag`,
				a.approver3_read_flag AS `approver3_read_flag`,
				c.emp_firstname AS `emp_firstname`,
				c.emp_lastname AS `emp_lastname`,
				b.payment_form AS `pr_paymentForm`,
				b.payee AS `payee`,
				b.amount AS `amount`
			FROM pac_pr_header a, pac_pr_details b, pac_employees c, pac_pr_status d
			WHERE a.pr_id = b.pr_id
			AND a.pr_status in ".$status.
			$roleQuery."
			AND a.requestor_id = c.id
			AND a.pr_status = d.status
			ORDER BY a.pr_date desc;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	//for ALL
	function getApprovedPRs($status, $amount){

		$sql = "
		SELECT
		a.pr_id AS `pr_id`,
		a.pr_status AS `pr_status`,
		a.pr_date AS `pr_date`,
		a.request_read_flag AS `request_read_flag`,
		a.approver1_read_flag AS `approver1_read_flag`,
		a.approver2_read_flag AS `approver2_read_flag`,
		a.approver3_read_flag AS `approver3_read_flag`,
		b.payment_form AS `pr_paymentForm`,
		c.emp_firstname AS `emp_firstname`,
		c.emp_lastname AS `emp_lastname`,
		d.emp_firstname AS `asc_firstname`,
		d.emp_lastname AS `asc_lastname`,
		e.emp_firstname AS `ver_firstname`,
		e.emp_lastname AS `ver_lastname`,
		f.emp_firstname AS `app_firstname`,
		f.emp_lastname AS `app_lastname`,
		b.payee AS `payee`,
		b.amount AS `amount`,
		a.approver1_id AS `approver1_id`,
		a.approver2_id AS `approver2_id`,
		a.approver3_id AS `approver3_id`
		FROM pac_pr_header a, pac_pr_details b, pac_employees c, pac_employees d, pac_employees e,
		pac_employees f
		WHERE a.pr_id = b.pr_id
		AND a.pr_status = ?
		AND b.amount ".$amount."
		AND a.requestor_id = c.id
		AND a.approver1_id = d.id
		AND a.approver2_id = e.id
		AND a.approver3_id = f.id
		ORDER BY a.pr_date desc
		";
		$q = $this->getdb()->query($sql, array($status));
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
				
				a.approver1_read_flag AS `approver1_read_flag`,
				
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
			AND a.requestor_id = c.id
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
				a.request_read_flag AS `request_read_flag`,
				
				b.payment_form AS `pr_paymentForm`,
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
			AND a.requestor_id = c.id
			AND c.id = ?
			ORDER BY a.pr_date desc;
		";
		$uid = $this->getCurrentRequestor();
		$q = $this->getdb()->query($sql, array($status,$uid));
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	function getPrListForAa($status, $amount){

		$sql = "
		SELECT
		a.pr_id AS `pr_id`,
		a.pr_status AS `pr_status`,
		a.pr_date AS `pr_date`,

		a.approver3_read_flag AS `approver3_read_flag`,
				
		c.emp_firstname AS `emp_firstname`,
		c.emp_lastname AS `emp_lastname`,
		d.emp_firstname AS `asc_firstname`,
		d.emp_lastname AS `asc_lastname`,
		e.emp_firstname AS `ver_firstname`,
		e.emp_lastname AS `ver_lastname`,
		f.emp_firstname AS `app_firstname`,
		f.emp_lastname AS `app_lastname`,
		b.payee AS `payee`,
		b.amount AS `amount`,
		a.approver1_id AS `approver1_id`,
		a.approver2_id AS `approver2_id`,
		a.approver3_id AS `approver3_id`
		FROM pac_pr_header a left outer join pac_employees f on a.approver3_id = f.id, pac_pr_details b, pac_employees c, pac_employees d, pac_employees e
		WHERE a.pr_id = b.pr_id
		AND a.pr_status = ?
		AND b.amount ".$amount."
		AND a.requestor_id = c.id
		AND a.approver1_id = d.id
		AND a.approver2_id = e.id
		ORDER BY a.pr_date desc
		";
		$q = $this->getdb()->query($sql, array($status));
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	function getPrListForV($status, $amount){
		$empId = $this->session->userdata('userId');
		$query = " and (a.approver2_id = ".$empId." or  a.approver2_id = 999) ";
		if($status=='30' or $status=='25') {
			$query = " and a.approver2_id = ".$empId;
		}

		$sql = "
		SELECT
		a.pr_id AS `pr_id`,
		a.pr_status AS `pr_status`,
		a.pr_date AS `pr_date`,
		
		a.approver2_read_flag AS `approver2_read_flag`,
		
		c.emp_firstname AS `emp_firstname`,
		c.emp_lastname AS `emp_lastname`,
		d.emp_firstname AS `asc_firstname`,
		d.emp_lastname AS `asc_lastname`,
		e.emp_firstname AS `ver_firstname`,
		e.emp_lastname AS `ver_lastname`,
		b.payee AS `payee`,
		b.amount AS `amount`,
		a.approver1_id AS `approver1_id`,
		a.approver2_id AS `approver2_id`,
		a.approver3_id AS `approver3_id`
		FROM 
			pac_pr_header a left outer join 
				pac_employees e on a.approver2_id = e.id, 
			pac_pr_details b, 
			pac_employees c, 
			pac_employees d
		WHERE a.pr_id = b.pr_id
		AND a.pr_status = ?
		AND b.amount ".$amount.
		$query."
		AND a.requestor_id = c.id
		AND a.approver1_id = d.id
		ORDER BY a.pr_date desc
	";

		$q = $this->getdb()->query($sql, array($status));
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
				b.receipt_img as `receipt_img`,
				CONCAT(b.exp_code,' - ',c.exp_desc) as `exp_code`,
				b.exp_code as `exp_code_only`
			FROM pac_pr_header a, pac_pr_details b, pac_exp_codes c
			WHERE a.pr_id = b.pr_id
			AND b.exp_code = c.exp_code_id
			AND a.pr_id = ?
			LIMIT 1;
		";

		$q = $this->getdb()->query($sql, array($id));
		if($q->num_rows()>0){
			return $q->first_row('array');
		}
		return null;
	}

	function getDistinctPayees(){
		$sql = "
			SELECT DISTINCT(payee) FROM pac_pr_details
			WHERE payee IS NOT NULL AND payee != ''
			ORDER BY payee ASC;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			$arr = array();
			foreach($q->result_array() as $row){
				$arr[] = $row['payee'];
			}
			return json_encode($arr);
		}
		return null;
	}

	function getCandidatePr(){
		$sql = "SELECT MAX(pr_id) +1 AS `max` FROM pac_pr_header;";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->first_row()->max;
		}
		return null;
	}
	
	function getComments($prId){
		$sql = "
			SELECT  
			a.comment_text,
			a.date_added,
			b.emp_firstname,
			b.emp_lastname,
			b.emp_email
		FROM pac_pr_comments a, pac_employees b
		WHERE a.comment_by = b.id
		AND a.pr_id = ?
		ORDER BY a.date_added DESC;";
		
		$q = $this->getdb()->query($sql, array($prId));
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}
	
	function getExpCodes(){
		$expCode = $this->session->userdata('expCodeId');
		$sql="
			SELECT 
				exp_code_id,
				exp_desc,
				exp_remarks,
				`status`
			FROM pac_exp_codes WHERE submit_step IN 
				(SELECT exp_code_id 
					FROM pac_employees 
					WHERE exp_code_id = $expCode)
			AND `status` = 'A';


		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			$a = $q->result_array();
			$fArr = array();
			foreach($a as $row){
				$fArr[] =
					array(
						"label"=>$row['exp_code_id'].' - '.str_replace("'","",$row['exp_desc']),
						"code"=>$row['exp_code_id']
					);
			}
			return json_encode($fArr);
		}
		return null;
	}
	
	function determineNextStatus($expCode){
		$sql = "
			SELECT post_step, verify_step, approve_step FROM pac_exp_codes
			WHERE exp_code_id = '$expCode';
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->first_row('array');
		}
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
				receipt_img = ?,
				exp_code = ?
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
								$arr['prExpCode'],
								
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
	
	function toggleRead($roleRead, $prId){
		if($roleRead=='WFC'){
			$column = "request_read_flag";
		}
		else if($roleRead=='ASH'){
			$column = "approver1_read_flag";
		}
		else if($roleRead=='VERIFIER'){
			$column = "approver2_read_flag";
		}
		else if($roleRead=='APPROVER'){
			$column = "approver3_read_flag";
		}
		else{
			exit('Unkown role');
		}
		
		
		$sql = "UPDATE pac_pr_header SET ".$column." = 1 WHERE pr_id = ?;";
		
		$this->getdb()->query($sql, array($prId));
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
