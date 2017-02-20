<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_SuratSakit extends CI_Model {
    
    private $datatable;
    var $table = array(
        'approval' => 'tblTrnSuratSakit'
    );
    var $column_order = array(
        'approval' => array(null,'NIK','Nama','Perusahaan','JenisKelamin','Umur','JenisSurat','TglMulaiIstirahat','LamaIstirahat','GeneralStatus')
    );
    var $column_search = array(
        'approval' => array('NIK','Nama','Perusahaan','JenisKelamin','Umur','JenisSurat','TglMulaiIstirahat','LamaIstirahat','GeneralStatus')
    );
    var $order = array(
        'approval' => array('SakitID' => 'DESC')
    );
    var $where = array(
        'approval' => 'GeneralStatus = 0 AND Approval = 0'
    );

    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    function selectAlasanSakit(){
        return $this->db->get('tblMstAlasanSakit')->result();
    }
    function getMstAllKaryByNIK($nik){
        $this->db->where("NIK = '".$nik."'");
        return $this->db->get('vwMstKaryawanSuratSakit');
    }
    function checkTglSuratSakit($nik, $tglsakit){
        $this->db->select('TglSuratSakit');
        $this->db->where("NIK = '".$nik."' AND TglSuratSakit = '".$tglsakit."' AND ((Approval = 1 AND GeneralStatus = 1) OR (Approval = 0 AND GeneralStatus = 0))");
        $query = $this->db->get('vwCheckSuratSakit');
        if ($query->num_rows() > 0) {
            $get = $query->row();
            return date('d-m-Y', strtotime($get->TglSuratSakit));
        }else {
            return FALSE;
        }
    }
    function checkTglSuratSakitForUpdate($nik, $sakitID, $tglsakit){
        $this->db->select('TglSuratSakit');
        $this->db->where("NIK = '".$nik."' AND SakitID <> '".$sakitID."' AND TglSuratSakit = '".$tglsakit."'");
        $query = $this->db->get('tblTrnSuratSakitDetail');
        if ($query->num_rows() > 0) {
            $get = $query->row();
            return date('d-m-Y', strtotime($get->TglSuratSakit));
        }else {
            return FALSE;
        }
    }
    function getNomorUrutKaryawan(){
        $this->db->order_by('NoUrut', 'DESC');
        $this->db->where('StatusTenaker', 'K');
        $query = $this->db->get('tblTrnSuratSakit');
        if ($query->num_rows() > 0) {
            $get = $query->row();
            return $get->NoUrut+1;
        }
        return 1;
    }
    
    //##=== Model Borongan ===
    function getMstAllBoronganByNIK($nik){
        return $this->db->get_where('vwMstTenakerBorongan', array('CONVERT(VARCHAR,NIK)' => $nik));
    }
    function getNomorUrutBorongan(){
        $this->db->order_by('NoUrut', 'DESC');
        $this->db->where('StatusTenaker', 'B');
        $query = $this->db->get('tblTrnSuratSakit');
        if ($query->num_rows() > 0) {
            $get = $query->row();
            return $get->NoUrut+1;
        }
        return 1;
    }
    
    //##=== Simpan Surat Sakit ===
    function simpanHeaderSuratSakit($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnSuratSakit', $data);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'data' => error_reporting(E_ALL));
        }
        return array('status' => TRUE, 'data' => $hdrID);
    }
    function simpanDetailSuratSakit($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnSuratSakitDetail', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return error_reporting(E_ALL);
        }
        return TRUE;
    }
    function updateHeaderSuratSakit($sakitID, $data){
        $this->db->trans_start();
        $this->db->where('SakitID', $sakitID);
        $this->db->update('tblTrnSuratSakit', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'data' => error_reporting(E_ALL));
        }
        return array('status' => TRUE, 'data' => $sakitID);
    }
    function deleteDetailSurat($sakitID){
        $this->db->where('SakitID', $sakitID);
        $this->db->delete('tblTrnSuratSakitDetail');
    }
    
    //##=== Modal Approval ===
    function selectSuratSakitForApproval(){
        $this->db->where('GeneralStatus', 0);
        $this->db->where('Approval', 0);
        return $this->db->get('tblTrnSuratSakit')->result();
    }
    function selectSuratSakitForApprovalInDatatable(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['approval'], $this->column_order['approval'], $this->column_search['approval'], $this->order['approval'], $this->where['approval']),
            'all'   => $this->datatable->count_all($this->table['approval'], $this->where['approval']),
            'filter'=> $this->datatable->count_filtered($this->table['approval'], $this->column_order['approval'], $this->column_search['approval'], $this->order['approval'], $this->where['approval'])
        );
    }
    function getSuratSakitByID($id){
        return $this->db->get_where('tblTrnSuratSakit', array('SakitID' => $id));
    }
}