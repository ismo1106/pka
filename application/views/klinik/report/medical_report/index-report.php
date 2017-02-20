<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/formValidation');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Klinik</a>
                    </li>
                    <li class="active">
                        Report
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Laporan Medical</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">List Medical</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-filter-report-susak" role="form" action="<?= current_url()?>" method="POST">
                            <div class="col-md-4">
                                <div class="input-daterange input-group hi-datepicker" id="date-range">
                                    <input type="text" class="form-control input-sm" name="txtDateStart" id="txtInputDateStart" placeholder="Start" value="<?= ($this->session->userdata('f_start')? $this->session->userdata('f_start'): '')?>">
                                    <span class="input-group-addon bg-custom text-white b-0">to</span>
                                    <input type="text" class="form-control input-sm" name="txtDateEnd" id="txtInputDateEnd" placeholder="End" value="<?= ($this->session->userdata('f_end')? $this->session->userdata('f_end'): '')?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="txtFilterTypeTK" class="form-control input-sm">
                                    <option value="">Filter by Type TK</option>
                                    <option value="TKB" <?= ($this->session->userdata('f_typetk') == 'TKB'? 'selected': '')?> >TK Baru</option>
                                    <option value="HB" <?= ($this->session->userdata('f_typetk') == 'HB'? 'selected': '')?> >Borongan/Harian</option>
                                    <option value="KK" <?= ($this->session->userdata('f_typetk') == 'KK'? 'selected': '')?> >Karyawan Kontrak</option>
                                    <option value="KT" <?= ($this->session->userdata('f_typetk') == 'KT'? 'selected': '')?> >Karyawan Tetap</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Filter <i class="fa fa-filter"></i> </button>
                                    <a href="<?= current_url()?>" class="btn btn-info btn-sm waves-effect waves-light"> <i class="fa fa-refresh"></i> Reload</a>
                                </div>
                                <button id="btnExportExcel" type="button" class="btn btn-success btn-sm waves-effect waves-light"> <i class="fa fa-file-excel-o"></i> Export</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <hr id="hrLineBatas" style="border:0;height:2px;">
                    </div>
                    <div class="col-sm-12">
                        <table id="tbl-report-medical" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
                                    <th>Regis No./NIK</th>
                                    <th>Nama</th>
                                    <th>Dept/Bagian</th>
                                    <th>Status</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>Masa Kerja</th>
                                    <th>Tanggal Medical</th>
                                    <th>Kesimpulan Medical</th>
                                    <th>Catatan Klinik</th>
                                    <th>Catatan P2K3</th>
                                    <th>Approval</th>
                                    <th>Control P2K3</th>
                                    <th>Control Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Info Medical -->
<div id="modal-info-medical" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Informasi Medical</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-12">Kesimpulan</label>
                            <div class="col-sm-12">
                                <textarea id="txtInputKesimpulan" class="form-control input-sm" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Pesan/Catatan Klinik</label>
                            <div class="col-sm-12">
                                <textarea id="txtInputCatatanKlinik" class="form-control input-sm" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12">Pesan/Catatan P2K3</label>
                            <div class="col-sm-12">
                                <textarea id="txtInputCatatanP2K3" class="form-control input-sm" readonly></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlDtbale   = '<?= base_url() ?>MedicalReport/getDTableReportMedicalAjax',
        urlExcel    = '<?= base_url() ?>MedicalReport/exportExcelMedical';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/report/report_medical/medical.js"></script>
