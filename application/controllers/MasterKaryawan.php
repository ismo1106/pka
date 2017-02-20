<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MasterKaryawan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Login/index'));
        }
        
        $this->load->model('Mdl_MasterKaryawan');
    }
    
    function index(){
        $page   = $this->uri->segment(4);
        if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
            redirect(base_url('MasterKaryawan/index/10/1'));
        }
        $numStart   = $page-1; 
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3)/10, $this->uri->segment(3));
        $startPaging    = (int)($numStart*$perPage[0]).$start;
        $endPaging      = (int)($page*$perPage[0]).$end;
        $total          = $this->Mdl_MasterKaryawan->countMasterKaryawan();
        
        $data['_selectData']    = $this->Mdl_MasterKaryawan->selectMasterKaryawan($startPaging,$endPaging);
        $data['_pagination']    = pagismotion($page, $perPage[1], $total);
        $this->template->display('karyawan/master/kontrak/index',$data);
    }
    function setFilterMasterKaryawan(){
        $this->session->unset_userdata('f_nik');
        $this->session->unset_userdata('f_nama');

        if($this->input->post('txtFilterNIK') == NULL && $this->input->post('txtFilterNama') == NULL){
            redirect(base_url('MasterKaryawan/index/10/1'));
        }

        $this->session->set_userdata('f_nik', $this->input->post('txtFilterNIK'));
        $this->session->set_userdata('f_nama', $this->input->post('txtFilterNama'));
        
        redirect(base_url('MasterKaryawan/getFilterMasterKaryawan/10/1'));
    }
    function getFilterMasterKaryawan(){
        $page   = $this->uri->segment(4);
        $nik    = $this->session->userdata('f_nik');
        $nama   = $this->session->userdata('f_nama');
        if($this->uri->segment(2) == FALSE || $this->uri->segment(3) == FALSE || $this->uri->segment(4) == FALSE){
            redirect(base_url('MasterKaryawan/getFilterMasterKaryawan/10/1'));
        }
        $numStart   = $page-1; 
        $start      = 1;
        $end        = 0;
        $perPage    = array($this->uri->segment(3)/10, $this->uri->segment(3));
        $startPaging    = (int)($numStart*$perPage[0]).$start;
        $endPaging      = (int)($page*$perPage[0]).$end;
        $total          = $this->Mdl_MasterKaryawan->countFilterMasterKaryawan($nik,$nama);
        
        $data['_selectData']    = $this->Mdl_MasterKaryawan->selectFilterMasterKaryawan($startPaging,$endPaging,$nik,$nama);
        $data['_pagination']    = pagismotion($page, $perPage[1], $total);
        $this->template->display('karyawan/master/kontrak/index',$data);
    }
    function getMstKary(){
        $nik    = $this->input->post('txtNIK');
        $data   = $this->Mdl_MasterKaryawan->getMstKaryByNIK($nik)->row();
        
        echo json_encode($data);
    }
    function updateMasterKary(){
        $nik    = $this->input->post('txtNIK');
        $dLink  = $this->input->post('txtDirectLink');
        $data   = array(
            'TglHabisKontrak'   => date('Y-m-d', strtotime($this->input->post('txtTglAkhir'))),
            'MASAKONTRAK'       => $this->input->post('txtMasa'),
            'KontrakKe'         => $this->input->post('txtKontKe'),
            'TanggalMedical'    => date('Y-m-d', strtotime($this->input->post('txtTglMedical'))),
            'UpdatedFromKUby'   => $this->session->userdata('u_user'),
            'UpdatedFromKUcomp' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'UpdatedFromKUdate' => date('Y-m-d H:i:s')
        );
        $this->Mdl_MasterKaryawan->updateMasterKaryawan($nik,$data);
        redirect($dLink);
    }
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(19);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
        
        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'Nama')
            ->setCellValue('D1', 'Dept/Jabatan')
            ->setCellValue('E1', 'Tanggal Masuk')
            ->setCellValue('F1', 'Tanggal Kontrak')
            ->setCellValue('G1', 'Tanggal Akhir Kontrak')
            ->setCellValue('H1', 'Masa Kontrak')
            ->setCellValue('I1', 'Kontrak ke')
            ->setCellValue('J1', 'Tanggal Medical')
            ->setCellValue('K1', 'Tgl Jatuh Tempo Cuti')
            ->setCellValue('L1', 'Jatah Cuti');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 2;
        for($i=0; $i<count($nikArr); $i++):
            $row    = $this->Mdl_MasterKaryawan->getMstKaryByNIK($nikArr[$i])->row();
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->NIK);
            $ex->setCellValue('C'.$counter, $row->NAMA);
            $ex->setCellValue('D'.$counter, $row->DeptAbbr.'/'.$row->JabatanName);
            $ex->setCellValue('E'.$counter, date('d-m-Y', strtotime($row->TGLMASUK)));
            $ex->setCellValue('F'.$counter, ($row->TglKontrak != NULL? date('d-m-Y', strtotime($row->TglKontrak)) : ''));
            $ex->setCellValue('G'.$counter, ($row->TglHabisKontrak != NULL? date('d-m-Y', strtotime($row->TglHabisKontrak)) : ''));
            $ex->setCellValue('H'.$counter, $row->MASAKONTRAK);
            $ex->setCellValue('I'.$counter, $row->KontrakKe);
            $ex->setCellValue('J'.$counter, ($row->TanggalMedical != NULL? date('d-m-Y', strtotime($row->TanggalMedical)) : ''));
            $ex->setCellValue('K'.$counter, ($row->TglJatuhTempoCuti != NULL? date('d-m-Y', strtotime($row->TglJatuhTempoCuti)) : ''));
            $ex->setCellValue('L'.$counter, $row->jatah_cuti);
            
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
        header('Content-Disposition: attachment;filename="ExportMasterKaryawan'. date('Ymd s') .'.xlsx"');
        
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
            $data = array(                                                      // Sesuaikan sama nama kolom tabel di database
                "TglHabisKontrak" => date('Y-m-d', strtotime($rowData[0][6])),
                "MASAKONTRAK" => $rowData[0][7],
                "KontrakKe" => $rowData[0][8],
                "TanggalMedical" => date('Y-m-d', strtotime($rowData[0][9])),
                "TglJatuhTempoCuti" => date('Y-m-d', strtotime($rowData[0][10])),
                "jatah_cuti" => $rowData[0][11],
                'UpdatedFromKUby' => $this->session->userdata('u_user'),
                'UpdatedFromKUcomp' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'UpdatedFromKUdate' => date('Y-m-d H:i:s')
            );
            
            $this->Mdl_MasterKaryawan->updateMasterKaryawan($nik,$data);        // Sesuaikan nama dengan nama tabel untuk melakukan insert data
            //delete_files($media['file_path']);                                  // menghapus semua file .xls yang diupload
        }
        redirect($this->input->post('txtDirectLink'));
    }
    function getMasterForUpdateMulti(){
        $nikArr = $this->input->post('txtNIK');
        
        $data   = array(
            '_selectKaryawan'   => $this->Mdl_MasterKaryawan->getMstKaryByMultiNIK($nikArr)->result()
        );
        $this->load->view('karyawan/master/kontrak/multiple-update',$data);
    }
    function updateMultiMasterKaryawan(){
        $arrNIK     = $this->input->post('txtArrNIK');
        $arrAkhir   = $this->input->post('txtArrTglAkhKontrak');
        $arrMasa    = $this->input->post('txtArrMasaKontrak');
        $arrKontKe  = $this->input->post('txtArrKontrakKe');
        $arrTglMedi = $this->input->post('txtArrTglMedical');
        $rows   = count($arrNIK);
        
        for($i=0; $i< $rows; $i++):
            $nik    = $arrNIK[$i];
            $data   = array(
                'TglHabisKontrak'   => date('Y-m-d', strtotime($arrAkhir[$i])),
                'MASAKONTRAK'       => $arrMasa[$i],
                'KontrakKe'         => $arrKontKe[$i],
                'TanggalMedical'    => date('Y-m-d', strtotime($arrTglMedi[$i])),
                'UpdatedFromKUby'   => $this->session->userdata('u_user'),
                'UpdatedFromKUcomp' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'UpdatedFromKUdate' => date('Y-m-d H:i:s')
            );
            $this->Mdl_MasterKaryawan->updateMasterKaryawan($nik,$data);
        endfor;
        
        redirect($this->input->post('txtDirectLink'));
    }
}