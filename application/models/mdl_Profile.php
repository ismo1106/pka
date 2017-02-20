<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Profile extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function getDataUserLogin($user){
        $this->db->where('LoginUser', $user);
        $get = $this->db->get('tblUtlLoginUser');
        return $get->row();
    }
    function updatePasswordUserBySelf($user, $data){
        $this->db->where('LoginUser', $user);
        $this->db->update('tblUtlLoginUser', $data);
    }
}