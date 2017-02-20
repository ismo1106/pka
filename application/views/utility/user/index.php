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
                        Management User
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Management User</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-user" class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>User Management</b></h4>
            <p class="text-muted m-b-30 font-13"> </p>
            <div class="row">
                
                <div class="col-md-7">
                    <div class="panel panel-inverse panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title">User yang tersimpan</h3>
                        </div>
                        <div class="panel-body">
                            <table id="tbl-user" class="table table-hover table-striped table-nowrap">
                                <thead>
                                    <tr>
                                        <th class="centered">#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Group User</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($_selectUser as $r): ?>
                                    <tr>
                                        <td class="valign-center">
                                            <a href="javascript:;" onclick="getReview(this);" data-id="<?= encode_str($r->LoginUser)?>"><i class="fa fa-pencil baik"></i></a>
                                            <a href="javascript:;" onclick="resetKey(this);" data-id="<?= encode_str($r->LoginUser)?>"><i class="fa fa-key sedang"></i></a>
                                            <a href="javascript:;" onclick="getDelete(this);" data-id="<?= encode_str($r->LoginUser)?>"><i class="fa fa-trash-o buruk"></i></a>
                                        </td>
                                        <td><?= $r->NamaDepan?> <?= $r->NamaBelakang?></td>
                                        <td><?= $r->LoginUser?></td>
                                        <td><?= $r->GroupName?></td>
                                        <td><?= ($r->NotActive == 1 ? '<span class="label label-danger">Not Active</span>' : '<span class="label label-success">Active</span>')?></td>
                                        <td><code><?= $r->CreatedBy?></code>, <small class="text-miring">at <?= date('F, d Y H:i:s', strtotime($r->CreatedDate))?></small></td>
                                        <td>
                                            <?php if($r->UpdatedBy == NULL): ?><em>-</em>
                                            <?php else: ?>
                                            <code><?= $r->UpdatedBy?></code>, <small class="text-miring">at <?= date('F, d Y H:i:s', strtotime($r->UpdatedDate))?></small>
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
                    <div id="panelFormUser" class="panel panel-info panel-border">
                        <div class="panel-heading">
                            <h3 class="panel-title hi-this-edit display-none">Edit User</h3>
                            <h3 class="panel-title hi-this-input">Create New User</h3>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info hi-this-input"><strong>Info!</strong> Untuk User baru atau reset password, password default <code>"123"</code>.</div>
                            <form id="form-mgt-user" method="POST" class="form-horizontal" role="form" data-parsley-validate novalidate >
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Account</label>
                                    <div class="col-md-10">
                                        <input id="txtInputAkun" name="txtAkun" type="text" required class="form-control input-sm" onblur="$(this).val($(this).val().toLowerCase());" placeholder="Input Account Name ..." required >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name</label>
                                    <div class="col-md-5">
                                        <input id="txtInputFirstName" name="txtFisrtName" type="text" required class="form-control input-sm" onblur="$(this).val(capitalizeFirstWord($(this).val()));" placeholder="Input First Name ..." required >
                                    </div>
                                    <div class="col-md-5">
                                        <input id="txtInputLastName" name="txtLastName" type="text" class="form-control input-sm" onblur="$(this).val(capitalizeFirstWord($(this).val()));" placeholder="Input Last Name ..." >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Group</label>
                                    <div class="col-md-10">
                                        <select id="selInputGroup" name="selGroup" class="form-control input-sm select2" required >
                                            <option value="">Choose...</option>
                                            <?php foreach ($_selectGroupUser as $g): ?>
                                            <option value="<?= $g->GroupID?>"><?= $g->GroupName?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status</label>
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
                                    <div class="col-md-offset-2 col-md-10">
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

<script type="text/javascript">
    var urlSubmit   = '<?=  base_url()?>Utility/createUser',
        urlReview   = '<?=  base_url()?>Utility/getReviewUser',
        urlUpdate   = '<?=  base_url()?>Utility/UpdateUser',
        urlDelete   = '<?=  base_url()?>Utility/DeleteUser',
        urlResetKey = '<?=  base_url()?>Utility/resetPasswordUser',
        urlBase     = '<?=  base_url()?>Utility/user';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/utility/user/index.js"></script>