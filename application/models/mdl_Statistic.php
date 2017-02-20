<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Statistic extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Chart Surat Sakit Daily
    function getWhereCSSD($date, $typeTK){
        $this->db->where('TypeTK', $typeTK);
        $this->db->where("Tanggal = '". date('Y-m-d', strtotime($date))."'");
        $get = $this->db->get('vwChartSuratSakitDaily');
        return ($get->num_rows() > 0? $get->row()->Total : 0);
    }
    function getWhereCSSDC($date, $typeTK){
        $this->db->where('TypeTK', $typeTK);
        $this->db->where("Tanggal = '". date('Y-m-d', strtotime($date))."'");
        $get = $this->db->get('vwChartSuratSakitDailyCreate');
        return ($get->num_rows() > 0? $get->row()->Total : 0);
    }
    function getWhereCIKD($date, $typeTK){
        $this->db->where('TypeTK', $typeTK);
        $this->db->where("Tanggal = '". date('Y-m-d', strtotime($date))."'");
        $get = $this->db->get('vwChartSuratSakitDailyIKD');
        return ($get->num_rows() > 0? $get->row()->Total : 0);
    }
}