<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_IzinCuti extends CI_Model {
    
    private $datatable;
    var $table = array(
        'kTetap' => 'vwMstKaryawanSuratSakit',
    );
    var $column_order = array(
        'kTetap' => array('NIK','Nama','DeptAbbr','JabatanName'),
    );
    var $column_search = array(
        'kTetap' => array('NIK','Nama','DeptAbbr','JabatanName'),
    );
    var $order = array(
        'kTetap' => array('NIK' => 'ASC'),
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('datatable');
        $this->datatable = new Datatable();
    }
    
    //##========================================================================
    function getDTableMstKaryTetapPngalihanTugas($dept){
        return array(
            'list'  => $this->datatable->get_datatables($this->table['kTetap'], $this->column_order['kTetap'], $this->column_search['kTetap'], $this->order['kTetap'], $this->whereKaryTetapPngalihanTugas($dept)),
            'all'   => $this->datatable->count_all($this->table['kTetap'], $this->whereKaryTetapPngalihanTugas($dept)),
            'filter'=> $this->datatable->count_filtered($this->table['kTetap'], $this->column_order['kTetap'], $this->column_search['kTetap'], $this->order['kTetap'], $this->whereKaryTetapPngalihanTugas($dept))
        );
    }
    function whereKaryTetapPngalihanTugas($dept){
        return "DeptAbbr LIKE '%".$dept."%'";
    }
}