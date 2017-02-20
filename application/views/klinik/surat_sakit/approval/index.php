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
                        Surat Sakit
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Approval Surat Sakit</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">Approval Surat Sakit</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    <form id="form-approve-susak" method="POST">
                        <div class="col-sm-12">
                            <table id="tbl-approval-susak" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chk-head"><label></label></th>
                                        <th>Opsi</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Perusahaan</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Jenis Surat</th>
                                        <th>Tgl Surat</th>
                                        <th>Lama Istirahat</th>
                                        <th>Kirim ke P2K3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <hr id="hrLineBatas" style="border:0;height:2px;">
                        </div>
                        <div class="col-sm-12 text-center">
                            <button id="btnTerima" type="button" class="btn btn-sm btn-success waves-effect waves-light"><i class="fa fa-thumbs-o-up m-r-5"></i> Accept</button>
                            <button id="btnTolak" type="button" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-thumbs-o-down m-r-5"></i> Decline</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlKUpdate  = '<?= base_url()?>SuratSakit/kUpdate',
        urlBUpdate  = '<?= base_url()?>SuratSakit/bUpdate',
        urlApprove  = '<?= base_url()?>SuratSakit/approvmentByOnce',
        urlTerima   = '<?= base_url()?>SuratSakit/approvmentAcceptMulti',
        urlTolak    = '<?= base_url()?>SuratSakit/approvmentDeclineMulti',
        urlDtable   = '<?= base_url()?>SuratSakit/getDatatableApproval';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/surat_sakit/approval/index.js"></script>