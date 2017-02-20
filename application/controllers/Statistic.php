<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Statistic extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_Statistic'));
    }
    
    function index(){
        redirect(base_url());
    }
            
    function SuratSakitDaily(){
        $this->session->unset_userdata('f_periode');
        if($this->input->post('txtFilterPeriode')):
            $this->session->set_userdata('f_periode', $this->input->post('txtFilterPeriode'));
        endif;
        $this->session->unset_userdata('f_typetk');
        if($this->input->post('txtFilterTypeTK')):
            $this->session->set_userdata('f_typetk', $this->input->post('txtFilterTypeTK'));
        endif;
        
        $date = strtotime(date('Y-m-d'));
        if($this->session->userdata('f_periode')){
            $date = strtotime($this->session->userdata('f_periode'));
        }
        
        $data = array(
            'bulan' => date('F', $date)
        );
        $this->template->display('statistic/surat_sakit/daily', $data);
    }
    function getJsonSSDailyChart($typeTK = 'ALL'){
        $date = date('Y-m').'-01';
        if($this->session->userdata('f_periode')){
            $date = date('Y-m-d', strtotime($this->session->userdata('f_periode')));
        }
        if($this->session->userdata('f_typetk')){
            $typeTK = $this->session->userdata('f_typetk');
        }
        $result = '';
        $days = date("t", strtotime($date));
        
        for($x = 0; $x <$days; $x++):
            $loopDate = date('Y-m-d', strtotime('+ '.$x.' day', strtotime($date)));
            $result[] = array(
                'Tanggal' => date('Y-m-d', strtotime($loopDate)),
                'TotalSick' => $this->Mdl_Statistic->getWhereCSSD($loopDate, $typeTK),
                'TotalCreate' => $this->Mdl_Statistic->getWhereCSSDC($loopDate, $typeTK),
                'TotalIKD' => $this->Mdl_Statistic->getWhereCIKD($loopDate, $typeTK)
            );
        endfor;
        
        print json_encode($result);
    }
    
}