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
                        Print
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Print Surat Sakit</h4>
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
                        <form id="form-filter-master-karyawan" role="form" action="<?= current_url()?>" method="POST">
                            <div class="col-md-2">
                                <select name="txtFilterStatus" class="form-control input-sm">
                                    <option value="">Filter by Status</option>
                                    <option value="K">Karyawan</option>
                                    <option value="B">Borongan/Harian</option>
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
                    <div class="col-md-12">
                        <hr id="hrLineBatas" style="border:0;height:2px;">
                    </div>
                    <div class="col-sm-12">
                        <table id="tbl-monitor-susak" class="table table-striped table-hover table-nowrap table-colored table-<?= rand_color()?>">
                            <thead>
                                <tr>
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
                                    <th>Opsi</th>
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
    var urlDtable   = '<?= base_url()?>SuratSakitMonitor/getListForDatatablePSS',
        urlKUpdate  = '<?= base_url()?>SuratSakit/kUpdate',
        urlBUpdate  = '<?= base_url()?>SuratSakit/bUpdate';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/print/list_pss.js"></script>