<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	 public function __construct(){
			parent::__construct();
			
	 }
	 
	 function index(){
		 $this->welcome();
	 }
	 
	
	public function welcome(){
		$data['title'] = 'Home';
		$data['content'] = '';
		$this->load->view('template_view', $data);
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
	
	public function view_adminsechead($id){
		$data = $this->AdminSecHeadContent($id);
		$this->load->view('template_view', $data);
	}
	
	
	public function WorkingFundCustodianContent($id){
		$data['title'] = 'View';
		$data['prDetails'] = $this->crud_model->getPrById($id);
		$data['content'] = $this->load->view('WorkingFundCustodian/read_view', $data, true);
		return $data;
	}
	

	
	public function AdminSecHeadContent($id){
		$data['title'] = 'Approve - Admin Sec. Head';
		$data['prContent'] = $this->WorkingFundCustodianContent();
		$data['content'] = $this->load->view('AdminSecHead/approve_view', $data, true);
		return $data;
	}
	
	
}