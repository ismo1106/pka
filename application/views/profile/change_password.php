<div class="row">
    <div class="col-md-12">
        <?= $this->session->flashdata('msg_error')?>
    </div>
    <div class="col-md-12">
        <form id="form-change-password" action="<?= base_url('Profile/updatePassword')?>" role="form" class="form-horizontal" method="POST">
            <div class="form-group">
                <label class="control-label col-md-offset-2 col-md-3">Current Password</label>
                <div class="col-md-5">
                    <input name="txtCurrentPassword" type="password" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-offset-2 col-md-3">New Password</label>
                <div class="col-md-5">
                    <input name="txtNewPassword" type="password" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-offset-2 col-md-3">Confirm Password</label>
                <div class="col-md-5">
                    <input name="txtConfirmPassword" type="password" class="form-control input-sm" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-5 col-md-5">
                    <input name="txtCurrentURL" type="hidden" value="<?= current_url()?>" />
                    <button name="btnSubmit" type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>