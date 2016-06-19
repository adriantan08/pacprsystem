<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		$this->load->model('crud_model');
	 }
	 
	 function index(){
		
	 }
	 
	 function create(){
		 
		 if(isset($_POST['postData'])){
			
			$catch = $this->crud_model->addPaymentRecord($_POST['postData']);
			
			//what to do with catch based on returned result after insert
		 }
	}
	 
	
}
