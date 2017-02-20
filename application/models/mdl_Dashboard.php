<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author   : Ismo, github@ismo1106
 */

class Mdl_Dashboard extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function getStatisticDataSakit(){
        $today = $this->db->get_where('tblTrnSuratSakitDetail', array('TglSuratSakit' => date('Y-m-d')))->num_rows();
        $yesterday = $this->db->get_where('tblTrnSuratSakitDetail', array('TglSuratSakit' => date('Y-m-d', strtotime('-1 days'))))->num_rows();
        
        return array(
            'today' => $today,
            'yesterday' => $yesterday,
            'exchange' => ($yesterday == $today? 'mdi mdi-code-tags text-success': ($yesterday > $today? 'mdi-arrow-down text-success': 'mdi-arrow-up text-danger'))
        );
    }
    
}