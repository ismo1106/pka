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
            <h4 class="page-title">Report Surat Sakit</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div id="pnl-mss" class="panel panel-color panel-<?= rand_color()?>" >
            <div class="panel-heading">
                <h3 class="panel-title">Semua Surat Sakit</h3>
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
                                <select name="txtFilterApproval" class="form-control input-sm">
                                    <option value="">Filter by Approval</option>
                                    <option value="00" <?= ($this->session->userdata('f_approval') == '00'? 'selected': '')?> >Not Yet</option>
                                    <option value="11" <?= ($this->session->userdata('f_approval') == '11'? 'selected': '')?> >Approved</option>
                                    <option value="01" <?= ($this->session->userdata('f_approval') == '01'? 'selected': '')?> >Decline</option>
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
                        <table id="tbl-report-susak" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th>Departemen</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>Tgl Surat</th>
                                    <th>Lama Istirahat</th>
                                    <th>Jenis Surat</th>
                                    <th>KK/ Non-KK</th>
                                    <th>Kirim ke P2K3</th>
                                    <th>Control P2K3</th>
                                    <th>Control Departemen</th>
                                    <th>Approval</th>
                                    <th>CreatedBy</th>
                                    <th>UpdatedBy</th>
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

<script type="text/javascript">
    var urlDtable   = '<?= base_url()?>SuratSakitReport/getListForDatatableSSR',
        urlExcel    = '<?= base_url()?>SuratSakitReport/exportExcelSuratSakit';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/report/surat_sakit_report/index.js"></script>