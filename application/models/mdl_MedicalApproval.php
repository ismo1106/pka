<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_MedicalApproval extends CI_Model {
    
    private $datatable;
    var $table = array(
        'vwMedical' => 'vwTrnMedical',
    );
    var $column_order = array(
        'listMedic' => array(NULL, NULL, 'NIK', 'Nama', 'Dept', 'TypeTK', 'JenisKelamin', 'Usia', 'TglMedical'),
    );
    var $column_search = array(
        'listMedic' => array('NIK', 'Nama', 'Dept', 'TypeTK', 'JenisKelamin', 'Usia', 'TglMedical'),
    );
    var $order = array(
        'listMedic' => array('MedicalID' => 'ASC'),
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    function getJenisMedicalModel($typeTK){
        $this->db->where('Kode', $typeTK);
        $get = $this->db->get('tblMstJenisMedical');
        $result = '';
        if($get->num_rows() > 0){
            $result = $get->row()->Nama;
        }
        return $result;
    }
            
    function getDatatableApprovalMedicalAll(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalApproval()),
            'all'   => $this->datatable->count_all($this->table['vwMedical'], $this->whereGetMedicalApproval()),
            'filter'=> $this->datatable->count_filtered($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalApproval())
        );
    }
    function whereGetMedicalApproval(){
        return "Approval = 0";
    }
    
    //##== Control P2K3 ========================================================
    function getDatatableControlMedicalP2K3(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalControlP2K3()),
            'all'   => $this->datatable->count_all($this->table['vwMedical'], $this->whereGetMedicalControlP2K3()),
            'filter'=> $this->datatable->count_filtered($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalControlP2K3())
        );
    }
    function whereGetMedicalControlP2K3(){
        return "Approval = 1 AND CatatanP2K3 IS NOT NULL";
    }
    
    //##== Control Dept ========================================================
    function getDatatableControlMedicalDept(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalControlDept()),
            'all'   => $this->datatable->count_all($this->table['vwMedical'], $this->whereGetMedicalControlDept()),
            'filter'=> $this->datatable->count_filtered($this->table['vwMedical'], $this->column_order['listMedic'], $this->column_search['listMedic'], $this->order['listMedic'], $this->whereGetMedicalControlDept())
        );
    }
    function whereGetMedicalControlDept(){
        $group = $this->session->userdata('u_group');
        return "Approval = 1 AND CheckedP2K3 = 1 AND CatatanP2K3 IS NOT NULL "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'K')";
    }
}