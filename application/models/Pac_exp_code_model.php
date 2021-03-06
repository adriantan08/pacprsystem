<?php
/*
 * Generated by CRUDigniter v2.3 Beta
 * www.crudigniter.com
 */

class Pac_exp_code_model extends CI_Model
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
     * Get pac_exp_code by
     */
    function get_pac_exp_code($id)
    {
        $pac_exp_code = $this->getdb()->query("
            SELECT
                *

            FROM
                `pac_exp_codes`

            WHERE
                `exp_code_id` = ?
        ",array($id))->row_array();

        return $pac_exp_code;
    }

    /*
     * Get all pac_exp_codes
     */
    function get_all_pac_exp_codes()
    {
        $pac_exp_codes = $this->getdb()->query("
            SELECT
                exp_code_id,
                exp_desc,
                exp_remarks,
                status,
                a.codename as submit_name,
                b.codename as post_name,
                c.codename as verify_name,
                d.codename as approve_name

            FROM
                `pac_exp_codes`, `pac_emp_exp_code` a,
                `pac_emp_exp_code` b,`pac_emp_exp_code` c,
                `pac_emp_exp_code` d
            WHERE
                1 = 1
                and submit_step = a.id
                and post_step = b.id
                and verify_step = c.id
                and approve_step = d.id
        ")->result_array();

        return $pac_exp_codes;
    }

    /*
     * function to add new pac_exp_code
     */
    function add_pac_exp_code($params)
    {
        $this->getdb()->insert('pac_exp_codes',$params);
        return $this->getdb()->insert_id();
    }

    /*
     * function to update pac_exp_code
     */
    function update_pac_exp_code($id,$params)
    {
        $this->getdb()->where('exp_code_id',$id);
        $response = $this->getdb()->update('pac_exp_codes',$params,"exp_code_id ='".$id."'");
        if($response)
        {
            return "pac_exp_code updated successfully";
        }
        else
        {
            return "Error occuring while updating pac_exp_code";
        }
    }

    /*
     * function to delete pac_exp_code
     */
    function delete_pac_exp_code($id)
    {
        $response = $this->getdb()->delete('pac_exp_codes',array('exp_code_id'=>$id));
        if($response)
        {
            return "pac_exp_code deleted successfully";
        }
        else
        {
            return "Error occuring while deleting pac_exp_code";
        }
    }
}
