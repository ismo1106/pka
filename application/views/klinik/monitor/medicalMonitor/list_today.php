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
            <h4 class="page-title">List Medical Hari Ini</h4>
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
                        <table id="tbl-monitor-medical-today" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
                                    <th>No. Urut</th>
                                    <th>Regis No./NIK</th>
                                    <th>Nama</th>
                                    <th>Dept/Bagian</th>
                                    <th>Status</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Umur</th>
                                    <th>Keterangan</th>
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
    var urlDtbale   = '<?= base_url() ?>MedicalMonitor/getDTableMedicalToday';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/monitor/medical_monitor/today.js"></script>
