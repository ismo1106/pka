<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MedicalMonitor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_MedicalMonitor', 'Mdl_Medical'));
    }
    
    function getInfoMedical(){
        $medicalID = decode_str($this->input->post('txtMedicalID'));
        $check  = $this->Mdl_Medical->getMedicalForUpdate($medicalID)->num_rows();
        $get    = $this->Mdl_Medical->getMedicalForUpdate($medicalID)->row();
        
        if ($check > 0){
            $data = array(
                'Kesimpulan'    => $get->Kesimpulan,
                'CatatanKlinik' => $get->CatatanKlinik,
                'CatatanP2K3'   => $get->CatatanP2K3
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    
    function index(){
        $this->toDay();
    }
    //## List Hari Ini =========================================================
    function toDay(){
        $this->template->display('klinik/monitor/medicalMonitor/list_today');
    }
    function getDTableMedicalToday(){
        $get = $this->Mdl_MedicalMonitor->getDTableMedicalListToday();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            $row[] = ($r->TypeTK == 'KT'? 'Karyawan Tetap': ($r->TypeTK == 'KK'? 'Karyawan Kontrak': ($r->TypeTK == 'HB'? 'Harian/Borongan': 'Tenaker Baru')));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = $r->Keterangan;
            
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


    //## Sudah Medical =========================================================
    function haveMedical(){
        $this->template->display('klinik/monitor/medicalMonitor/have_medical');
    }
    function getDTableHaveMedical(){
        $get = $this->Mdl_MedicalMonitor->getDTableHaveMedicalModel();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<button type="button" onclick="infoMedical(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-primary" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-info-circle"></i> </button>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            $row[] = ($r->TypeTK == 'KT'? 'Karyawan Tetap': ($r->TypeTK == 'KK'? 'Karyawan Kontrak': ($r->TypeTK == 'HB'? 'Harian/Borongan': 'Tenaker Baru')));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = date('d-m-Y', strtotime($r->TglMedical));
            $row[] = ($r->ApprovalBy == NULL? '<label class="label label-warning">Not Yet</label>':'<label class="label label-success hi-tooltip-click" title="'.$r->ApprovalByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->ApprovalDate)).')">Approved</label>');
            $row[] = ($r->CatatanP2K3 == NULL? '-': ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'));
            $row[] = ($r->CatatanP2K3 == NULL? '-': ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'));
            
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