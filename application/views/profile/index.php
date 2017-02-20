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
                        <a href="#">Profile</a>
                    </li>
                    <li class="active">
                        Profile
                    </li>
                </ol>
            </div>
            <?php 
                
            ?>
            <h4 class="page-title"><?= $_title?></h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div id="this-form-profile" class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="<?= site_url('Profile/index')?>" class="list-group-item <?= ($_active == 'index'? 'active':'')?>">Profile</a>
                        <a href="<?= site_url('Profile/changeAvatar')?>" class="list-group-item <?= ($_active == 'avatar'? 'active':'')?>">Change Avatar</a>
                        <a href="<?= site_url('Profile/changePassword')?>" class="list-group-item <?= ($_active == 'password'? 'active':'')?>">Change Password</a>
                        <a href="<?= site_url('Profile/setting')?>" class="list-group-item <?= ($_active == 'setting'? 'active':'')?>">Setting</a>
                    </div>
                </div>
                <div class=" col-md-9">
                    <div class="card-box">
                        <?= $_contentProfile?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>