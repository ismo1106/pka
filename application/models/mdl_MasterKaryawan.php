<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_MasterKaryawan extends CI_Model {
    
    private $db_payroll;
    
    public function __construct() {
        parent::__construct();
        
        $this->db_payroll   = $this->load->database('payroll', TRUE);
    }
    
    //##========================================================================
    function selectMasterKaryawan($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY NIK DESC) AS Row, "
                . "* FROM vwMstKaryawanKontrak AS tbl ) vwMstKaryawanKontrak WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countMasterKaryawan(){
        $query = $this->db->query("SELECT NIK FROM vwMstKaryawanKontrak ORDER BY NIK DESC");
        return $query->num_rows();
    }
    function selectFilterMasterKaryawan($start,$end,$nik,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY NIK DESC) AS Row, "
                . "* FROM vwMstKaryawanKontrak AS tbl WHERE NIK LIKE '%".$nik."%' AND NAMA LIKE '%".$nama."%' ) "
                . "vwMstKaryawanKontrak WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countFilterMasterKaryawan($nik,$nama){
        $query = $this->db->query("SELECT NIK FROM vwMstKaryawanKontrak WHERE NIK LIKE '%".$nik."%' AND NAMA LIKE '%".$nama."%' ORDER BY NIK DESC");
        return $query->num_rows();
    }
    
    //##========================================================================
    function getMstKaryByNIK($nik){
        return $this->db->get_where('vwMstKaryawanKontrak', array('NIK' => $nik));
    }
    function getMstKaryByMultiNIK($nik){
        return $this->db->query("SELECT * FROM vwMstKaryawanKontrak WHERE NIK IN (".$nik.") ORDER BY NIK DESC");
    }
    
    //##========================================================================
    function updateMasterKaryawan($nik,$data){
        $this->db_payroll->where('NIK', $nik);
        $this->db_payroll->update('tblMstKaryawan', $data);
    }
}