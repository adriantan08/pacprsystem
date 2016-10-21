<?php
/*
 * Generated by CRUDigniter v2.3 Beta
 * www.crudigniter.com
 */

class Pac_emp_exp_code_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getdb(){
      if(ENVIRONMENT !== 'production')
        return $this->load->database('default',true);
      else
        return $this->load->database('production',true);
    }

    /*
     * Get pac_emp_exp_code by id
     */
    function get_pac_emp_exp_code($id)
    {
        $pac_emp_exp_code = $this->getdb()->query("
            SELECT
                *

            FROM
                `pac_emp_exp_code`

            WHERE
                `id` = ?
        ",array($id))->row_array();

        return $pac_emp_exp_code;
    }

    /*
     * Get all pac_emp_exp_code
     */
    function get_all_pac_emp_exp_code()
    {
        $pac_emp_exp_code = $this->getdb()->query("
            SELECT
                *

            FROM
                `pac_emp_exp_code`

            WHERE
                1 = 1
        ")->result_array();

        return $pac_emp_exp_code;
    }

    /*
     * function to add new pac_emp_exp_code
     */
    function add_pac_emp_exp_code($params)
    {
        $this->getdb()->insert('pac_emp_exp_code',$params);
        return $this->getdb()->insert_id();
    }

    /*
     * function to update pac_emp_exp_code
     */
    function update_pac_emp_exp_code($id,$params)
    {
        $this->getdb()->where('id',$id);
        $response = $this->getdb()->update('pac_emp_exp_code',$params);
        if($response)
        {
            return "pac_emp_exp_code updated successfully";
        }
        else
        {
            return "Error occuring while updating pac_emp_exp_code";
        }
    }

    /*
     * function to delete pac_emp_exp_code
     */
    function delete_pac_emp_exp_code($id)
    {
        $response = $this->getdb()->delete('pac_emp_exp_code',array('id'=>$id));
        if($response)
        {
            return "pac_emp_exp_code deleted successfully";
        }
        else
        {
            return "Error occuring while deleting pac_emp_exp_code";
        }
    }
}
