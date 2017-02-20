<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if($this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model('Mdl_Login');
    }
    
    function index(){
        $data   = array(
            '_message'  => $this->session->flashdata('error_login')
        );
        $this->load->view('login', $data);
    }
    
    function cekLogin(){
        $user   = $this->input->post('txtUserID');
        $pass   = md5(sha1($this->input->post('txtUserPW')));
        
        $cekUser    = $this->Mdl_Login->checkUserAccount($user);
        $cekStatus  = $this->Mdl_Login->checkStatusUser($user);
        $cekPass    = $this->Mdl_Login->checkUserPassword($user, $pass);
        $getUser    = $this->Mdl_Login->getUserAcoount($user);
        
        if($cekUser == TRUE){
            if($cekStatus == TRUE){
                if($cekPass == TRUE){
                    $this->session->set_userdata('u_user', $getUser->LoginUser);
                    $this->session->set_userdata('u_first_name', $getUser->NamaDepan);
                    $this->session->set_userdata('u_last_name', $getUser->NamaBelakang);
                    $this->session->set_userdata('u_group', $getUser->GroupID);
                    $this->saveLog();
                    redirect('Welcome/index');
                }else{
                    $this->session->set_flashdata('error_login', 'Your password is wrong!');
                    redirect('Login/index');
                }
            }else{
                $this->session->set_flashdata('error_login', 'Username is not active!');
                redirect('Login/index');
            }
        }else{
            $this->session->set_flashdata('error_login', 'Username is not registered!');
            redirect('Login/index');
        }
    }
    
    function saveLog(){
        $this->load->library(array('User_agent', 'Mobile_Detect', 'Misc'));
        $detect = new Mobile_Detect();

        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'PC');
        foreach ($detect->getRules() as $name => $regex):
            $check = $detect->{'is' . $name}();
            if ($check == 'true') {
                $deviceType .= $name . ' ';
            }
        endforeach;

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ipaddr = ($_SERVER['REMOTE_ADDR'] == '::1') ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];

        $info = array(
            'InDate' => date("Y-m-d H:i:s"),
            'LoginUser' => $this->session->userdata('u_user'),
            'Hostname' => $hostname,
            'IpAddress' => $ipaddr,
            'Device' => $deviceType,
            'Browser' => $agent,
            'Platform' => $this->misc->platform(),
            'UserAgent' => $this->agent->agent_string()
        );
        $logID = $this->Mdl_Login->simpanLog($info);
        if ($logID === 0) {
            $this->session->set_userdata('log_id', 0);
        }else {
            $this->session->set_userdata('log_id', $logID);
        }
    }
}