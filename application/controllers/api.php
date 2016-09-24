<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	 public function __construct(){
		parent::__construct();
		
		//ENABLE THIS ON PROD OR WHEN LOGIN IS UP. 
		$this->checkSession();
	 }
	 
	 function index(){
		//ENABLE THIS ON PROD OR WHEN LOGIN IS UP. 
		$this->checkSession();
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
			 //take a hold of the POST data for inner manipulation
			$temp = json_decode($_POST['postData'],true);
			//run approval logic here to determine what is the correct status 
			if($temp[0]['prStatus'] == SUBMITTED_STATUS){
				$stepsArr = $this->Crud_model->determineNextStatus($temp[0]['prExpCode']);
				if($stepsArr['post_step'] == 0 
					&& $stepsArr['verify_step'] != 0){
							$temp[0]['prStatus'] = POSTED_STATUS;
				}
				else if($stepsArr['post_step'] == 0 
						&& $stepsArr['verify_step'] == 0
						&& $stepsArr['approve_step'] != 0){
							$temp[0]['prStatus'] = VERIFIED_STATUS;	
				}
				//else what's gonna happen is it will be retained to SUBMITTED_STATUS 
				
				echo $temp[0]['prStatus'];
				//now to send it back to $_POST data 
				$_POST['postData'] = json_encode($temp);
			}
			
			if($intent == 'create')
				$catch = $this->Crud_model->addPaymentRecord($_POST['postData']);
			else if($intent == 'update')
				$catch = $this->Crud_model->updatePaymentRecord($_POST['postData']);
			
			
			
			//what to do with catch based on returned result after insert
		 }
	}
	 
	 function approve(){
		 //At this point, we already checked if there is a session;
		 //We then check if user is authorized to approve
		if($this->User_model->isAsh() || $this->User_model->isVerifier() || $this->User_model->isApprover()){
			if(isset($_POST['approvalType']) && isset($_POST['prNum']) && isset($_POST['status'])){
				
				$catch = $this->Crud_model->updatePrStatus($_POST['prNum'], $_POST['status'], $_POST['approvalType']);
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
		
		date_default_timezone_set(DEFAULT_TIMEZONE);
		$serverDate = date('Y-m-d H-i-s-u');
		
		$prNum = $_REQUEST['prNum'];
		//imgNum is added to support unique naming convention for multiple image upload
		$imgNum = $_REQUEST['imgNum'];
		$file = $_FILES['files'];
		
		$extension = strtolower(pathinfo($file['name'][0], PATHINFO_EXTENSION));
		
		//Error handling in case move_uploaded_file failed. probable cause is that mountpoint_upload folder was not found
		try {
			//IMAGE UPLOAD DATA FORMAT:  PR<prnumber>-<imgNum>-Y-m-d H-i-s.<extension based on original image file
			//We don't rely on combination of PRNum and date only in case upload was really FAST.
			//Example: PR123-2016-7-7 04-55-00-132323.png
			
			
			//In case you are wondering, when user tried to upload image, it gets stored into the server already. When user hits Draft or Submit, 
			//we just use the moved (move_uploaded_file) filename and map it into the the PR# when we hit insert / update into the database
			$imgFileName = 'PR'.$prNum.'-'.$imgNum.'-'.$serverDate.'.'.$extension;
			
			//throw exception if can't move the file
			if (!move_uploaded_file($file['tmp_name'][0], UPLOAD_DIR.$imgFileName)) {
				
				throw new Exception('Could not move file');
			}
			echo json_encode(array(
				"serverResponse"=>"success",
				"image"=>$imgFileName
			));
			
		} catch (Exception $e) {
			
			$arr = array("serverResponse"=>"We have some problems in the upload server. Please contact support.",
							"error stacktrace"=>"$e");
			echo json_encode($arr);
		}
		
		
	
	}
	
	function getpayees(){
		echo json_encode($this->Crud_model->getDistinctPayees());
	}
	
	function addcomment(){
		if(isset($_POST['comment']) && isset($_POST['prId'])){
			$this->Crud_model->addComment($_POST['prId'],$_POST['comment']);
		}
		 else{
			 echo 'post data error';
		 }
	}
	
}
