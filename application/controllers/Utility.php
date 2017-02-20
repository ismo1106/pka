<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Utility extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        
        $this->load->model(array('Mdl_Utility', 'Mdl_Menu'));
    }
    
    //##== Managament Group User
    function group(){                                                           // Index Group
        $data   = array(
            '_selectGroupUser'  => $this->Mdl_Utility->selectGroupUser(),
        );
        $this->template->display('utility/group/index', $data);
    }
    function SaveGroup(){                                                       // Simpan Group
        $data   = array(
            'GroupName'         => $this->input->post('txtNama'),
            'GroupDescription'  => $this->input->post('txtDescription'),
            'NotActive'         => $this->input->post('radStatus'),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $this->Mdl_Utility->saveGroupUser($data);
        redirect('Utility/group');
    }
    function getReviewGroup(){                                                       // Review Group
        $key    = decode_str($this->input->post('txtPrime'));
        $data   = $this->Mdl_Utility->getGroupUser($key)->row();
        
        echo json_encode($data);
    }
    function UpdateGroup(){                                                     // Update Group
        $idGrup = decode_str($this->input->post('txtIdGroup'));
        $data   = array(
            'GroupName'         => $this->input->post('txtNama'),
            'GroupDescription'  => $this->input->post('txtDescription'),
            'NotActive'         => $this->input->post('radStatus'),
            'UpdatedBy'         => $this->session->userdata('u_user'),
            'UpdatedDate'       => date('Y-m-d H:i:s')
        );
        $this->Mdl_Utility->updateGroupUser($idGrup, $data);
        redirect('Utility/group');
    }
    function DeleteGroup(){                                                     // Delete Group
        $idGrup = decode_str($this->input->post('txtIdGroup'));
        
        $this->Mdl_Utility->deleteGroupUser($idGrup);
        if($this->input->post('type') == 'bypass'){
            echo json_encode(array('msg' => 'success'));
        }else{
            redirect('Utility/group');
        }
    }
    
    //##== Managament User Access
    function user(){                                                            // Index User Managament
        $data   = array(
            '_selectUser'       => $this->Mdl_Utility->selectUserAccount(),
            '_selectGroupUser'  => $this->Mdl_Utility->selectGroupUser()
        );
        $this->template->display('utility/user/index',$data);
    }
    function createUser(){
        $data   = array(
            'LoginUser'     => strtolower($this->input->post('txtAkun')),
            'LoginPassword' => md5(sha1('123')),
            'GroupID'       => $this->input->post('selGroup'),
            'NamaDepan'     => ucwords(strtolower($this->input->post('txtFisrtName'))),
            'NamaBelakang'  => ucwords(strtolower($this->input->post('txtLastName'))),
            'NotActive'     => $this->input->post('radStatus'),
            'CreatedBy'     => $this->session->userdata('u_user'),
            'CreatedDate'   => date('Y-m-d H:i:s')
        );
        $this->Mdl_Utility->saveUserAccount($data);
        redirect('Utility/user');
    }
    function resetPasswordUser(){
        $user   = decode_str($this->input->post('userid'));
        $data   = array(
            'LoginPassword' => md5(sha1('123')),
            'UpdatedBy'     => $this->session->userdata('u_user'),
            'UpdatedDate'   => date('Y-m-d H:i:s')
        );
        $update = $this->Mdl_Utility->updateUserAccount($user, $data);
        echo json_encode($update);
    }
    function getReviewUser(){                                                       // Review Group
        $key    = decode_str($this->input->post('txtUser'));
        $data   = $this->Mdl_Utility->getUser($key)->row();
        
        echo json_encode($data);
    }
    function UpdateUser(){
        $user   = strtolower($this->input->post('txtAkun'));
        $data   = array(
            'GroupID'       => $this->input->post('selGroup'),
            'NamaDepan'     => ucwords(strtolower($this->input->post('txtFisrtName'))),
            'NamaBelakang'  => ucwords(strtolower($this->input->post('txtLastName'))),
            'NotActive'     => $this->input->post('radStatus'),
            'UpdatedBy'     => $this->session->userdata('u_user'),
            'UpdatedDate'   => date('Y-m-d H:i:s')
        );
        $this->Mdl_Utility->updateUserAccount($user, $data);
        redirect('Utility/user');
    }
    function DeleteUser(){                                                     // Delete Group
        $idUser = $this->input->post('txtAkun');
        $User = ($this->input->post('type')? decode_str($idUser): $idUser);
        
        $this->Mdl_Utility->deleteUserAccount($User);
        if($this->input->post('type') == 'bypass'){
            echo json_encode(array('msg' => 'success'));
        }else{
            redirect('Utility/user');
        }
    }
    
    //##== Management Akses Menu
    function getAksesForMenu(){
        $grpID  = decode_str($this->input->post('txtGroupID'));
        $data   = array(
            '_selectMenu1'  => $this->Mdl_Menu->getMenu1(),
            '_selectMenu2'  => $this->Mdl_Menu->getMenu2(),
            '_selectMenu3'  => $this->Mdl_Menu->getMenu3(),
            '_getArray'     => $this->Mdl_Menu->getMenuByGroupIdArray($grpID)
        );
        $this->load->view('utility/group/menuAkses', $data);
    }
    function UpdateMenuAkses(){
        $groupID    = decode_str($this->input->post('txtGroupIDforAkses'));
        $chkMenuID  = $this->input->post('chkMenuID');
        
        $this->Mdl_Menu->deleteMenuAksesByGroupID($groupID);
        for($i=0; $i < count($chkMenuID); $i++):
            $data   = array(
                'GroupID' => $groupID,
                'MenuID' => $chkMenuID[$i]
            );
            $this->Mdl_Menu->insertNewAksesMenuByGroupID($data);
        endfor;
        redirect($this->input->post('txtDirectLink'));
    }
    
    //##== Management Akses Departemen
    function getAksesDept(){
        $grpID  = decode_str($this->input->post('txtGroupID'));
        $data = array(
            '_selectDeptKary'   => $this->Mdl_Utility->selectDeptKary(),
            '_selectDeptBoro'   => $this->Mdl_Utility->selectDeptBoro(),
            '_getArrayKary'     => $this->Mdl_Utility->getDetKaryByGroupIdArray($grpID),
            '_getArrayBoro'     => $this->Mdl_Utility->getDetBoroByGroupIdArray($grpID)
        );
        $this->load->view('utility/group/deptAkses', $data);
    }
    function UpdateDeptAkses(){
        $groupID        = decode_str($this->input->post('txtGroupIDforAksesDept'));
        $chkMenuIDkary  = $this->input->post('chkDeptIDkary');
        $chkMenuIDboro  = $this->input->post('chkDeptIDboro');
        
        $this->Mdl_Utility->deleteDeptAksesByGroupID($groupID);
        for($i=0; $i < count($chkMenuIDkary); $i++):
            $data   = array(
                'GroupID' => $groupID,
                'DeptID' => $chkMenuIDkary[$i],
                'DeptType' => 'K'
            );
            $this->Mdl_Utility->insertNewAksesDeptByGroupID($data);
        endfor;
        for($i=0; $i < count($chkMenuIDboro); $i++):
            $data   = array(
                'GroupID' => $groupID,
                'DeptID' => $chkMenuIDboro[$i],
                'DeptType' => 'B'
            );
            $this->Mdl_Utility->insertNewAksesDeptByGroupID($data);
        endfor;
        redirect($this->input->post('txtDirectLink'));
    }
    
    //##== Menagement Special Access
    function special(){
        $data   = array(
            '_selectSpecialAccess'  => $this->Mdl_Utility->selectSpecialAccess(),
        );
        $this->template->display('utility/special/index', $data);
    }
    function getSpecialAksesForGroup(){
        $idSpecial  = decode_str($this->input->post('txtSpecialID'));
        $data   = array(
            '_selectGroup'  => $this->Mdl_Utility->selectGroupUser(),
            '_getArray'     => $this->Mdl_Utility->getGroupBySpecialIdArray($idSpecial)
        );
        $this->load->view('utility/special/selectGroup', $data);
    }
    function saveSpecial(){
        $idGroup    = $this->input->post('txtGroupID');
        $idSpecial  = decode_str($this->input->post('txtIDspecial'));
        
        $this->Mdl_Utility->deleteSpecialAccess($idSpecial);
        for($i=0; $i< count($idGroup); $i++):
            $data   = array(
                'GroupID'   => $idGroup[$i],
                'AccessID'  => $idSpecial
            );
            $this->Mdl_Utility->insertSpecialAccess($data);
        endfor;
        redirect($this->input->post('txtDirectLink'));
    }
    
    //## Setting Department Medical per 6 Month
    function getDepartSixMonth(){
        $data = array(
            '_selectDeptKary'   => $this->Mdl_Utility->selectDeptKary(),
            '_selectDeptBoro'   => $this->Mdl_Utility->selectDeptBoro(),
            '_getArrayKary'     => $this->Mdl_Utility->getDetKaryForMedicalSixMonthArray(),
            '_getArrayBoro'     => $this->Mdl_Utility->getDetBoroForMedicalSixMonthArray()
        );
        $this->load->view('utility/special/deptAkses', $data);
    }
    function saveDeptMedicalSixMonth(){
        $chkMenuIDkary  = $this->input->post('chkDeptIDkary');
        $chkMenuIDboro  = $this->input->post('chkDeptIDboro');
        
        $this->Mdl_Utility->deleteDeptMedicalSixMonth();
        for($i=0; $i < count($chkMenuIDkary); $i++):
            $data   = array(
                'DeptID' => $chkMenuIDkary[$i],
                'DeptType' => 'K'
            );
            $this->Mdl_Utility->insertDeptMedicalSixMonth($data);
        endfor;
        for($i=0; $i < count($chkMenuIDboro); $i++):
            $data   = array(
                'DeptID' => $chkMenuIDboro[$i],
                'DeptType' => 'B'
            );
            $this->Mdl_Utility->insertDeptMedicalSixMonth($data);
        endfor;
        redirect($this->input->post('txtDirectLink'));
    }
}