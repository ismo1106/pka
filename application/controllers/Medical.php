<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Medical extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_Medical'));
    }
    
    function signaturePadMedical(){
        $this->load->view('klinik/medical_input/signature-pad');
    }
    function checkFileExist(){
        define('UPLOAD_DIR', './upload/imgSignature/');
        $fileName = $this->input->post('txtFileName').'-';
        echo file_exists(UPLOAD_DIR.$fileName.date('Y').'.png');
    }
    function signaturConvertToImg(){
        define('UPLOAD_DIR', './upload/imgSignature/');
	$fileName = $_POST['txtFileName'].'-';
	$img = $_POST['txtImg'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . $fileName . date('Y') . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
    }

    //## == Input Medical TK Baru
    function index(){
        $this->template->display('klinik/medical_input/index-baru');
    }
    function getDatatableMedicalTKBaru(){
        $get = $this->Mdl_Medical->getDatatableMedicalTKNew();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            
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
    function getDataTKNewByNoReg(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_Medical->getMstTKNewForMedical($nik)->num_rows();
        $get    = $this->Mdl_Medical->getMstTKNewForMedical($nik)->row();
        
        if ($check > 0){
            echo json_encode($get);
        }else{
            echo json_encode('false');
        }
    }
    function simpanMedicalTKNew(){
        $data = array(
            'TypeTK'            => 'TKB',
            'NIK'               => $this->input->post('txtNIK'),
            'TglMedical'        => date('Y-m-d'),
            'MasaKerja'         => $this->input->post('txtMasaKerja'),
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->simpanMedical($data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect(base_url('Medical/index?err=submit'));
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Medical/index?success=ok'));
    }

    //## == Input Medical Tenaker Borongan
    function borongan(){
        $this->template->display('klinik/medical_input/index-boro');
    }
    function getDatatableMedicalBoro(){
        $get = $this->Mdl_Medical->getDatatableMedicalBorongan();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            
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
    function getDataBoroByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_Medical->getMstBoroForMedical($nik)->num_rows();
        $get    = $this->Mdl_Medical->getMstBoroForMedical($nik)->row();
        
        if ($check > 0){
            $data = array(
                'NIK' => str_replace(' ', '', $get->NIK),
                'FixNo' => $get->FixNo,
                'Nama' => $get->Nama,
                'Dept' => $get->DeptAbbr,
                'Usia' => $get->Usia,
                'Jekel' => ($get->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan'),
                'JekelAbbr' => $get->JenisKelamin,
                'Perusahaan' => $get->Perusahaan,
                'MasaJerja' => hitung_umur($get->TanggalMasuk, TRUE)
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function simpanMedicalBoro(){
        $data = array(
            'TypeTK'            => 'HB',
            'NIK'               => $this->input->post('txtNIK'),
            'FixNo'             => $this->input->post('txtNoFix'),
            'TglMedical'        => date('Y-m-d'),
            'MasaKerja'         => $this->input->post('txtMasaKerja'),
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->simpanMedical($data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect(base_url('Medical/borongan?err=submit'));
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Medical/borongan?success=ok'));
    }
    
    //## == Input Medical Karyawan Kontrak
    function kontrak(){
        $this->template->display('klinik/medical_input/index-kontrak');
    }
    function getDatatableMedicalKaryKontrak(){
        $get = $this->Mdl_Medical->getDatatableMedicalKontrak();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            
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
    function getDataKontrakByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_Medical->getMstKontrakForMedical($nik)->num_rows();
        $get    = $this->Mdl_Medical->getMstKontrakForMedical($nik)->row();
        
        if ($check > 0){
            $data = array(
                'NIK' => $get->NIK,
                'RegNo' => $get->RegNo,
                'Nama' => $get->NAMA,
                'Dept' => $get->DeptAbbr,
                'Usia' => $get->Usia,
                'Jekel' => ($get->Sex == 'L'? 'Laki-laki': 'Perempuan'),
                'JekelAbbr' => $get->Sex,
                'Perusahaan' => 'PT. PSG',
                'MasaJerja' => hitung_umur($get->TGLMASUK, TRUE)
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function simpanMedicalKontrak(){
        $data = array(
            'TypeTK'            => 'KK',
            'NIK'               => $this->input->post('txtNIK'),
            'RegNo'             => $this->input->post('txtRegNo'),
            'TglMedical'        => date('Y-m-d'),
            'MasaKerja'         => $this->input->post('txtMasaKerja'),
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->simpanMedical($data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect(base_url('Medical/kontrak?err=submit'));
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Medical/kontrak?success=ok'));
    }
    
    //## == Input Medical Karyawan Tetap
    function tetap(){
        $this->template->display('klinik/medical_input/index-tetap');
    }
    function getDatatableMedicalKaryTetap(){
        $get = $this->Mdl_Medical->getDatatableMedicalTetap();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NoUrut;
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            
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
    function getDataTetapByNIK(){
        $nik    = $this->input->post('txtNIK');
        $check  = $this->Mdl_Medical->getMstTetapForMedical($nik)->num_rows();
        $get    = $this->Mdl_Medical->getMstTetapForMedical($nik)->row();
        
        if ($check > 0){
            $data = array(
                'NIK' => $get->NIK,
                'RegNo' => $get->RegNo,
                'Nama' => $get->NAMA,
                'Dept' => $get->DeptAbbr,
                'Usia' => $get->Usia,
                'Jekel' => ($get->Sex == 'L'? 'Laki-laki': 'Perempuan'),
                'JekelAbbr' => $get->Sex,
                'Perusahaan' => 'PT. PSG',
                'MasaJerja' => hitung_umur($get->TGLMASUK, TRUE)
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function simpanMedicalTetap(){
        $data = array(
            'TypeTK'            => 'KT',
            'NIK'               => $this->input->post('txtNIK'),
            'RegNo'             => $this->input->post('txtRegNo'),
            'TglMedical'        => date('Y-m-d'),
            'MasaKerja'         => $this->input->post('txtMasaKerja'),
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->simpanMedical($data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect(base_url('Medical/tetap?err=submit'));
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Medical/tetap?success=ok'));
    }
    
    //## == Input Medical Khusus (Off, break)
    function khusus(){
        $this->template->display('klinik/medical_input/index-xkhusus');
    }
    function setFilterMedicalKhusus(){
        $this->session->unset_userdata('f_name');
        $this->session->set_userdata('f_name', $this->input->post('filterName'));
        $this->Mdl_Medical->whereGetMedicalKhusus();
    }
    function getDatatableMedicalKaryKhusus(){
        $get = $this->Mdl_Medical->getDatatableMedicalKhusus();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->RegNo;
            $row[] = ucwords(strtolower($r->NAMA));
            $row[] = ($r->Sex == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = ucwords(strtolower($r->TEMPATLHR));
            $row[] = date('d F Y', strtotime($r->TGLLAHIR));
            $row[] = $r->Usia.' Tahun';
            
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
    function getDataKhususByREGNO(){
        $nik    = $this->input->post('txtREGNO');
        $check  = $this->Mdl_Medical->getMstKhususForMedical($nik)->num_rows();
        $get    = $this->Mdl_Medical->getMstKhususForMedical($nik)->row();
        
        if ($check > 0){
            $data = array(
                'NIK' => $get->NIK,
                'RegNo' => $get->RegNo,
                'Nama' => $get->NAMA,
                'Dept' => $get->DeptAbbr,
                'Usia' => $get->Usia,
                'Jekel' => ($get->Sex == 'L'? 'Laki-laki': 'Perempuan'),
                'JekelAbbr' => $get->Sex,
                'Perusahaan' => 'PT. PSG',
                'MasaJerja' => hitung_umur($get->TGLMASUK, TRUE)
            );
            echo json_encode($data);
        }else{
            echo json_encode('false');
        }
    }
    function simpanMedicalKhusus(){
        $data = array(
            'TypeTK'            => 'MK',
            'NIK'               => $this->input->post('txtNIK'),
            'RegNo'             => $this->input->post('txtRegNo'),
            'TglMedical'        => date('Y-m-d'),
            'MasaKerja'         => $this->input->post('txtMasaKerja'),
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'CreatedBy'         => $this->session->userdata('u_user'),
            'CreatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CreatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->simpanMedical($data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect(base_url('Medical/khusus?err=submit'));
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Disimpan.');
        redirect(base_url('Medical/khusus?success=ok'));
    }

    //## == Update Medical from Approval =========================================
    function updateMedical(){
        $medicalID = decode_str($this->uri->segment(3));
        $data = array(
            '_getData' => $this->Mdl_Medical->getMedicalForUpdate($medicalID)->row()
        );
        $this->template->display('klinik/medical_input/up-baru', $data);
    }
    function updateMedicalFromApproval(){
        $medicalID = decode_str($this->input->post('txtMedicalID'));
        $data = array(
            'Asma'              => $this->input->post('radAsma'),
            'Diabetes'          => $this->input->post('radDiabetes'),
            'Eksim'             => $this->input->post('radEksim'),
            'Ulcus'             => $this->input->post('radUlcus'),
            'TBC'               => $this->input->post('radTBC'),
            'Hepatitis'         => $this->input->post('radHepatitis'),
            'Hernia'            => $this->input->post('radHernia'),
            'Wasir'             => $this->input->post('radWasir'),
            'Epilepsi'          => $this->input->post('radEpilepsi'),
            'TekananDarah'      => $this->input->post('txtTekananDarah'),
            'DenyutNadi'        => $this->input->post('txtDenyutNadi'),
            'DenyutNadiSatuan'  => $this->input->post('selDenyutNadi'),
            'TinggiBadan'       => $this->input->post('txtTinggiBadan'),
            'BeratBadan'        => $this->input->post('txtBeratBadan'),
            'BMI'               => $this->input->post('txtBMI'),
            'ResultBMI'         => $this->input->post('txtResultBMI'),
            'KeadaanUmum'       => $this->input->post('txtKeadaanUmum'),
            'Kepala'            => $this->input->post('txtKepala'),
            'Mata'              => $this->input->post('txtMata'),
            'JarakPandang'      => $this->input->post('txtJarakPanndang'),
            'ButaWarna'         => $this->input->post('txtButaWarna'),
            'Hidung'            => $this->input->post('txtHidung'),
            'RonggaMulut'       => $this->input->post('txtRonggaMulut'),
            'Leher'             => $this->input->post('txtLeher'),
            'Paruparu'          => $this->input->post('txtParuparu'),
            'Jantung'           => $this->input->post('txtJantung'),
            'HatiLimpa'         => $this->input->post('txtHatiLimpa'),
            'Perut'             => $this->input->post('txtPerut'),
            'AnusKelamin'       => $this->input->post('txtAnusKelamin'),
            'AnggotaBadan'      => $this->input->post('txtAnggotaBadang'),
            'Napza'             => ($this->input->post('txtNapza')? $this->input->post('txtNapza'): NULL),
            'DarahRutin'        => ($this->input->post('txtDarahRutin')? $this->input->post('txtDarahRutin'): NULL),
            'Audiometri'        => ($this->input->post('txtAudiometri')? $this->input->post('txtAudiometri'): NULL),
            'Widal'             => ($this->input->post('txtWidal')? $this->input->post('txtWidal'): NULL),
            'Kesimpulan'        => ($this->input->post('txtKesimpulan')? $this->input->post('txtKesimpulan'): NULL),
            'CatatanKlinik'     => ($this->input->post('txtCatatanKlinik')? $this->input->post('txtCatatanKlinik'): NULL),
            'CatatanP2K3'       => ($this->input->post('txtCatatanP2K3')? $this->input->post('txtCatatanP2K3'): NULL),
            'TglMDC'            => ($this->input->post('txtTglMDC')? date('Y-m-d', strtotime($this->input->post('txtTglMDC'))): NULL),
            'TglWidal'          => ($this->input->post('txtTglWidal')? date('Y-m-d', strtotime($this->input->post('txtTglWidal'))): NULL),
            'TglDarahRutin'     => ($this->input->post('txtTglDarahRutin')? date('Y-m-d', strtotime($this->input->post('txtTglDarahRutin'))): NULL),
            'TglUrine'          => ($this->input->post('txtTglUrine')? date('Y-m-d', strtotime($this->input->post('txtTglUrine'))): NULL),
            'KeteranganMedis'   => $this->input->post('txtKetMedis'),
            'TglGula'           => ($this->input->post('txtTglGula')? date('Y-m-d', strtotime($this->input->post('txtTglGula'))): NULL),
            'TglKolesterol'     => ($this->input->post('txtTglKolesterol')? date('Y-m-d', strtotime($this->input->post('txtTglKolesterol'))): NULL),
            'TglAsamUrat'       => ($this->input->post('txtTglAsamUrat')? date('Y-m-d', strtotime($this->input->post('txtTglAsamUrat'))): NULL),
            'UpdatedBy'         => $this->session->userdata('u_user'),
            'UpdatedComp'       => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'UpdatedDate'       => date('Y-m-d H:i:s')
        );
        $result = $this->Mdl_Medical->updateMedical($medicalID, $data);
        if($result['status'] == FALSE){
            $this->session->set_flashdata('_message', $result['data']);
            redirect($this->input->post('txtDirectLink').'?err=update');
        }
        $this->session->set_flashdata('_message', 'Data Berhasil Diperbahahui.');
        redirect($this->input->post('txtDirectLink').'?success=ok');
    }
    
    
    function test(){
        $image = file_get_contents('D:/myAvatar.png');
        $image_codes = base64_encode($image);
        echo '<image src="data:image/jpg;charset=utf-8;base64,'.$image_codes.'" />';
    }
}