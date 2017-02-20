<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/sweetAlert');
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
                        Medical
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Registrasi Medical</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">Registrasi Medical</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        <div class="card-box widget-box-two <?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3)? 'widget-two-teal': ($_kuotaHariIni >=$_totalKuota? 'widget-two-danger': 'widget-two-warning'))?>">
                            <i class="mdi mdi-cube-outline widget-two-icon"></i>
                            <div class="wigdet-two-content">
                                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Sisa Kuota</p>
                                <h2 class="<?= (($_totalKuota-$_kuotaHariIni) > ($_totalKuota/3)? 'text-success': 'text-danger')?>"><span data-plugin="counterup"><?= ($_totalKuota-$_kuotaHariIni)?></span> </h2>
                                <p class="text-muted m-0"><b>Total Kuota:</b> <?= $_totalKuota?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <?php if($this->session->flashdata('_message')): ?>
                        <div class="alert <?= (isset($_GET['success'])? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong><?= (isset($_GET['success'])? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-9 col-sm-12 text-center">
                        <span class="<?= ($_aksesTKNew == FALSE? 'display-none': '')?>">
                            <button id="btnTKbaru" type="button" <?= ($_kuotaHariIni >=$_totalKuota || $_aksesTKNew == FALSE? 'disabled': '')?> class="btn btn-md btn-success waves-effect waves-light">Tenaker Baru</button>
                        </span>
                        <button id="btnHarian" type="button" <?= ($_kuotaHariIni >=$_totalKuota? 'disabled': '')?> class="btn btn-md btn-inverse waves-effect waves-light">Borongan/Harian</button>
                        <button id="btnKontrak" type="button" <?= ($_kuotaHariIni >=$_totalKuota? 'disabled': '')?> class="btn btn-md btn-teal waves-effect waves-light">Karyawan Kontrak</button>
                        <button id="btnTetap" type="button" <?= ($_kuotaHariIni >=$_totalKuota? 'disabled': '')?> class="btn btn-md btn-purple waves-effect waves-light">Karyawan Tetap</button>
                    </div>
                    
                    <div class="col-sm-12">
                        <table id="tbl-daftar-medical" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
                                    <th>No. Urut</th>
                                    <th>NIK/ No. Register</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>Tanggal Medical</th>
                                    <th>Waktu</th>
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

<!-- Modal Select TK Baru -->
<div id="modal-select-tknew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content p-0 b-0">
            <form action="<?= base_url('MedicalRegister/simpanRegisMedicalTKNew')?>" method="POST" role="form">
            <div class="panel panel-color panel-success">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">Pilih Tenaga Kerja Baru</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="modal-content-tknew" class="col-md-12">
                            <table id="tbl-select-tknew" class="table table-striped table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 45px">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head-new" type="checkbox" class="chk-head">
                                                <label for="checkbox-head-new"><i></i></label>
                                            </div>
                                        </th>
                                        <th>No. Register</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Register</button>
                    <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Select TK Borongan/Harian -->
<div id="modal-select-harian" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content  p-0 b-0">
            <form action="<?= base_url('MedicalRegister/simpanRegisMedicalHarian')?>" method="POST" role="form">
            <div class="panel panel-color panel-inverse">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">Pilih Tenaga Borongan/ Harian</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="modal-content-harian" class="col-md-12">
                            <table id="tbl-select-harian" class="table table-striped table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 45px">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head-hb" type="checkbox" class="chk-head">
                                                <label for="checkbox-head-hb"><i></i></label>
                                            </div>
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Masa Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                    <button type="submit" class="btn btn-sm btn-inverse waves-effect waves-light">Register</button>
                    <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Select Karyawan Kontrak -->
<div id="modal-select-kontrak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content  p-0 b-0">
            <form action="<?= base_url('MedicalRegister/simpanRegisMedicalKaryKontrak')?>" method="POST" role="form">
            <div class="panel panel-color panel-teal">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">Pilih Karyawan Kontrak</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="modal-content-kontrak" class="col-md-12">
                            <table id="tbl-select-kontrak" class="table table-striped table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 45px">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head-kk" type="checkbox" class="chk-head">
                                                <label for="checkbox-head-kk"><i></i></label>
                                            </div>
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Masa Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                    <button type="submit" class="btn btn-sm btn-teal waves-effect waves-light">Register</button>
                    <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Select Karyawan Tetap -->
<div id="modal-select-tetap" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content  p-0 b-0">
            <form action="<?= base_url('MedicalRegister/simpanRegisMedicalKaryTetap')?>" method="POST" role="form">
            <div class="panel panel-color panel-purple">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">Pilih Karyawan Tetap</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="modal-content-tetap" class="col-md-12">
                            <table id="tbl-select-tetap" class="table table-striped table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 45px">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head-kt" type="checkbox" class="chk-head">
                                                <label for="checkbox-head-kt"><i></i></label>
                                            </div>
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Masa Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                    <button type="submit" class="btn btn-sm btn-purple waves-effect waves-light">Register</button>
                    <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlDTableIndex  = '<?= base_url()?>MedicalRegister/getDatatableIndex',
        urlDTableTKNew  = '<?= base_url()?>MedicalRegister/getDatatableTKNew',
        urlDTableHarian = '<?= base_url()?>MedicalRegister/getDatatableTKHarian',
        urlDTableKtrak  = '<?= base_url()?>MedicalRegister/getDatatableKaryKontrak',
        urlDTableTetap  = '<?= base_url()?>MedicalRegister/getDatatableKaryTetap',
        urlDtable   = '<?= base_url()?>getDatatableIndex';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/medical_register/index.js"></script>