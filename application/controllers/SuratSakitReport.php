<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* Author   : Ismo Broto; @ismo1106
*/

class SuratSakitReport extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('u_user')){
            redirect(site_url('Welcome/index'));
        }
        
        $this->load->model(array('Mdl_SuratSakitReport'));
    }
    
    function index(){
        $this->session->unset_userdata('f_start');
        $this->session->unset_userdata('f_end');
        $this->session->unset_userdata('f_approval');
        $this->session->set_userdata('f_start', $this->input->post('txtDateStart'));
        $this->session->set_userdata('f_end', $this->input->post('txtDateEnd'));
        $this->session->set_userdata('f_approval', $this->input->post('txtFilterApproval'));
        
        //echo $this->session->userdata('f_approval');
        $this->Mdl_SuratSakitReport->whereReportSuratSakit();
        $this->template->display('klinik/report/surat_sakit_report/index');
    }
    function getListForDatatableSSR(){
        $get = $this->Mdl_SuratSakitReport->getDatatableSuratSakitReport();
        
        $data = array();
        foreach ($get['list'] as $r) {
            $row = array();
            $row[] = $r->NIK;
            $row[] = ucwords(strtolower($r->Nama));
            $row[] = ($r->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan');
            $row[] = $r->DeptAbbr;
            $row[] = ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan');
            $row[] = $r->Umur.' Th';
            $row[] = date('F d, Y', strtotime($r->TglMulaiIstirahat));
            $row[] = $r->LamaIstirahat;
            $row[] = ($r->JenisSurat == 'all'? '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Surat dan Keterangan Dokter</span>': 
                     ($r->JenisSurat == 'iss'? 'Surat Sakit': '<span class="hi-tooltip-click" title="Keterangan: '.$r->KeteranganDokter.'">Keterangan Dokter</span>'));
            $row[] = ($r->KecelakaanKerja == 1 ? 'KK': 'Non-KK');
            $row[] = ($r->KirimP2K3 == 1 ? '<label class="label label-success">Yes</label>': '<label class="label label-inverse">No</label>');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedP2K3 == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->KirimP2K3 == 1 ? ($r->CheckedDept == 1? '<label class="label label-success">Checked</label>': '<label class="label label-warning">Not Yet</label>'): '-');
            $row[] = ($r->GeneralStatus == 1 && $r->Approval == 1 ? '<label class="label label-success">Approved</label>': ($r->GeneralStatus == 1 && $r->Approval == 0 ? '<label class="label label-danger">Unapproved</label>': '<label class="label label-warning">Not Yet</label>'));
            $row[] = '<span class="hi-tooltip-click" title="'.  date('F d, Y  H:i:s', strtotime($r->CreatedDate)).'">'.$r->CreatedByName.'</span>';
            $row[] = ($r->UpdatedBy? '<span class="hi-tooltip-click" title="'.  date('F d, Y  H:i:s', strtotime($r->UpdatedDate)).'">'.$r->UpdatedByName.'</span>': '<small><em>Not Yet</em></small>');
            
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
    
    function exportExcelSuratSakit(){
        $start  = date('Y-m-d', strtotime($this->input->get('txtDateStart')));
        $end    = date('Y-m-d', strtotime($this->input->get('txtDateEnd')));
        $data   = $this->Mdl_SuratSakitReport->getSusakReportToExportExcel($start,$end);
        $this->load->library('PHPExcel');
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17.6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17.6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17.6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
        
        $rowHeader = 3;
        $objPHPExcel->getActiveSheet()->getStyle($rowHeader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowHeader, 'No. Surat')
            ->setCellValue('B'.$rowHeader, 'NIK')
            ->setCellValue('C'.$rowHeader, 'Nama')
            ->setCellValue('D'.$rowHeader, 'Status')
            ->setCellValue('E'.$rowHeader, 'Departemen')
            ->setCellValue('F'.$rowHeader, 'Jenis Kelamin')
            ->setCellValue('G'.$rowHeader, 'Umur')
            ->setCellValue('H'.$rowHeader, 'Tgl Mulai Istirahat')
            ->setCellValue('I'.$rowHeader, 'Tgl Selesai Istirahat')
            ->setCellValue('J'.$rowHeader, 'Tgl Kembali Kerja')
            ->setCellValue('K'.$rowHeader, 'Lama Istirahat')
            ->setCellValue('L'.$rowHeader, 'Jenis Surat')
            ->setCellValue('M'.$rowHeader, 'Kecelakaan Kerja')
            ->setCellValue('N'.$rowHeader, 'Kirim ke P2K3');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        //$no = 1;
        $counter = $rowHeader+1;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $row->SakitID);
            $ex->setCellValue('B'.$counter, strval($row->NIK));
            $ex->setCellValue('C'.$counter, ucwords(strtolower($row->Nama)));
            $ex->setCellValue('D'.$counter, ($row->StatusTenaker == 'B'? 'Borongan/Harian': 'Karyawan'));
            $ex->setCellValue('E'.$counter, $row->DeptAbbr);
            $ex->setCellValue('F'.$counter, ($row->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan'));
            $ex->setCellValue('G'.$counter, $row->Umur.' Tahun');
            $ex->setCellValue('H'.$counter, date('d-m-Y', strtotime($row->TglMulaiIstirahat)));
            $ex->setCellValue('I'.$counter, date('d-m-Y', strtotime($row->TglSelesaiIstirahat)));
            $ex->setCellValue('J'.$counter, date('d-m-Y', strtotime($row->TglKembaliKerja)));
            $ex->setCellValue('K'.$counter, $row->LamaIstirahat.' hari');
            $ex->setCellValue('L'.$counter, ($row->JenisSurat == 'all'? 'Surat dan Keterangan Dokter': ($row->JenisSurat == 'iss'? 'Surat Sakit': 'Keterangan Dokter')));
            $ex->setCellValue('M'.$counter, ($row->KecelakaanKerja == 1? 'Ya': 'Tidak'));
            $ex->setCellValue('N'.$counter, ($row->KirimP2K3 == 1? 'Ya': 'Tidak'));
            
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getProperties()->setCreator("Ismo Broto")
            ->setLastModifiedBy("Modul Export Report Surat Sakit")
            ->setTitle("Export Report Surat Sakit")
            ->setSubject("Export Report Surat Sakit")
            ->setDescription("Export Report Surat Sakit, generated by PHPExcel.")
            ->setKeywords("office 2007 openxml php surat sakit")
            ->setCategory("KKMapp");
        $objPHPExcel->getActiveSheet()->setTitle('Surat Sakit');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ExportReportSuratSakit'. date('Ymd s') .'.xlsx"');
        
        $objWriter->save('php://output');
    }
}