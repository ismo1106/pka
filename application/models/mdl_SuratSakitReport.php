<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Author   : Ismo Broto,   @ismo1106
 */

class Mdl_SuratSakitReport extends CI_Model{
    
    private $datatable;
    var $table = array(
        'tblSuratSakit' => 'vwTrnSuratSakit'
    );
    var $column_order = array(
        'tblSuratSakit' => array('NIK','Nama','StatusTenaker','DeptAbbr','JenisKelamin','Umur','TglMulaiIstirahat','LamaIstirahat',NULL,NULL,NULL,NULL,NULL,'GeneralStatus')
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
    
    function getDatatableSuratSakitReport(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereReportSuratSakit()),
            'all'   => $this->datatable->count_all($this->table['tblSuratSakit'], $this->whereReportSuratSakit()),
            'filter'=> $this->datatable->count_filtered($this->table['tblSuratSakit'], $this->column_order['tblSuratSakit'], $this->column_search['tblSuratSakit'], $this->order['tblSuratSakit'], $this->whereReportSuratSakit())
        );
    }
    function whereReportSuratSakit(){
        $start = ($this->session->userdata('f_start')? date('Y-m-d', strtotime($this->session->userdata('f_start'))): date('Y-m').'-01');
        $end = ($this->session->userdata('f_end')? date('Y-m-d', strtotime($this->session->userdata('f_end'))): date('Y-m-t'));
        $apprv = $this->session->userdata('f_approval');
        
        $strF = "TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'";
        if($this->session->userdata('f_start') && $this->session->userdata('f_approval')){
            if($apprv == 00){
                $strF =  "Approval = 0 AND GeneralStatus = 0 AND TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'";
            }elseif ($apprv == 11) {
                $strF =  "Approval = 1 AND GeneralStatus = 1 AND TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'";
            }else{
                $strF =  "Approval = 0 AND GeneralStatus = 1 AND TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'";
            }
        }else{
            if($this->session->userdata('f_start')){
                $strF =  "TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'";
            }
            if($this->session->userdata('f_approval')){
                if($apprv == 00){
                    $strF =  "Approval = 0 AND GeneralStatus = 0";
                }elseif ($apprv == 11) {
                    $strF =  "Approval = 1 AND GeneralStatus = 1";
                }else{
                    $strF =  "Approval = 0 AND GeneralStatus = 1";
                }
            }
        }
            
        return $strF;
    }
    function getSusakReportToExportExcel($start,$end){
        $this->db->order_by('SakitID', 'ASC');
        $this->db->where("TglMulaiIstirahat BETWEEN '".$start."' AND '".$end."'");
        $get = $this->db->get($this->table['tblSuratSakit']);
        return $get->result();
    }
}