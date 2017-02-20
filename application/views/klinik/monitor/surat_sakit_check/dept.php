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
                        <a href="#">P2K3 & Dept</a>
                    </li>
                    <li class="active">
                        Monitoring Control
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Monitoring Oleh Departemen</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div id="pnl-mss" class="panel panel-color panel-<?= rand_color()?>" >
            <div class="panel-heading">
                <h3 class="panel-title">Surat Sakit Telah Diperiksa P2K3</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="col-md-12">
                        <form id="form-filter-susak" role="form" action="<?= current_url()?>" method="POST">
                            <div class="col-md-2">
                                <select name="txtFilterStatus" class="form-control input-sm">
                                    <option value="">Filter by Status</option>
                                    <option value="K">Karyawan</option>
                                    <option value="B">Borongan/Harian</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="txtFilterSurat" class="form-control input-sm">
                                    <option value="">Filter by Jenis Surat</option>
                                    <option value="all">Semua</option>
                                    <option value="ikd">Keterangan Dokter</option>
                                    <option value="iss">Surat Sakit</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input name="txtFilterPeriode" type="text" class="form-control input-sm hi-datepicker" placeholder="Filter by Periode">
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Filter <i class="fa fa-filter"></i> </button>
                                    <a href="<?= current_url()?>" class="btn btn-info btn-sm waves-effect waves-light"> <i class="fa fa-refresh"></i> Reload</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <form id="form-check-susak-dept" method="POST">
                        <div class="col-md-12">
                            <hr class="hrLineBatas" style="border:0;height:2px;">
                        </div>
                        <div class="col-sm-12">
                            <table id="tbl-dept-susak" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chk-head"><label></label></th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Perusahaan</th>
                                        <th>Departemen</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Tgl Surat/ Mulai Istirahat</th>
                                        <th>Tgl Selesai Istirahat</th>
                                        <th>Tgl Kembali Kerja</th>
                                        <th>Lama Istirahat</th>
                                        <th>Jenis Surat</th>
                                        <th>KK/ Non-KK</th>
                                        <th>Kirim ke P2K3</th>
                                        <th>Control P2K3</th>
                                        <th>Control Departemen</th>
                                        <th>Approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <hr class="hrLineBatas" style="border:0;height:2px;">
                        </div>
                        <div class="col-sm-12 text-center">
                            <button id="btnChecked" type="button" class="btn btn-sm btn-success waves-effect waves-light"><i class="fa fa-thumbs-o-up m-r-5"></i> Checked</button>
                        </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlDtable   = '<?= base_url()?>SuratSakitMonitor/getDatatableCheckDept',
        urlChecked  = '<?= base_url()?>SuratSakitMonitor/checkedDept';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/monitor/surat_sakit_monitor/dept.js"></script>