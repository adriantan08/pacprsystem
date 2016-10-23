<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
			$data['content'] = $this->load->view('Verifier/home_view',null,true);
			$this->load->view('template_view_ash', $data);
		}
		else if($this->session->userdata('userRole') == "APPROVER"){
			$data['content'] = $this->load->view('ApprovingAuth/home_view',null,true);
			$this->load->view('template_view_ash', $data);
		}
		else if($this->session->userdata('userRole') == "SYSTEM ADMIN"){
			$data['content'] = "";
			$this->load->view('template_view_admin', $data);
		}
		else{
			$data['content'] = $this->load->view('WorkingFundCustodian/home_view',null,true);
			$this->load->view('template_view', $data);
		}
	}

	public function create(){
		//Initial role check authorization
		if(!$this->User_model->isWfc())
			$this->logout();

		$data['title'] = 'Create';
		$data['candidatePR'] = $this->Crud_model->getCandidatePr();
		$data['expCodesList'] = $this->Crud_model->getExpCodes();
		$data['content'] = $this->load->view('WorkingFundCustodian/create_view', $data, true);
		$this->load->view('template_view', $data);
	}


	//This view is the main handler on how to decide to view the PR based on user role
	public function view($id){
		//Initial role check authorization
		if(!$this->User_model->isWfc())
			$this->logout();
		
		$this->Crud_model->toggleRead('WFC', $id);
		$data = $this->WorkingFundCustodianContent($id);
		$this->load->view('template_view', $data);
	}


	public function WorkingFundCustodianContent($id){
		//Initial role check authorization
		if(!$this->User_model->isWfc())
			$this->logout();

		$data['title'] = 'View';
		$data['prDetails'] = $this->Crud_model->getPrById($id);
		
		$data['expCodesList'] = $this->Crud_model->getExpCodes();
		$data['content'] = $this->load->view('WorkingFundCustodian/read_view', $data, true);
		return $data;
	}

	/**
		ASH Views
	***/
	public function view_adminsechead($id){
		//Initial role check authorization
		if(!$this->User_model->isAsh())
			$this->logout();
		
		$prDetails = $this->Crud_model->getPrById($id);
		if(!$this->Crud_model->isAuthorizedExpCode($prDetails['pr_id'], 'post_step')){
			$data['content'] = 'You don\'t have the proper Expenditure Code assigned.';
			$this->load->view('template_view_ash', $data);
			
		}
		else{
			$this->Crud_model->toggleRead('ASH', $id);
			$data['title'] = 'Approve - Admin Sec. Head';
			$data['prDetails'] = $prDetails;
			$data['content'] = $this->load->view('AdminSecHead/approve_view', $data, true);
			$this->load->view('template_view_ash', $data);
		}
	}

	/**
		VERIFIER Views
	*****/
	public function view_verifier($id){
		//Initial role check authorization
		if(!$this->User_model->isVerifier())
			$this->logout();
		
		$prDetails = $this->Crud_model->getPrById($id);
		
		if(!$this->Crud_model->isAuthorizedExpCode($prDetails['pr_id'], 'verify_step')){
			$data['content'] = 'You don\'t have the proper Expenditure Code assigned.';
			$this->load->view('template_view_ash', $data);
			
		}
		else{
			$this->Crud_model->toggleRead('VERIFIER', $id);
			$data['title'] = 'Approve - Verifier';
			$data['prDetails'] = $prDetails;
			$data['content'] = $this->load->view('Verifier/approve_view', $data, true);
			$this->load->view('template_view_ash', $data);
		}
	}

	/**
		APPROVER Views
	*****/
	public function view_approver($id){
		//Initial role check authorization
		if(!$this->User_model->isApprover())
			$this->logout();
		
		$prDetails = $this->Crud_model->getPrById($id);
		
		if(!$this->Crud_model->isAuthorizedExpCode($prDetails['pr_id'], 'approve_step')){
			$data['content'] = 'You don\'t have the proper Expenditure Code assigned.';
			$this->load->view('template_view_ash', $data);
			
		}
		else{
			$this->Crud_model->toggleRead('APPROVER', $id);
			$data['title'] = 'Approve - Approver';
			$data['prDetails'] = $prDetails;
			$data['content'] = $this->load->view('ApprovingAuth/approve_view', $data, true);
			$this->load->view('template_view_ash', $data);
		}
	}
	
	function report(){
		//We open reporting to Approvers first
		if(!$this->User_model->isApprover())
			$this->logout();
		
		$data['title'] = 'PAC PR SYSTEM - REPORTS';
		$data['content'] = $this->load->view('report_view', null, true);
		$this->load->view('template_view_ash', $data);
	}
	
	
	/*
		Types of reprots accordingto requirements:
		1. All PRs issued and approved for a period of time
		2. All PRs encoded for a selected period of time that were not yet approved
		3. All PRs encoded that were not yet verified as of date
		4. All PRs issued for particule payee for a period of time
	*/

	function downloadreport1($from, $to){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		$from  = str_replace('-','/', urldecode($from));
		$to  = str_replace('-','/', urldecode($to));

		$arr =  $this->Crud_model->paymentReqIssApp($from, $to);
		
		if($arr != null){
			
			$objPHPExcel = new PHPExcel();
			
			date_default_timezone_set("Asia/Singapore");
			
			$objPHPExcel->getProperties()->setCreator("PAC PR SYSTEM");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$objPHPExcel->getActiveSheet()->fromArray(array("PALAWAN AQUACULTURE CORPORATION"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("SUMMARY OF PAYMENT REQUEST ISSUED AND APPROVED"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("For period of: ".$from.' to '.$to), NULL, 'I'.$rowCtr++);
			$rowCtr++;
			$dataArray = array(
				'DATE ENCODED',
				'PR DATE',
				'PR. NO.',
				'PAYEE',
				'AMOUNT',
				'PURPOSE',
				'P.O. / J.O. NO.',
				'RECEIVING REPORT NO.',
				'INV. NO.',
				'OTHERS',
				'Expenditure Code',
				'Expenditure Description',
				'DETAILS',
				'PREPARED BY',
				'VERIFIED BY',
				'DATE VERIFIED',
				'VERIFIED2 BY',
				'DATE VERIFIED2',
				'APPROVED BY',
				'DATE APPROVED'
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($arr as $row){
				
				$dataArray = array(
						$row['created_on'],
						$row['pr_date'],
						$row['pr_id'],
						$row['payee'],
						$row['amount'],
						$row['purpose'],
						$row['po_jo_no'],
						$row['rr_no'],
						$row['inv_no'],
						$row['others'],
						$row['exp_code'],
						$row['exp_desc'],
						$row['details'],
						$row['prepared_by'],
						$row['posted_by'],
						$row['posted_date'],
						$row['verified_by'],
						$row['verified_date'],
						$row['approved_by'],
						$row['approved_date'],
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('PAC PR Report');
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			ob_end_clean();
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="PAC PR Report - "'.date("Y-m-d").".xlsx");

			// Write file to the browser
			$objWriter->save('php://output');
			
		}
	}
	
	function downloadreport2(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		$arr =  $this->Crud_model->paymentReqForApp();
		
		if($arr != null){
			
			$objPHPExcel = new PHPExcel();
			
			date_default_timezone_set("Asia/Singapore");
			
			$objPHPExcel->getProperties()->setCreator("PAC PR SYSTEM");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$objPHPExcel->getActiveSheet()->fromArray(array("PALAWAN AQUACULTURE CORPORATION"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("SUMMARY OF PAYMENT REQUEST FOR APPROVAL"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("As of ".date("Y-m-d")), NULL, 'I'.$rowCtr++);
			
			$rowCtr++;
			
			$dataArray = array(
				'DATE ENCODED',
				'PR DATE',
				'PR. NO.',
				'PAYEE',
				'AMOUNT',
				'PURPOSE',
				'P.O. / J.O. NO.',
				'RECEIVING REPORT NO.',
				'INV. NO.',
				'OTHERS',
				'Expenditure Code',
				'Expenditure Description',
				'DETAILS',
				'PREPARED BY',
				'VERIFIED BY',
				'DATE VERIFIED',
				'VERIFIED2 BY',
				'DATE VERIFIED2'
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($arr as $row){
				
				$dataArray = array(
						$row['created_on'],
						$row['pr_date'],
						$row['pr_id'],
						$row['payee'],
						$row['amount'],
						$row['purpose'],
						$row['po_jo_no'],
						$row['rr_no'],
						$row['inv_no'],
						$row['others'],
						$row['exp_code'],
						$row['exp_desc'],
						$row['details'],
						$row['prepared_by'],
						$row['posted_by'],
						$row['posted_date'],
						$row['verified_by'],
						$row['verified_date']
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('PAC PR Report');
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			ob_end_clean();
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="PAC PR Report - "'.date("Y-m-d").".xlsx");

			// Write file to the browser
			$objWriter->save('php://output');
			
		}
	}
	
	function downloadreport3(){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		$arr =  $this->Crud_model->paymentReqForVer();
		
		if($arr != null){
			
			$objPHPExcel = new PHPExcel();
			
			date_default_timezone_set("Asia/Singapore");
			
			$objPHPExcel->getProperties()->setCreator("PAC PR SYSTEM");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$objPHPExcel->getActiveSheet()->fromArray(array("PALAWAN AQUACULTURE CORPORATION"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("SUMMARY OF PAYMENT REQUEST FOR VERIFICATION"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("As of ".date("Y-m-d")), NULL, 'I'.$rowCtr++);
			
			$rowCtr++;
			
			$dataArray = array(
				'DATE ENCODED',
				'PR DATE',
				'PR. NO.',
				'PAYEE',
				'AMOUNT',
				'PURPOSE',
				'P.O. / J.O. NO.',
				'RECEIVING REPORT NO.',
				'INV. NO.',
				'OTHERS',
				'Expenditure Code',
				'Expenditure Description',
				'DETAILS',
				'PREPARED BY'
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($arr as $row){
				
				$dataArray = array(
						$row['created_on'],
						$row['pr_date'],
						$row['pr_id'],
						$row['payee'],
						$row['amount'],
						$row['purpose'],
						$row['po_jo_no'],
						$row['rr_no'],
						$row['inv_no'],
						$row['others'],
						$row['exp_code'],
						$row['exp_desc'],
						$row['details'],
						$row['prepared_by']
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('PAC PR Report');
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			ob_end_clean();
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="PAC PR Report - "'.date("Y-m-d").".xlsx");

			// Write file to the browser
			$objWriter->save('php://output');
			
		}
	}
	
	function downloadreport4($payee, $from, $to){
		include 'lib/phpexcel/Classes/PHPExcel.php';
		include 'lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';
		
		$payee = urldecode($payee);
		$from  = str_replace('-','/', urldecode($from));
		$to  = str_replace('-','/', urldecode($to));
		
		$arr =  $this->Crud_model->paymentReqPerPayee($payee,$from,$to);
		
		if($arr != null){
			
			$objPHPExcel = new PHPExcel();
			
			date_default_timezone_set("Asia/Singapore");
			
			$objPHPExcel->getProperties()->setCreator("PAC PR SYSTEM");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCtr = 1;
			
			$objPHPExcel->getActiveSheet()->fromArray(array("PALAWAN AQUACULTURE CORPORATION"), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("SUMMARY OF PR ISSUED FOR ".$payee), NULL, 'H'.$rowCtr++);
			$objPHPExcel->getActiveSheet()->fromArray(array("For Period: ".$from." to ".$to), NULL, 'I'.$rowCtr++);
			
			$rowCtr++;
			
			$dataArray = array(
				'DATE ENCODED',
				'PR DATE',
				'PR. NO.',
				'PAYEE',
				'AMOUNT',
				'PURPOSE',
				'P.O. / J.O. NO.',
				'RECEIVING REPORT NO.',
				'INV. NO.',
				'OTHERS',
				'Expenditure Code',
				'Expenditure Description',
				'DETAILS',
				'PREPARED BY',
				'VERIFIED BY',
				'DATE VERIFIED',
				'VERIFIED2 BY',
				'DATE VERIFIED2',
				'APPROVED BY',
				'DATE APPROVED'
			);
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			foreach($arr as $row){
				
				//ensure we do not expose AUTO-APPROVE name if PR is not yet posted or verifier or approved
				if($row['posted_date'] == '')
					$row['posted_by'] = '';
				if($row['verified_date'] == '')
					$row['verified_by'] = '';
				if($row['approved_date'] == '')
					$row['approved_by'] = '';
					
				$dataArray = array(
						$row['created_on'],
						$row['pr_date'],
						$row['pr_id'],
						$row['payee'],
						$row['amount'],
						$row['purpose'],
						$row['po_jo_no'],
						$row['rr_no'],
						$row['inv_no'],
						$row['others'],
						$row['exp_code'],
						$row['exp_desc'],
						$row['details'],
						$row['prepared_by'],
						$row['posted_by'],
						$row['posted_date'],
						$row['verified_by'],
						$row['verified_date'],
						$row['approved_by'],
						$row['approved_date'],
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A'.$rowCtr++);
			}
			$objPHPExcel->getActiveSheet()->setTitle('PAC PR Report');
			
			
			//Get the Focused/Active sheet back to In Scope.
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			ob_end_clean();
			// We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called file.xls
			header('Content-Disposition: attachment; filename="PAC PR Report - "'.date("Y-m-d").".xlsx");

			// Write file to the browser
			$objWriter->save('php://output');
			
		}
	}
	
	function print_preview($prList=null){
		$prList = urldecode($prList);
		
		$data['prList'] = $this->Crud_model->getBulkPr($prList);
		$this->load->view('print_view', $data);
	}
	

}
