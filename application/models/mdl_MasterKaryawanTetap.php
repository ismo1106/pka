<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_MasterKaryawanTetap extends CI_Model {
    
    private $db_payroll;
    
    public function __construct() {
        parent::__construct();
        
        $this->db_payroll   = $this->load->database('payroll', TRUE);
    }
    
    //##========================================================================
    function selectMasterKaryawanTetap($start,$end){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY NIK DESC) AS Row, "
                . "* FROM vwMstKaryawanTetap AS tbl ) vwMstKaryawanTetap WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countMasterKaryawanTetap(){
        $query = $this->db->query("SELECT NIK FROM vwMstKaryawanTetap ORDER BY NIK DESC");
        return $query->num_rows();
    }
    function selectFilterMasterKaryawanTetap($start,$end,$nik,$nama){
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY NIK DESC) AS Row, "
                . "* FROM vwMstKaryawanTetap AS tbl WHERE NIK LIKE '%".$nik."%' AND NAMA LIKE '%".$nama."%' ) "
                . "vwMstKaryawanTetap WHERE Row >= ".$start." AND Row <= ".$end." ");
        return $query->result();
    }
    function countFilterMasterKaryawanTetap($nik,$nama){
        $query = $this->db->query("SELECT NIK FROM vwMstKaryawanTetap WHERE NIK LIKE '%".$nik."%' AND NAMA LIKE '%".$nama."%' ORDER BY NIK DESC");
        return $query->num_rows();
    }
    
    //##========================================================================
    function getMstKaryByNIKtetap($nik){
        return $this->db->get_where('vwMstKaryawanTetap', array('NIK' => $nik));
    }
    function getMstKaryByMultiNIKtetap($nik){
        return $this->db->query("SELECT * FROM vwMstKaryawanTetap WHERE NIK IN (".$nik.") ORDER BY NIK DESC");
    }
    
    //##========================================================================
    function updateMasterKaryawanTetap($nik,$data){
        $this->db_payroll->where('NIK', $nik);
        $this->db_payroll->update('tblMstKaryawan', $data);
    }
}