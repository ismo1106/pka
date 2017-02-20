<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author : Ismo Broto, @ismo1106
 */

class DatatableRekrut {

    protected $_CI;
    private $db2;

    public function __construct() {
        $this->_CI = &get_instance();
        $this->db2 = $this->_CI->load->database('recruitmen', TRUE);
    }

    private function _get_datatables_query($tabel = '', $column_search = array(), $column_filter = array(), $order = array()) {
        $this->db2->from($tabel);
        $i = 0;
        foreach ($column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db2->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db2->like($item, $_POST['search']['value']);
                } else {
                    $this->db2->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) //last loop
                    $this->db2->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) { // here order processing
            $this->db2->order_by($column_filter[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db2->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($tabel, $column_search, $column_filter, $order) {
        $this->_get_datatables_query($tabel, $column_search, $column_filter, $order);
        if ($_POST['length'] != -1)
            $this->db2->limit($_POST['length'], $_POST['start']);
        $query = $this->db2->get();
        return $query->result();
    }

    function count_filtered($tabel, $column_search, $column_filter, $order) {
        $this->_get_datatables_query($tabel, $column_search, $column_filter, $order);
        $query = $this->db2->get();
        return $query->num_rows();
    }

    public function count_all($table = '') {
        $this->db2->from($table);
        return $this->db2->count_all_results();
    }

}
