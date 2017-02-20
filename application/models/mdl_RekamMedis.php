<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_RekamMedis extends CI_Model {

    private $db_payroll;

    public function __construct(){
      parent::__construct();
      $this->db_payroll = $this->load->database('payroll',TRUE);
      $this->db_bor = $this->load->database('borongan',TRUE);
    }

   //get pasien id for karyawan and borongan
   private function Get_Karyawan_Data($idkar,$tipekar){
      $sql = "RekamMedis_GetPasienID ?,?";
      $data= array('PARAM_1'=>$idkar,'PARAM_2'=>$tipekar);
      $query = $this->db->query($sql,$data);
      return $query;
    }

    //get pasien id
    function Get_Karyawan_AllData($idkar,$tipekar){
      if($tipekar>=0 && $tipekar<3){
        return $this->Get_Karyawan_Data($idkar,$tipekar);
      }
      return;
    }

    //generate auto number
    function Generate_Auto_Number($idkar,$tipekar){
      $sql = "RekamMedis_AutoNumber ?,?";
      $data = array('PARAM_1'=>$idkar,'PARAM_2'=>$tipekar);
      $query = $this->db->query($sql,$data);
      return $query;
    }

    //create new rm
    function Create_New_RekamMedisOut($data){
      $sql = "RekamMedis_NewNoRM ?,?,?,?,?";
      $query = $this->db->query($sql,$data);
      return $query;
    }

    //browse data RM
    function Browse_Data_RM($data){
      $sql = "RekamMedis_BrowseData ?,?";
      $query = $this->db->query($sql,$data);
      return $query;
    }

    //get pasien form id
    function GetPasienID_FromRMID($id){
       $query = $this->db->get_where('tblTrnRekamMedisHdr',array('noid'=>$id));
       $row = $query->row(0);
       if(isset($row))
         $noindexrm = $row->NOINDEXRM;
       else
         $noindexrm = '0';
       $query = $this->Get_Karyawan_Data($noindexrm,4);
       return $query;
    }

    //getmaster_diagnosa
    function Browse_MasterDiagnosa(){
      $query = $this->db->select('KODE,DIAGNOSA')->from('tblMstRekamMedisDiagnosa')
                        ->order_by('KODE','ASC')->get();
      return $query;
    }

    //get Keluhan
    function GetKeluhan_fromID($id){
      $query = $this->db->select('ORDERNO,KELUHAN')->from('tblTrnRekamMedisKeluhanDtl')->where('NOID',$id)->order_by('ORDERNO','ASC')->get();
      return $query;
    }

    //get diagnosa
    function GetDiagnosa_fromID($id)
    {
      $sql = "Get_DiagnosaID ?";
      $query = $this->db->query($sql,array('PARAM_1'=>$id));
      return $query;
    }

    //post keluhan
    function pushkeluhan($id,$keluhan,$orderno){
        $sql = "RekamMedis_addKeluhan ?,?,?";
        $query  = $this->db->query($sql,array('PARAM_1'=>$id,'PARAM_2'=>$keluhan,'PARAM_3'=>$orderno));
        return $query;
    }

    //post diagnosa
    function pushdiagnosa($id,$kodediagnosa,$noorder=0){
      $sql = "RekamMedis_addDiagnosa ?,?,?";
      $query = $this->db->query($sql,array('PARAM_1'=>$id,'PARAM_2'=>$kodediagnosa,'PARAM_3'=>$noorder));
      return $query;
    }

    //completed form rekammedis
    function CompleteRekamMedis($id){
      
    }

}
