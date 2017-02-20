<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class IzinCuti extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_SuratSakit','Mdl_IzinCuti'));
    }
    
    function index(){
        $this->template->display('karyawan/cuti_izin_input/index_tetap');
    }
    function getDataByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->num_rows();
        $get    = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->row();
        
        if ($check > 0){
            $data = array(
                'Nama'      => $get->NAMA,
                'Jabatan'   => $get->JabatanName,
                'Dept'      => $get->DeptAbbr
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function getDatatableSelectPengalihanTugas(){
        $dept = $this->input->post('deptF');
        $get = $this->Mdl_IzinCuti->getDTableMstKaryTetapPngalihanTugas($dept);
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->NAMA));
            $row[] = $r->DeptAbbr;
            $row[] = ucwords(strtolower($r->JabatanName));
            
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $get['all'],
            "recordsFiltered" => $get['filter'],
            "data" => $data,
        );
        
        echo json_encode($output);
    }
    
}