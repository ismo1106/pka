<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class MedicalReport extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_MedicalMonitor'));
    }
    
    function index(){
        $this->session->unset_userdata('f_start');
        $this->session->unset_userdata('f_end');
        $this->session->unset_userdata('f_typetk');
        $this->session->set_userdata('f_start', $this->input->post('txtDateStart'));
        $this->session->set_userdata('f_end', $this->input->post('txtDateEnd'));
        $this->session->set_userdata('f_typetk', $this->input->post('txtFilterTypeTK'));
        
        $this->Mdl_MedicalMonitor->whereGetReportMedical();
        $this->template->display('klinik/report/medical_report/index-report');
    }
    function getDTableReportMedicalAjax(){
        $get = $this->Mdl_MedicalMonitor->getDTableReportMedicalModel();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->Dept? $r->Dept: '-');
            $row[] = ($r->TypeTK == 'KT'? 'Karyawan Tetap': ($r->TypeTK == 'KK'? 'Karyawan Kontrak': ($r->TypeTK == 'HB'? 'Harian/Borongan': '<em>Tenaker Baru</em>')));
            $row[] = ($r->JenisKelamin == 'P'? 'Perempuan': 'Laki-laki');
            $row[] = $r->Usia.' Tahun';
            $row[] = ($r->MasaKerja? $r->MasaKerja: '-');
            $row[] = date('d-m-Y', strtotime($r->TglMedical));
            $row[] = ($r->Kesimpulan? $r->Kesimpulan: '-');
            $row[] = ($r->CatatanKlinik? $r->CatatanKlinik: '-');
            $row[] = ($r->CatatanP2K3? $r->CatatanP2K3: '-');
            $row[] = ($r->ApprovalBy == NULL? '<label class="label label-warning">Not Yet</label>':'<label class="label label-success hi-tooltip-click" title="'.$r->ApprovalByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->ApprovalDate)).')">Approved</label>');
            $row[] = ($r->CatatanP2K3 == NULL? '-': ($r->CheckedP2K3 == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedP2K3ByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedP2K3Date)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'));
            $row[] = ($r->CatatanP2K3 == NULL? '-': ($r->CheckedDept == 1? '<label class="label label-success hi-tooltip-click" title="'.$r->CheckedDeptByName.' '
                    . '('.  date('F d, Y H:i:s', strtotime($r->CheckedDeptDate)).')">Checked</label>': '<label class="label label-warning">Not Yet</label>'));
            
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $get['all'],
            "recordsFiltered" => $get['filter'],
            "data" => $data,
        );
        
        echo json_encode($output);
    }
    function exportExcelMedical(){
        $start  = date('Y-m-d', strtotime($this->input->get('txtDateStart')));
        $end    = date('Y-m-d', strtotime($this->input->get('txtDateEnd')));
        $typeTK = $this->input->get('txtTypeTK');
        $data   = $this->Mdl_MedicalMonitor->getMedicalReportToExportExcel($start,$end,$typeTK);
        $this->load->library('PHPExcel');
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(24);
        
        $rowHeader =3;
        $objPHPExcel->getActiveSheet()->getStyle($rowHeader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowHeader, 'No. Reg/NIK')
            ->setCellValue('B'.$rowHeader, 'Nama')
            ->setCellValue('C'.$rowHeader, 'Dept/Bagian')
            ->setCellValue('D'.$rowHeader, 'Status')
            ->setCellValue('E'.$rowHeader, 'Jenis Kelamin')
            ->setCellValue('F'.$rowHeader, 'Umur')
            ->setCellValue('G'.$rowHeader, 'Masa Kerja')
            ->setCellValue('H'.$rowHeader, 'Tanggal Medical')
            ->setCellValue('I'.$rowHeader, 'Kesimpulan Medikal')
            ->setCellValue('J'.$rowHeader, 'Catatan Klinik')
            ->setCellValue('K'.$rowHeader, 'Catatan P2K3')
            ->setCellValue('L'.$rowHeader, 'Approval')
            ->setCellValue('M'.$rowHeader, 'Control P2K3')
            ->setCellValue('N'.$rowHeader, 'Control Dept');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        //$no = 1;
        $counter = $rowHeader+1;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, strval($row->NIK));
            $ex->setCellValue('B'.$counter, ucwords(strtolower($row->Nama)));
            $ex->setCellValue('C'.$counter, ($row->Dept? $row->Dept: '-'));
            $ex->setCellValue('D'.$counter, ($row->TypeTK == 'KT'? 'Karyawan Tetap': ($row->TypeTK == 'KK'? 'Karyawan Kontrak': ($row->TypeTK == 'HB'? 'Harian/Borongan': 'Tenaker Baru'))));
            $ex->setCellValue('E'.$counter, ($row->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan'));
            $ex->setCellValue('F'.$counter, $row->Usia.' Tahun');
            $ex->setCellValue('G'.$counter, ($row->MasaKerja? $row->MasaKerja:'-'));
            $ex->setCellValue('H'.$counter, date('d-m-Y', strtotime($row->TglMedical)));
            $ex->setCellValue('I'.$counter, ($row->Kesimpulan? $row->Kesimpulan:'-'));
            $ex->setCellValue('J'.$counter, ($row->CatatanKlinik? $row->CatatanKlinik:'-'));
            $ex->setCellValue('K'.$counter, ($row->CatatanP2K3? $row->CatatanP2K3:'-'));
            $ex->setCellValue('L'.$counter, $row->ApprovalByName.' - '.($row->ApprovalDate? date('d-m-Y', strtotime($row->ApprovalDate)):''));
            $ex->setCellValue('M'.$counter, $row->CheckedP2K3ByName.' - '.($row->CheckedP2K3Date? date('d-m-Y', strtotime($row->CheckedP2K3Date)):''));
            $ex->setCellValue('N'.$counter, $row->CheckedDeptByName.' - '.($row->CheckedDeptDate? date('d-m-Y', strtotime($row->CheckedDeptDate)):''));
            
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getProperties()->setCreator("Ismo Broto")
            ->setLastModifiedBy("Modul Export Report Medical Check Up")
            ->setTitle("Export Report Medical Check Up")
            ->setSubject("Export Report Medical Check Up")
            ->setDescription("Export Report Medical Check Up, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php medical")
            ->setCategory("KKMapp");
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Medical');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ExportReportMedical'. date('Ymd s') .'.xlsx"');
        
        $objWriter->save('php://output');
    }
    
}