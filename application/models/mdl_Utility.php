<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Utility extends CI_Model {
    
    //##========================================================================
    function selectGroupUser(){
        $get    = $this->db->get('tblUtlGroupMenu');
        return $get->result();
    }
    function saveGroupUser($data){
        $this->db->insert('tblUtlGroupMenu', $data);
    }
    function updateGroupUser($id, $data){
        $this->db->where('GroupID', $id);
        $this->db->update('tblUtlGroupMenu', $data);
    }
    function deleteGroupUser($id){
        $this->db->where('GroupID', $id);
        $this->db->delete('tblUtlGroupMenu');
    }
    function getGroupUser($id){
        $this->db->where('GroupID',$id);
        return $this->db->get('tblUtlGroupMenu');
    }
    
    //##========================================================================
    function selectUserAccount(){
        $get    = $this->db->get('vwUtlLoginUser');
        return $get->result();
    }
    function saveUserAccount($data){
        $this->db->trans_start();
        $this->db->insert('tblUtlLoginUser', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return error_reporting(E_ALL);
        }
        return TRUE;
    }
    function updateUserAccount($id, $data){
        $this->db->trans_start();
        $this->db->where('LoginUser', $id);
        $this->db->update('tblUtlLoginUser', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return error_reporting(E_ALL);
        }
        return TRUE;
    }
    function deleteUserAccount($id){
        $this->db->where('LoginUser', $id);
        $this->db->delete('tblUtlLoginUser');
    }
    function getUser($id){
        $this->db->where('LoginUser',$id);
        return $this->db->get('tblUtlLoginUser');
    }
    
    //##========================================================================
    function selectDeptKary(){
        $this->db->order_by('DeptAbbr', 'ASC');
        $query  = $this->db->get('vwMstDepartemenKaryawan');
        return $query->result();
    }
    function selectDeptBoro(){
        $this->db->order_by('DeptAbbr', 'ASC');
        $query  = $this->db->get('vwMstDepartemenBorongan');
        return $query->result();
    }
    function getDetKaryByGroupIdArray($groupID){
        $this->db->where('GroupID', $groupID);
        $this->db->where('DeptType', 'K');
        $get = $this->db->get('tblUtlDeptAccess');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->DeptID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function getDetBoroByGroupIdArray($groupID){
        $this->db->where('GroupID', $groupID);
        $this->db->where('DeptType', 'B');
        $get = $this->db->get('tblUtlDeptAccess');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->DeptID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function deleteDeptAksesByGroupID($groupID){
        $this->db->where('GroupID', $groupID);
        $this->db->delete('tblUtlDeptAccess');
    }
    function insertNewAksesDeptByGroupID($data){
        $this->db->insert('tblUtlDeptAccess', $data);
    }
    
    //##========================================================================
    function selectSpecialAccess(){
        $get = $this->db->get('tblUtlSpecialAccess');
        return $get->result();
    }
    function getGroupBySpecialIdArray($idSpecial){
        $this->db->where('AccessID', $idSpecial);
        $get = $this->db->get('tblUtlSpecialAccessGroup');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->GroupID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function insertSpecialAccess($data){
        $this->db->insert('tblUtlSpecialAccessGroup', $data);
    }
    function deleteSpecialAccess($idSpecial){
        $this->db->where('AccessID', $idSpecial);
        $this->db->delete('tblUtlSpecialAccessGroup');
    }
    
    //## Dept Medical per 6 Month
    function getDetKaryForMedicalSixMonthArray(){
        $this->db->where('DeptType', 'K');
        $get = $this->db->get('tblDeptMedicalPerSixMonth');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->DeptID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function getDetBoroForMedicalSixMonthArray(){
        $this->db->where('DeptType', 'B');
        $get = $this->db->get('tblDeptMedicalPerSixMonth');
        if ($get->num_rows() > 0) {
            foreach ($get->result() as $data) {
                $hasil[] = $data->DeptID;
            }
            return $hasil;
        }else{
            return $hasil = array('');
        }
    }
    function deleteDeptMedicalSixMonth(){
        $this->db->empty_table('tblDeptMedicalPerSixMonth');
    }
    function insertDeptMedicalSixMonth($data){
        $this->db->insert('tblDeptMedicalPerSixMonth', $data);
    }
}