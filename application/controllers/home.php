<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		//Temp override session while no login yet
		$this->session->set_userdata('userId',2);
		$this->session->set_userdata('userRole','WCF');

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
		else{
			$data['content'] = $this->load->view('WorkingFundCustodian/home_view',null,true);
			$this->load->view('template_view', $data);
		}
	}

	public function create(){
		$data['title'] = 'Create';
		$data['content'] = $this->load->view('WorkingFundCustodian/create_view', '', true);
		$this->load->view('template_view', $data);
	}


	//This view is the main handler on how to decide to view the PR based on user role
	public function view($id){
		$data = $this->WorkingFundCustodianContent($id);
		$this->load->view('template_view', $data);
	}


	public function WorkingFundCustodianContent($id){
		$data['title'] = 'View';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('WorkingFundCustodian/read_view', $data, true);
		return $data;
	}





	/**
		ASH Views
	***/
	public function view_adminsechead($id){
		$data['title'] = 'Approve - Admin Sec. Head';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('AdminSecHead/approve_view', $data, true);
		$this->load->view('template_view_ash', $data);
	}


}
