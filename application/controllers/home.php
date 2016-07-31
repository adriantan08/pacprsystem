<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		$this->checkSession();
	 }

	 function checkSession(){
		

		if($this->session->userdata('userId')== null && $this->session->userdata('userId')== ''){
			$this->logout();
		}

	}

	function logout(){
		$this->session->sess_destroy();
		redirect('/login/', 'refresh');
	}

	 function index(){
		 $this->checkSession();
		 $this->welcome();
	 }


	public function welcome(){
		$data['title'] = 'Home';
		
		if($this->session->userdata('userRole') == "ASH"){
			$data['content'] = $this->load->view('AdminSecHead/home_view',null,true);
			$this->load->view('template_view_ash', $data);
		}
		else if($this->session->userdata('userRole') == "VERIFIER"){
			//include verifier home page here
			//$data['content'] = $this->load->view('AdminSecHead/home_view',null,true);
			$this->load->view('template_view_ash', $data);
		}
		else if($this->session->userdata('userRole') == "APPROVER"){
			//include verifier home page here
			$this->load->view('template_view_ash', $data);
		}
		else{
			$data['content'] = $this->load->view('WorkingFundCustodian/home_view',null,true);
			$this->load->view('template_view', $data);
		}
	}

	public function create(){
		//Initial role check authorization
		if(!$this->user_model->isWcf())
			$this->logout();
		
		$data['title'] = 'Create';
		$data['candidatePR'] = $this->crud_model->getCandidatePr();
		$data['content'] = $this->load->view('WorkingFundCustodian/create_view', $data, true);
		$this->load->view('template_view', $data);
	}


	//This view is the main handler on how to decide to view the PR based on user role
	public function view($id){
		//Initial role check authorization
		if(!$this->user_model->isWcf())
			$this->logout();
		
		$data = $this->WorkingFundCustodianContent($id);
		$this->load->view('template_view', $data);
	}


	public function WorkingFundCustodianContent($id){
		//Initial role check authorization
		if(!$this->user_model->isWcf())
			$this->logout();
		
		$data['title'] = 'View';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('WorkingFundCustodian/read_view', $data, true);
		return $data;
	}

	/**
		ASH Views
	***/
	public function view_adminsechead($id){
		//Initial role check authorization
		if(!$this->user_model->isAsh())
			$this->logout();
		
		$data['title'] = 'Approve - Admin Sec. Head';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('AdminSecHead/approve_view', $data, true);
		$this->load->view('template_view_ash', $data);
	}

	/**
		VERIFIER Views
	*****/
	public function view_verifier($id){
		//Initial role check authorization
		if(!$this->user_model->isVerifier())
			$this->logout();
		
		$data['title'] = 'Approve - Verifier';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('Verifier/approve_view', $data, true);
		$this->load->view('template_view_ash', $data);
	}

	/**
		APPROVER Views
	*****/
	public function view_approver($id){
		//Initial role check authorization
		if(!$this->user_model->isApprover())
			$this->logout();
		
		$data['title'] = 'Approve - Approver';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('ApprovingAuth/approve_view', $data, true);
		$this->load->view('template_view_ash', $data);
	}

}
