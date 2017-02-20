<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Login extends CI_Model{
    
    private $db2;
    
    public function __construct() {
        parent::__construct();
        
        $this->db2  = $this->load->database('recruitmen', TRUE);
    }
    
    function checkStatusUser($user_id){
        $get = $this->db->get_where('tblUtlLoginUser', array('LoginUser' => $user_id))->row();
        return ($get->NotActive == 0 ? TRUE : FALSE);
    }    
    function checkUserAccount($user_id){
        $query = $this->db->get_where('tblUtlLoginUser', array('LoginUser' => $user_id));
        return ($query->num_rows() > 0 ? TRUE : FALSE);
    }
    function checkUserPassword($user_id, $user_pass){
        $query = $this->db->get_where('tblUtlLoginUser', array('LoginUser' => $user_id, 'LoginPassword' => $user_pass));
        return ($query->num_rows() > 0 ? TRUE : FALSE);
    }
    function getUserAcoount($user_id){
        $get = $this->db->get_where('tblUtlLoginUser', array('LoginUser' => $user_id));
        return $get->row();
    }
    function simpanLog($info){
        $this->db->trans_start();
            $this->db->insert('tblUtlLoginHistory', $info);
            $loginid = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $loginid;
    }
    function simpanLogOut() {
        $this->db->where('LogID', $this->session->userdata('log_id'));
        $this->db->update('tblUtlLoginHistory', array('OutDate' => date('Y-m-d H:i:s')));
    }

}