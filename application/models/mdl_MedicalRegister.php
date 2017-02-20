<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_MedicalRegister extends CI_Model {
    
    private $datatable;
    var $table = array(
        'toDay' => 'tblTrnListMedicalHarian',
        'TKNew' => 'vwMstMedicalTenakerNew',
        'harian' => 'vwMstMedicalBoronganThisMonth',
        'kontrak' => 'vwMstMedicalKontrakThisMonth',
        'tetap' => 'vwMstMedicalTetapThisMonth'
    );
    var $column_order = array(
        'toDay' => array('NoUrut','NIK','Nama','Dept','JenisKelamin','Usia','TglMedical'),
        'TKNew' => array(null,'RegisNumber','Nama','JenisKelamin','Usia'),
        'harian' => array(null,'NIK','Nama','JenisKelamin','Usia'),
        'kontrak' => array(null,'NIK','NAMA','Sex','Usia'),
        'tetap' => array(null,'NIK','NAMA','Sex','Usia')
    );
    var $column_search = array(
        'toDay' => array('NoUrut','NIK','Nama','Dept'),
        'TKNew' => array('RegisNumber','Nama','JenisKelamin','Usia'),
        'harian' => array('NIK','Nama','JenisKelamin','Usia'),
        'kontrak' => array('NIK','NAMA','Sex','Usia'),
        'tetap' => array('NIK','NAMA','Sex','Usia','MasaKerja')
    );
    var $order = array(
        'toDay' => array('NoUrut' => 'ASC'),
        'TKNew' => array('RegisNumber' => 'DESC'),
        'harian' => array('NIK' => 'DESC'),
        'kontrak' => array('NIK' => 'DESC'),
        'tetap' => array('NIK' => 'DESC')
    );
    var $where = array(
        'toDay' => "TglMedical = CONVERT(DATE,GETDATE())",
        'TKNew' => '',
        'harian' => "NIK NOT IN (SELECT mh.NIK FROM tblTrnListMedicalHarian AS mh WHERE mh.TypeTK = 'HB')",
        'kontrak' => "NIK NOT IN (SELECT mh.NIK FROM tblTrnListMedicalHarian AS mh WHERE mh.TypeTK = 'KK')",
        'tetap' => "NIK NOT IN (SELECT mh.NIK FROM tblTrnListMedicalHarian AS mh WHERE mh.TypeTK = 'KT')"
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    function getTotalKuotaMedicalPerHari(){
        $getDate = date('N');
        $this->db->where('DayNumber', $getDate);
        $get = $this->db->get('tblMstKuotaMedialPerHari')->row();
        return $get->Kuota;
    }
    function countMedicalToDay(){
        $this->db->where("TglMedical = CONVERT(DATE,GETDATE())");
        $get = $this->db->get('tblTrnListMedicalHarian');
        return $get->num_rows();
    }
    function getAksesRegTKNew($groupID){
        $this->db->where('AccessID', 1);
        $this->db->where('GroupID', $groupID);
        $get = $this->db->get('tblUtlSpecialAccessGroup');
        if ($get->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    //## Getting Master
    function getTKNew($id){
        return $this->db->get_where($this->table['TKNew'], array('RegisNumber' => $id))->row();
    }
    function getTKHarian($nik){
        return $this->db->get_where($this->table['harian'], array('NIK' => $nik))->row();
    }
    function getKaryKontrak($nik){
        return $this->db->get_where($this->table['kontrak'], array('NIK' => $nik))->row();
    }
    function getKaryTetap($nik){
        return $this->db->get_where($this->table['tetap'], array('NIK' => $nik))->row();
    }
            
    function getNomorUrutMedical(){
        $this->db->order_by('NoUrut', 'DESC');
        $this->db->where("TglMedical = '".date('Y-m-d')."'");
        $query = $this->db->get('tblTrnListMedicalHarian');
        if ($query->num_rows() > 0) {
            $get = $query->row();
            return $get->NoUrut+1;
        }
        return 1;
    }
    //##== Simpan Register Medical
    function insertRegisMedical($data){
        $this->db->trans_start();
        $this->db->insert('tblTrnListMedicalHarian', $data);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return error_reporting(E_ALL);
        }
        return TRUE;
    }


    //##=== Get Datatable ======================================================
    function getDatatableMedicalToDay(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['toDay'], $this->column_order['toDay'], $this->column_search['toDay'], $this->order['toDay'], $this->where['toDay']),
            'all'   => $this->datatable->count_all($this->table['toDay'], $this->where['toDay']),
            'filter'=> $this->datatable->count_filtered($this->table['toDay'], $this->column_order['toDay'], $this->column_search['toDay'], $this->order['toDay'], $this->where['toDay'])
        );
    }
    function getDatatableModelTKNew(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['TKNew'], $this->column_order['TKNew'], $this->column_search['TKNew'], $this->order['TKNew'], $this->whereListRegMedicalToDayTKNew()),
            'all'   => $this->datatable->count_all($this->table['TKNew'], $this->whereListRegMedicalToDayTKNew()),
            'filter'=> $this->datatable->count_filtered($this->table['TKNew'], $this->column_order['TKNew'], $this->column_search['TKNew'], $this->order['TKNew'], $this->whereListRegMedicalToDayTKNew())
        );
    }
    function whereListRegMedicalToDayTKNew(){
        return "RegisNumber NOT IN (SELECT NIK FROM tblTrnListMedicalHarian WHERE TypeTK = 'TKB' AND TglMedical = CONVERT(DATE,GETDATE())) "
                . "AND RegisNumber NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'TKB' AND YEAR(TglMedical) = '".date('Y')."')";
    }
            
    function getDatatableModelTKHarian(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['harian'], $this->column_order['harian'], $this->column_search['harian'], $this->order['harian'], $this->whereListRegMedicalToDayBoro()),
            'all'   => $this->datatable->count_all($this->table['harian'], $this->whereListRegMedicalToDayBoro()),
            'filter'=> $this->datatable->count_filtered($this->table['harian'], $this->column_order['harian'], $this->column_search['harian'], $this->order['harian'], $this->whereListRegMedicalToDayBoro())
        );
    }
    function whereListRegMedicalToDayBoro(){
        $group = $this->session->userdata('u_group');
        return "NIK NOT IN (SELECT NIK FROM tblTrnListMedicalHarian WHERE TypeTK = 'HB' AND TglMedical = CONVERT(DATE,GETDATE())) "
                . "AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'HB' AND YEAR(TglMedical) = '".date('Y')."') "
                . "AND IDDepartemen IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'B')";
    }
    
    function getDatatableModelKaryKontrak(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['kontrak'], $this->column_order['kontrak'], $this->column_search['kontrak'], $this->order['kontrak'], $this->whereListRegMedicalToDayKontrak()),
            'all'   => $this->datatable->count_all($this->table['kontrak'], $this->whereListRegMedicalToDayKontrak()),
            'filter'=> $this->datatable->count_filtered($this->table['kontrak'], $this->column_order['kontrak'], $this->column_search['kontrak'], $this->order['kontrak'], $this->whereListRegMedicalToDayKontrak())
        );
    }
    function whereListRegMedicalToDayKontrak(){
        $group = $this->session->userdata('u_group');
        return "NIK NOT IN (SELECT NIK FROM tblTrnListMedicalHarian WHERE TypeTK = 'KK' AND TglMedical = CONVERT(DATE,GETDATE())) "
                . "AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'KK' AND YEAR(TglMedical) = '".date('Y')."') "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'K')";
    }
    
    function getDatatableModelKaryTetap(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tetap'], $this->column_order['tetap'], $this->column_search['tetap'], $this->order['tetap'], $this->whereListRegMedicalToDayTetap()),
            'all'   => $this->datatable->count_all($this->table['tetap'], $this->whereListRegMedicalToDayTetap()),
            'filter'=> $this->datatable->count_filtered($this->table['tetap'], $this->column_order['tetap'], $this->column_search['tetap'], $this->order['tetap'], $this->whereListRegMedicalToDayTetap())
        );
    }
    function whereListRegMedicalToDayTetap(){
        $group = $this->session->userdata('u_group');
        return "NIK NOT IN (SELECT NIK FROM tblTrnListMedicalHarian WHERE TypeTK = 'KT' AND TglMedical = CONVERT(DATE,GETDATE())) "
                . "AND NIK NOT IN (SELECT NIK FROM tblTrnMedical WHERE TypeTK = 'KT' AND YEAR(TglMedical) = '".date('Y')."') "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'K')";
    }
}