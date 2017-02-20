<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MedicalApproval extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_MedicalApproval', 'Mdl_Medical'));
    }
    
    function index(){
        $this->template->display('klinik/medical_approval/index-approval');
    }
    function getDatatableApprovalMedical(){
        $get = $this->Mdl_MedicalApproval->getDatatableApprovalMedicalAll();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            //$row[] = '<input name="chkMedicalID[]" type="checkbox" value="'.encode_str($r->MedicalID).'" class="chk-child"><label></label>';
            if($r->Kesimpulan == NULL && $r->Kesimpulan == ''){
                $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" disabled type="checkbox">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            }else{
                $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" name="chkMedicalID[]" type="checkbox" class="chk-child" value="'.encode_str($r->MedicalID).'">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            }
            $row[] = '<button type="button" onclick="approveMedical(this);" '.($r->Kesimpulan == NULL && $r->Kesimpulan == ''? 'disabled': '').' '
                    . 'class="btn btn-icon btn-xs waves-effect waves-light btn-success" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-thumbs-o-up"></i> </button> '
                    . '<button type="button" onclick="editMedical(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-warning" data-id="'.encode_str($r->MedicalID).'" data-sts="'.$r->TypeTK.'"> <i class="fa fa-pencil"></i> </button> '
                    . '<button type="button" onclick="infoMedical(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-primary" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-info-circle"></i> </button>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            //$row[] = ($r->TypeTK == 'KT'? 'Karyawan Tetap': ($r->TypeTK == 'KK'? 'Karyawan Kontrak': ($r->TypeTK == 'HB'? 'Harian/Borongan': ($r->TypeTK == 'TKB'? 'Tenaga Kerja Baru': 'Medical Khusus'))));
            $row[] = $this->Mdl_MedicalApproval->getJenisMedicalModel($r->TypeTK);
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = date('d-m-Y', strtotime($r->TglMedical));
            
            $data[] = $row;
            $no++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $get['all'],
            "recordsFiltered" => $get['filter'],
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    // Submit Approval
    function acceptMedicalOneByOne(){
        $medicalID = decode_str($this->input->post('txtMedicalID'));
        $data = array(
            'Approval'      => 1,
            'ApprovalBy'    => $this->session->userdata('u_user'),
            'ApprovalDate'  => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->updateMedical($medicalID, $data);
        if($result['status'] == FALSE){
            $data = array(
                'msg' => 'error',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }else{
            $data = array(
                'msg' => 'success',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }
    }
    function acceptMedicalMulti(){
        $medicalID = $this->input->post('chkMedicalID');
        for($i=0; $i < count($medicalID); $i++):
            $data = array(
                'Approval'      => 1,
                'ApprovalBy'    => $this->session->userdata('u_user'),
                'ApprovalDate'  => date('Y-m-d H:i:s')
            );
            $header = $this->Mdl_Medical->updateMedical(decode_str($medicalID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('MedicalApproval/index?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diterima.');
        redirect(base_url('MedicalApproval/index?success=ok'));
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
    
    //## == Control P2K3 =======================================================
    function p2k3(){
        $this->template->display('klinik/medical_approval/control-p2k3');
    }
    function getDatatableMedicalControlP2K3(){
        $get = $this->Mdl_MedicalApproval->getDatatableControlMedicalP2K3();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                    . '<input id="checkbox-child'.$no.'" name="chkMedicalID[]" type="checkbox" '.($r->CheckedP2K3 == 1? 'disabled':'').' class="'.($r->CheckedP2K3 == 1? '':'chk-child').'" value="'.encode_str($r->MedicalID).'">'
                    . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = '<button type="button" onclick="checkedMedicalP2K3(this);" '.($r->CheckedP2K3 == 1? 'disabled':'').' class="btn btn-icon btn-xs waves-effect waves-light btn-success" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-thumbs-o-up"></i> </button> '
                    . '<button type="button" onclick="infoMedical(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-primary" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-info-circle"></i> </button>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            $row[] = $this->Mdl_MedicalApproval->getJenisMedicalModel($r->TypeTK);
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = date('d-m-Y', strtotime($r->TglMedical));
            $row[] = ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>');
            $row[] = ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>');
            
            $data[] = $row;
            $no++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $get['all'],
            "recordsFiltered" => $get['filter'],
            "data" => $data,
        );
        
        echo json_encode($output);
    }
    function checkedP2K3MedicalOneByOne(){
        $medicalID = decode_str($this->input->post('txtMedicalID'));
        $data = array(
            'CheckedP2K3'      => 1,
            'CheckedP2K3By'    => $this->session->userdata('u_user'),
            'CheckedP2K3Date'  => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->updateMedical($medicalID, $data);
        if($result['status'] == FALSE){
            $data = array(
                'msg' => 'error',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }else{
            $data = array(
                'msg' => 'success',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }
    }
    function checkedP2K3MedicalMulti(){
        $medicalID = $this->input->post('chkMedicalID');
        for($i=0; $i < count($medicalID); $i++):
            $data = array(
                'CheckedP2K3'      => 1,
                'CheckedP2K3By'    => $this->session->userdata('u_user'),
                'CheckedP2K3Date'  => date('Y-m-d H:i:s')
            );
            $header = $this->Mdl_Medical->updateMedical(decode_str($medicalID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('MedicalApproval/p2k3?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diperiksa.');
        redirect(base_url('MedicalApproval/p2k3?success=ok'));
    }
    
    //## == Control Dept =======================================================
    function dept(){
        $this->template->display('klinik/medical_approval/control-dept');
    }
    function getDatatableMedicalControlDept(){
        $get = $this->Mdl_MedicalApproval->getDatatableControlMedicalDept();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                    . '<input id="checkbox-child'.$no.'" name="chkMedicalID[]" type="checkbox" '.($r->CheckedDept == 1? 'disabled':'').' class="'.($r->CheckedDept == 1? '':'chk-child').'" value="'.encode_str($r->MedicalID).'">'
                    . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = '<button type="button" onclick="checkedMedicalP2K3(this);" '.($r->CheckedDept == 1? 'disabled':'').' class="btn btn-icon btn-xs waves-effect waves-light btn-success" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-thumbs-o-up"></i> </button> '
                    . '<button type="button" onclick="infoMedical(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-primary" data-id="'.encode_str($r->MedicalID).'"> <i class="fa fa-info-circle"></i> </button>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            $row[] = $this->Mdl_MedicalApproval->getJenisMedicalModel($r->TypeTK);
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = date('d-m-Y', strtotime($r->TglMedical));
            $row[] = ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>');
            $row[] = ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>');
            
            $data[] = $row;
            $no++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $get['all'],
            "recordsFiltered" => $get['filter'],
            "data" => $data,
        );
        
        echo json_encode($output);
    }
    function checkedDeptMedicalOneByOne(){
        $medicalID = decode_str($this->input->post('txtMedicalID'));
        $data = array(
            'CheckedDept'      => 1,
            'CheckedDeptBy'    => $this->session->userdata('u_user'),
            'CheckedDeptDate'  => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->updateMedical($medicalID, $data);
        if($result['status'] == FALSE){
            $data = array(
                'msg' => 'error',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }else{
            $data = array(
                'msg' => 'success',
                'txt' => $result['data']
            );
            echo json_encode($data);
        }
    }
    function checkedDeptMedicalMulti(){
        $medicalID = $this->input->post('chkMedicalID');
        for($i=0; $i < count($medicalID); $i++):
            $data = array(
                'CheckedDept'      => 1,
                'CheckedDeptBy'    => $this->session->userdata('u_user'),
                'CheckedDeptDate'  => date('Y-m-d H:i:s')
            );
            $header = $this->Mdl_Medical->updateMedical(decode_str($medicalID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('MedicalApproval/dept?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diperiksa.');
        redirect(base_url('MedicalApproval/dept?success=ok'));
    }
}