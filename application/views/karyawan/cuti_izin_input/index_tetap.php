<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formValidation');
    $this->load->view('assets/formAdvance');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/styleTableInput');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Karyawan</a>
                    </li>
                    <li class="active">
                        Cuti, Izin, Dll
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Input Cuti, Izin, Dll</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title">Input Cuti, Izin, Dll Karyawan Tetap</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    <form id="form-input-cuti-tetap" class="form-horizontal" role="form" method="POST" data-parsley-validate>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">NIK</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" id="txtInputNIK" name="txtNIK" required class="form-control input-sm" placeholder="Search">
                                        <span class="input-group-btn">
                                            <button id="btn-cariNIK" type="button" class="btn btn-sm waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-9">
                                    <input id="txtInputNama" name="txtNama" type="text" required class="form-control input-sm txt-header" placeholder="Nama Karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Departemen</label>
                                <div class="col-md-9">
                                    <input id="txtInputDept" name="txtDept" type="text" required class="form-control input-sm txt-header" placeholder="Departemen Karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Jabatan</label>
                                <div class="col-md-9">
                                    <input id="txtInputJabatan" name="txtJabatan" type="text" required class="form-control input-sm txt-header" placeholder="Jabatan Karyawan">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Lama Izin/Cuti</label>
                                <div class="col-md-8">
                                    <input id="txtInputDurasi" name="txtDurasi" type="text" required class="form-control input-sm txt-header" placeholder="Lama Izin/Cuti">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tanggal Mulai</label>
                                <div class="col-md-8">
                                    <input id="txtInputTglMulai" name="txtTglMulai" type="text" required class="form-control input-sm txt-header" placeholder="Tanggal Mulai">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Pelimpahan Tugas ke</label>
                                <div class="col-md-8">
                                    <input id="txtInputPelimpahanTugas" name="txtPelimpahanTugas" type="text" readonly class="form-control input-sm txt-header" placeholder="Pelimpahan Tugas (Click me)">
                                    <input id="txtInputPelimpahanTugasNIK" name="txtPelimpahanTugasNIK" type="hidden" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-8">
                                    <button id="btnCheckCuti" class="btn btn-sm btn-primary">Check <i class="fa fa-refresh"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-offset-3 col-md-6 col-md-12">
                            <table class="table-input table-input-hover">
                                <thead>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>Jatah Cuti</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Dispensasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sebelumnya</td>
                                        <td><input id="inputBeforeJatah" name="txtBeforeJatah" readonly class="txt-table text-center" /></td>
                                        <td><input id="inputBeforeTempo" name="txtBeforeTempo" readonly class="txt-table text-right" /></td>
                                        <td><input id="inputBeforeDispn" name="txtBeforeDispn" readonly class="txt-table text-right" /></td>
                                    </tr>
                                    <tr>
                                        <td>Sekarang</td>
                                        <td><input id="inputNowJatah" name="txtNowJatah" readonly class="txt-table text-center" /></td>
                                        <td><input id="inputNowTempo" name="txtNowTempo" readonly class="txt-table text-right" /></td>
                                        <td><input id="inputNowDispn" name="txtNowDispn" readonly class="txt-table text-right" /></td>
                                    </tr>
                                    <tr>
                                        <td>Proporsonal</td>
                                        <td><input id="inputPropJatah" name="txtPropJatah" readonly class="txt-table text-center" /></td>
                                        <td><input id="inputPropTempo" name="txtPropTempo" readonly class="txt-table text-right" /></td>
                                        <td><input id="inputPropDispn" name="txtPropDispn" readonly class="txt-table text-right" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-12">
                            <hr class="hrLineBatas" style="border:0;height:2px;">
                        </div>
                        <div class="col-md-12">
                            <table class="table-input table-input-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Izin</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4"><em>No Data</em></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="col-md-12">
                            <hr class="hrLineBatas" style="border:0;height:2px;">
                        </div>
                        <div class="col-md-12 text-right">
                            <button id="btnSignature" class="btn btn-sm btn-primary" type="button"> Signature <i class="fa fa-pencil-square-o"></i> </button>
                            <button id="btnSubmit" class="btn btn-sm btn-success" type="button"> Submit <i class="fa fa-send-o"></i> </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-pengalihan-tugas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Informasi Medical</h4>
            </div>
            <div class="modal-body">
                <div id="content-modal-pengalihan-tugas" class="row">
                    <table id="tbl-select-pengalihan-tugas" class="table table-hover table-striped table-nowrap">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
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

<script type="text/javascript">
    var urlGetData  = '<?= base_url() ?>IzinCuti/getDataByNIK';
        urlDTmKary  = '<?= base_url() ?>IzinCuti/getDatatableSelectPengalihanTugas';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/karyawan/cuti_izin/index-tetap.js"></script>