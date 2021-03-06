<?php
/*
 * Generated by CRUDigniter v2.3 Beta
 * www.crudigniter.com
 */

class Pac_exp_code extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->checkSession();
        $this->load->model('Pac_exp_code_model');
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
    /*
     * Listing of pac_exp_codes
     */
    function index()
    {
		if(!$this->User_model->isSysAdmin())
			$this->logout();

        $data['pac_exp_codes'] = $this->Pac_exp_code_model->get_all_pac_exp_codes();
		$data['title'] = 'PAC PR System - Admin';
        $data['content'] = $this->load->view('pac_exp_code/index',$data,true);
		$this->load->view('template_view_admin',$data);
    }

    function uniqueExpCode($exp_code_id){
    $doesExist = $this->User_model->getExpCode($exp_code_id);
      if($doesExist){
         $this->form_validation->set_message('uniqueExpCode', 'Expenditure Code ID already exists.');
         return false;
      }
      else {
        return true;
      }
    }

    /*
     * Adding a new pac_exp_code
     */
    function add()
    {
		if(!$this->User_model->isSysAdmin())
			$this->logout();

        $this->load->library('form_validation');

		$this->form_validation->set_rules('exp_code_id','Exp Code Id','required|callback_uniqueExpCode');
    $this->form_validation->set_rules('exp_desc','Exp Desc','required');
    $this->form_validation->set_rules('submit_step','Prepare','required');
    $this->form_validation->set_rules('post_step','Verify','required');
    $this->form_validation->set_rules('verify_step','Verify2','required');
    $this->form_validation->set_rules('approve_step','Approve','required');

		if($this->form_validation->run())
        {
            $params = array(
				'exp_code_id' => $this->input->post('exp_code_id'),
				'exp_desc' => $this->input->post('exp_desc'),
				'exp_remarks' => $this->input->post('exp_remarks'),
				'status' => $this->input->post('status'),
				'submit_step' => $this->input->post('submit_step'),
				'post_step' => $this->input->post('post_step'),
				'verify_step' => $this->input->post('verify_step'),
				'approve_step' => $this->input->post('approve_step'),
            );

            $pac_exp_code_id = $this->Pac_exp_code_model->add_pac_exp_code($params);
            redirect('pac_exp_code/index');
        }
        else
        {

			$this->load->model('Pac_emp_exp_code_model') ;
			$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
			$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
			$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
			$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();


			$data['title'] = 'PAC PR System - Admin';
			$data['content'] = $this->load->view('pac_exp_code/add',$data,true);
			$this->load->view('template_view_admin',$data);


        }
    }

    /*
     * Editing a pac_exp_code
     */
    function edit($id)
    {	if(!$this->User_model->isSysAdmin())
			$this->logout();

        // check if the pac_exp_code exists before trying to edit it
        $pac_exp_code = $this->Pac_exp_code_model->get_pac_exp_code($id);

        if(isset($pac_exp_code['exp_code_id']))
        {
            $this->load->library('form_validation');
			      //$this->form_validation->set_rules('exp_code_id','Exp Code Id','required');
            $this->form_validation->set_rules('exp_desc','Exp Desc','required');
            $this->form_validation->set_rules('submit_step','Prepare','required');
            $this->form_validation->set_rules('post_step','Verify','required');
            $this->form_validation->set_rules('verify_step','Verify2','required');
            $this->form_validation->set_rules('approve_step','Approve','required');

			if($this->form_validation->run())
            {
                $params = array(
					'exp_code_id' => $pac_exp_code['exp_code_id'],
					'exp_desc' => $this->input->post('exp_desc'),
					'exp_remarks' => $this->input->post('exp_remarks'),
					'status' => $this->input->post('status'),
					'submit_step' => $this->input->post('submit_step'),
					'post_step' => $this->input->post('post_step'),
					'verify_step' => $this->input->post('verify_step'),
					'approve_step' => $this->input->post('approve_step'),
                );

                $this->Pac_exp_code_model->update_pac_exp_code($id,$params);
                redirect('pac_exp_code/index');
            }
            else
            {
                $data['pac_exp_code'] = $this->Pac_exp_code_model->get_pac_exp_code($id);

				$this->load->model('Pac_emp_exp_code_model');
				$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
				$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
				$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();
				$data['all_pac_emp_exp_code'] = $this->Pac_emp_exp_code_model->get_all_pac_emp_exp_code();

				$data['title'] = 'PAC PR System - Admin';
				$data['content'] = $this->load->view('pac_exp_code/edit',$data,true);
				$this->load->view('template_view_admin',$data);

            }
        }
        else
            show_error('The pac_exp_code you are trying to edit does not exist.');
    }

    /*
     * Deleting pac_exp_code
     */
    function remove($id)
    {
        $pac_exp_code = $this->Pac_exp_code_model->get_pac_exp_code($id);

        // check if the pac_exp_code exists before trying to delete it
        if(isset($pac_exp_code['exp_code_id']))
        {
            $this->Pac_exp_code_model->delete_pac_exp_code($id);
            redirect('pac_exp_code/index');
        }
        else
            show_error('The pac_exp_code you are trying to delete does not exist.');
    }

}
