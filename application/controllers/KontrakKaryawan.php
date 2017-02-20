<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class KontrakKaryawan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        
        $this->load->model('Mdl_KontrakKaryawan');
    }
    
    //##== Habis Kontrak =======================================================
    function index(){
        $this->template->display('karyawan/habis_kontrak/index');
    }
    function getDatatablesHabisKontrak(){
        $get = $this->Mdl_KontrakKaryawan->getDatatableKaryHabisKontrak();
        
        $data = array();
        $no = 1;
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<div class="mk-trc" data-style="check" data-text="true">'
                . '<input id="checkbox-child'.$no.'" name="chkRegNo[]" type="checkbox" class="chk-child" value="'.encode_str($r->RegNo).'">'
                . '<label for="checkbox-child'.$no.'"><i></i></label></div>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->NAMA));
            $row[] = ($r->Sex == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->DeptAbbr.(is_null($r->BagianName)? '': ' - '.ucwords(strtolower($r->BagianName)));
            $row[] = date('F d, Y', strtotime($r->TglHabisKontrak));
            $row[] = $r->KontrakKe;
            $row[] = $r->LIMIT;
            $row[] = '<div class="btn-group">
                        <button type="button" class="btn-submit btn btn-xs btn-success waves-effect" data-id="'.encode_str($r->RegNo).'">Submit</button>
                        <button type="button" class="btn-detail btn btn-xs btn-default waves-effect" data-id="'.encode_str($r->RegNo).'">Detail</button>
                    </div>';
            
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
    function showDetail(){
        $regNo  = decode_str($this->input->post('txtRegNo'));
        $data   = array(
            '_selectKaryawan'   => $this->Mdl_KontrakKaryawan->selectKaryawanByRegNo($regNo)->row()
        );
        $this->load->view('karyawan/habis_kontrak/detail', $data);
    }
    function saveConfirmHabisKontrakByOne(){
        $regNo  = decode_str($this->input->post('txtRegNo'));
        $get    = $this->Mdl_KontrakKaryawan->selectKaryawanByRegNo($regNo)->row();
        $data = array(
            'RegNo'         => $regNo,
            'NIK'           => $get->NIK,
            'CheckPSN'      => 1,
            'CheckPSNby'    => $this->session->userdata('u_user'),
            'CheckPSNdate'  => date('Y-m-d H:i:s'),
        );
        $result = $this->Mdl_KontrakKaryawan->insertConfirmHabisKontrak($data);
        
        echo json_encode($result);
    }
    function saveConfirmHabisKontrakMulty(){
        $txtRegnoNo = $this->input->post('chkRegNo');
        $result     = '';
        for($x=0; $x<count($txtRegnoNo); $x++):
            $regNo  = decode_str($txtRegnoNo[$x]);
            $get    = $this->Mdl_KontrakKaryawan->selectKaryawanByRegNo($regNo)->row();
            $data = array(
                'RegNo'         => $regNo,
                'NIK'           => $get->NIK,
                'CheckPSN'      => 1,
                'CheckPSNby'    => $this->session->userdata('u_user'),
                'CheckPSNdate'  => date('Y-m-d H:i:s'),
            );
            $result = $this->Mdl_KontrakKaryawan->insertConfirmHabisKontrak($data);
        endfor;
        echo json_encode($result);
    }
    
}