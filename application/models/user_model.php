<?php
class User_model extends CI_Model {

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


	function auth($username, $password){
		$sql ="
			SELECT
				a.id as `emp_id`,
				a.emp_firstname,
				a.emp_lastname,
				a.emp_email,
				b.name as `role_name`,
				a.exp_code_id,
				a.emp_username,
				a.emp_password
			FROM
				pac_employees a,
				pac_emp_roles b
			WHERE
				a.emp_role_id = b.id AND
				a.emp_username = ? AND
				a.emp_status = 'ACTIVE';
		";

		$q = $this->getdb()->query($sql, array($username));
		if($q->num_rows()>0)
			return $q->first_row('array');
		return null;
	}


	 function isWfc(){
		 if($this->session->userdata('userRole') == 'WFC'){
			 return true;
		 }
		 return false;
	 }

	 function isAsh(){
		 if($this->session->userdata('userRole') == 'ASH'){
			 return true;
		 }
		 return false;
	 }

	function isVerifier(){
		if($this->session->userdata('userRole')=='VERIFIER')
			return true;
		return false;
	}

	function isApprover(){
		if($this->session->userdata('userRole')=='APPROVER')
			return true;
		return false;
	}

	function isSysAdmin(){
		if($this->session->userdata('userRole')=='SYSTEM ADMIN')
			return true;
		return false;
	}

	function getEmployeeByUsername($username){
	  $sql = "
	   SELECT * FROM pac_employees
	   WHERE emp_username = ?;
	  ";
	  $q = $this->getdb()->query($sql, array($username));
	  if($q->num_rows()>0)
	   return true;
	  return false;
	 }

	 function getCodename($codename){
 	  $sql = "
 	   SELECT * FROM pac_emp_exp_code
 	   WHERE codename = ?;
 	  ";
 	  $q = $this->getdb()->query($sql, array($codename));
 	  if($q->num_rows()>0)
 	   return true;
 	  return false;
 	 }
	 function getExpCode($exp_code_id){
 	  $sql = "
 	   SELECT * FROM pac_exp_codes
 	   WHERE exp_code_id = ?;
 	  ";
 	  $q = $this->getdb()->query($sql, array($exp_code_id));
 	  if($q->num_rows()>0)
 	   return true;
 	  return false;
 	 }



}
?>
