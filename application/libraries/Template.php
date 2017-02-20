<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author : Ismo Broto, @ismo1106
 */

class Template {
    protected $_CI;
    public function __construct() {
        $this->_CI=&get_instance();
    }
    
    function display($template, $data = NULL){
        $this->_CI->load->model('Mdl_Menu');
        
        $data['_getMenu1']  = $this->_CI->Mdl_Menu->selectMenu1($this->_CI->session->userdata('u_group'));
        $data['_getMenu2']  = $this->_CI->Mdl_Menu->selectMenu2($this->_CI->session->userdata('u_group'));
        $data['_getMenu3']  = $this->_CI->Mdl_Menu->selectMenu3($this->_CI->session->userdata('u_group'));
        
        $data['_header']    = $this->_CI->load->view('template/header', $data, TRUE);
        $data['_navbar']    = $this->_CI->load->view('template/navbar', $data, TRUE);
        $data['_content']   = $this->_CI->load->view($template, $data, TRUE);
        $data['_footer']    = $this->_CI->load->view('template/footer', $data, TRUE);
        $this->_CI->load->view('/template', $data);
    }
    
}