<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MedicalRegister extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_MedicalRegister'));
    }
    
    function index(){
        $groupID        = $this->session->userdata('u_group');
        $data = array(
            '_totalKuota'   => $this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari(),
            '_kuotaHariIni' => $this->Mdl_MedicalRegister->countMedicalToDay(),
            '_aksesTKNew'   => $this->Mdl_MedicalRegister->getAksesRegTKNew($groupID),
        );
        $this->template->display('klinik/medical_register/index', $data);
    }
    function getDatatableIndex(){
        $get = $this->Mdl_MedicalRegister->getDatatableMedicalToDay();
        $kuota = $this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari();
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = $r->Dept;
            $row[] = ($r->JenisKelamin =='L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Usia.' Th';
            $row[] = $r->TglMedical;
            $row[] = getJadwalMedical($kuota, $r->NoUrut)['dari'].' - '.getJadwalMedical($kuota, $r->NoUrut)['sampai'];
            
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
    function getDatatableTKNew(){
        $get = $this->Mdl_MedicalRegister->getDatatableModelTKNew();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            //$row[] = '<input name="chkRegNumber[]" type="checkbox" value="'.encode_str($r->RegisNumber).'" class="chk-child"><label></label>';
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" name="chkRegNumber[]" type="checkbox" class="chk-child" value="'.encode_str($r->RegisNumber).'">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = $r->RegisNumber;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ucwords(strtolower($r->JenisKelamin));
            $row[] = $r->Usia.' Th';
            
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
    function getDatatableTKHarian(){
        $get = $this->Mdl_MedicalRegister->getDatatableModelTKHarian();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" name="chkNikHarian[]" type="checkbox" class="chk-child" value="'.encode_str($r->NIK).'">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = strtoupper($r->DeptAbbr);
            $row[] = ucwords(strtolower($r->JenisKelamin));
            $row[] = $r->Usia.' Th';
            $row[] = date('d-m-Y', strtotime($r->TanggalMasuk));
            $row[] = $r->MasaKerja;
            
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
    function getDatatableKaryKontrak(){
        $get = $this->Mdl_MedicalRegister->getDatatableModelKaryKontrak();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" name="chkNikKontrak[]" type="checkbox" class="chk-child" value="'.encode_str($r->NIK).'">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->NAMA));
            $row[] = strtoupper($r->DeptAbbr);
            $row[] = ucwords(strtolower($r->Sex));
            $row[] = $r->Usia.' Th';
            $row[] = date('d-m-Y', strtotime($r->TGLMASUK));
            $row[] = $r->MasaKerja;
            
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
    function getDatatableKaryTetap(){
        $get = $this->Mdl_MedicalRegister->getDatatableModelKaryTetap();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                        . '<input id="checkbox-child'.$no.'" name="chkNikTetap[]" type="checkbox" class="chk-child" value="'.encode_str($r->NIK).'">'
                        . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->NAMA));
            $row[] = strtoupper($r->DeptAbbr);
            $row[] = ucwords(strtolower($r->Sex));
            $row[] = $r->Usia.' Th';
            $row[] = date('d-m-Y', strtotime($r->TGLMASUK));
            $row[] = $r->MasaKerja;
            
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

    //##=== Action Simpan Registrasi Medical
    function simpanRegisMedicalTKNew(){
        $regID = $this->input->post('chkRegNumber');
        
        for($i=0; $i < count($regID); $i++):
            $get = $this->Mdl_MedicalRegister->getTKNew(decode_str($regID[$i]));
            $noUrut = $this->Mdl_MedicalRegister->getNomorUrutMedical();
            $kuota =$this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari();
            $teregis = $this->Mdl_MedicalRegister->countMedicalToDay();
            $data = array(
                'NIK'           => decode_str($regID[$i]),
                'TypeTK'        => 'TKB',
                'Nama'          => $get->Nama,
                'TglMedical'    => date('Y-m-d'),
                'JenisKelamin'  => $get->JenisKelaminAbbr,
                'Usia'          => $get->Usia,
                'NoUrut'        => $noUrut,
                'CreatedBy'     => $this->session->userdata('u_user'),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );
            if($teregis >= $kuota){
                $this->session->set_flashdata('_message', 'Tidak semua data terdaftar, Kuota penuh!');
                redirect(base_url('MedicalRegister/index?warning=parsial'));
            }
            $status = $this->Mdl_MedicalRegister->insertRegisMedical($data);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('MedicalRegister/index?err=detail'));
            }
        endfor;
        $this->session->set_flashdata('_message', 'Data Berhasil Didaftarkan.');
        redirect(base_url('MedicalRegister/index?success=ok'));
    }
    function simpanRegisMedicalHarian(){
        $nik = $this->input->post('chkNikHarian');
        
        for($i=0; $i < count($nik); $i++):
            $get = $this->Mdl_MedicalRegister->getTKHarian(decode_str($nik[$i]));
            $noUrut = $this->Mdl_MedicalRegister->getNomorUrutMedical();
            $kuota =$this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari();
            $teregis = $this->Mdl_MedicalRegister->countMedicalToDay();
            $data = array(
                'NIK'           => decode_str($nik[$i]),
                'TypeTK'        => 'HB',
                'Nama'          => $get->Nama,
                'NoFix'         => $get->FixNo,
                'TglMedical'    => date('Y-m-d'),
                'JenisKelamin'  => $get->JenisKelamin,
                'Dept'          => $get->DeptAbbr,
                'Usia'          => $get->Usia,
                'NoUrut'        => $noUrut,
                'CreatedBy'     => $this->session->userdata('u_user'),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );
            if($teregis >= $kuota){
                $this->session->set_flashdata('_message', 'Tidak semua data terdaftar, Kuota penuh!');
                redirect(base_url('MedicalRegister/index?warning=parsial'));
            }
            $status = $this->Mdl_MedicalRegister->insertRegisMedical($data);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('MedicalRegister/index?err=detail'));
            }
        endfor;
        $this->session->set_flashdata('_message', 'Data Berhasil Didaftarkan.');
        redirect(base_url('MedicalRegister/index?success=ok'));
    }
    function simpanRegisMedicalKaryKontrak(){
        $nik = $this->input->post('chkNikKontrak');
        
        for($i=0; $i < count($nik); $i++):
            $get = $this->Mdl_MedicalRegister->getKaryKontrak(decode_str($nik[$i]));
            $noUrut = $this->Mdl_MedicalRegister->getNomorUrutMedical();
            $kuota =$this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari();
            $teregis = $this->Mdl_MedicalRegister->countMedicalToDay();
            $data = array(
                'NIK'           => decode_str($nik[$i]),
                'TypeTK'        => 'KK',
                'Nama'          => $get->NAMA,
                'RegNo'         => $get->RegNo,
                'TglMedical'    => date('Y-m-d'),
                'JenisKelamin'  => $get->Sex,
                'Dept'          => $get->DeptAbbr,
                'Usia'          => $get->Usia,
                'NoUrut'        => $noUrut,
                'CreatedBy'     => $this->session->userdata('u_user'),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );
            if($teregis >= $kuota){
                $this->session->set_flashdata('_message', 'Tidak semua data terdaftar, Kuota penuh!');
                redirect(base_url('MedicalRegister/index?warning=parsial'));
            }
            $status = $this->Mdl_MedicalRegister->insertRegisMedical($data);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('MedicalRegister/index?err=detail'));
            }
        endfor;
        $this->session->set_flashdata('_message', 'Data Berhasil Didaftarkan.');
        redirect(base_url('MedicalRegister/index?success=ok'));
    }
    function simpanRegisMedicalKaryTetap(){
        $nik = $this->input->post('chkNikTetap');
        
        for($i=0; $i < count($nik); $i++):
            $get = $this->Mdl_MedicalRegister->getKaryTetap(decode_str($nik[$i]));
            $noUrut = $this->Mdl_MedicalRegister->getNomorUrutMedical();
            $kuota =$this->Mdl_MedicalRegister->getTotalKuotaMedicalPerHari();
            $teregis = $this->Mdl_MedicalRegister->countMedicalToDay();
            $data = array(
                'NIK'           => decode_str($nik[$i]),
                'TypeTK'        => 'KT',
                'Nama'          => $get->NAMA,
                'RegNo'         => $get->RegNo,
                'TglMedical'    => date('Y-m-d'),
                'JenisKelamin'  => $get->Sex,
                'Dept'          => $get->DeptAbbr,
                'Usia'          => $get->Usia,
                'NoUrut'        => $noUrut,
                'CreatedBy'     => $this->session->userdata('u_user'),
                'CreatedDate'   => date('Y-m-d H:i:s')
            );
            if($teregis >= $kuota){
                $this->session->set_flashdata('_message', 'Tidak semua data terdaftar, Kuota penuh!');
                redirect(base_url('MedicalRegister/index?warning=parsial'));
            }
            $status = $this->Mdl_MedicalRegister->insertRegisMedical($data);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('MedicalRegister/index?err=detail'));
            }
        endfor;
        $this->session->set_flashdata('_message', 'Data Berhasil Didaftarkan.');
        redirect(base_url('MedicalRegister/index?success=ok'));
    }
}