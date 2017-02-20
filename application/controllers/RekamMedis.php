<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : hery
*/

class RekamMedis extends CI_Controller {

    public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        $this->load->model(array('Mdl_RekamMedis'));
    }

    private function load_css(){
      return array('css/rmstyle.css','plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
    }

    private function load_js(){
      return array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                   'app/klinik/rekammedis/rekammedisindex.js');
    }

    public function index(){
        $data['_addcss']= $this->load_css();
        $data['_addjs']=$this->load_js();
        //array('rmstyle.css');
        $this->template->display('klinik/rekammedis/index',$data);
    }

    public function searchpasien(){
      $pasienid = $this->input->post('scanbarcode');
      $options = $this->input->post('pasienoption');
      if($pasienid ==='' || !is_numeric($options) || !$pasienid){
        return redirect(site_url('RekamMedis/index')); //redirect if empty
      }

      //karyawan dan borongan
      $datakar = $this->Mdl_RekamMedis->Get_Karyawan_AllData($pasienid,$options);
      $count = count($datakar->result());
      if($count>0){
        $data['_addcss'] = $this->load_css();
        $data['_addjs']=$this->load_js();
        $data['_hasil'] = $datakar->result_array();
        return $this->template->display('klinik/rekammedis/index',$data);
      }

      //data tidak ditemukan
      $this->session->set_flashdata('message','Pasien-ID ' . $pasienid . ' tidak ditemukan');
      redirect(site_url('RekamMedis/index'));
    }

   //generate auto index pasien id
    private function gennoindex($fixno,$tipe){
      $newnorm = $this->Mdl_RekamMedis->Generate_Auto_Number($fixno,$tipe);
      $count = count($newnorm->result());
      if($count>0){
        $datafixno = $newnorm->result();
        return json_encode(array("count"=>1,"error"=>false,"pesan"=>"done","data"=>$datafixno));
      }else {
        return json_encode(array("count"=>0,"error"=>true,"pesan"=>"Tidak ditemukan data auto index"));
      }
    }

    //new rm keluar
    public function newrmkeluar(){
        if($this->input->is_ajax_request()){
          $fixno = $this->input->post('fixno');
          $tipe = $this->input->post('tipe');
          $ndata = $this->gennoindex($fixno,$tipe);
          echo $ndata; //ajax json --- sorry no security (temporary)
        }else {
          $fixno = $this->input->post('fixno');
          $noindex= $this->input->post('noindex');
          $tipefixno= $this->input->post('tipefixno');
          $nobpjs = $this->input->post('nobpjs');
          $tgltrans=$this->input->post('tglmasuk');
          $date = date_create_from_format('j/n/Y',$tgltrans);
          $tgl =  $date->format('Y-m-d');

          $data = array("PARAM_1"=>$noindex,"PARAM_2"=>$fixno,"PARAM_3"=>$nobpjs,"PARAM_4"=>$tgl,"PARAM_5"=>$tipefixno);
          $returnquery = $this->Mdl_RekamMedis->Create_New_RekamMedisOut($data);
          $this->session->set_flashdata('in',$returnquery->result_array());
          return redirect(site_url('rekammedis/rekammedispelayanan'));
          //-----------------------
        }
    }

    //-------------------pelayanan rekam Mdl_RekamMedis
    public function rekammedispelayanan()
    {
        //rekam medis css
        $data['_addcss'] = array('css/rmstyle.css',
                                  'plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
                                  'app/klinik/rekammedis/scrolling-nav.css',
                                  'plugins/datatables/jquery.dataTables.min.css');
        //rekam medis js
        $data['_addjs'] = array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                                'plugins/datatables/jquery.dataTables.min.js',
                                'js/jquery.easing.min.js',
                                'js/scrollreveal.min.js',
                                'js/creative.js',
                                'app/klinik/rekammedis/rekammedisperawatan.js');
        $query=$this->Mdl_RekamMedis->Browse_MasterDiagnosa();
        $sdata = $this->session->flashdata('in');
        if(isset($sdata))
        {
          $noid = $sdata[0]['NOID'];
          $diagnosa = $this->Mdl_RekamMedis->GetDiagnosa_fromID($noid);
          $data['_hdiagnosa'] = $diagnosa->result_array();

          $keluhan=$this->Mdl_RekamMedis->GetKeluhan_fromID($noid);
          $data['_hkeluhan'] = $keluhan->result_array();
        }
        $data['_hasil']= $sdata;
        $data['_diagnosa'] = $query->result_array();
        return $this->template->display('klinik/rekammedis/perawatan/diagnosa_rekammedis',$data);
    }

    //get data rm for date --json result
    private function getDataRMwithDate($tgl,$iscomplete){
      $date = date_create_from_format('j/n/Y',$tgl);
      $strdate = $date->format('Y-m-d');
      $data = array('PARAM_1'=>$strdate,'PARAM_2'=>$iscomplete);
      $retunquery = $this->Mdl_RekamMedis->Browse_Data_RM($data);
      $c = $retunquery->row(0);// count($returnquery->result());
      if(isset($c)){
        $dt = $retunquery->result();
        return json_encode(array('error'=>false,'pesan'=>'done','data'=>$dt));
      }else{
        return json_encode(array('error'=>true,'pesan'=>'no data','data'=>false));
      }

    }

    //ajax browsing data rm
    public function browsing_datarm(){
      if($this->input->is_ajax_request()){
        $tglfilter = $this->input->post('tgl');
        $iscomplete = $this->input->post('iscomplete');
        $hasil = $this->getDataRMwithDate($tglfilter,$iscomplete);
        echo $hasil;
      }else{
        echo 'You are not authorized to access this page!';
      }
    }

    //get all here
    public function getpasienidfromrm(){
       if($this->input->is_ajax_request()){
         $idrm = $this->input->post('noid');
         if(!is_numeric($idrm)){
           echo json_encode(array('error'=>'error id'));
           return;
         }else{
           $noindex = $this->Mdl_RekamMedis->GetPasienID_FromRMID($idrm);
           $row = $noindex->row(0);
           if(isset($row)){
             $keluhan = $this->Mdl_RekamMedis->GetKeluhan_fromID($idrm);
             $diagnosis = $this->Mdl_RekamMedis->GetDiagnosa_fromID($idrm);
             echo json_encode(array('error'=>false,'data'=>$noindex->result(),
                                                   'keluhan'=>$keluhan->result(),
                                                   'diagnosa'=>$diagnosis->result()));
           }
           else
             echo json_encode(array('error'=>true,'data'=>'no data'));
         }
       }else{
         echo 'You are not authorized to access this page!';
       }
    }

    //push keluhan
    public function pushkeluhan(){
      if($this->input->is_ajax_request()){
        $noid = $this->input->post('noid');
        $keluhan= $this->input->post('keluhan');
        $orderno= $this->input->post('orderno');
        $query = $this->Mdl_RekamMedis->pushkeluhan($noid,$keluhan,$orderno);
        echo json_encode(array('error'=>false,'data'=>$query->result()));
      }else{
        echo 'You are not authorized to access this page!';
      }
    }

    //push diagnosa
    public function pushdiagnosa(){
      if($this->input->is_ajax_request()){
        $noid = $this->input->post('noid');
        $kode =$this->input->post('kode');
        $noorder=$this->input->post('orderno');
        $query = $this->Mdl_RekamMedis->pushdiagnosa($noid,$kode,$noorder);
        echo json_encode(array('error'=>false,'data'=>$query->result()));
      }else{
        echo 'You are not authorized to access this page!';
      }
    }

}
