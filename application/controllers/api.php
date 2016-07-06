<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		
		//ENABLE THIS ON PROD OR WHEN LOGIN IS UP. 
		//$this->checkSession();
	 }
	 
	 function index(){
		//ENABLE THIS ON PROD OR WHEN LOGIN IS UP. 
		//$this->checkSession();
	 }
	 
	 function checkSession(){
		if($this->session->userdata('userId')== null && $this->session->userdata('userId')== ''){
			$this->kick();
		}
	}
	
	function kick(){
		$this->session->sess_destroy();
		redirect('/login/unauth', 'refresh');
	}
	 
	 
	function create($intent){
		 
		 if(isset($_POST['postData'])){
			if($intent == 'create')
				$catch = $this->crud_model->addPaymentRecord($_POST['postData']);
			else if($intent == 'update')
				$catch = $this->crud_model->updatePaymentRecord($_POST['postData']);
			
			//what to do with catch based on returned result after insert
		 }
	}
	 
	 function approve(){
		 //At this point, we already checked if there is a session;
		 //We then check if user is authorized to approve
		if($this->user_model->isAsh() || $this->user_model->isVerifier() || $this->user_model->isApprover()){
			if(isset($_POST['approvalType']) && isset($_POST['prNum']) && isset($_POST['status'])){
				
				$catch = $this->crud_model->updatePrStatus($_POST['prNum'], $_POST['status'], $_POST['approvalType']);
			}
			
			//what to do with catch
		}
		else{
			$this->kick();
		}
	 }
	 
	 function uploadreceipt(){
		//we need to set error reporting 0, since the script is expecting a pure json response.
		//this is so that the error message we throw can get back to the script and display error message as an alert
		error_reporting(0);

		$file = $_FILES['files'];
		
		//Error handling in case move_uploaded_file failed. probable cause is that mountpoint_upload folder was not found
		try {
			print_r(UPLOAD_DIR.$file['name'][0]);
			//throw exception if can't move the file
			if (!move_uploaded_file($file['tmp_name'][0], UPLOAD_DIR.$file['name'][0])) {
				throw new Exception('Could not move file');
			}

			
		} catch (Exception $e) {
			
			$arr = array("serverResponse"=>"We have some problems in the upload server. Please contact support.");
			echo json_encode($arr);
		}
		
		
	
	}
	
}
