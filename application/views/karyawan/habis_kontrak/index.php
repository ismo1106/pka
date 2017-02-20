<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/sweetAlert2');
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
                        Habis Kontrak
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Karyawan Habis Kontrak</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-habis-kontrak" class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-<?= rand_color()?>">
            <div class="panel-heading">
                <h3 class="panel-title">Karyawan dalam masa tenggang kontrak/ habis kontrak</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form id="form-send-kontrak" method="POST">
                        <div class="col-md-12">
                            <table id="tbl-habis-kontrak" class="table table-hover table-colored table-striped table-nowrap table-<?= rand_color()?>">
                                <thead>
                                    <tr>
                                        <th class="valign-center">
                                            <div class="mk-trc" data-style="check" data-text="true">
                                                <input id="checkbox-head" type="checkbox" class="chk-head">
                                                <label for="checkbox-head"><i></i></label>
                                            </div>
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th class="text-center">P/L</th>
                                        <th>Dept/Bagian</th>
                                        <th>Tgl Habis Kontrak</th>
                                        <th>Kontrak Ke</th>
                                        <th>Limit</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <hr id="hrLineBatas" style="border:0;height:2px;">
                        </div>
                    
                        <div class="col-sm-12 text-center">
                            <button id="btnSubmit" type="button" class="btn btn-sm btn-success waves-effect waves-light"><i class="fa fa-thumbs-o-up m-r-5"></i> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Detail Karyawan -->
<div id="modal-detail-karyawan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel">Detail Karyawan</h4>
            </div>
            <div id="modal-content-detail-karyawan" class="modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>
        

<script type="text/javascript">
    var urlDtbale       = '<?= base_url()?>KontrakKaryawan/getDatatablesHabisKontrak',
        urlBase         = '<?= current_url()?>',
        urlSubmitByOne  = '<?= base_url()?>KontrakKaryawan/saveConfirmHabisKontrakByOne',
        urlSubmitMulty  = '<?= base_url()?>KontrakKaryawan/saveConfirmHabisKontrakMulty',
        urlShowDetail   = '<?= base_url()?>KontrakKaryawan/showDetail';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/karyawan/habis_kontrak/index.js"></script>