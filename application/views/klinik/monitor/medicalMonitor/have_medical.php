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
                        Monitor
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Tenaga Kerja Sudah Medical</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">List Tenaga Kerja yang Medical</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="tbl-monitor-medical-have" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
                                    <th>Info</th>
                                    <th>Regis No./NIK</th>
                                    <th>Nama</th>
                                    <th>Dept/Bagian</th>
                                    <th>Status</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>Tanggal Medical</th>
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
    var urlDtbale   = '<?= base_url() ?>MedicalMonitor/getDTableHaveMedical',
        urlInfoMed  = '<?= base_url() ?>MedicalMonitor/getInfoMedical';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/monitor/medical_monitor/have.js"></script>
