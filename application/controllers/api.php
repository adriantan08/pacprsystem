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
	
}
