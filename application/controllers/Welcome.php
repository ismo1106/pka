<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Welcome extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        
        $this->load->model(array('Mdl_KonekDB2','Mdl_Login','Mdl_Dashboard'));
        $this->load->library('datatable');
    }
    
    public function index() {
        $data   = array(
            '_getStatSakit' => $this->Mdl_Dashboard->getStatisticDataSakit()
        );
        $this->template->display('dashboardNew', $data);
    }

    function sign_out(){
        $this->Mdl_Login->simpanLogOut();
        $this->session->sess_destroy();
        
        redirect('Login/index');
    }

}
