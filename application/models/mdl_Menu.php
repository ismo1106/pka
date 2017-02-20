<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Menu extends CI_Model {

    private $menu1 = 'vwUtlMenuLv1';
    private $menu2 = 'vwUtlMenuLv2';
    private $menu3 = 'vwUtlMenuLv3';
    private $TblMenu1 = 'tblUtlMenuLv1';
    private $TblMenu2 = 'tblUtlMenuLv2';
    private $TblMenu3 = 'tblUtlMenuLv3';

    function __construct() {
        parent:: __construct();
    }

    public function selectMenu1($GrupID) {
        $this->db->where('GroupID', $GrupID);
        $this->db->order_by('MenuID', 'ASC');
        $query = $this->db->get($this->menu1);
        return $query->result();
    }
    public function selectMenu2($GrupID) {
        $this->db->where('GroupID', $GrupID);
        $this->db->order_by('MenuID', 'ASC');
        $query = $this->db->get($this->menu2);
        return $query->result();
    }
    public function selectMenu3($GrupID) {
        $this->db->where('GroupID', $GrupID);
        $this->db->order_by('MenuID', 'ASC');
        $query = $this->db->get($this->menu3);
        return $query->result();
    }
    
    function getMenu1(){
        $this->db->order_by('MenuID', 'ASC');
        $query  = $this->db->get($this->TblMenu1);
        return $query->result();
    }
    function getMenu2(){
        $this->db->order_by('MenuID', 'ASC');
        $query  = $this->db->get($this->TblMenu2);
        return $query->result();
    }
    function getMenu3(){
        $this->db->order_by('MenuID', 'ASC');
        $query  = $this->db->get($this->TblMenu3);
        return $query->result();
    }
    
    function getMenuByGroupIdArray($groupID){
        $this->db->where('GroupID', $groupID);
        $get = $this->db->get('tblUtlMenuAccess');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->MenuID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function deleteMenuAksesByGroupID($groupID){
        $this->db->where('GroupID', $groupID);
        $this->db->delete('tblUtlMenuAccess');
    }
    function insertNewAksesMenuByGroupID($data){
        $this->db->insert('tblUtlMenuAccess', $data);
    }

}
