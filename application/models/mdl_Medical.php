<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Medical extends CI_Model {
    
    private $datatable;
    var $table = array(
        'listToDay' => 'vwTrnListMedicalHariIni',
        'allKary'   => 'vwAllKaryawanOnOff',
    );
    var $column_order = array(
        'tknew'     => array('NoUrut','NIK','Nama','JenisKelamin','Usia'),
        'allKary'   => array('RegNo','Nama','JenisKelamin','TEMPATLHR','TGLLAHIR','Usia'),
    );
    var $column_search = array(
        'tknew'     => array('NoUrut','NIK','Nama','Dept'),
        'allKary'   => array('Nama','TEMPATLHR'),
    );
    var $order = array(
        'tknew'     => array('NoUrut' => 'ASC'),
        'allKary'   => array('Nama' => 'ASC'),
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    //##== TK Baru
    function getDatatableMedicalTKNew(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalTKNew()),
            'all'   => $this->datatable->count_all($this->table['listToDay'], $this->whereGetMedicalTKNew()),
            'filter'=> $this->datatable->count_filtered($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalTKNew())
        );
    }
    function whereGetMedicalTKNew(){
        return "TypeTK = 'TKB' AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'TKB' AND YEAR(TglMedical) = '".date('Y')."')";
    }
    function getMstTKNewForMedical($noReg){
        $this->db->where("RegisNumber = '".$noReg."'");
        return $this->db->get('vwMstTenakerNew');
    }
    
    //##== Borongan/Harian
    function getDatatableMedicalBorongan(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalBoro()),
            'all'   => $this->datatable->count_all($this->table['listToDay'], $this->whereGetMedicalBoro()),
            'filter'=> $this->datatable->count_filtered($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalBoro())
        );
    }
    function whereGetMedicalBoro(){
        return "TypeTK = 'HB' AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'HB' AND YEAR(TglMedical) = '".date('Y')."')";
    }
    function getMstBoroForMedical($nik){
        $this->db->where("NIK = '".$nik."'");
        return $this->db->get('vwMstTenakerBorongan');
    }
    
    //##== Kary Kontrak
    function getDatatableMedicalKontrak(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalKontrak()),
            'all'   => $this->datatable->count_all($this->table['listToDay'], $this->whereGetMedicalKontrak()),
            'filter'=> $this->datatable->count_filtered($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalKontrak())
        );
    }
    function whereGetMedicalKontrak(){
        return "TypeTK = 'KK' AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'KK' AND YEAR(TglMedical) = '".date('Y')."')";
    }
    function getMstKontrakForMedical($nik){
        $this->db->where("NIK = '".$nik."'");
        return $this->db->get('vwMstKaryawanKontrak');
    }
    
    //##== Kary Tetap
    function getDatatableMedicalTetap(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalTetap()),
            'all'   => $this->datatable->count_all($this->table['listToDay'], $this->whereGetMedicalTetap()),
            'filter'=> $this->datatable->count_filtered($this->table['listToDay'], $this->column_order['tknew'], $this->column_search['tknew'], $this->order['tknew'], $this->whereGetMedicalTetap())
        );
    }
    function whereGetMedicalTetap(){
        return "TypeTK = 'KT' AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'KT' AND YEAR(TglMedical) = '".date('Y')."')";
    }
    function getMstTetapForMedical($nik){
        $this->db->where("NIK = '".$nik."'");
        return $this->db->get('vwMstKaryawanTetap');
    }
    
    //##== Medical KHUSUS
    function getDatatableMedicalKhusus(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['allKary'], $this->column_order['allKary'], $this->column_search['allKary'], $this->order['allKary'], $this->whereGetMedicalKhusus()),
            'all'   => $this->datatable->count_all($this->table['allKary'], $this->whereGetMedicalKhusus()),
            'filter'=> $this->datatable->count_filtered($this->table['allKary'], $this->column_order['allKary'], $this->column_search['allKary'], $this->order['allKary'], $this->whereGetMedicalKhusus())
        );
    }
    function whereGetMedicalKhusus(){
        $name = $this->session->userdata('f_name');
        return "Nama LIKE '%".$name."%'";
    }
    function getMstKhususForMedical($nik){
        $this->db->where("RegNo = '".$nik."'");
        return $this->db->get($this->table['allKary']);
    }
    
    //##== Submit Medical
    function getMedicalForUpdate($medicalID){
        $this->db->where("MedicalID = '".$medicalID."'");
        return $this->db->get('vwTrnMedical');
    }
    function simpanMedical($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnMedical', $data);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'data' => error_reporting(E_ALL));
        }
        return array('status' => TRUE, 'data' => $hdrID);
    }
    function updateMedical($medicalID, $data){
        $this->db->trans_start();
        $this->db->where('MedicalID', $medicalID);
        $this->db->update('tblTrnMedical', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'data' => error_reporting(E_ALL));
        }
        return array('status' => TRUE, 'data' => $medicalID);
    }
}