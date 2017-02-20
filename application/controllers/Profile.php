<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Profile extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model('Mdl_Profile');
    }
    
    function index(){
        $data   = array(
            '_title' => 'Profile',
            '_active' => 'index',
            '_contentProfile' => $this->load->view('profile/profile', NULL, TRUE)
        );
        $this->template->display('profile/index', $data);
    }
    function changeAvatar(){
        $data   = array(
            '_title' => 'Change Avatar',
            '_active' => 'avatar',
            '_contentProfile' => $this->load->view('profile/change_avatar', NULL, TRUE)
        );
        $this->template->display('profile/index', $data);
    }
    function changePassword(){
        $data   = array(
            '_title' => 'Change Password',
            '_active' => 'password',
            '_contentProfile' => $this->load->view('profile/change_password', NULL, TRUE)
        );
        $this->template->display('profile/index', $data);
    }
    function setting(){
        $data   = array(
            '_title' => 'Setting',
            '_active' => 'setting',
            '_contentProfile' => $this->load->view('profile/change_avatar', NULL, TRUE)
        );
        $this->template->display('profile/index', $data);
    }
    
    function updatePassword(){
        $user   = $this->session->userdata('u_user');
        $currentPass    = md5(sha1($this->input->post('txtCurrentPassword')));
        $newPass        = $this->input->post('txtNewPassword');
        $confirmPass    = $this->input->post('txtConfirmPassword');
        
        $get    = $this->Mdl_Profile->getDataUserLogin($user);
        if($get->LoginPassword == $currentPass){
            if($newPass == $confirmPass){
                $data   = array(
                    'LoginPassword' => md5(sha1($newPass))
                );
                $this->Mdl_Profile->updatePasswordUserBySelf($user, $data);
                $err = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong>Well done!</strong> Password anda berhasil diubah.</div>';
                $this->session->set_flashdata('msg_error', $err);
                redirect($this->input->post('txtCurrentURL'));
            }else{
                $err = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong>Oh snap!</strong> Password confirm anda salah.</div>';
                $this->session->set_flashdata('msg_error', $err);
                redirect($this->input->post('txtCurrentURL'));
            }
        }else{
            $err = '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Oh snap!</strong> Password lama anda salah.</div>';
            $this->session->set_flashdata('msg_error', $err);
            redirect($this->input->post('txtCurrentURL'));
        }
    }
}