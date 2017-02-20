<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MasterKaryawanTetap extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        
        $this->load->model('Mdl_MasterKaryawanTetap');
    }
    
    function index(){
        $page   = $this->uri->segment(4);
        if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
            redirect(base_url('MasterKaryawanTetap/index/10/1'));
        }
        $numStart   = $page-1; 
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3)/10, $this->uri->segment(3));
        $startPaging    = (int)($numStart*$perPage[0]).$start;
        $endPaging      = (int)($page*$perPage[0]).$end;
        $total          = $this->Mdl_MasterKaryawanTetap->countMasterKaryawanTetap();
        
        $data['_selectData']    = $this->Mdl_MasterKaryawanTetap->selectMasterKaryawanTetap($startPaging,$endPaging);
        $data['_pagination']    = pagismotion($page, $perPage[1], $total);
        $this->template->display('karyawan/master/tetap/index',$data);
    }
    function setFilterMasterKaryawan(){
        $this->session->unset_userdata('f_nik');
        $this->session->unset_userdata('f_nama');

        if($this->input->post('txtFilterNIK') == NULL && $this->input->post('txtFilterNama') == NULL){
            redirect(base_url('MasterKaryawanTetap/index/10/1'));
        }

        $this->session->set_userdata('f_nik', $this->input->post('txtFilterNIK'));
        $this->session->set_userdata('f_nama', $this->input->post('txtFilterNama'));
        
        redirect(base_url('MasterKaryawanTetap/getFilterMasterKaryawan/10/1'));
    }
    function getFilterMasterKaryawan(){
        $page   = $this->uri->segment(4);
        $nik    = $this->session->userdata('f_nik');
        $nama   = $this->session->userdata('f_nama');
        if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
            redirect(base_url('MasterKaryawanTetap/getFilterMasterKaryawan/10/1'));
        }
        $numStart   = $page-1; 
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3)/10, $this->uri->segment(3));
        $startPaging    = (int)($numStart*$perPage[0]).$start;
        $endPaging      = (int)($page*$perPage[0]).$end;
        $total          = $this->Mdl_MasterKaryawanTetap->countFilterMasterKaryawanTetap($nik,$nama);
        
        $data['_selectData']    = $this->Mdl_MasterKaryawanTetap->selectFilterMasterKaryawanTetap($startPaging,$endPaging,$nik,$nama);
        $data['_pagination']    = pagismotion($page, $perPage[1], $total);
        $this->template->display('karyawan/master/tetap/index',$data);
    }
    
    //##=== Excel
    function exportMasterKaryawan(){
        $nikArr = $this->input->post('chkNikChecked');
        
        $this->load->library('PHPExcel');
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(19);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        
        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Nama')
            ->setCellValue('D1', 'Dept/Jabatan')
            ->setCellValue('E1', 'Tanggal Masuk')
            ->setCellValue('F1', 'Tanggal Medical')
            ->setCellValue('G1', 'Tgl Jatuh Tempo Cuti')
            ->setCellValue('H1', 'Jatah Cuti');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 2;
        for($i=0; $i<count($nikArr); $i++):
            $row    = $this->Mdl_MasterKaryawanTetap->getMstKaryByNIKtetap($nikArr[$i])->row();
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->NIK);
            $ex->setCellValue('C'.$counter, $row->NAMA);
            $ex->setCellValue('D'.$counter, $row->DeptAbbr.'/'.$row->JabatanName);
            $ex->setCellValue('E'.$counter, date('d-m-Y', strtotime($row->TGLMASUK)));
            $ex->setCellValue('F'.$counter, ($row->TanggalMedical != NULL? date('d-m-Y', strtotime($row->TanggalMedical)) : ''));
            $ex->setCellValue('G'.$counter, ($row->TglJatuhTempoCuti != NULL? date('d-m-Y', strtotime($row->TglJatuhTempoCuti)) : ''));
            $ex->setCellValue('H'.$counter, $row->jatah_cuti);
            
            $counter = $counter+1;
        endfor;
        
        $objPHPExcel->getProperties()->setCreator("Ismo Broto")
            ->setLastModifiedBy("Ismo Broto")
            ->setTitle("Export PHPExcel Test Document")
            ->setSubject("Export PHPExcel Test Document")
            ->setDescription("Test doc for Office 2007 XLSX, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("PHPExcel");
        $objPHPExcel->getActiveSheet()->setTitle('Data Orang');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ExportMasterKaryawanTetap'. date('Ymd s') .'.xlsx"');
        
        $objWriter->save('php://output');
    }
    function importToUpdateMasterKary(){
        $this->load->library('PHPExcel');
        
        $fileName = time() . $_FILES['fileImport']['name'];                     // Sesuai dengan nama Tag Input/Upload

        $config['upload_path'] = './upload/fileExcelUpdateMasterKaryawan/';                                // Buat folder dengan nama "fileExcel" di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('fileImport'))
            $this->upload->display_errors();

        $media_filename = $this->upload->data('file_name');
        $inputFileName = './upload/fileExcelUpdateMasterKaryawan/' . $media_filename;
        //echo $inputFileName;

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) {                           // Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            
            $nik = $rowData[0][1];
            $data = array(
                "TanggalMedical" => date('Y-m-d', strtotime($rowData[0][5])),
                "TglJatuhTempoCuti" => date('Y-m-d', strtotime($rowData[0][6])),
                "jatah_cuti" => $rowData[0][7],
                'UpdatedFromKUby' => $this->session->userdata('u_user'),
                'UpdatedFromKUcomp' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'UpdatedFromKUdate' => date('Y-m-d H:i:s')
            );
            
            $this->Mdl_MasterKaryawanTetap->updateMasterKaryawanTetap($nik,$data);        // Sesuaikan nama dengan nama tabel untuk melakukan insert data
            //delete_files($media['file_path']);                                  // menghapus semua file .xls yang diupload
        }
        redirect($this->input->post('txtDirectLink'));
    }
}