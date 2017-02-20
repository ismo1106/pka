<?php
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/dataTable');
    $this->load->view('assets/formValidation');
    $this->load->view('assets/formAdvance');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Utility</a>
                    </li>
                    <li class="active">
                        Management Access
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Special Access</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-group-user" class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Management Special Access</b></h4>
            <p class="text-muted m-b-30 font-13"> </p>
            <div class="row">
                
                <div class="col-md-7">
                    <div class="panel panel-inverse panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title">Special Access yg Digunakan</h3>
                        </div>
                        <div class="panel-body">
                            <table id="tbl-group-special" class="table table-hover table-striped table-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nama Akses</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_selectSpecialAccess as $r): ?>
                                    <tr>
                                        <td class="valign-center text-center">
                                            <a href="javascript:;" onclick="getAccess(this);" data-id="<?= encode_str($r->Id)?>"><i class="fa fa-bars sedang"></i></a>
                                        </td>
                                        <td><?= $r->NamaAkses?></td>
                                        <td><?= $r->Keterangan?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="panel panel-inverse panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lain-lain</h3>
                        </div>
                        <div class="panel-body">
                            <button id="btnSetDeptSixMonth" class="btn btn-sm btn-primary waves-effect waves-light">Dept Medical per 6 Month</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Special Access Menu by Group -->
<div id="modal-menu-akses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-menu-akses" action="<?= base_url('Utility/saveSpecial')?>" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><strong id="txtHdrGroup"></strong></h4>
                <input id="txtInputIDspecial" name="txtIDspecial" type="hidden" />
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-horizontal">
                        <select id="select-group" name="txtGroupID[]" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                        </select>
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

<!-- Modal Hak Akses Departemen by Group -->
<div id="modal-dept-akses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content">
            <form id="form-menu-akses" action="<?= base_url('Utility/saveDeptMedicalSixMonth')?>" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Departemen Medial 6 Bulan Sekali</h4>
                <input id="txtInputGroupIDforAksesDept" name="txtGroupIDforAksesDept" type="hidden" />
            </div>
            <div class="modal-body">
                <div class="row" id="content-dept-akses">
                    Loading...
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
    var urlAccess   = '<?=  base_url()?>Utility/getSpecialAksesForGroup',
        urlDepart   = '<?=  base_url()?>Utility/getDepartSixMonth';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/utility/special/index.js"></script>