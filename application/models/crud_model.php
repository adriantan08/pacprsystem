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
				a.created_on AS `created_on`,
				a.changed_on AS `changed_on`,
				CONCAT(g.emp_firstname,' ',g.emp_lastname) AS `prepare_name`,
				a.approver1_id AS `approver1_id`,
				a.approver2_id AS `approver2_id`,
				a.approver3_id AS `approver3_id`,
				CONCAT(d.emp_firstname,' ',d.emp_lastname) AS `post_name`,
				CONCAT(e.emp_firstname,' ',e.emp_lastname) AS `verifier_name`,
				CONCAT(f.emp_firstname,' ',f.emp_lastname) AS `approver_name`,
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
				b.receipt_img AS `receipt_img`,
				CONCAT(c.exp_code_id,'|',c.exp_desc) AS `exp_code`
			FROM pac_pr_header a, pac_pr_details b, pac_exp_codes c,
				pac_employees d,
				pac_employees e,
				pac_employees f,
				pac_employees g
			WHERE a.pr_id = b.pr_id
			AND b.exp_code = c.exp_code_id
			AND a.approver1_id = d.id
			AND a.approver2_id = e.id
			AND a.approver3_id = f.id
			AND a.requestor_id = g.id
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
			ORDER BY a.changed_on DESC;
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
			$roleQuery = " AND (a.approver1_id = ".$empId." or a.approver1_id = 999) AND g.post_step = ".$this->session->userdata('expCodeId');
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
			FROM pac_pr_header a, pac_pr_details b, pac_employees c, pac_pr_status d, pac_exp_codes g
			WHERE a.pr_id = b.pr_id
			AND a.pr_status in ".$status.
			$roleQuery."
			AND a.requestor_id = c.id
			AND a.pr_status = d.status
			AND b.exp_code = g.exp_code_id
			ORDER BY a.changed_on DESC;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}

	//for ALL
	function getApprovedPRs($status, $amount){
		$empId = $this->session->userdata('userId');
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
		AND a.requestor_id = ?
		ORDER BY a.changed_on DESC
		";
		$q = $this->getdb()->query($sql, array($status, $empId));
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
			FROM pac_pr_header a, pac_pr_details b, pac_employees c, pac_exp_codes g
			WHERE a.pr_id = b.pr_id
			AND a.pr_status = ?
			AND a.requestor_id = c.id
			AND b.exp_code = g.exp_code_id
			AND g.post_step = ".$this->session->userdata('expCodeId')."
			ORDER BY a.changed_on DESC;
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
			ORDER BY a.changed_on DESC;
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
		FROM pac_pr_header a left outer join pac_employees f on a.approver3_id = f.id, pac_pr_details b, pac_employees c, pac_employees d, pac_employees e,
		pac_exp_codes g
		WHERE a.pr_id = b.pr_id
		AND a.pr_status = ?
		AND b.amount ".$amount."
		AND a.requestor_id = c.id
		AND a.approver1_id = d.id
		AND a.approver2_id = e.id
		AND b.exp_code = g.exp_code_id
		AND g.approve_step = ".$this->session->userdata('expCodeId')."
		
		ORDER BY a.changed_on DESC;
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
			pac_employees d,
			pac_exp_codes g
		WHERE a.pr_id = b.pr_id
		AND a.pr_status = ?
		AND b.amount ".$amount.
		$query."
		AND a.requestor_id = c.id
		AND a.approver1_id = d.id
		AND b.exp_code = g.exp_code_id
		AND g.verify_step = ".$this->session->userdata('expCodeId')."
		ORDER BY a.changed_on DESC;
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
		return json_encode(array());
	}

	function getCandidatePr(){
		$sql = "SELECT MAX(pr_id) +1 AS `max` FROM pac_pr_header;";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			$res = $q->first_row()->max;
			
			$controlNumber = $this->getPrControlNumber();
			
			//If there are no PRs yet, we get the current controlNumber +1 as initial number
			if($res == null)
				return $controlNumber+1;
			
			
			
			return $res+$controlNumber;
		}
		return null;
	}
	
	function getPrControlNumber(){
		$sql = "
			SELECT control_number FROM pac_pr_control_number
			WHERE SYSDATE() BETWEEN start_date AND end_date
			ORDER BY control_number DESC LIMIT 1;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			$res = $q->first_row()->control_number;
			return $res;
		}
		return 0;
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

	function isAuthorizedExpCode($prId, $column){
		$sql="
			SELECT *
			FROM pac_pr_details a, pac_employees b, pac_exp_codes c
			WHERE a.exp_code = c.exp_code_id
			AND c.$column = ".$this->session->userdata("expCodeId")."
			AND a.pr_id = $prId;
		";
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return true;
		}
		return false;
	}

/*******************************************************************
*
*	SELECT
*
********************************************************************/


/*******************************************************************
* 
*	REPORTS - START
*
********************************************************************/

	function getReport1(){
		//filter date as necessary
		$sql ='
			
			SELECT 
				a.created_on,
				a.pr_date,
				a.pr_id,
				
				b.payee,
				b.amount,
				b.purpose,
				b.po_jo_no,
				b.rr_no,
				b.inv_no,
				b.others,
				b.exp_code,
				c.exp_desc,
				b.details,
				CONCAT(d.emp_firstname," ",d.emp_lastname) AS `prepared_by` ,
				CONCAT(e.emp_firstname," ",e.emp_lastname) AS `verified_by` ,
				a.verified_date AS `verified_date`,
				CONCAT(f.emp_firstname," ",f.emp_lastname) AS `approved_by` ,
				a.approved_date AS `approved_date`
			FROM 
				pac_pr_header a, 
				pac_pr_details b, 
				pac_exp_codes c,
				
				pac_employees d,
				pac_employees e,
				pac_employees f
				
			WHERE a.pr_id  = b.pr_id
			AND b.exp_code = c.exp_code_id
			AND a.requestor_id = d.id
			AND a.approver2_id = e.id
			AND a.approver3_id = f.id;

		';
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return null;
	}
	/* SUMMARY OF PAYMENT REQUEST ISSUED AND APPROVED */
function paymentReqIssApp($date1,$date2){
	$sql = "
		SELECT header.created_on,
					 header.pr_date,
					 header.pr_id,
					 det.payee,
					 det.amount,
					 det.purpose,
					 det.po_jo_no,
					 det.rr_no,
					 det.inv_no,
					 det.others,
					 det.exp_code,
					 exp.exp_desc,
					 det.details,
					 CONCAT(app1.emp_firstname, ' ',app1.emp_lastname) as prepared_by,
					 CONCAT(app4.emp_firstname, ' ',app4.emp_lastname) as posted_by,
					 header.posted_date,
					 CONCAT(app2.emp_firstname, ' ',app2.emp_lastname) as verified_by,
					 header.verified_date,
					 CONCAT(app3.emp_firstname, ' ',app3.emp_lastname) as approved_by,
					 header.approved_date
		FROM 
			pac_pr_header header, 
			pac_pr_details det, 
			pac_exp_codes exp,
			pac_employees app1, 
			pac_employees app2, 
			pac_employees app3,
			pac_employees app4
		WHERE header.pr_id = det.pr_id
		AND header.pr_date between '$date1' and '$date2'
		AND det.exp_code = exp.exp_code_id
		AND header.requestor_id = app1.id
		AND header.approver2_id = app2.id
		AND header.approver3_id = app3.id
		AND header.approver1_id = app4.id
	";
	$q = $this->getdb()->query($sql);
	if($q->num_rows()>0){
		return $q->result_array();
	}
}

/* SUMMARY OF PAYMENT REQUEST FOR APPROVAL */
function paymentReqForApp(){
	$sql = "
		SELECT header.created_on,
					 header.pr_date,
					 header.pr_id,
					 det.payee,
					 det.amount,
					 det.purpose,
					 det.po_jo_no,
					 det.rr_no,
					 det.inv_no,
					 det.others,
					 det.exp_code,
					 exp.exp_desc,
					 det.details,
					 CONCAT(app1.emp_firstname, ' ',app1.emp_lastname) as prepared_by,
					 CONCAT(app3.emp_firstname, ' ',app3.emp_lastname) as posted_by,
					 header.posted_date,
					 CONCAT(app2.emp_firstname, ' ',app2.emp_lastname) as verified_by,
					 header.verified_date
		FROM pac_pr_header header, pac_pr_details det, pac_exp_codes exp,
		pac_employees app1, pac_employees app2, pac_employees app3
		WHERE header.pr_id = det.pr_id
		AND header.pr_status < ".APPROVED_STATUS."
		AND det.exp_code = exp.exp_code_id
		AND header.requestor_id = app1.id
		AND header.approver2_id = app2.id
		AND header.approver1_id = app3.id
	";
	$q = $this->getdb()->query($sql);
	if($q->num_rows()>0){
		return $q->result_array();
	}
}

/* SUMMARY OF PAYMENT REQUEST FOR VERIFICATION */
function paymentReqForVer(){
	$sql = "
		SELECT header.created_on,
					 header.pr_date,
					 header.pr_id,
					 det.payee,
					 det.amount,
					 det.purpose,
					 det.po_jo_no,
					 det.rr_no,
					 det.inv_no,
					 det.others,
					 det.exp_code,
					 exp.exp_desc,
					 det.details,
					 CONCAT(app1.emp_firstname, ' ',app1.emp_lastname) as prepared_by
		FROM pac_pr_header header, pac_pr_details det, pac_exp_codes exp,
		pac_employees app1
		WHERE header.pr_id = det.pr_id
		AND header.pr_status < ".VERIFIED_STATUS."
		AND det.exp_code = exp.exp_code_id
		AND header.requestor_id = app1.id
	";
	$q = $this->getdb()->query($sql);
	if($q->num_rows()>0){
		return $q->result_array();
	}
}

	/* SUMMARY OF PR ISSUED FOR a PAYEE*/
	function paymentReqPerPayee($payee,$date1,$date2){
		$sql = "
			SELECT header.created_on,
						 header.pr_date,
						 header.pr_id,
						 det.payee,
						 det.amount,
						 det.purpose,
						 det.po_jo_no,
						 det.rr_no,
						 det.inv_no,
						 det.others,
						 det.exp_code,
						 exp.exp_desc,
						 det.details,
						 CONCAT(app1.emp_firstname, ' ',app1.emp_lastname) as prepared_by,
						 CONCAT(app4.emp_firstname, ' ',app4.emp_lastname) as 
						 posted_by,
						 header.posted_date,
						 CONCAT(app2.emp_firstname, ' ',app2.emp_lastname) as verified_by,
						 header.verified_date,
						 CONCAT(app3.emp_firstname, ' ',app3.emp_lastname) as approved_by,
						 header.approved_date
			FROM pac_pr_header header, pac_pr_details det, pac_exp_codes exp,
			pac_employees app1, pac_employees app2, pac_employees app3, pac_employees app4
			WHERE header.pr_id = det.pr_id
			AND det.payee = '$payee'
			AND header.pr_date between '$date1' and '$date2'
			AND det.exp_code = exp.exp_code_id
			AND header.requestor_id = app1.id
			AND header.approver2_id = app2.id
			AND header.approver3_id = app3.id
			AND header.approver1_id = app4.id
		";
		
		$q = $this->getdb()->query($sql);
		if($q->num_rows()>0){
			return $q->result_array();
		}
	}
/*******************************************************************
*
*	REPORTS - END
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

		
		//column2 dictates what type of approval it is based on status code, so we can properly track
		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H:i:s');
		
		$column2 = '';
		if($prStatus == 20){
			$column2 = "posted_date = '".$serverDate."',"; 
			$this->addComment($prNum, "VERIFIED BY (auto-generated): ".$this->session->userdata('empFirstName')." ".$this->session->userdata('empLastName'));
		}
		else if($prStatus == 30){
			$column2 = "verified_date = '".$serverDate."',"; 
			$this->addComment($prNum, "VERIFIED BY (auto-generated): ".$this->session->userdata('empFirstName')." ".$this->session->userdata('empLastName'));
		}
		else if($prStatus == 40){
			$column2 = "approved_date = '".$serverDate."',"; 
			$this->addComment($prNum, "APPROVED BY (auto-generated): ".$this->session->userdata('empFirstName')." ".$this->session->userdata('empLastName'));
		}
		
		//else, user sent back the PR;
		
		$sql = "
			UPDATE pac_pr_header
			SET
				pr_status = ?,
				".$column2."
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
	
	function archivePrs($ids, $action){
		foreach($ids as $id){
			if($action == 'archive')
				$status = ARCHIVED_STATUS;
			else
				$status = APPROVED_STATUS;
			if(is_numeric($id)){
				
				$sql =  "
					UPDATE pac_pr_header SET pr_status = ".$status."
					WHERE pr_id = ?;
				";
				$this->getdb()->query($sql, array($id));
			
				$this->logHistoryApproval($id, $status, strtoupper($action));
			}
		}
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
