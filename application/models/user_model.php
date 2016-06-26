<?php
class user_model extends CI_Model {
	
	function getdb(){
		return $this->load->database('default',true);
	}
	
/*******************************************************************
*
*	INSERTS
*
********************************************************************/
	
	
	function auth($username, $password){
		$sql ="
			SELECT 
				a.emp_id,
				a.emp_firstname,
				a.emp_lastname,
				a.emp_email,
				b.role_name,
				a.emp_username,
				a.emp_password
			FROM 
				pac_employees a,
				pac_emp_roles b
			WHERE
				a.emp_roleid = b.role_id AND
				a.emp_username = ?;
		";
		
		$q = $this->getdb()->query($sql, array($username));
		if($q->num_rows()>0)
			return $q->first_row('array');
		return null;
	}
	
	
	 function isWcf(){
		 if($this->session->userdata('userRole') == 'WCF'){
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
	
}
?>