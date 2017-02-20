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
            <h4 class="page-title">Control Medical Oleh Departemen</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">Medical yang telah diperiksa</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    <form id="form-control-medical-dept" method="POST">
                        <div class="col-sm-12">
                            <table id="tbl-control-medical-dept" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head" type="checkbox" class="chk-head">
                                                <label for="checkbox-head"><i></i></label>
                                            </div>
                                        </th>
                                        <th>Opsi</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Dept/Bagian</th>
                                        <th>Status</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Tanggal Medical</th>
                                        <th>Control P2K3</th>
                                        <th>Control Departemen</th>
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
                            <button id="btnCheckedDept" type="button" class="btn btn-sm btn-success waves-effect waves-light">
                                <i class="fa fa-thumbs-o-up m-r-5"></i> Checked</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    var urlDtbale   = '<?= base_url() ?>MedicalApproval/getDatatableMedicalControlDept',
        urlInfoMed  = '<?= base_url() ?>MedicalApproval/getInfoMedical',
        urlCheckByOne   = '<?= base_url() ?>MedicalApproval/checkedDeptMedicalOneByOne',
        urlCheckMulti   = '<?= base_url() ?>MedicalApproval/checkedDeptMedicalMulti';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/medical_input/approval.js"></script>