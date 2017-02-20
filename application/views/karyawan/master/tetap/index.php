<?php
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/dataTable');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/formAdvance');
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
                        Master Karyawan
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Master Karyawan Tetap</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-master-karyawan" class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title">Karyawan Tetap Aktif</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-filter-master-karyawan" role="form" action="<?=  base_url('MasterKaryawanTetap/setFilterMasterKaryawan')?>" method="POST">
                            <div class="col-md-2">
                                <div class="dataTables_length">
                                    <label>Show 
                                        <select id="pagismotion-length" class="form-control input-sm">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> entries
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input name="txtFilterNIK" type="text" class="form-control input-sm" placeholder="Filter by NIK">
                            </div>
                            <div class="col-md-2">
                                <input name="txtFilterNama" type="text" class="form-control input-sm" placeholder="Filter by Nama">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" hidden>Filter</button>
                            </div>
                            <div class="col-md-4 text-right">
                                <button id="btnMlUpdate" type="button" class="btn btn-sm btn-info disabled"><i class="fa fa-table m-r-5"></i> Multiple Update</button>
                                <div class="btn-group">
                                    <button id="btnExpExcel" type="button" class="btn btn-sm btn-success">Export <i class="fa fa-file-excel-o m-r-5"></i></button>
                                    <button id="btnImpExcel" type="button" class="btn btn-sm btn-primary"><i class="fa fa-file-excel-o m-r-5"></i> Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-12">
                        <form id="form-filter-export-excel" role="form" method="POST">
                            <table id="tbl-mater-karyawan" class="table table-hover table-colored table-purple table-striped table-nowrap">
                                <thead>
                                    <tr>
                                        <th class="valign-center">
                                            <input type="checkbox" class="chk-select"><label></label>
                                        </th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th class="text-center">P/L</th>
                                        <th>Dept/Bagian</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Medical</th>
                                        <th>Tgl Jatuh Tempo Cuti</th>
                                        <th>Jatah Cuti</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_selectData as $r): ?>
                                    <tr>
                                        <td class="valign-center">
                                            <input name="chkNikChecked[]" value="<?= $r->NIK?>" type="checkbox" class="chk-select-send"><label></label>
                                        </td>
                                        <td><?= $r->NIK?></td>
                                        <td><?= $r->NAMA?></td>
                                        <td class=" text-center"><?= $r->Sex?></td>
                                        <td><?= strtoupper($r->DeptAbbr).($r->BagianName == NULL ? '' : '/'.ucwords(strtolower($r->BagianName))) ?></td>
                                        <td><?= ($r->TGLMASUK != NULL ? date('F d, Y', strtotime($r->TGLMASUK)) : '')?></td>
                                        <td><?= ($r->TanggalMedical != NULL ? date('F d, Y', strtotime($r->TanggalMedical)) : '')?></td>
                                        <td><?= ($r->TglJatuhTempoCuti != NULL ? date('F d, Y', strtotime($r->TglJatuhTempoCuti)) : '')?></td>
                                        <td><?= $r->jatah_cuti?></td>
                                        <td><?= ($r->TanggalMedical!= '' && $r->TglJatuhTempoCuti!= '' && $r->jatah_cuti!= '' ? '<label class="label label-success">Fixed</label>': '<label class="label label-danger">Not Fix</label>')?></td>
                                        <td>
                                            <a href="javascript:editMasterKary(<?= $r->NIK?>);" class="btn btn-xs btn-success waves-effect waves-light disabled">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                        
            </div>
            <div class="panel-footer text-center">
                <?= $_pagination?>
            </div>
        </div>
    
    </div>       
</div>

<!-- Edit Master Karyawan Tetap One Line -->
<div id="modal-edit-master-karyawan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-edit-mst-karyawan" action="<?= base_url('MasterKaryawanTetap/updateMasterKary')?>" method="POST" role="form" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Data, Sdr. <span id="spanNamaHeader"></span> <small class="text-miring">(<span id="spanNikHeader"></span>)</small></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div id="divInputTglKontrak" class="form-group">
                            <label for="txtInputTglKontrak" class="control-label">Tanggal Kontrak</label>
                            <input id="txtInputTglKontrak" name="txtTglKontrak" type="text" class="form-control input-sm" readonly="" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="divInputTglAkhir" class="form-group">
                            <label for="txtInputTglAkhir" class="control-label">Tanggal Akhir Kontrak</label>
                            <input id="txtInputTglAkhir" name="txtTglAkhir" type="text" class="form-control input-sm hi-datepicker" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtInputMasa" class="control-label">Masa Kontrak</label>
                            <input id="txtInputMasa" name="txtMasa" type="text" onkeyup="calculateMasa(this);" class="form-control input-sm" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtInputKontKe" class="control-label">Kontrak ke</label>
                            <input id="txtInputKontKe" name="txtKontKe" type="text" class="form-control input-sm" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="divInputTglMedical" class="form-group">
                            <label for="txtInputTglMedical" class="control-label">Tanggal Medical</label>
                            <input id="txtInputTglMedical" name="txtTglMedical" type="text" class="form-control input-sm hi-datepicker" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                <input name="txtNIK" id="txtInputNIK" type="hidden" value="" />
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Update</button>
                <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Master Karyawan Tetap Multiple via Excel -->
<div id="modal-imp-master-karyawan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-imp-mst-karyawan" action="<?= base_url('MasterKaryawanTetap/importToUpdateMasterKary')?>" method="POST" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Import Data Master Karyawan untuk Update</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="fileImport" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="filestyle" data-size="sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Import</button>
                <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Master Karyawan Tetap Multiple with Modal -->
<div id="modal-edit-multiple" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <form id="form-edit-multiple" action="<?= base_url('MasterKaryawanTetap/updateMultiMasterKaryawan')?>" method="POST" role="form" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Multiple Update Master Karyawan</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="ajax-multi-update" class="col-md-12 table-responsive">
                        <table class="table-input">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Kontrak</th>
                                    <th>Tgl Akhir Kontrak</th>
                                    <th>Masa Kontrak</th>
                                    <th>Kontrak ke</th>
                                    <th>Tanggal Medical</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="javascript:;" ><i class="fa fa-trash-o buruk"></i></a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input name="" class="txt-table" /></td>
                                    <td><input name="" class="txt-table" /></td>
                                    <td><input name="" class="txt-table" /></td>
                                    <td><input name="" class="txt-table" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="txtDirectLink" type="hidden" value="<?= current_url()?>" />
                <button type="submit" class="btn btn-sm btn-success waves-effect waves-light">Update</button>
                <button type="button" class="btn btn-sm btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlGetEdit  = '<?= base_url()?>MasterKaryawanTetap/getMstKary',
        urlExpExcel = '<?= base_url()?>MasterKaryawanTetap/exportMasterKaryawan',
        urlMultiUp  = '<?= base_url()?>MasterKaryawanTetap/getMasterForUpdateMulti',
        urlPaging   = ['<?= base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>', '<?= $this->uri->segment(4)?>', '<?= $this->uri->segment(3)?>'],
        urlBase     = '<?= base_url()?>MasterKaryawanTetap/index';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/karyawan/master/tetap/index.js"></script>