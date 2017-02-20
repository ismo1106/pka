<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class SuratSakit extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_SuratSakit'));
    }
    
    //##== Input Surat Sakit Karyawan
    function index(){ // Form Input surat sakit Karyawan
        $data   = array(
            '_selectAlasanSakit'    => $this->Mdl_SuratSakit->selectAlasanSakit()
        );
        $this->template->display('klinik/surat_sakit/input_karyawan/index', $data);
    }
    function getDataByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->num_rows();
        $get    = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->row();
        
        if ($check > 0){
            $data = array(
                'Nama'      => $get->NAMA,
                'Jabatan'   => $get->JabatanName,
                'Dept'      => $get->DeptAbbr,
                'Jekel'     => $get->Sex,
                'Usia'      => $get->Usia
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function checkSuratSakit(){
        $tglmulai   = strtotime($this->input->post('txtTglMulai'));
        $nik        = $this->input->post('txtNIK');
        $durasi     = $this->input->post('txtDurasi');
        $msg = 'kosong';
        for ($i = 0; $i < $durasi; $i++) {
            $tglsakit = date('Y-m-d', strtotime('+' . $i . 'day', $tglmulai));
            $cek = $this->Mdl_SuratSakit->checkTglSuratSakit($nik, $tglsakit);
            if ($cek != FALSE) {
                $msg .=$cek . ', ';
            }
        }
        //echo json_encode(str_replace('kosong', '', $msg));
        if ($msg == 'kosong') {
            $data = array(
                'msg' => 'ok',
                'txt' => ''
            );
            echo json_encode($data);
        } else {
            $data = array(
                'msg' => 'warning',
                'txt' => str_replace('kosong', '', $msg)
            );
            echo json_encode($data);
        }
    }
    function checkSuratSakitForUpdate(){
        $tglmulai   = strtotime($this->input->post('txtTglMulai'));
        $nik        = $this->input->post('txtNIK');
        $durasi     = $this->input->post('txtDurasi');
        $sakitID    = decode_str($this->input->post('txtSakitID'));
        $msg = 'kosong';
        for ($i = 0; $i < $durasi; $i++) {
            $tglsakit = date('Y-m-d', strtotime('+' . $i . 'day', $tglmulai));
            $cek = $this->Mdl_SuratSakit->checkTglSuratSakitForUpdate($nik, $sakitID, $tglsakit);
            if ($cek != FALSE) {
                $msg .=$cek . ', ';
            }
        }
        //echo json_encode(str_replace('kosong', '', $msg));
        if ($msg == 'kosong') {
            $data = array(
                'msg' => 'ok',
                'txt' => ''
            );
            echo json_encode($data);
        } else {
            $data = array(
                'msg' => 'warning',
                'txt' => str_replace('kosong', '', $msg)
            );
            echo json_encode($data);
        }
    }
    function simpanSuratSakitKaryawan(){
        $nik = $this->input->post('txtNIK');
        $get = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->row();
        $getNoUrut = $this->Mdl_SuratSakit->getNomorUrutKaryawan();
        $tglMulai = strtotime($this->input->post('txtTglMulai'));
        $tglSurat = strtotime($this->input->post('txtTglSurat'));
        $durasi = $this->input->post('txtDurasi');
        $tglAkhir = date('Y-m-d', strtotime('+'.intval($durasi-1).'day', $tglMulai));
        $tglKembali = date('Y-m-d', strtotime('+'.intval($durasi).'day', $tglMulai));
        $data = array(
            'NIK'                   => $nik,
            'RegNo'                 => $get->RegNo,
            'StatusTenaker'         => 'K',
            'Perusahaan'            => 'PT. PSG',
            'Nama'                  => $this->input->post('txtNama'),
            'JabatanID'             => $get->JabatanID,
            'BagianID'              => $get->BagianID,
            'DeptID'                => $get->DeptID,
            'Umur'                  => $this->input->post('txtUmur'),
            'JenisKelamin'          => $get->Sex,
            'Alamat'                => $get->ALAMATR,
            'NoUrut'                => $getNoUrut,
            'TglMulaiIstirahat'     => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): date('Y-m-d', $tglMulai)),
            'TglSelesaiIstirahat'   => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglAkhir),
            'TglKembaliKerja'       => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglKembali),
            'LamaIstirahat'         => ($this->input->post('selJenisSurat') == 'ikd'? 0: $durasi),
            'JenisSurat'            => $this->input->post('selJenisSurat'),
            'KeteranganDokter'      => $this->input->post('txtKetDokter'),
            'AlasanID'              => $this->input->post('selAlasanSakit'),
            'KecelakaanKerja'       => $this->input->post('radioJenisSakit'),
            'LevelKK'               => $this->input->post('selLevelKK'),
            'KirimP2K3'             => $this->input->post('radioKirimP2K3'),
            'CreatedBy'             => $this->session->userdata('u_user'),
            'CreatedKomp'           => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'           => date('Y-m-d H:i:s')
        );
        $header = $this->Mdl_SuratSakit->simpanHeaderSuratSakit($data);
        if($header['status'] == FALSE){
            $this->session->set_flashdata('_message', $header['data']);
            redirect(base_url('SuratSakit/index?err=header'));
        }
        
        if($this->input->post('selJenisSurat') == 'ikd'){
            $detail = array(
                'SakitID'       => $header['data'],
                'NIK'           => $nik,
                'TglSuratSakit' => date('Y-m-d', $tglSurat)
            );
            $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/index?err=detail'));
            }
        }else{
            for($i=0; $i < $durasi; $i++):
                $detail = array(
                    'SakitID'       => $header['data'],
                    'NIK'           => $nik,
                    'TglSuratSakit' => date('Y-m-d', strtotime('+' . $i . 'day', $tglMulai))
                );
                $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            endfor;
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/index?err=detail'));
            }
        }
        
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('SuratSakit/index?success=ok'));
    }
    
    //##== Input Surat Sakit Borongan
    function borongan(){
        $data   = array(
            '_selectAlasanSakit'    => $this->Mdl_SuratSakit->selectAlasanSakit()
        );
        $this->template->display('klinik/surat_sakit/input_borongan/index', $data);
    }
    function getDataBoronganByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_SuratSakit->getMstAllBoronganByNIK($nik)->num_rows();
        $data   = $this->Mdl_SuratSakit->getMstAllBoronganByNIK($nik)->row();
        
        if ($check > 0){
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function simpanSuratSakitBorongan(){
        $nik = $this->input->post('txtNIK');
        $get = $this->Mdl_SuratSakit->getMstAllBoronganByNIK($nik)->row();
        $getNoUrut = $this->Mdl_SuratSakit->getNomorUrutBorongan();
        $tglMulai = strtotime($this->input->post('txtTglMulai'));
        $tglSurat = strtotime($this->input->post('txtTglSurat'));
        $durasi = $this->input->post('txtDurasi');
        $tglAkhir = date('Y-m-d', strtotime('+'.intval($durasi-1).'day', $tglMulai));
        $tglKembali = date('Y-m-d', strtotime('+'.intval($durasi).'day', $tglMulai));
        $data = array(
            'NIK'                   => $nik,
            'NoFix'                 => $get->FixNo,
            'StatusTenaker'         => 'B',
            'Perusahaan'            => $get->Perusahaan,
            'Nama'                  => $this->input->post('txtNama'),
            'JabatanID'             => $get->IDJabatan,
            //'BagianID'              => $get->BagianID,
            'DeptID'                => $get->IDDepartemen,
            'Umur'                  => $this->input->post('txtUmur'),
            'JenisKelamin'          => $get->JenisKelamin,
            'Alamat'                => $get->Alamat,
            'NoUrut'                => $getNoUrut,
            'TglMulaiIstirahat'     => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): date('Y-m-d', $tglMulai)),
            'TglSelesaiIstirahat'   => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglAkhir),
            'TglKembaliKerja'       => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglKembali),
            'LamaIstirahat'         => ($this->input->post('selJenisSurat') == 'ikd'? 0: $durasi),
            'JenisSurat'            => $this->input->post('selJenisSurat'),
            'KeteranganDokter'      => $this->input->post('txtKetDokter'),
            'AlasanID'              => $this->input->post('selAlasanSakit'),
            'KecelakaanKerja'       => $this->input->post('radioJenisSakit'),
            'LevelKK'               => $this->input->post('selLevelKK'),
            'KirimP2K3'             => $this->input->post('radioKirimP2K3'),
            'CreatedBy'             => $this->session->userdata('u_user'),
            'CreatedKomp'           => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'           => date('Y-m-d H:i:s')
        );
        $header = $this->Mdl_SuratSakit->simpanHeaderSuratSakit($data);
        if($header['status'] == FALSE){
            $this->session->set_flashdata('_message', $header['data']);
            redirect(base_url('SuratSakit/borongan?err=header'));
        }
        
        if($this->input->post('selJenisSurat') == 'ikd'){
            $detail = array(
                'SakitID'       => $header['data'],
                'NIK'           => $nik,
                'TglSuratSakit' => date('Y-m-d', $tglSurat)
            );
            $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/borongan?err=detail'));
            }
        }else{
            for($i=0; $i < $durasi; $i++):
                $detail = array(
                    'SakitID'       => $header['data'],
                    'NIK'           => $nik,
                    'TglSuratSakit' => date('Y-m-d', strtotime('+' . $i . 'day', $tglMulai))
                );
                $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            endfor;
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/borongan?err=detail'));
            }
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('SuratSakit/borongan?success=ok'));
    }
    
    //##== Approval Surat Sakit
    function approval(){
        $this->template->display('klinik/surat_sakit/approval/index');
    }
    function getDatatableApproval(){
        $get = $this->Mdl_SuratSakit->selectSuratSakitForApprovalInDatatable();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = '<input name="chkSakitID[]" type="checkbox" value="'.encode_str($r->SakitID).'" class="chk-child"><label></label>';
            $row[] = '<button type="button" onclick="terimaSusak(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-success" data-id="'.encode_str($r->SakitID).'"> <i class="fa fa-thumbs-o-up"></i> </button> '
                    . '<button type="button" onclick="editSusak(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-warning" data-id="'.encode_str($r->SakitID).'" data-sts="'.$r->StatusTenaker.'"> <i class="fa fa-pencil"></i> </button> '
                    . '<button type="button" onclick="tolakSusak(this);" class="btn btn-icon btn-xs waves-effect waves-light btn-danger" data-id="'.encode_str($r->SakitID).'"> <i class="fa fa-thumbs-o-down"></i> </button>';
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = strtoupper($r->Perusahaan);
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = ($r->JenisSurat == 'all'? 'Surat dan Keterangan Dokter': ($r->JenisSurat == 'iss'? 'Surat Sakit': 'Keterangan Dokter'));
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            
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
            
    function approvmentByOnce(){
        $sakitID = decode_str($this->input->post('txtSakitID'));
        $approve = $this->input->post('txtApproval');
        $data = array(
            'Approval'      => $approve,
            'ApprovalBy'    => $this->session->userdata('u_user'),
            'ApprovalDate'  => date('Y-m-d H:i:s'),
            'GeneralStatus' => 1
        );
        $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit($sakitID, $data);
        if($header['status'] == FALSE){
            $data = array(
                'msg' => 'error',
                'txt' => $header['data']
            );
            echo json_encode($data);
        }else{
            $data = array(
                'msg' => 'success',
                'txt' => $header['data']
            );
            echo json_encode($data);
        }
    }
    function approvmentAcceptMulti(){
        $sakitID = $this->input->post('chkSakitID');
        for($i=0; $i < count($sakitID); $i++):
            $data = array(
                'Approval'      => 1,
                'ApprovalBy'    => $this->session->userdata('u_user'),
                'ApprovalDate'  => date('Y-m-d H:i:s'),
                'GeneralStatus' => 1
            );
            $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit(decode_str($sakitID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('SuratSakit/approval?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Diterima.');
        redirect(base_url('SuratSakit/approval?success=ok'));
    }
    function approvmentDeclineMulti(){
        $sakitID = $this->input->post('chkSakitID');
        for($i=0; $i < count($sakitID); $i++):
            $data = array(
                'Approval'      => 0,
                'ApprovalBy'    => $this->session->userdata('u_user'),
                'ApprovalDate'  => date('Y-m-d H:i:s'),
                'GeneralStatus' => 1
            );
            $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit(decode_str($sakitID[$i]), $data);
            if($header['status'] == FALSE){
                $this->session->set_flashdata('_message', $header['data']);
                redirect(base_url('SuratSakit/approval?err=header'));
            }
        endfor;
        
        $this->session->set_flashdata('_message', 'Surat Sakit telah Ditolak.');
        redirect(base_url('SuratSakit/approval?success=ok'));
    }

    //##== Update Surat Sakit Karyawan
    function kUpdate(){
        $hdrID  = decode_str($this->uri->segment(3));
        $getSS  = $this->Mdl_SuratSakit->getSuratSakitByID($hdrID)->row();
        $data   = array(
            '_getDataSusak'         => $getSS,
            '_getDataTenaker'       => $this->Mdl_SuratSakit->getMstAllKaryByNIK($getSS->NIK)->row(),
            '_selectAlasanSakit'    => $this->Mdl_SuratSakit->selectAlasanSakit()
        );
        $this->template->display('klinik/surat_sakit/input_karyawan/update', $data);
    }
    function updateSuratSakitKaryawan(){
        $sakitID = decode_str($this->input->post('txtSakitID'));
        $getSS  = $this->Mdl_SuratSakit->getSuratSakitByID($sakitID)->row();
        
        $nik = $getSS->NIK;
        $get = $this->Mdl_SuratSakit->getMstAllKaryByNIK($nik)->row();
        //$getNoUrut = $this->Mdl_SuratSakit->getNomorUrutKaryawan();
        $tglMulai = strtotime($this->input->post('txtTglMulai'));
        $tglSurat = strtotime($this->input->post('txtTglSurat'));
        $durasi = $this->input->post('txtDurasi');
        $tglAkhir = date('Y-m-d', strtotime('+'.intval($durasi-1).'day', $tglMulai));
        $tglKembali = date('Y-m-d', strtotime('+'.intval($durasi).'day', $tglMulai));
        $data = array(
            'NIK'                   => $nik,
            'RegNo'                 => $get->RegNo,
            'StatusTenaker'         => 'K',
            'Perusahaan'            => 'PT. PSG',
            'Nama'                  => $this->input->post('txtNama'),
            'JabatanID'             => $get->JabatanID,
            'BagianID'              => $get->BagianID,
            'DeptID'                => $get->DeptID,
            'Umur'                  => $this->input->post('txtUmur'),
            'JenisKelamin'          => $get->Sex,
            'Alamat'                => $get->ALAMATR,
            //'NoUrut'                => $getNoUrut,
            'TglMulaiIstirahat'     => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): date('Y-m-d', $tglMulai)),
            'TglSelesaiIstirahat'   => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglAkhir),
            'TglKembaliKerja'       => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglKembali),
            'LamaIstirahat'         => ($this->input->post('selJenisSurat') == 'ikd'? 0: $durasi),
            'JenisSurat'            => $this->input->post('selJenisSurat'),
            'KeteranganDokter'      => $this->input->post('txtKetDokter'),
            'AlasanID'              => $this->input->post('selAlasanSakit'),
            'KecelakaanKerja'       => $this->input->post('radioJenisSakit'),
            'LevelKK'               => $this->input->post('selLevelKK'),
            'KirimP2K3'             => $this->input->post('radioKirimP2K3'),
            'UpdatedBy'             => $this->session->userdata('u_user'),
            'UpdatedKomp'           => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'UpdatedDate'           => date('Y-m-d H:i:s')
        );
        $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit($sakitID, $data);
        if($header['status'] == FALSE){
            $this->session->set_flashdata('_message', $header['data']);
            redirect(base_url('SuratSakit/kUpdate/'.encode_str($sakitID).'?err=header'));
        }
        
        //==## Delete first detail surat sakit
        $this->Mdl_SuratSakit->deleteDetailSurat($sakitID);
        if($this->input->post('selJenisSurat') == 'ikd'){
            $detail = array(
                'SakitID'       => $header['data'],
                'NIK'           => $nik,
                'TglSuratSakit' => date('Y-m-d', $tglSurat)
            );
            $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/kUpdate/'.encode_str($sakitID).'?err=detail'));
            }
        }else{
            for($i=0; $i < $durasi; $i++):
                $detail = array(
                    'SakitID'       => $header['data'],
                    'NIK'           => $nik,
                    'TglSuratSakit' => date('Y-m-d', strtotime('+' . $i . 'day', $tglMulai))
                );
                $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            endfor;
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/kUpdate/'.encode_str($sakitID).'?err=detail'));
            }
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Diupdate.');
        redirect(base_url('SuratSakit/kUpdate/'.encode_str($sakitID).'?success=ok'));
    }

    //##== Update Surat Sakit Karyawan
    function bUpdate(){
        $hdrID  = decode_str($this->uri->segment(3));
        $getSS  = $this->Mdl_SuratSakit->getSuratSakitByID($hdrID)->row();
        $data   = array(
            '_getDataSusak'         => $getSS,
            '_getDataTenaker'       => $this->Mdl_SuratSakit->getMstAllBoronganByNIK($getSS->NIK)->row(),
            '_selectAlasanSakit'    => $this->Mdl_SuratSakit->selectAlasanSakit()
        );
        $this->template->display('klinik/surat_sakit/input_borongan/update', $data);
    }
    function updateSuratSakitBorongan(){
        $sakitID = decode_str($this->input->post('txtSakitID'));
        $getSS  = $this->Mdl_SuratSakit->getSuratSakitByID($sakitID)->row();
        
        $nik = $getSS->NIK;
        $get = $this->Mdl_SuratSakit->getMstAllBoronganByNIK($nik)->row();
        //$getNoUrut = $this->Mdl_SuratSakit->getNomorUrutBorongan();
        $tglMulai = strtotime($this->input->post('txtTglMulai'));
        $tglSurat = strtotime($this->input->post('txtTglSurat'));
        $durasi = $this->input->post('txtDurasi');
        $tglAkhir = date('Y-m-d', strtotime('+'.intval($durasi-1).'day', $tglMulai));
        $tglKembali = date('Y-m-d', strtotime('+'.intval($durasi).'day', $tglMulai));
        $data = array(
            'NIK'                   => $nik,
            'NoFix'                 => $get->FixNo,
            'StatusTenaker'         => 'B',
            'Perusahaan'            => $get->Perusahaan,
            'Nama'                  => $this->input->post('txtNama'),
            'JabatanID'             => $get->IDJabatan,
            //'BagianID'              => $get->BagianID,
            'DeptID'                => $get->IDDepartemen,
            'Umur'                  => $this->input->post('txtUmur'),
            'JenisKelamin'          => $get->JenisKelamin,
            'Alamat'                => $get->Alamat,
            //'NoUrut'                => $getNoUrut,
            'TglMulaiIstirahat'     => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): date('Y-m-d', $tglMulai)),
            'TglSelesaiIstirahat'   => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglAkhir),
            'TglKembaliKerja'       => ($this->input->post('selJenisSurat') == 'ikd'? date('Y-m-d', $tglSurat): $tglKembali),
            'LamaIstirahat'         => ($this->input->post('selJenisSurat') == 'ikd'? 0: $durasi),
            'JenisSurat'            => $this->input->post('selJenisSurat'),
            'KeteranganDokter'      => $this->input->post('txtKetDokter'),
            'AlasanID'              => $this->input->post('selAlasanSakit'),
            'KecelakaanKerja'       => $this->input->post('radioJenisSakit'),
            'LevelKK'               => $this->input->post('selLevelKK'),
            'KirimP2K3'             => $this->input->post('radioKirimP2K3'),
            'UpdatedBy'             => $this->session->userdata('u_user'),
            'UpdatedKomp'           => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'UpdatedDate'           => date('Y-m-d H:i:s')
        );
        $header = $this->Mdl_SuratSakit->updateHeaderSuratSakit($sakitID, $data);
        if($header['status'] == FALSE){
            $this->session->set_flashdata('_message', $header['data']);
            redirect(base_url('SuratSakit/bUpdate/'.encode_str($sakitID).'?err=header'));
        }
        
        $this->Mdl_SuratSakit->deleteDetailSurat($sakitID);
        if($this->input->post('selJenisSurat') == 'ikd'){
            $detail = array(
                'SakitID'       => $header['data'],
                'NIK'           => $nik,
                'TglSuratSakit' => date('Y-m-d', $tglSurat)
            );
            $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/bUpdate/'.encode_str($sakitID).'?err=detail'));
            }
        }else{
            for($i=0; $i < $durasi; $i++):
                $detail = array(
                    'SakitID'       => $header['data'],
                    'NIK'           => $nik,
                    'TglSuratSakit' => date('Y-m-d', strtotime('+' . $i . 'day', $tglMulai))
                );
                $status = $this->Mdl_SuratSakit->simpanDetailSuratSakit($detail);
            endfor;
            if($status != TRUE){
                $this->session->set_flashdata('_message', $status);
                redirect(base_url('SuratSakit/bUpdate/'.encode_str($sakitID).'?err=detail'));
            }
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('SuratSakit/bUpdate/'.encode_str($sakitID).'?success=ok'));
    }
}