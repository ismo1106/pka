<?php

class SuratSakit extends FPDF{
    
    private $data = array();
    
    public function setData($data){
        $this->data = $data;
    }
            
    function Header() {
        $this->setFillColor(255, 255, 255);
        $this->setFont('Times', 'B', 10);
        
        $this->SetXY(5, 5);
        $this->Cell(15, 14, '', 'TBLR', 0, 'C', true);
        $this->Image("assets/images/psg-logo.png", 6, 6, 13, 0, 'PNG');
        
        $this->Cell(55, 14, 'PT. PULAU SAMBU GUNTUNG', 'TBLR', 0, 'C', true);
        $this->setFont('Times', '', 9);
        $this->Cell(25, 7, 'DOK. : '.$this->data[1], 'TBLR', 1, 'L', true);
        $this->SetX(75);
        $this->Cell(25, 7, 'TGL. : '.date('d/m/y', strtotime($this->data[0])), 'TBLR', 1, 'L', true);
        $this->SetX(5);
        $this->Cell(15, 7, 'JUDUL', 'TBLR', 0, 'C', true);
        $this->setFont('Times', 'B', 9);
        $this->Cell(55, 7, 'SURAT KETERANGAN ISTIRAHAT', 'TBLR', 0, 'C', true);
        $this->setFont('Times', '', 9);
        $this->Cell(25, 7, 'HAL. : ', 'TBLR', 1, 'L', true);
    }
            
    function Footer() {
        $this->setFillColor(255, 255, 255);
        $this->setFont('Times', '', 8);
        
        $this->Line(5, 5, 5,  143); //R
        $this->Line(100, 5, 100,  143); //L
        $this->Line(5, 5, 100 , 5); //T
        $this->Line(5, 143, 100 , 143); //B
    }
            
    function Content($r){
        $this->setFont('Times', '', 10);
        $this->setFillColor(255, 255, 255);
        
        $this->Ln(7);
        $this->MultiCell(85, 5, '       Yang bertanda tangan dibawah ini, Dokter pada klinik PT. PSG-CWP1 cabang Sungai Guntung, '
                . 'menerangkan bahwa:', '', 'L', TRUE);
        
        $this->SetX(15);
        $this->Cell(20, 5, 'Nama', '', 0, 'L', TRUE);
        $this->Cell(60, 5, ': '. ucwords(strtolower($r->Nama)), '', 1, 'L', TRUE);
        $this->SetX(15);
        $this->Cell(20, 5, 'Umur', '', 0, 'L', TRUE);
        $this->Cell(45, 5, ': '.$r->Umur.' tahun' , '', 0, 'L', TRUE);
        $this->Cell(15, 5, '(L / P)', '', 1, 'L', TRUE);
        if($r->JenisKelamin == 'L'){
            $this->Line(90, 55.5, 86, 55.5);
        }else{
            $this->Line(85, 55.5, 81, 55.5);
        }
        $this->SetX(15);
        $this->Cell(20, 5, 'N I K', '', 0, 'L', TRUE);
        $this->Cell(60, 5, ': '.$r->NIK, '', 1, 'L', TRUE);
        $this->SetX(15);
        $this->Cell(20, 5, 'Dept./Sect.', '', 0, 'L', TRUE);
        $this->Cell(60, 5, ': '.$r->DeptAbbr.'/'.$r->Bagian, '', 1, 'L', TRUE);
        
        $this->MultiCell(85, 5, 'Perlu diberikan istirahat kerja selama . . . '.$r->LamaIstirahat.' . . . ( . . . '.terbilang($r->LamaIstirahat).' '
                . '. . . ) hari karena sakit. terhitung mulai tanggal . . . '.  date('d/m/y', strtotime($r->TglMulaiIstirahat)).' . . . s/d . . . '
                . date('d/m/y', strtotime($r->TglSelesaiIstirahat)).' . . .', '', 'L', TRUE);
        $this->MultiCell(85, 5, 'Telah dinyatakan dapat kembali bekerja terhitung mulai tanggal : . . . '.  date('d/m/y', strtotime($r->TglKembaliKerja)).' '
                . '. . .', '', 'L', TRUE);
        $this->MultiCell(85, 5, 'Kepada yang bersangkutan diharab maklum.', '', 'L', TRUE);
        
        $this->Ln(10);
        $this->SetX(5);
        $this->Cell(48, 5, 'Dibuat oleh : ', 'TBLR', 0, 'C', TRUE);
        $this->Cell(47, 5, 'Disetujui oleh :', 'TBLR', 1, 'C', TRUE);
        $this->SetX(5);
        $this->Cell(48, 5, '', 'TLR', 0, 'C', TRUE);
        $this->Cell(47, 5, '', 'TLR', 1, 'C', TRUE);
        $this->SetX(5);
        $this->Cell(48, 5, '', 'BLR', 0, 'C', TRUE);
        $this->Cell(47, 5, '', 'BLR', 1, 'C', TRUE);
        $this->SetX(5);
        $this->Cell(18, 5, 'Nama', 'TL', 0, 'L', TRUE);
        $this->Cell(30, 5, ': '.$r->CreatedByName, 'TR', 0, 'L', TRUE);
        $this->Cell(17, 5, 'Nama', 'TL', 0, 'L', TRUE);
        $this->Cell(30, 5, ': '.$r->ApprovalByName, 'TR', 1, 'L', TRUE);
        $this->SetX(5);
        $this->Cell(18, 5, 'Jabtan', 'L', 0, 'L', TRUE);
        $this->Cell(30, 5, ': Perawat', 'R', 0, 'L', TRUE);
        $this->Cell(17, 5, 'Jabatan', 'L', 0, 'L', TRUE);
        $this->Cell(30, 5, ': Dokter', 'R', 1, 'L', TRUE);
        $this->SetX(5);
        $this->Cell(18, 5, 'Tanggal', 'BL', 0, 'L', TRUE);
        $this->Cell(30, 5, ': '.date('d/m/y', strtotime($r->CreatedDate)), 'BR', 0, 'L', TRUE);
        $this->Cell(17, 5, 'Tanggal', 'BL', 0, 'L', TRUE);
        $this->Cell(30, 5, ': '.date('d/m/y', strtotime($r->ApprovalDate)), 'BR', 1, 'L', TRUE);
        $this->SetX(5);
        $this->Cell(47, 5, 'Mulai Berlaku 01.02.2012', 'LTB', 0, 'L', TRUE);
        $this->Cell(48, 5, 'FRM-FSS-452-00', 'RTB', 1, 'R', TRUE);
    }
}

$pdf = new SuratSakit('P', 'mm', array(105,148));
$pdf->setData($_dataHeader);
$pdf->AddPage();
$pdf->SetAutoPageBreak(FALSE);
$pdf->Content($_dataContent);
$pdf->Output();