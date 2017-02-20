<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class Error extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    function is_503(){
        $this->load->view('errors/is_503');
    }
    
    function is_404(){
        $this->load->view('errors/is_404');
    }
}
 