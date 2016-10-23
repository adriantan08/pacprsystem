<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		
		if($this->session->userdata('userId')!= null){
			redirect('/home','refresh');
		}
	 }
	 
	 
	 function index(){
		echo UPLOAD_DIR;
		$this->load->view('login_view');
	 }
	 
	function unauth(){
		echo '401: Unauthorized';
	}
	
	function processLogin(){
		if(isset($_POST['u']) && isset($_POST['p'])){
			$this->load->model('user_model');
			
			$result = $this->User_model->auth($_POST['u'], $_POST['p']);
			if($result == null){
				echo 'Username not found.';
			}
			else if(is_array($result)){
				if($this->encrypt->decode($result['emp_password']) != $_POST['p']){
					echo 'Invalid username / password.';
					
				}
				else{
					
					$this->session->set_userdata('userId',$result['emp_id']);
					$this->session->set_userdata('userRole',$result['role_name']);
					$this->session->set_userdata('expCodeId',$result['exp_code_id']);
					$this->session->set_userdata('empFirstName',$result['emp_firstname']);
					$this->session->set_userdata('empLastName',$result['emp_lastname']);
					echo 'success';
					
				}
			}
			else{
				echo 'Unknown error ocurred. Contact admin.';
			}
		}
		else{
			echo 'Post data error.';
		}
	}
	
}

