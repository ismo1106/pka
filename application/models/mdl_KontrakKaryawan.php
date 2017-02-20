<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_KontrakKaryawan extends CI_Model {
    
    private $db_payroll;
    private $datatable;
    var $table = array(
        'tblHbsKontrak' => 'vwTrnKaryHabisKontrak'
    );
    var $column_order = array(
        'tblHbsKontrak' => array(NULL,'NIK','NAMA','Sex','DeptAbbr','TglHabisKontrak','KontrakKe','LIMIT')
    );
    var $column_search = array(
        'tblHbsKontrak' => array('NIK','NAMA','Sex','DeptAbbr','TglHabisKontrak','KontrakKe','LIMIT')
    );
    var $order = array(
        'tblHbsKontrak' => array('TglHabisKontrak' => 'DESC')
    );
    
    public function __construct() {
        parent::__construct();
        $this->db_payroll = $this->load->database('payroll', TRUE);
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
        
    //##== Select Datatables Karyawan Habis Kontrak ============================
    function getDatatableKaryHabisKontrak(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblHbsKontrak'], $this->column_order['tblHbsKontrak'], $this->column_search['tblHbsKontrak'], $this->order['tblHbsKontrak'], $this->whereDatatableKaryHabisKontrak()),
            'all'   => $this->datatable->count_all($this->table['tblHbsKontrak'], $this->whereDatatableKaryHabisKontrak()),
            'filter'=> $this->datatable->count_filtered($this->table['tblHbsKontrak'], $this->column_order['tblHbsKontrak'], $this->column_search['tblHbsKontrak'], $this->order['tblHbsKontrak'], $this->whereDatatableKaryHabisKontrak())
        );
    }
    function whereDatatableKaryHabisKontrak(){
        return "RegNo NOT IN (SELECT Regno FROM tblTrnKontrakUlang WHERE GeneralStatus = 0)";
    }
            
    function selectKaryawanByRegNo($regNo){
        $this->db->where('RegNo', $regNo);
        return $this->db->get($this->table['tblHbsKontrak']);
    }
    function insertConfirmHabisKontrak($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnKontrakUlang', $data);
        $hdrID = $this->db->insert_id();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status' => FALSE, 'data' => error_reporting(E_ALL));
        }
        return array('status' => TRUE, 'data' => $hdrID);
    }
}