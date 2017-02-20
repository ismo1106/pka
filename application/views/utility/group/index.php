<?php
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/dataTable');
    $this->load->view('assets/formValidation');
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
                        Management Group
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Management Group</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-group-user" class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Group User</b></h4>
            <p class="text-muted m-b-30 font-13"> </p>
            <div class="row">
                
                <div class="col-md-7">
                    <div class="panel panel-inverse panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title">Group User yang tersimpan</h3>
                        </div>
                        <div class="panel-body">
                            <table id="tbl-group-user" class="table table-hover table-striped table-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nama Group User</th>
                                        <th>Descripsi</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_selectGroupUser as $r): ?>
                                    <tr>
                                        <td class="valign-center">
                                            <a href="javascript:;" onclick="getAccess(this);" data-id="<?= encode_str($r->GroupID)?>"><i class="fa fa-bars sedang"></i></a>
                                            <a href="javascript:;" onclick="getDepart(this);" data-id="<?= encode_str($r->GroupID)?>"><i class="fa fa-users blue"></i></a>
                                            <a href="javascript:;" onclick="getReview(this);" data-id="<?= encode_str($r->GroupID)?>"><i class="fa fa-pencil baik"></i></a>
                                            <a href="javascript:;" onclick="getDelete(this);" data-id="<?= encode_str($r->GroupID)?>"><i class="fa fa-trash-o buruk"></i></a>
                                        </td>
                                        <td><?= $r->GroupName?></td>
                                        <td><?= $r->GroupDescription?></td>
                                        <td><?= ($r->NotActive == 1 ? '<span class="label label-danger">Not Active</span>' : '<span class="label label-success">Active</span>')?></td>
                                        <td><code><?= $r->CreatedBy?></code>, <small class="text-miring">at <?= date('F d, Y H:i:s', strtotime($r->CreatedDate))?></small></td>
                                        <td>
                                            <?php if($r->UpdatedBy == NULL): ?><em>-</em>
                                            <?php else: ?>
                                            <code><?= $r->UpdatedBy?></code>, <small class="text-miring">at <?= date('F d, Y H:i:s', strtotime($r->UpdatedDate))?></small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div id="panelFormGroup" class="panel panel-info panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title hi-this-edit display-none">Edit Group User</h3>
                            <h3 class="panel-title hi-this-input">Input Group User</h3>
                        </div>
                        <div class="panel-body">
                            <form id="form-mgt-group" method="POST" class="form-horizontal" role="form" data-parsley-validate novalidate >
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Nama Group</label>
                                    <div class="col-md-9">
                                        <input id="txtInputIdGroup" name="txtIdGroup" type="hidden" >
                                        <input id="txtInputNama" name="txtNama" type="text" required class="form-control input-sm" placeholder="Input Nama Group ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Deskripsi</label>
                                    <div class="col-md-9">
                                        <textarea id="txtInputDescription" name="txtDescription" class="form-control input-sm" rows="2" placeholder="Input Description Group ..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status</label>
                                    <div class="col-md-9">
                                        <div class="radio">
                                            <input type="radio" name="radStatus" id="radActive" value="0" checked="">
                                            <label for="genderM"> Active</label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" name="radStatus" id="radNotActive" value="1" >
                                            <label for="genderM"> Not Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                        <span class="hi-this-input">
                                            <button type="button" id="btnSubmit" class="btn btn-sm btn-info waves-effect waves-light">Simpan</button>
                                        </span>
                                        <span class="hi-this-edit display-none">
                                            <button type="button" id="btnUpdate" class="btn btn-sm btn-success waves-effect waves-light">Edit</button>
                                            <button type="button" id="btnDelete" class="btn btn-sm btn-danger waves-effect waves-light">Hapus</button>
                                        </span>
                                        <button type="reset" id="btnCancel" class="btn btn-sm btn-orange waves-effect waves-light">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Modal Hak Akses Menu by Group -->
<div id="modal-menu-akses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-menu-akses" action="<?= base_url('Utility/UpdateMenuAkses')?>" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Access Menu <strong id="txtHdrGroup"></strong></h4>
                <input id="txtInputGroupIDforAkses" name="txtGroupIDforAkses" type="hidden" />
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="content-menu-akses" class="col-md-12">
                        Loading...
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
            <form id="form-menu-akses" action="<?= base_url('Utility/UpdateDeptAkses')?>" method="POST" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Access Departemen <strong id="txtHdrGroupDept"></strong></h4>
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
    var urlSubmit   = '<?=  base_url()?>Utility/SaveGroup',
        urlReview   = '<?=  base_url()?>Utility/getReviewGroup',
        urlUpdate   = '<?=  base_url()?>Utility/UpdateGroup',
        urlDelete   = '<?=  base_url()?>Utility/DeleteGroup',
        urlAccess   = '<?=  base_url()?>Utility/getAksesForMenu',
        urlDepart   = '<?=  base_url()?>Utility/getAksesDept',
        urlBase     = '<?=  base_url()?>Utility/group';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/utility/group/index.js"></script>