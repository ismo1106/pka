<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class SuratSakitMonitor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_SuratSakitMonitor', 'Mdl_SuratSakit'));
    }
    
    function index(){
        $this->session->unset_userdata('f_status');
        $this->session->unset_userdata('f_surat');
        $this->session->unset_userdata('f_period');
        $this->session->unset_userdata('f_kk');
        $this->session->set_userdata('f_status', $this->input->post('txtFilterStatus'));
        $this->session->set_userdata('f_surat', $this->input->post('txtFilterSurat'));
        $this->session->set_userdata('f_period', $this->input->post('txtFilterPeriode'));
        $this->session->set_userdata('f_kk', $this->input->post('txtFilterKK'));
        
        $this->Mdl_SuratSakitMonitor->whereMonitorSuratSakit();
        $this->template->display('klinik/monitor/surat_sakit_monitor/index');
    }
    function getListForDatatableSSM(){
        $get = $this->Mdl_SuratSakitMonitor->getDatatableSuratSakitMonitor();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan');
            $row[] = $r->DeptAbbr;
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglSelesaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglKembaliKerja));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->JenisSurat == 'all'? '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Surat dan Keterangan Dokter</span>': 
                     ($r->JenisSurat == 'iss'? 'Surat Sakit': '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Keterangan Dokter</span>'));
            $row[] = ($r->KecelakaanKerja == 1 ? 'KK': 'Non-KK');
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedP2K3 == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedDept == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->GeneralStatus == 1 && $r->Approval == 1 ? '<label class="label label-success">Approved</label>': ($r->GeneralStatus == 1 && $r->Approval == 0 ? '<label class="label label-danger">Unapproved</label>': '<label class="label label-warning">Not Yet</label>'));
            
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
    
    //##== Check By P2K3 =======================================================
    function p2k3(){
        $this->session->unset_userdata('f_status');
        $this->session->unset_userdata('f_surat');
        $this->session->unset_userdata('f_period');
        $this->session->set_userdata('f_status', $this->input->post('txtFilterStatus'));
        $this->session->set_userdata('f_surat', $this->input->post('txtFilterSurat'));
        $this->session->set_userdata('f_period', $this->input->post('txtFilterPeriode'));
        
        $this->Mdl_SuratSakitMonitor->whereCheckP2K3SuratSakit();
        $this->template->display('klinik/monitor/surat_sakit_check/p2k3');
    }
    function getDatatableCheckP2K3(){
        $get = $this->Mdl_SuratSakitMonitor->getDatatableSuratSakitCheckP2K3();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<input name="chkSakitID[]" type="checkbox" value="'.encode_str($r->SakitID).'" class="chk-child"><label></label>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan');
            $row[] = $r->DeptAbbr;
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglSelesaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglKembaliKerja));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->JenisSurat == 'all'? '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Surat dan Keterangan Dokter</span>': 
                     ($r->JenisSurat == 'iss'? 'Surat Sakit': '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Keterangan Dokter</span>'));
            $row[] = ($r->KecelakaanKerja == 1 ? 'KK': 'Non-KK');
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            
            $row[] = ($r->GeneralStatus == 1 && $r->Approval == 1 ? '<label class="label label-success">Approved</label>': ($r->GeneralStatus == 1 && $r->Approval == 0 ? '<label class="label label-danger">Unapproved</label>': '<label class="label label-warning">Not Yet</label>'));
            
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
    function checkedP2K3(){
        $sakitID = $this->input->post('chkSakitID');
        for($i=0; $i < count($sakitID); $i++):
            $data = array(
                'CheckedP2K3'       => 1,
                'CheckedP2K3By'     => $this->session->userdata('u_user'),
                'CheckedP2K3Date'   => date('Y-m-d H:i:s')
            );
            $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit(decode_str($sakitID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('SuratSakitMonitor/p2k3?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diterima.');
        redirect(base_url('SuratSakitMonitor/p2k3?success=ok'));
    }
    
    //##== Check By Departemen =================================================
    function dept(){
        $this->session->unset_userdata('f_status');
        $this->session->unset_userdata('f_surat');
        $this->session->unset_userdata('f_period');
        $this->session->set_userdata('f_status', $this->input->post('txtFilterStatus'));
        $this->session->set_userdata('f_surat', $this->input->post('txtFilterSurat'));
        $this->session->set_userdata('f_period', $this->input->post('txtFilterPeriode'));
        
        $this->Mdl_SuratSakitMonitor->whereCheckDeptSuratSakit();
        $this->template->display('klinik/monitor/surat_sakit_check/dept');
    }
    function getDatatableCheckDept(){
        $get = $this->Mdl_SuratSakitMonitor->getDatatableSuratSakitCheckDept();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = '<input name="chkSakitID[]" type="checkbox" value="'.encode_str($r->SakitID).'" class="chk-child"><label></label>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan');
            $row[] = $r->DeptAbbr;
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglSelesaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglKembaliKerja));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->JenisSurat == 'all'? '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Surat dan Keterangan Dokter</span>': 
                     ($r->JenisSurat == 'iss'? 'Surat Sakit': '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Keterangan Dokter</span>'));
            $row[] = ($r->KecelakaanKerja == 1 ? 'KK': 'Non-KK');
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            
            $row[] = ($r->GeneralStatus == 1 && $r->Approval == 1 ? '<label class="label label-success">Approved</label>': ($r->GeneralStatus == 1 && $r->Approval == 0 ? '<label class="label label-danger">Unapproved</label>': '<label class="label label-warning">Not Yet</label>'));
            
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
    function checkedDept(){
        $sakitID = $this->input->post('chkSakitID');
        for($i=0; $i < count($sakitID); $i++):
            $data = array(
                'CheckedDept'       => 1,
                'CheckedDeptBy'     => $this->session->userdata('u_user'),
                'CheckedDeptDate'   => date('Y-m-d H:i:s')
            );
            $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit(decode_str($sakitID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('SuratSakitMonitor/dept?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diterima.');
        redirect(base_url('SuratSakitMonitor/dept?success=ok'));
    }

    //##== Print Surat Sakit====================================================
    function printSuratSakitList(){
        $this->session->unset_userdata('f_status');
        $this->session->unset_userdata('f_period');
        $this->session->set_userdata('f_status', $this->input->post('txtFilterStatus'));
        $this->session->set_userdata('f_period', $this->input->post('txtFilterPeriode'));
        
        $this->Mdl_SuratSakitMonitor->wherePrintSuratSakit();
        $this->template->display('klinik/print/surat_sakit_list');
    }
    function getListForDatatablePSS(){
        $get = $this->Mdl_SuratSakitMonitor->getDatatableSuratSakitPrint();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan');
            $row[] = $r->DeptAbbr;
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglSelesaiIstirahat));
            $row[] = date('F d, Y', strtotime($r->TglKembaliKerja));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->JenisSurat == 'all'? 'Surat dan Keterangan Dokter': ($r->JenisSurat == 'iss'? 'Surat Sakit': 'Keterangan Dokter'));
            $row[] = ($r->KecelakaanKerja == 1 ? 'KK': 'Non-KK');
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedP2K3 == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedDept == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->GeneralStatus == 1 && $r->Approval == 1 ? '<label class="label label-success">Approved</label>': ($r->GeneralStatus == 1 && $r->Approval == 0 ? '<label class="label label-danger">Unapproved</label>': '<label class="label label-warning">Not Yet</label>'));
            $row[] = '<a href="'.base_url('SuratSakitMonitor/printSuratSakit/'.encode_str($r->SakitID)).'" target="_blank" class="btn btn-xs btn-success">Print</a>';
            
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
    function printSuratSakit($no){
        $this->load->library(array('fpdf'));
        
        $getData = $this->Mdl_SuratSakitMonitor->getDataSusakInMonitor(decode_str($no));
        
        $data = array(
            '_dataHeader'   => array($getData->TglMulaiIstirahat, decode_str($no)),
            '_dataContent'  => $getData
        );
        $this->load->view('klinik/print/surat_sakit_pdf', $data);
    }
}