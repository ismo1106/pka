<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Author   : Ismo Broto,   @ismo1106
 */

class Mdl_SuratSakitMonitor extends CI_Model{
    
    private $datatable;
    var $table = array(
        'tblSuratSakit' => 'vwTrnSuratSakit'
    );
    var $column_order = array(
        'tblSuratSakit' => array('NIK','Nama','StatusTenaker','DeptAbbr','JenisKelamin','Umur','TglMulaiIstirahat','LamaIstirahat',NULL,NULL,NULL,NULL,NULL,'GeneralStatus'),
        'susakP2K3' => array(NULL,'NIK','Nama','StatusTenaker','DeptAbbr','JenisKelamin','Umur','TglMulaiIstirahat','LamaIstirahat',NULL,NULL,NULL,NULL,NULL,'GeneralStatus')
    );
    var $column_search = array(
        'tblSuratSakit' => array('NIK','Nama','Perusahaan','DeptAbbr','JenisKelamin','Umur','JenisSurat','TglMulaiIstirahat','LamaIstirahat','GeneralStatus')
    );
    var $order = array(
        'tblSuratSakit' => array('TglMulaiIstirahat' => 'DESC')
    );
    var $where = array(
        'tblSuratSakit' => 'GeneralStatus = 1'
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    //##== Monitor Surat Sakit =================================================
    function getDatatableSuratSakitMonitor(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereMonitorSuratSakit()),
            'all'   => $this->datatable->count_all($this->table['tblSuratSakit'], $this->whereMonitorSuratSakit()),
            'filter'=> $this->datatable->count_filtered($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereMonitorSuratSakit())
        );
    }
    function whereMonitorSuratSakit(){
        $status = ($this->session->userdata('f_status')? $this->session->userdata('f_status'): 'K');
        $surat = $this->session->userdata('f_surat');
        $kk = $this->session->userdata('f_kk');
        $period = ($this->session->userdata('f_period')? date('Y-m', strtotime($this->session->userdata('f_period'))): '');
        
        $group = $this->session->userdata('u_group');
        $strWhere = "";
        if($status == 'K'){
            $strWhere =  "StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%' AND JenisSurat LIKE '%".$surat."%' "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'K') "
                . ($this->session->userdata('f_kk')? "AND KecelakaanKerja LIKE '%".str_replace(9, 0, $kk)."%'":"");
        }else{
            $strWhere =  "StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%' AND JenisSurat LIKE '%".$surat."%' "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'B') "
                . ($this->session->userdata('f_kk')? "AND KecelakaanKerja LIKE '%".str_replace(9, 0, $kk)."%'":"");
        }
        return $strWhere;
    }
    
    //##== Print Surat Sakit ===================================================
    function getDatatableSuratSakitPrint(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->wherePrintSuratSakit()),
            'all'   => $this->datatable->count_all($this->table['tblSuratSakit'], $this->wherePrintSuratSakit()),
            'filter'=> $this->datatable->count_filtered($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->wherePrintSuratSakit())
        );
    }
    function wherePrintSuratSakit(){
        $status = $this->session->userdata('f_status');
        $period = ($this->session->userdata('f_period')? date('Y-m', strtotime($this->session->userdata('f_period'))): date('Y-m'));
        return "Approval = 1 AND StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%'";
    }
    function getDataSusakInMonitor($no){
        $this->db->where('SakitID', $no);
        return $this->db->get($this->table['tblSuratSakit'])->row();
    }
    
    //##== Surat Sakit Check P2K3 ==============================================
    function getDatatableSuratSakitCheckP2K3(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblSuratSakit'], $this->column_order['susakP2K3'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereCheckP2K3SuratSakit()),
            'all'   => $this->datatable->count_all($this->table['tblSuratSakit'], $this->whereCheckP2K3SuratSakit()),
            'filter'=> $this->datatable->count_filtered($this->table['tblSuratSakit'], $this->column_order['susakP2K3'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereCheckP2K3SuratSakit())
        );
    }
    function whereCheckP2K3SuratSakit(){
        $status = $this->session->userdata('f_status');
        $surat = $this->session->userdata('f_surat');
        $period = ($this->session->userdata('f_period')? date('Y-m', strtotime($this->session->userdata('f_period'))): '');
        return "StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%' AND JenisSurat LIKE '%".$surat."%' AND "
                . "Approval = 1 AND KirimP2K3 = 1";
    }
    
    //##== Surat Sakit Check Departemen ==============================================
    function getDatatableSuratSakitCheckDept(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblSuratSakit'], $this->column_order['susakP2K3'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereCheckDeptSuratSakit()),
            'all'   => $this->datatable->count_all($this->table['tblSuratSakit'], $this->whereCheckDeptSuratSakit()),
            'filter'=> $this->datatable->count_filtered($this->table['tblSuratSakit'], $this->column_order['susakP2K3'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereCheckDeptSuratSakit())
        );
    }
    function whereCheckDeptSuratSakit(){
        $status = ($this->session->userdata('f_status')? $this->session->userdata('f_status'): 'K');
        $surat = $this->session->userdata('f_surat');
        $period = ($this->session->userdata('f_period')? date('Y-m', strtotime($this->session->userdata('f_period'))): '');
        
        $group = $this->session->userdata('u_group');
        $strWhere = "";
        if($status == 'K'){
            $strWhere =  "StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%' AND JenisSurat LIKE '%".$surat."%' "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'K') AND "
                . "Approval = 1 AND KirimP2K3 = 1 AND CheckedP2K3 = 1";
        }else{
            $strWhere =  "StatusTenaker LIKE '%".$status."%' AND TglMulaiIstirahat LIKE '".$period."%' AND JenisSurat LIKE '%".$surat."%' "
                . "AND DeptID IN (SELECT DeptID FROM tblUtlDeptAccess WHERE GroupID = ".$group." AND DeptType = 'B') AND "
                . "Approval = 1 AND KirimP2K3 = 1 AND CheckedP2K3 = 1";
        }
        return $strWhere;
    }
}