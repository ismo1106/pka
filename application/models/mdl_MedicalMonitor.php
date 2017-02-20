<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_MedicalMonitor extends CI_Model {
    
    private $datatable;
    var $table = array(
        'listToDay' => 'vwTrnListMedicalHariIni',
        'haveMedic' => 'vwTrnMedical',
    );
    var $column_order = array(
        'ToDay' => array('NoUrut','NIK','Nama','Dept','TypeTK','JenisKelamin','Usia','Keterangan'),
        'haveMedic' => array(NULL,'NIK','Nama','Dept','TypeTK','JenisKelamin','Usia','TglMedical','Approval','CheckedP2K3','CheckedDept'),
    );
    var $column_search = array(
        'ToDay' => array('NIK','Nama','Dept','JenisKelamin','Usia'),
    );
    var $order = array(
        'ToDay' => array('NoUrut' => 'ASC'),
        'haveMedic' => array('TglMedical' => 'DESC'),
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    //##== List Medical Today
    function getDTableMedicalListToday(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['listToDay'], $this->column_order['ToDay'], $this->column_search['ToDay'], $this->order['ToDay'], FALSE),
            'all'   => $this->datatable->count_all($this->table['listToDay'], FALSE),
            'filter'=> $this->datatable->count_filtered($this->table['listToDay'], $this->column_order['ToDay'], $this->column_search['ToDay'], $this->order['ToDay'], FALSE)
        );
    }
    
    //##== Have Medical List
    function getDTableHaveMedicalModel(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['haveMedic'], $this->column_order['haveMedic'], $this->column_search['ToDay'], $this->order['haveMedic'], $this->whereGetHaveMedical()),
            'all'   => $this->datatable->count_all($this->table['haveMedic'], $this->whereGetHaveMedical()),
            'filter'=> $this->datatable->count_filtered($this->table['haveMedic'], $this->column_order['haveMedic'], $this->column_search['ToDay'], $this->order['haveMedic'], $this->whereGetHaveMedical())
        );
    }
    function whereGetHaveMedical(){
        return "YEAR (TglMedical) = '". date('Y') ."'";
    }
    
    
    //##== Report Medical
    function getDTableReportMedicalModel(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['haveMedic'], $this->column_order['haveMedic'], $this->column_search['ToDay'], $this->order['haveMedic'], $this->whereGetReportMedical()),
            'all'   => $this->datatable->count_all($this->table['haveMedic'], $this->whereGetReportMedical()),
            'filter'=> $this->datatable->count_filtered($this->table['haveMedic'], $this->column_order['haveMedic'], $this->column_search['ToDay'], $this->order['haveMedic'], $this->whereGetReportMedical())
        );
    }
    function whereGetReportMedical(){
        $start = ($this->session->userdata('f_start')? date('Y-m-d', strtotime($this->session->userdata('f_start'))): '');
        $end = ($this->session->userdata('f_end')? date('Y-m-d', strtotime($this->session->userdata('f_end'))): '');
        $typeTK = $this->session->userdata('f_typetk');
        
        $strF = "";
        if($this->session->userdata('f_start') && $this->session->userdata('f_typetk')){
            $strF =  "TypeTK = '".$typeTK."' AND TglMedical BETWEEN '".$start."' AND '".$end."'";
        }else{
            if($this->session->userdata('f_start')){
                $strF =  "TglMedical BETWEEN '".$start."' AND '".$end."'";
            }
            if($this->session->userdata('f_typetk')){
                $strF =  "TypeTK = '".$typeTK."'";
            }
        }
            
        return $strF;
    }
    function getMedicalReportToExportExcel($start,$end,$typeTK){
        $this->db->order_by('MedicalID', 'ASC');
        $this->db->where("TypeTK LIKE '%".$typeTK."%' AND TglMedical BETWEEN '".$start."' AND '".$end."'");
        $get = $this->db->get($this->table['haveMedic']);
        return $get->result();
    }
    
}