<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Author   : Ismo Broto,   @ismo1106
 */

class Mdl_KonekDB2 extends CI_Model{
    
    private $db2;
    private $datatable;
    var $table = 'vwUtlLogin';
    var $column_order = array(null, 'LoginID','NamaUser','GroupName','GroupDescription'); //set column field database for datatable orderable
    var $column_search = array('LoginID','NamaUser','GroupName','GroupDescription'); //set column field database for datatable searchable 
    var $order = array('NamaUser' => 'asc'); // default order 
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatablerekrut');
        $this->db2  = $this->load->database('recruitmen', TRUE);
        $this->datatable = new DatatableRekrut();
    }
    private function _get_datatables_query() {
        $this->db2->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop
                    $this->db2->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db2->like($item, $_POST['search']['value']);
                } else {
                    $this->db2->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db2->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) { // here order processing
            $this->db2->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db2->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db2->limit($_POST['length'], $_POST['start']);
        $query = $this->db2->get();
        return $query->result();
    }
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db2->get();
        return $query->num_rows();
    }
    public function count_all() {
        $this->db2->from($this->table);
        return $this->db2->count_all_results();
    }
    
    function getSimpleDatatbale(){
        return array(
            'list'  => $this->datatable->get_datatables($this->table, $this->column_search, $this->column_search, $this->order),
            'all'   => $this->datatable->count_all($this->table),
            'filter'=> $this->datatable->count_filtered($this->table, $this->column_search, $this->column_search, $this->order)
        );
    }
    
    function selectUser(){
        //$select = $this->db2->query('SELECT TOP 15 * FROM tblUtlLogin');
        $this->db2->limit(10,11);
        $this->db2->order_by('LoginID');
        $select = $this->db2->get('tblUtlLogin');
        return $select->result();
    }
}