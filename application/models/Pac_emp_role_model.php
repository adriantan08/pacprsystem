<?php
/*
 * Generated by CRUDigniter v2.3 Beta
 * www.crudigniter.com
 */

class Pac_emp_role_model extends CI_Model
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
     * Get pac_emp_role by id
     */
    function get_pac_emp_role($id)
    {
        $pac_emp_role = $this->getdb()->query("
            SELECT
                *

            FROM
                `pac_emp_roles`

            WHERE
                `id` = ?
        ",array($id))->row_array();

        return $pac_emp_role;
    }

    /*
     * Get all pac_emp_roles
     */
    function get_all_pac_emp_roles()
    {
        $pac_emp_roles = $this->getdb()->query("
            SELECT
                *

            FROM
                `pac_emp_roles`

            WHERE
                1 = 1
        ")->result_array();

        return $pac_emp_roles;
    }

    /*
     * function to add new pac_emp_role
     */
    function add_pac_emp_role($params)
    {
        $this->getdb()->insert('pac_emp_roles',$params);
        return $this->getdb()->insert_id();
    }

    /*
     * function to update pac_emp_role
     */
    function update_pac_emp_role($id,$params)
    {
        $this->getdb()->where('id',$id);
        $response = $this->getdb()->update('pac_emp_roles',$params);
        if($response)
        {
            return "pac_emp_role updated successfully";
        }
        else
        {
            return "Error occuring while updating pac_emp_role";
        }
    }

    /*
     * function to delete pac_emp_role
     */
    function delete_pac_emp_role($id)
    {
        $response = $this->getdb()->delete('pac_emp_roles',array('id'=>$id));
        if($response)
        {
            return "pac_emp_role deleted successfully";
        }
        else
        {
            return "Error occuring while deleting pac_emp_role";
        }
    }
}
